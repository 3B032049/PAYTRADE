<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    </head>    
    <body>
        @include('layouts.partials.navigation')
        @yield('content')
        @include('layouts.partials.footer')
    </body>
<html>