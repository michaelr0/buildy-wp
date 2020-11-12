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
$title_id = $bladeData->content->title->id ?? null;
$title_classes = $bladeData->content->title->class ?? null;

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
    {!! "<".$heading_level." id='$title_id' class='bmcb-$moduleType[0]__title text-$headingColorClass $moduleClasses $title_classes' style='$styleAtts'>" !!}
    {!! $title !!}
    {!! "</".$heading_level.">" !!}
@endif
