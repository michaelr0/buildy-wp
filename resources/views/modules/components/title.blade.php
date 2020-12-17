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
$moduleClasses = !empty($is_heading) ? $bladeData->attributes->class ?? "" : "";

if (isset($moduleType[0])) {
  $moduleClasses .= " bmcb-{$moduleType[0]}__title";
}

if (!empty($headingColorClass)) {
  $moduleClasses .= " text-$headingColorClass";
}

if (!empty($title_classes)) {
  $moduleClasses .= " $title_classes";
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
  <{{ $heading_level }}
  @if(!empty($title_id)) id='{{ $title_id }}' @endif
  @if(!empty($moduleClasses)) class='{{ $moduleClasses }}' @endif
  @if(!empty($styleAtts)) style='$styleAtts' @endif>
    {!! $title !!}
  </{{ $heading_level }}>
@endif
