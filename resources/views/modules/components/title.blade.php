{{--
/**
 * @version 1.0.0
 * @since   1.0.0
 */
 --}}
@php
$moduleType = explode('-', $bladeData->type);
$title = $bladeData->content->title->value ?? null;
$default_level = $default ?? 'h3';
$heading_level = $bladeData->content->title->level ?? $default_level;
$color = $bladeData->content->title->color ?? null;
if (!empty($is_heading)) {
    $moduleClasses = $bladeData->attributes->class ?? null;
}else{
    $moduleClasses = null;
}

if($color) {
    if (strpos($color, '#') !== false) {
        $styleAtts = "color: $color;";
    } else {
        $headingColorClass = strtolower($color);
    }
}
@endphp
@if($title)
    {!! "<".$heading_level." class='bmcb-$moduleType[0]__title text-$headingColorClass $moduleClasses' style='$styleAtts'>" !!}
    {!! $title !!}
    {!! "</".$heading_level.">" !!}
@endif
