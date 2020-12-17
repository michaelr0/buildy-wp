@php

$atts = $bladeData->attributes ?? null;

if (!empty($atts)) {
  $moduleID = $atts->id ?? null;
  $moduleClasses = $atts->class ?? null;
  $dataAtts = $atts->data ?? null;
}

$spacing = $bladeData->generatedAttributes->spacing ?? null;
$dataAttString = null;

$inline = $bladeData->inline ?? null;

if (!empty($inline)) {
  $bgImage = $bladeData->inline->backgroundImage ?? null;
  $bgColor = $bladeData->inline->backgroundColor ?? "";
}

if (isset($bgImage)) {
  $bgSize = $bgImage->backgroundSize ?? "";
  $bgPosition = $bgImage->backgroundPosition ?? "";
  $bgRepeat = $bgImage->backgroundRepeat ?? null;
  $bgImageSize = $bgImage->imageSize ?? "full";
  $bgImageURL = $bgImage->url ?? null;
  $bgImageID = $bgImage->imageID ?? null;
}


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
    $value = stripslashes($dataAtt->value);
    $dataAttString .= " data-{$name}='{$value}' ";
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
    @if($bgSize) {{ "background-size: $bgSize;" }} @endif
    @if($bgPosition) {{ "background-position: $bgPosition;" }} @endif
    @if($bgRepeat) {{ "background-repeat: $bgRepeat;" }} @endif"
    @if($dataAttString)
      {!! $dataAttString !!}
    @endif>{!!$buildy->renderContent($bladeData->content)!!}</div>
