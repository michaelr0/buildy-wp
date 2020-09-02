@extends('modules.common')

@php
    $moduleClasses = $bladeData->attributes->class ? $bladeData->attributes->class : null;
    $color = $bladeData->inline->backgroundColor ? $bladeData->inline->backgroundColor : null;
    $height = $bladeData->inline->height ? $bladeData->inline->height : null;
@endphp

@section('content')
    <hr style="
    @isset($color)
        background-color: {{ $color }};
    @endisset
    @isset($height)
        height: {{ $height }};
    @endisset" class="bmcb-hr {{ $moduleClasses ? $moduleClasses : '' }}" />
@overwrite
