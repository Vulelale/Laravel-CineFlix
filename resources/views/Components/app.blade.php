<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'CineFlix')</title>
    @vite('resources/css/app.css')
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('icon/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>
<body>
    
    @include('inc.navbar')
    
    
    
    @include('inc.dugme')  
    
    {{$slot}}
    
    @if (request()->is('/'))
    @include('inc.card')
    @endif
    
    @include('inc.footer')
    
    
</body>
</html>