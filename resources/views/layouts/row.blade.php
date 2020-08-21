@php
$moduleID = $bladeData->attributes->id ?? null;
$moduleClasses = $bladeData->attributes->class ?? null;
$spacing = $bladeData->generatedAttributes->spacing ?? null;
$textAlignxs = (string) ($bladeData->inline->textAlign->xs ?? null);
$textAlignlg = (string) ($bladeData->inline->textAlign->xl ?? null);
$columns = collect($bladeData->content);
$bgImage = (!empty($bladeData->inline->backgroundImage->url)) ? 'background-image: url(' . $bladeData->inline->backgroundImage->url . ');' : "";
$bgSize = (!empty($bladeData->inline->backgroundImage->backgroundSize)) ? 'background-size:' . $bladeData->inline->backgroundImage->backgroundSize . ';' : "";
$bgPosition = (!empty($bladeData->inline->backgroundImage->backgroundPosition)) ? 'background-position:' . $bladeData->inline->backgroundImage->backgroundPosition . ';' : "";
$bgColor = (!empty($bladeData->inline->backgroundColor)) ? "background-color: {$bladeData->inline->backgroundColor};" : "";
$internalLinkEnabled = $bladeData->attributes->in_page_link_enabled ?? null;
$internalLinkText = $bladeData->attributes->in_page_link_text ?? null;
$internalLinkTarget = $internalLinkText ? preg_replace("/\W|_/",'',$internalLinkText) : null;
$dataAtts = $bladeData->attributes->data ?? null;

// CSS GRID
$enableCSSGrid = $bladeData->inline->cssGrid->enabled ?? null;
$cssGridGap = $bladeData->inline->cssGrid->gap ?? null;

if ($enableCSSGrid) {
    $gridPrefix = "grid";
    $moduleClasses ? $moduleClasses .= " $gridPrefix" : $moduleClasses = $gridPrefix;

    // This will become e.g grid-4-8
    $colClass = $gridPrefix;

    foreach($columns as $column) {
        $colClass .= "-" . $column->options->columns->xl;
    }

    $moduleClasses .= " $colClass";
}

if ($enableCSSGrid && $cssGridGap) {
    $moduleClasses .= " gap-$cssGridGap";
}

if (!$enableCSSGrid && $cssGridGap) {
    $moduleClasses .= " col-gap-$cssGridGap";
}

// Temporary large/small version of text align, I'll loop this eventually
if ($textAlignxs) {
    $moduleClasses ? $moduleClasses .= " text-$textAlignxs" : $moduleClasses = "text-$textAlignxs";
}
if ($textAlignlg) {
    $moduleClasses ? $moduleClasses .= " xl:text-$textAlignlg" : $moduleClasses = "xl:text-$textAlignlg";
}

/* Add responsive margin/padding classes if they're set */
if ($spacing) {
    $moduleClasses ? $moduleClasses .= " $spacing" : $moduleClasses = $spacing;
}

@endphp

<div
    @if($moduleID) id="{{ $moduleID }}" @endif
    @if($internalLinkEnabled)
        id="{{ $internalLinkTarget }}"
        data-internal_link_enabled="true" @endif
    @if($internalLinkText) data-internal_link_text="{{ $internalLinkText }}" @endif
    class="bmcb-row row {{ $moduleClasses ? $moduleClasses : '' }}"
    @if($bgColor || $bgImage) style="{{ $bgColor }} {{ $bgImage }} {{ $bgSize }} {{ $bgPosition }}" @endif
    @if ($dataAtts)
        @foreach($dataAtts as $att)
            @if(!$att->value)
                <?php echo 'data-' . $att->name; ?>
            @else
                <?php echo 'data-' . $att->name . '="' . $att->value . '"' ; ?>
            @endif
        @endforeach
    @endif>
    {!! $buildy->renderContent($bladeData->content) !!}
</div>
