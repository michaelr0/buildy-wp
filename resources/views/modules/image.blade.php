@extends('modules.common')

@php
    $image = $bladeData->content->image->url;
    $width = $bladeData->content->image->width ? "width: {$bladeData->content->image->width};" : '';
    $maxWidth = $bladeData->content->image->maxWidth ? "max-width: {$bladeData->content->image->maxWidth};" : '';
    $height = $bladeData->content->image->height ? "height: {$bladeData->content->image->height};" : '';
    $maxHeight = $bladeData->content->image->maxHeight ? "max-height: {$bladeData->content->image->maxHeight};" : '';
    $objectFit = $bladeData->content->image->objectFit ? "object-fit: {$bladeData->content->image->objectFit};" : '';
    $objectPosition = $bladeData->content->image->objectPosition ? "object-position: {$bladeData->content->image->objectPosition};" : '';
    $module_link_url = $bladeData->options->module_link->url ?? null;
    if (function_exists('attachment_url_to_postid')) {
        $image_ID = attachment_url_to_postid( $image );
    }
@endphp

@section('content')
    @if(!empty($module_link_url))
        <a href="{{ $module_link_url }}">
    @endif
    @component('modules.components.title', ['bladeData'=> $bladeData])@endcomponent
    @if($image_ID && function_exists('wp_get_attachment_image'))
        @php echo wp_get_attachment_image($image_ID, 'full', "", array( "class" => "bmcb-image", "style" => "$width $maxWidth $height $maxHeight $objectFit $objectPosition" )); @endphp
    @else
        <img style="{{ $width }} {{ $maxWidth }} {{ $height }} {{ $objectFit }} {{ $objectPosition }}"
        @if($image) src="{{ $image }}" @endif />
    @endif
    @if(!empty($module_link_url))
        </a>
    @endif
@overwrite
