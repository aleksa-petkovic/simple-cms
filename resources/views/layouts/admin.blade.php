@extends('layouts.master')

@section('headSection')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/admin.css') }}" />
@stop

@section('scriptSection')
    <script src="{{ mix('js/admin/admin.js') }}"></script>
@stop


@section('layoutContent')

    <section class="contentContainer">
        @yield('content')
    </section>

@stop
