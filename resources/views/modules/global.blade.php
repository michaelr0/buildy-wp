@php
$moduleClasses = $bladeData->attributes->class ?? null;
$bgColor = (!empty($bladeData->inline->backgroundColor)) ? "background-color: {$bladeData->inline->backgroundColor};" : "";
$bgImage = (!empty($bladeData->inline->backgroundImage->url)) ? 'background-image: url(' . $bladeData->inline->backgroundImage->url . ');' : "";
$bgSize = (!empty($bladeData->inline->backgroundImage->backgroundSize)) ? 'background-size:' . $bladeData->inline->backgroundImage->backgroundSize . ';' : "";
$bgPosition = (!empty($bladeData->inline->backgroundImage->backgroundPosition)) ? 'background-position:' . $bladeData->inline->backgroundImage->backgroundPosition . ';' : "";
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
    @if($bgColor || $bgImage) style="{{ $bgColor }} {{ $bgImage }} {{ $bgSize }} {{ $bgPosition }}" @endif
    class="bmcb-global-wrapper {{ $moduleClasses ? $moduleClasses : '' }}">
      {!! $buildy->renderFrontend($bladeData->content->id) !!}
    </div>
@endif
