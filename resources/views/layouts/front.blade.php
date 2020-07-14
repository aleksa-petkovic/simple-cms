@extends('layouts.master')

@section('headSection')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/front.css') }}" />
@stop

@section('scriptSection')
    <script src="{{ mix('js/front.js') }}"></script>
@stop

@section('layoutContent')
    @yield('content')
@stop
