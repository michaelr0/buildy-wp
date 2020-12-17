@extends('modules.common')

@php
    $buttonURL = (string) $bladeData->content->button->url ?? null;
    if (isset($buttonURL) preg_match("/^\d+$/", $buttonURL)) {
        $buttonURL = get_permalink($buttonURL);
    }
    $color = $bladeData->content->button->colour ?? null;
    $bgColor = $bladeData->content->button->backgroundColor ?? null;
    $borderColor = $bladeData->content->button->borderColor ?? null;
    $showBG = $bladeData->content->button->showBackground ?? false;
    $outlined = $bladeData->content->button->outlined ?? false;
    $unStyled = $bladeData->content->button->unStyled ?? false;
    $target = $bladeData->content->button->target ?? null;
    $size = ($bladeData->content->button->size && $bladeData->content->button->size !== 'Initial') ? $bladeData->content->button->size ?? false : false;
@endphp

@section('content')
    <a
    class="btn
    @if(!$unStyled)
        @if($showBG && isset($bgColor))
            bg-{{ $bgColor }}
        @endif
        @if(!$outlined && isset($bgColor))
            bg-{{ $bgColor }}
        @else
            is-outlined
        @endif
        @if($outlined && isset($borderColor))
            border-{{ $borderColor }}
        @endif
    @else
        btn-unstyled
    @endif
    @isset($color)
        text-{{ $color }}
    @endisset
    @isset($size)
        btn--{{ $size }}
    @endisset
    "
    @isset($target)
        target="{{ $target }}"
    @endisset
    href="{{ isset($buttonURL) ? $buttonURL : '#' }}">{{ $bladeData->content->button->text }}</a>
@overwrite
