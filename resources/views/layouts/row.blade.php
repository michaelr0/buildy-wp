@php

$atts = $bladeData->attributes ?? null;

$moduleClasses = '';

if (!empty($atts)) {
  $moduleID = $bladeData->attributes->id ?? null;
  $moduleClasses = $bladeData->attributes->class ?? null;
  $internalLinkEnabled = $bladeData->attributes->in_page_link_enabled ?? null;
  $internalLinkText = $bladeData->attributes->in_page_link_text ?? null;
  $dataAtts = $bladeData->attributes->data ?? null;
}


$moduleStyle = !empty($bladeData->options) ? $bladeData->options->moduleStyle ?? null : null;

if (isset($moduleStyle) && $moduleStyle !== 'none') {
  $moduleStyle = strtolower(preg_replace("/\s+/", "-", $moduleStyle));
  $moduleClasses .= " module-style__$moduleStyle";
}

$spacing = !empty($bladeData->generatedAttributes) ? $bladeData->generatedAttributes->spacing : null;
$columns = collect($bladeData->content);

$inline = $bladeData->inline ?? null;

if (isset($inline)) {
  $textAlignxs = (string) ($bladeData->inline->textAlign->xs ?? null);
  $textAlignlg = (string) ($bladeData->inline->textAlign->xl ?? null);

  $bgSize = $bladeData->inline->backgroundImage->backgroundSize ?? "";
  $bgPosition = $bladeData->inline->backgroundImage->backgroundPosition ?? "";
  $bgRepeat = $bladeData->inline->backgroundImage->backgroundRepeat ?? null;
  $bgColor = $bladeData->inline->backgroundColor ?? "";

  $bgImageSize = $bladeData->inline->backgroundImage->imageSize ?? "full";
  $bgImageURL = $bladeData->inline->backgroundImage->url ?? null;
  $bgImageID = $bladeData->inline->backgroundImage->imageID ?? null;

  // CSS GRID
  $enableCSSGrid = $bladeData->inline->cssGrid->enabled ?? null;
  $cssGridGap = $bladeData->inline->cssGrid->gap ?? null;
}


if ((!isset($bgImageID) && isset($bgImageURL)) && function_exists('attachment_url_to_postid')) {
  $bgImageID = attachment_url_to_postid( $bgImageURL );
}

if (isset($bgImageID)) {
  $bgImageURL = wp_get_attachment_image_url( $bgImageID, $bgImageSize);
  $bgImage = $bgImageURL;
}

$internalLinkTarget = isset($internalLinkText) ? preg_replace("/\W|_/",'',$internalLinkText) : null;
$dataAttString = null;

// Add data atts to a string
if (isset($dataAtts)) {
  foreach($dataAtts as $dataAtt) {
    $name = strtolower($dataAtt->name);
    $value = stripslashes($dataAtt->value);
    $dataAttString .= " data-{$name}='{$value}' ";
  }
}


if (isset($enableCSSGrid) && $enableCSSGrid) {
    $gridPrefix = "grid";
    $moduleClasses ? $moduleClasses .= " $gridPrefix" : $moduleClasses = $gridPrefix;

    // This will become e.g grid-4-8
    $colClass = $gridPrefix;

    foreach($columns as $column) {
        $colClass .= "-" . $column->options->columns->xl;
    }

    $moduleClasses .= " $colClass";
}

if (isset($cssGridGap)) {
    $moduleClasses .= " col-gap-$cssGridGap";
}

// Temporary large/small version of text align, I'll loop this eventually
if (isset($textAlignxs)) {
    isset($moduleClasses) ? $moduleClasses .= " text-$textAlignxs" : $moduleClasses = "text-$textAlignxs";
}
if (isset($textAlignlg)) {
    isset($moduleClasses) ? $moduleClasses .= " xl:text-$textAlignlg" : $moduleClasses = "xl:text-$textAlignlg";
}
/* Add responsive margin/padding classes if they're set */
if (isset($spacing)) {
    isset($moduleClasses) ? $moduleClasses .= " $spacing" : $moduleClasses = $spacing;
}

@endphp

<div
    @isset($moduleID) id="{{ $moduleID }}" @endisset
    @if(isset($internalLinkEnabled))
        @isset($internalLinkTarget) id="{{ $internalLinkTarget }}" @endisset
        data-internal_link_enabled="true" @endif
    @isset($internalLinkText) data-internal_link_text="{{ $internalLinkText }}" @endisset
    class="bmcb-row row {{ $moduleClasses ? $moduleClasses : '' }}"
    style="
    @isset($bgColor) {{ "background-color: $bgColor;" }} @endisset
    @isset($bgImage) {{ "background-image: url($bgImage);" }} @endisset
    @isset($bgSize) {{ "background-size: $bgSize;" }} @endisset
    @isset($bgPosition) {{ "background-position: $bgPosition;" }} @endisset
    @isset($bgRepeat) {{ "background-repeat: $bgRepeat;" }} @endisset"
    @isset($dataAttString)
      {!! $dataAttString !!}
    @endisset>
    {!! $buildy->renderContent($bladeData->content) !!}
</div>
