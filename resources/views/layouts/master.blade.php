<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta content="True" name="HandheldFriendly">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <meta name="csrf-token" content="{{ Session::token() }}">

    @if (!App::environment('production'))
        <meta name="environment" content="{{ App::environment() }}">
    @endif

    @yield('headSection')
</head>
<body style="background-color: beige">

@yield('layoutContent')

@yield('scriptsSection')
</body>
</html>
