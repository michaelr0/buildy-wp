@php
$moduleID = $bladeData->attributes->id ?? null;
$moduleClasses = $bladeData->attributes->class ?? null;
$boxed = (!empty($bladeData->options->layout_boxed) && $bladeData->options->layout_boxed) ? 'container' : 'container-fluid';
$bgImage = (!empty($bladeData->inline->backgroundImage->url)) ? 'background-image: url(' . $bladeData->inline->backgroundImage->url . ');' : "";
$bgSize = (!empty($bladeData->inline->backgroundImage->backgroundSize)) ? 'background-size:' . $bladeData->inline->backgroundImage->backgroundSize . ';' : "";
$bgPosition = (!empty($bladeData->inline->backgroundImage->backgroundPosition)) ? 'background-position:' . $bladeData->inline->backgroundImage->backgroundPosition . ';' : "";
$bgColor = (!empty($bladeData->inline->backgroundColor)) ? "background-color: {$bladeData->inline->backgroundColor};" : "";
$internalLinkEnabled = $bladeData->attributes->in_page_link_enabled ?? null;
$internalLinkText = $bladeData->attributes->in_page_link_text ?? null;
$internalLinkTarget = $internalLinkText ? preg_replace("/\W|_/",'',$internalLinkText) : null;
$spacing = $bladeData->generatedAttributes->spacing ?? null;
$dataAtts = $bladeData->attributes->data ?? null;

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
    @if($bgColor || $bgImage) style="{{ $bgColor }} {{ $bgImage }} {{ $bgSize }} {{ $bgPosition }}" @endif
    @if ($dataAtts)
        @foreach($dataAtts as $att)
            @if(!$att->value)
                <? echo 'data-' . $att->name; ?>
            @else
                <? echo 'data-' . $att->name . '="' . $att->value . '"' ; ?>
            @endif
        @endforeach
    @endif>
    @if ($bladeData->options->inner_container ?? false)
        <div class="container">
    @endif
        {!! $buildy->renderContent($bladeData->content) !!}
    @if ($bladeData->options->inner_container ?? false)
        </div>
    @endif
</div>
