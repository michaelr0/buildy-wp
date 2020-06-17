{{--
/**
 * @version 1.0.0
 * @since   1.0.0
 */
 --}}
@extends('modules.common')

@section('content')
    @component('modules.components.title', ['bladeData'=> $bladeData])@endcomponent
    {!! $bladeData->content->body !!}
@overwrite
