@extends('modules.common')

@php
    //  Accordion
    $items = $bladeData->content->accordion->items ?? null;
@endphp

 @section('content')
    @component('modules.components.title', ['bladeData'=> $bladeData])@endcomponent

    @foreach($items as $index=>$item)
        <div class="accordion" @if($index === 0) open @endif>
            <div class="accordion-title">{{ $item->title }}</div>
            <div class="accordion-body">{!! $item->body !!}</div>
        </div>
    @endforeach
 @overwrite
