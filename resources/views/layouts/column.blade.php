@php
$moduleID = $bladeData->attributes->id ?? null;
$moduleClasses = $bladeData->attributes->class ?? null;
$spacing = $bladeData->generatedAttributes->spacing ?? null;
$dataAtts = $bladeData->attributes->data ?? null;
$dataAttString = null;

$bgSize = (!empty($bladeData->inline->backgroundImage->backgroundSize)) ? $bladeData->inline->backgroundImage->backgroundSize : "";
$bgPosition = (!empty($bladeData->inline->backgroundImage->backgroundPosition)) ? $bladeData->inline->backgroundImage->backgroundPosition : "";
$bgRepeat = $bladeData->inline->backgroundImage->backgroundRepeat ?: 'no-repeat';
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

if (isset($dataAtts)) {
  foreach($dataAtts as $dataAtt) {
    $name = strtolower($dataAtt->name);
    $dataAttString .= " data-{$name}={$dataAtt->value}";
  }
}

/* Add responsive margin/padding classes if they are set */
if ($spacing) {
    $moduleClasses ? $moduleClasses .= " $spacing" : $moduleClasses = $spacing;
}

@endphp

<div id="{{ $moduleID }}"
    class="bmcb-column col {{ $bladeData->generatedAttributes->columns }} {{ $moduleClasses ? $moduleClasses : null }}"
    style="
    @if($bgColor) {{ "background-color: $bgColor;" }} @endif
    @if($bgImage) {{ "background-image: url($bgImage);" }} @endif
    @if($bgSize) {{ "backround-size: $bgSize;" }} @endif
    @if($bgPosition) {{ "background-position: $bgPosition;" }} @endif
    @if($bgRepeat) {{ "background-repeat: $bgRepeat;" }} @endif"
    @if($dataAttString) {{ $dataAttString }} @endif>{!!$buildy->renderContent($bladeData->content)!!}</div>
