@php
$moduleID = $bladeData->attributes->id ?? null;
$moduleClasses = $bladeData->attributes->class ?? null;
$boxed = (!empty($bladeData->options->layout_boxed) && $bladeData->options->layout_boxed) ? 'container' : 'container-fluid';

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
$spacing = $bladeData->generatedAttributes->spacing ?? null;
$dataAtts = $bladeData->attributes->data ?? null;
$dataAttString = null;

// Add data atts to a string
if (isset($dataAtts)) {
  foreach($dataAtts as $dataAtt) {
    $name = strtolower($dataAtt->name);
    $dataAttString .= " data-{$name}={$dataAtt->value}";
  }
}

/* Add responsive margin/padding classes if they're set */
if ($spacing) {
    $moduleClasses ? $moduleClasses .= " $spacing" : $moduleClasses = $spacing;
}
@endphp

{{-- @include('widgets.WP_Widget_Categories') --}}

<div
    @if($moduleID) id="{{ $moduleID }}" @endif
    @if($internalLinkEnabled)
        id="{{ $internalLinkTarget }}"
        data-internal_link_enabled="true" @endif
    @if($internalLinkText) data-internal_link_text="{{ $internalLinkText }}" @endif
    class="bmcb-section {{ $boxed ? $boxed : '' }} {{ $moduleClasses ? $moduleClasses : '' }}"
    style="
    @if($bgColor) {{ "background-color: $bgColor;" }} @endif
    @if($bgImage) {{ "background-image: url($bgImage);" }} @endif
    @if($bgSize) {{ "backround-size: $bgSize;" }} @endif
    @if($bgPosition) {{ "background-position: $bgPosition;" }} @endif
    @if($bgRepeat) {{ "background-repeat: $bgRepeat;" }} @endif"
    @if($dataAttString) {{ $dataAttString }} @endif>
    @if ($bladeData->options->inner_container ?? false)
        <div class="container">
    @endif
        {!! $buildy->renderContent($bladeData->content) !!}
    @if ($bladeData->options->inner_container ?? false)
        </div>
    @endif
</div>
