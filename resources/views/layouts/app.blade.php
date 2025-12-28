<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
    </style>
</head>
<body>
<div class="container">
    <nav class="side">
        @yield('menu')
    </nav>
    <main class="content">
        @yield('content')
    </main>
</div>
</body>
</html>
