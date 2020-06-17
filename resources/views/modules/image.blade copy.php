@extends('modules.common')

@php
    $image = $bladeData->content->image->url;
    $width = $bladeData->content->image->width ? "width: {$bladeData->content->image->width};" : '';
    $maxWidth = $bladeData->content->image->maxWidth ? "max-width: {$bladeData->content->image->maxWidth};" : '';
    $height = $bladeData->content->image->height ? "height: {$bladeData->content->image->height};" : '';
    $objectFit = $bladeData->content->image->height ? "object-fit: {$bladeData->content->image->objectFit};" : '';
    $objectPosition = $bladeData->content->image->height ? "object-position: {$bladeData->content->image->objectPosition};" : '';
    if (function_exists('attachment_url_to_postid')) {
        $image_ID = attachment_url_to_postid( $image );
    }
@endphp

@section('content')
    @component('modules.components.title', ['bladeData'=> $bladeData])@endcomponent
    @if($image_ID && function_exists('wp_get_attachment_image'))
        @php echo wp_get_attachment_image($image_ID, 'full', false, array( "style" => "{{ $width }} {{ $maxWidth }} {{ $height }} {{ $objectFit }} {{ $objectPosition }}" )); @endphp
    @else
        <img style="{{ $width }} {{ $maxWidth }} {{ $height }} {{ $objectFit }} {{ $objectPosition }}"
        @if($image) src="{{ $image }}" @endif />
    @endif
@overwrite
