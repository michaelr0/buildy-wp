@php
$moduleID = $bladeData->attributes->id ?? null;
$moduleClasses = $bladeData->attributes->class ?? null;
$bgImage = (!empty($bladeData->inline->backgroundImage->url)) ? 'background-image: url(' . $bladeData->inline->backgroundImage->url . ');' : "";
$bgSize = (!empty($bladeData->inline->backgroundImage->backgroundSize)) ? 'background-size:' . $bladeData->inline->backgroundImage->backgroundSize . ';' : "";
$bgPosition = (!empty($bladeData->inline->backgroundImage->backgroundPosition)) ? 'background-position:' . $bladeData->inline->backgroundImage->backgroundPosition . ';' : "";
$bgColor = (!empty($bladeData->inline->backgroundColor)) ? "background-color: {$bladeData->inline->backgroundColor};" : "";
$spacing = $bladeData->generatedAttributes->spacing ?? null;
$dataAtts = $bladeData->attributes->data ?? null;
$dataAttString = null;

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

<div id="{{ $moduleID }}"
    class="bmcb-column col {{ $bladeData->generatedAttributes->columns }} {{ $moduleClasses ? $moduleClasses : null }}"
    @if($bgColor || $bgImage) style="{{ $bgColor }} {{ $bgImage }} {{ $bgSize }} {{ $bgPosition }}" @endif
    @if($dataAttString) {{ $dataAttString }} @endif>{!!$buildy->renderContent($bladeData->content)!!}</div>
