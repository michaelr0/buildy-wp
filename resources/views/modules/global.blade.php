@php
$moduleClasses = $bladeData->attributes->class ?? null;
$spacing = $bladeData->generatedAttributes->spacing ?? null;
$dataAtts = $bladeData->attributes->data ?? null;
$dataAttString = null;

$bgSize = $bladeData->inline->backgroundImage->backgroundSize ?? "";
$bgPosition = $bladeData->inline->backgroundImage->backgroundPosition ?? "";
$bgRepeat = $bladeData->inline->backgroundImage->backgroundRepeat ?? null;
$bgColor = $bladeData->inline->backgroundColor ?? "";
$bgImageSize = $bladeData->inline->backgroundImage->imageSize ?? "full";
$bgImageURL = $bladeData->inline->backgroundImage->url ?? null;
$bgImageID = $bladeData->inline->backgroundImage->imageID ?? null;

if ((!isset($bgImageID) && isset($bgImageURL)) && function_exists('attachment_url_to_postid')) {
  $bgImageID = attachment_url_to_postid( $bgImageURL );
}

if (isset($bgImageID)) {
  $bgImageURL = wp_get_attachment_image_url( $bgImageID, $bgImageSize);
  $bgImage = $bgImageURL;
}

// Text colours
$colors = $bladeData->inline->color ?? null;
if (isset($colors)) {
    forEach($colors as $key=>$val) {
        if (strtolower($val) !== 'none') {
            if ($key !== 'xs') {
                $moduleClasses ? $moduleClasses .= " $key:text-$val" : $moduleClasses = "$key:text-$val";
            } else {
                $moduleClasses ? $moduleClasses .= " text-$val" : $moduleClasses = "text-$val";
            }
        }
    }
}
// Add data atts to a string
if (isset($dataAtts)) {
  foreach($dataAtts as $dataAtt) {
    $name = strtolower($dataAtt->name);
    $value = stripslashes($dataAtt->value);
    $dataAttString .= " data-{$name}='{$value}' ";
  }
}

/* Add responsive margin/padding classes if they're set */
if ($spacing) {
    $moduleClasses ? $moduleClasses .= " $spacing" : $moduleClasses = $spacing;
}
@endphp
@if(!empty($bladeData->content->id))
    <div
    style="
    @isset($bgColor) {{ "background-color: $bgColor;" }} @endisset
    @isset($bgImage) {{ "background-image: url($bgImage);" }} @endisset
    @isset($bgSize) {{ "background-size: $bgSize;" }} @endisset
    @isset($bgPosition) {{ "background-position: $bgPosition;" }} @endisset
    @isset($bgRepeat) {{ "background-repeat: $bgRepeat;" }} @endisset"
    class="bmcb-global-wrapper {{ $moduleClasses ? $moduleClasses : '' }}"
    @isset($dataAttString)
      {!! $dataAttString !!}
    @endisset>
      {!! $buildy->renderFrontend($bladeData->content->id) !!}
    </div>
@endif
