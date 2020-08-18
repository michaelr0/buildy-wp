@php
$moduleID = $bladeData->attributes->id ?? null;
$moduleClasses = $bladeData->attributes->class ?? null;
$bgImage = (!empty($bladeData->inline->backgroundImage->url)) ? 'background-image: url(' . $bladeData->inline->backgroundImage->url . ');' : "";
$bgSize = (!empty($bladeData->inline->backgroundImage->backgroundSize)) ? 'background-size:' . $bladeData->inline->backgroundImage->backgroundSize . ';' : "";
$bgPosition = (!empty($bladeData->inline->backgroundImage->backgroundPosition)) ? 'background-position:' . $bladeData->inline->backgroundImage->backgroundPosition . ';' : "";
$bgColor = (!empty($bladeData->inline->backgroundColor)) ? "background-color: {$bladeData->inline->backgroundColor};" : "";
$spacing = $bladeData->generatedAttributes->spacing ?? null;
$dataAtts = $bladeData->attributes->data ?? null;

/* Add responsive margin/padding classes if they're set */
if ($spacing) {
    $moduleClasses ? $moduleClasses .= " $spacing" : $moduleClasses = $spacing;
}

@endphp

<div id="{{ $moduleID }}"
    class="bmcb-column col {{ $bladeData->generatedAttributes->columns }} {{ $moduleClasses ? $moduleClasses : null }}"
    @if($bgColor || $bgImage) style="{{ $bgColor }} {{ $bgImage }} {{ $bgSize }} {{ $bgPosition }}" @endif
    @if ($dataAtts)
        @foreach($dataAtts as $att)
            @if(!$att->value)
                <? echo 'data-' . $att->name; ?>
            @else
                <? echo 'data-' . $att->name . '="' . $att->value . '"' ; ?>
            @endif
        @endforeach
    @endif>{!!$buildy->renderContent($bladeData->content)!!}</div>
