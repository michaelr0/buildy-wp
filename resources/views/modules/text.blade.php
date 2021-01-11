@extends('modules.common')

 {{-- @section('class', 'spud') --}}

 @php
 //Content
  $bodyContent = $bladeData->content->body ?? null;
 @endphp

@section('content')
    @component('modules.components.title', ['bladeData'=> $bladeData])@endcomponent
    {!! $bodyContent !!}
@overwrite
