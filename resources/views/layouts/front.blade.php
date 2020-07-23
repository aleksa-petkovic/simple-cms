@extends('layouts.master')

@section('headSection')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/front.css') }}" />
    <style type="text/css">
        @media screen and (min-width: 768px){
            .dropdown:hover .dropdown-menu, .btn-group:hover .dropdown-menu{
                display: block;
            }
            .dropdown-menu{
                margin-top: 0;
            }
            .dropdown-toggle{
                margin-bottom: 2px;
            }
            .navbar .dropdown-toggle, .nav-tabs .dropdown-toggle{
                margin-bottom: 0;
            }
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".dropdown, .btn-group").hover(function(){
                var dropdownMenu = $(this).children(".dropdown-menu");
                if(dropdownMenu.is(":visible")){
                    dropdownMenu.parent().toggleClass("open");
                }
            });
        });
    </script>
@stop

@section('scriptSection')
    <script src="{{ mix('js/front.js') }}"></script>
@stop

@section('layoutContent')
    <header class="header js-header">
        @include('header.nav')
    </header>

    @yield('content')
@stop
