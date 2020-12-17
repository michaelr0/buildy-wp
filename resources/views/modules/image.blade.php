@extends('modules.common')

@php
    $width = $bladeData->content->image->width ? "width: {$bladeData->content->image->width};" : '';
    $maxWidth = $bladeData->content->image->maxWidth ? "max-width: {$bladeData->content->image->maxWidth};" : '';
    $height = $bladeData->content->image->height ? "height: {$bladeData->content->image->height};" : '';
    $maxHeight = $bladeData->content->image->maxHeight ? "max-height: {$bladeData->content->image->maxHeight};" : '';
    $module_link_url = $bladeData->options->module_link->url ?? null;
    $module_link_new_tab = $bladeData->options->module_link->new_tab ?? null;

    $objectFit = $bladeData->content->image->objectFit ? "object-fit: {$bladeData->content->image->objectFit};" : '';
    $objectPosition = $bladeData->content->image->objectPosition ? "object-position: {$bladeData->content->image->objectPosition};" : '';
    $imageURL = (!empty($bladeData->content->image->url)) ? $bladeData->content->image->url : null;
    $imageSize = (!empty($bladeData->content->image->imageSize)) ? $bladeData->content->image->imageSize : "full";
    $imageID = $bladeData->content->image->imageID ?? null;

    if ((!$imageID && $imageURL) && function_exists('attachment_url_to_postid')) {
      $imageID = attachment_url_to_postid( $imageURL );
    }
@endphp

@section('content')
    @if(!empty($module_link_url))
        <a @if($module_link_new_tab) target="_blank" @endif href="{{ $module_link_url }}">
    @endif
    @component('modules.components.title', ['bladeData'=> $bladeData])@endcomponent
    @if(!empty($imageID) && function_exists('wp_get_attachment_image'))
        @php echo wp_get_attachment_image($imageID, $imageSize, "", array( "class" => "bmcb-image", "style" => "$width $maxWidth $height $maxHeight $objectFit $objectPosition" )); @endphp
    @else
        <img style="{{ $width }} {{ $maxWidth }} {{ $height }} {{ $objectFit }} {{ $objectPosition }}"
        @if(!empty($imageURL)) src="{{ $imageURL }}" @endif />
    @endif
    @if(!empty($module_link_url))
        </a>
    @endif
@overwrite
