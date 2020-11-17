@php
$moduleID = $bladeData->attributes->id ?? null;
$moduleClasses = $bladeData->attributes->class ?? null;

$moduleStyle = $bladeData->options->moduleStyle ?? null;

if ($moduleStyle && $moduleStyle !== 'none') {
  $moduleStyle = strtolower(preg_replace("/\s+/", "-", $moduleStyle));
  $moduleClasses .= " module-style__$moduleStyle";
}

$spacing = $bladeData->generatedAttributes->spacing ?? null;
$textAlignxs = (string) ($bladeData->inline->textAlign->xs ?? null);
$textAlignlg = (string) ($bladeData->inline->textAlign->xl ?? null);
$columns = collect($bladeData->content);

$bgSize = (!empty($bladeData->inline->backgroundImage->backgroundSize)) ? $bladeData->inline->backgroundImage->backgroundSize : "";
$bgPosition = (!empty($bladeData->inline->backgroundImage->backgroundPosition)) ? $bladeData->inline->backgroundImage->backgroundPosition : "";
$bgRepeat = $bladeData->inline->backgroundImage->backgroundRepeat ?: null;
$bgColor = (!empty($bladeData->inline->backgroundColor)) ? $bladeData->inline->backgroundColor : "";

$bgImageSize = (!empty($bladeData->inline->backgroundImage->imageSize)) ? $bladeData->inline->backgroundImage->imageSize : "full";
$bgImageURL = (!empty($bladeData->inline->backgroundImage->url)) ? $bladeData->inline->backgroundImage->url : null;
$bgImageID = $bladeData->inline->backgroundImage->imageID ?? null;

if ((!$bgImageID && $bgImageURL) && function_exists('attachment_url_to_postid')) {
  $bgImageID = attachment_url_to_postid( $bgImageURL );
}

if ($bgImageID) {
  $bgImageURL = wp_get_attachment_image_url( $bgImageID, $bgImageSize);
  $bgImage = $bgImageURL;
}

$internalLinkEnabled = $bladeData->attributes->in_page_link_enabled ?? null;
$internalLinkText = $bladeData->attributes->in_page_link_text ?? null;
$internalLinkTarget = $internalLinkText ? preg_replace("/\W|_/",'',$internalLinkText) : null;
$dataAtts = $bladeData->attributes->data ?? null;
$dataAttString = null;

// Add data atts to a string
if (isset($dataAtts)) {
  foreach($dataAtts as $dataAtt) {
    $name = strtolower($dataAtt->name);
    $value = stripslashes($dataAtt->value);
    $dataAttString .= " data-{$name}='{$value}' ";
  }
}

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
    style="
    @if($bgColor) {{ "background-color: $bgColor;" }} @endif
    @if($bgImage) {{ "background-image: url($bgImage);" }} @endif
    @if($bgSize) {{ "background-size: $bgSize;" }} @endif
    @if($bgPosition) {{ "background-position: $bgPosition;" }} @endif
    @if($bgRepeat) {{ "background-repeat: $bgRepeat;" }} @endif"
    @if($dataAttString)
      {!! $dataAttString !!}
    @endif>
    {!! $buildy->renderContent($bladeData->content) !!}
</div>
