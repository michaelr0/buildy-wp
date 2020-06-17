@extends('modules.common')

 {{-- @section('class', 'spud') --}}

@section('content')
    @component('modules.components.title', ['bladeData'=> $bladeData])@endcomponent
    {!! $bladeData->content->body !!}
@overwrite
