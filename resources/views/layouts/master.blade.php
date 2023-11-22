<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>    
    <body>
        @include('layouts.partials.navigation')
        <section id="location">
            @yield('content')
        </section>        
        @include('layouts.partials.footer')
    </body>
<html>