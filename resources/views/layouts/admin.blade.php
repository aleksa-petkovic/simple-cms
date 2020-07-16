@extends('layouts.master')

@section('headSection')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/admin.css') }}" />
@stop

@section('scriptsSection')
    <script src="{{ mix('js/admin/admin.js') }}"></script>
@stop

@section('layoutContent')

        @include('admin.header')

    <div class="d-flex">

        @include('admin.navigation')

        <section class="container-fluid">
            @yield('content')
        </section>
    </div>

@stop
