@extends('modules.common')

@php
    // $map = [
    //     "primary" => "primary",
    //     "success" => "green",
    //     "info" => "lightgray",
    //     "warning" => "orange",
    //     "danger" => "red",
    //     "light" => "lightgray",
    //     "dark" => "gray",
    //     "link" => "link"
    // ];
    $buttonURL = (string) $bladeData->content->button->url;
    if (preg_match("/^\d+$/", $buttonURL)) {
        $buttonURL = get_permalink($buttonURL);
    }
    $color = $bladeData->content->button->colour;
    $bgColor = $bladeData->content->button->backgroundColor;
    $borderColor = $bladeData->content->button->borderColor;
    $showBG = $bladeData->content->button->showBackground;
    $outlined = $bladeData->content->button->outlined;
    $unStyled = $bladeData->content->button->unStyled;
    $target = $bladeData->content->button->target;
    $size = $bladeData->content->button->size && $bladeData->content->button->size !== 'Initial' ? $bladeData->content->button->size : false;
@endphp

@section('content')
    <a
    class="btn
    @if(!$unStyled)
        @if($showBG)
            bg-{{ $bgColor }}
        @endif
        @if(!$outlined)
            bg-{{ $bgColor }}
        @else
            is-outlined
        @endif
        @if($outlined && $borderColor)
            border-{{ $borderColor }}
        @endif
    @else
        btn-unstyled
    @endif
    @if($color)
        text-{{ $color }}
    @endif
    @if($size)
        btn--{{ $size }}
    @endif
    "
    @if($target)
        target="{{ $target }}"
    @endif
    href="{{ $buttonURL ? $buttonURL : '#' }}">{{ $bladeData->content->button->text }}</a>
@overwrite
