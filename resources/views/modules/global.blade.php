@php
$moduleClasses = $bladeData->attributes->class ?? null;
$spacing = $bladeData->generatedAttributes->spacing ?? null;
$dataAtts = $bladeData->attributes->data ?? null;
$dataAttString = null;

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

// Text colours
$colors = $bladeData->inline->color ?? null;
if ($colors) {
    forEach($colors as $key=>$val) {
        if ($val !== 'None') {
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
    $dataAttString .= " data-{$name}={$dataAtt->value}";
  }
}

/* Add responsive margin/padding classes if they're set */
if ($spacing) {
    $moduleClasses ? $moduleClasses .= " $spacing" : $moduleClasses = $spacing;
}
@endphp
@if(!empty($bladeData->content->id))
    {{--
      $bladeData->id
      $bladeData->type
      $bladeData->content
      $bladeData->content->id
      $bladeData->content->options
      $bladeData->content->options->isEditable
      $bladeData->content->options->admin_label
      $bladeData->content->attributes
      $bladeData->content->attributes->id
      $bladeData->content->attributes->class
      $bladeData->content->generatedAttributes
      $bladeData->content->generatedAttributes->columns
      $bladeData->content->generatedAttributes->spacing
    --}}

    <div
    style="
    @if($bgColor) {{ "background-color: $bgColor;" }} @endif
    @if($bgImage) {{ "background-image: url($bgImage);" }} @endif
    @if($bgSize) {{ "backround-size: $bgSize;" }} @endif
    @if($bgPosition) {{ "background-position: $bgPosition;" }} @endif
    @if($bgRepeat) {{ "background-repeat: $bgRepeat;" }} @endif"
    class="bmcb-global-wrapper {{ $moduleClasses ? $moduleClasses : '' }}">
      {!! $buildy->renderFrontend($bladeData->content->id) !!}
    </div>
@endif
