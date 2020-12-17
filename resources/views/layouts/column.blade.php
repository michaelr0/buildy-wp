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

if (isset($inline)) {
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


if ((!isset($bgImageID) && isset($bgImageURL)) && function_exists('attachment_url_to_postid')) {
  $bgImageID = attachment_url_to_postid( $bgImageURL );
}

if (isset($bgImageID)) {
  $bgImageURL = wp_get_attachment_image_url( $bgImageID, $bgImageSize ?? 'full');
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
if (isset($spacing)) {
    isset($moduleClasses) ? $moduleClasses .= " $spacing" : $moduleClasses = $spacing;
}

@endphp

<div @isset($moduleID) id="{{ $moduleID }}" @endisset
    class="bmcb-column col {{ $bladeData->generatedAttributes->columns }} {{ $moduleClasses ? $moduleClasses : null }}"
    style="
    @isset($bgColor) {{ "background-color: $bgColor;" }} @endisset
    @isset($bgImage) {{ "background-image: url($bgImage);" }} @endisset
    @isset($bgSize) {{ "background-size: $bgSize;" }} @endisset
    @isset($bgPosition) {{ "background-position: $bgPosition;" }} @endisset
    @isset($bgRepeat) {{ "background-repeat: $bgRepeat;" }} @endisset"
    @isset($dataAttString)
      {!! $dataAttString !!}
    @endisset>{!!$buildy->renderContent($bladeData->content)!!}</div>
