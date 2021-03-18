@extends('modules.common')

@php
$type = $bladeData->content->post->postType ?? null;
$perpage = $bladeData->content->post->perPage ?? 6;
$cols = $bladeData->content->post->columns ?? 3;
$offset = $bladeData->content->post->offset ?? null;
$cat_in = $bladeData->content->post->includeCats ?? null;
$paged = $bladeData->content->post->enablePagination;
$paginationType = $bladeData->content->post->paginationType ?? 'default';
$paginationTrigger = $bladeData->content->post->paginationTrigger ?? 'click';
$contentTemplate = $bladeData->content->post->contentTemplate ?? '';

// Build up the attribute string
$atts = "";
    if(!empty($perpage)) : $atts .= "perpage='$perpage' "; endif;
    if(!empty($offset)) : $atts .= "offset='$offset' "; endif;
    if(!empty($cols)) : $atts .= "cols='$cols' "; endif;
    if(!empty($type)) : $atts .= "post_type='$type' "; endif;
    if(!empty($cat_in)) : $atts .= "cats='$cat_in' "; endif;
    if(!empty($cat_in)) : $atts .= "cats='$cat_in' "; endif;
    if(!empty($paged)) : $atts .= "pagination_enabled='$paged' "; endif;
    if(!empty($paginationType)) : $atts .= "pagination_type='$paginationType' "; endif;
    if(!empty($paginationTrigger)) : $atts .= "pagination_trigger='$paginationTrigger' "; endif;
    if(!empty($contentTemplate)) : $atts .= "content_template='$contentTemplate' "; endif;
@endphp

@section('content')
    @component('modules.components.title', ['bladeData'=> $bladeData])@endcomponent
    {!! "[list-posts $atts]" !!}
@overwrite
