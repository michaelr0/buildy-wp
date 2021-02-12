
@php
  $module_link_url = $bladeData->options->module_link->url ?? null;
  $images = $bladeData->content->gallery->images ?? null;
  $gap = isset($bladeData->content->gallery->columnGap) ? "gap: {$bladeData->content->gallery->columnGap};" : "gap: 2rem";
  $is_slider = !empty($bladeData->content->gallery->isSlider) ? "bmcb-slider" : false;
  $options = $bladeData->options->slider ?? null;
  $cols = !empty($bladeData->content->gallery->columnCount) ? "grid-{$bladeData->content->gallery->columnCount}" : 'grid-3';
@endphp

@extends('modules.common', ["customClasses" => "{$is_slider}"])

@section('content')
    @if(!empty($module_link_url))
        <a @if($module_link_new_tab) target="_blank" @endif href="{{ $module_link_url }}">
    @endif

    @component('modules.components.title', ['bladeData'=> $bladeData])@endcomponent

    @if(!empty($images))
      <div 
        class="bmcb-gallery__items {{ !$is_slider ? 'grid' : '' }} {{ $cols }}" 
        @if(!empty($gap) && !$is_slider) 
          style="{{ $gap }}" 
        @endif
        @if (isset($options) && $is_slider)
          @foreach($options as $key=>$val)
            @if($val !== '')
              data-{{ $key }}="{{ $val ? $val : 'false' }}"
            @endif
          @endforeach
        @endif
      >
        @foreach($images as $image)
          @if(!$is_slider)
            <a class="bmcb-gallery__item" href="<?= wp_get_attachment_url($image->id); ?>">
              <?= wp_get_attachment_image($image->id, 'large', "", array( "class" => "bmcb-image"  )); ?>
            </a>
          @else
            <?= wp_get_attachment_image($image->id, 'full', "", array( "class" => "bmcb-image bmcb-gallery__item bmcb-gallery__item--slide"  )); ?>
          @endif
        @endforeach
      </div>
    @endif

    @if(!empty($module_link_url))
        </a>
    @endif
@overwrite