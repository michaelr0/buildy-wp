@php

$atts = $bladeData->attributes ?? null;

if (!empty($atts)) {
  $moduleID = $bladeData->attributes->id ?? null;
  $moduleClasses = $bladeData->attributes->class ?? null;
  $internalLinkEnabled = $bladeData->attributes->in_page_link_enabled ?? null;
  $internalLinkText = $bladeData->attributes->in_page_link_text ?? null;
  $dataAtts = $bladeData->attributes->data ?? null;
}

$options = $bladeData->options ?? null;

if (!empty($options)) {
  $moduleStyle = $bladeData->options->moduleStyle ?? null ?? null;
  $boxed = (!empty($bladeData->options->layout_boxed) && $bladeData->options->layout_boxed) ? 'container' : 'container-fluid';
}

if (isset($moduleStyle) && $moduleStyle !== 'none') {
  $moduleStyle = strtolower(preg_replace("/\s+/", "-", $moduleStyle));
  $moduleClasses .= " module-style__$moduleStyle";
}

$inline = $bladeData->inline ?? null;

if (isset($inline)) {
  $bgSize = $bladeData->inline->backgroundImage->backgroundSize ?? "";
  $bgPosition = $bladeData->inline->backgroundImage->backgroundPosition ?? "";
  $bgRepeat = $bladeData->inline->backgroundImage->backgroundRepeat ?? null;
  $bgColor = $bladeData->inline->backgroundColor ?? "";
  $bgImageSize = $bladeData->inline->backgroundImage->imageSize ?? "full";
  $bgImageURL = $bladeData->inline->backgroundImage->url ?? null;
  $bgImageID = $bladeData->inline->backgroundImage->imageID ?? null;
}

if ((!isset($bgImageID) && isset($bgImageURL)) && function_exists('attachment_url_to_postid')) {
  $bgImageID = attachment_url_to_postid( $bgImageURL );
}

if (isset($bgImageID)) {
  $bgImageURL = wp_get_attachment_image_url( $bgImageID, $bgImageSize);
  $bgImage = $bgImageURL;
}

$internalLinkTarget = isset($internalLinkText) ? preg_replace("/\W|_/",'',$internalLinkText) : null;
$spacing = $bladeData->generatedAttributes->spacing ?? null;
$dataAttString = null;

// Add data atts to a string
if (isset($dataAtts)) {
  foreach($dataAtts as $dataAtt) {
    $name = strtolower($dataAtt->name);
    $value = stripslashes($dataAtt->value);
    $dataAttString .= " data-{$name}='{$value}' ";
  }
}

/* Add responsive margin/padding classes if they're set */
if (isset($spacing)) {
    isset($moduleClasses) ? $moduleClasses .= " $spacing" : $moduleClasses = $spacing;
}
@endphp

{{-- @include('widgets.WP_Widget_Categories') --}}

<div
    @isset($moduleID) id="{{ $moduleID }}" @endisset
    @if(isset($internalLinkEnabled) && $internalLinkEnabled)
        @isset($internalLinkTarget) id="{{ $internalLinkTarget }}" @endisset
        data-internal_link_enabled="true"
    @endif
    @isset($internalLinkText) data-internal_link_text="{{ $internalLinkText }}" @endisset
    class="bmcb-section {{ $boxed ? $boxed : '' }} {{ $moduleClasses ? $moduleClasses : '' }}"
    style="
    @isset($bgColor) {{ "background-color: $bgColor;" }} @endisset
    @isset($bgImage) {{ "background-image: url($bgImage);" }} @endisset
    @isset($bgSize) {{ "background-size: $bgSize;" }} @endisset
    @isset($bgPosition) {{ "background-position: $bgPosition;" }} @endisset
    @isset($bgRepeat) {{ "background-repeat: $bgRepeat;" }} @endisset"
    @isset($dataAttString)
      {!! $dataAttString !!}
    @endisset>
    @if (isset($options) ? $options->inner_container ?? false : false)
        <div class="container">
    @endif
        {!! $buildy->renderContent($bladeData->content) !!}
    @if (isset($options) ? $options->inner_container ?? false : false)
        </div>
    @endif
</div>
