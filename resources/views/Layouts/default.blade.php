<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Budgeteer') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

<div class="container-fluid w-100 bg-dark">

    <div class="section header bg-dark">
        @component('Partials/navigation') @endcomponent
    </div>
</div>

<div class="container-fluid w-100 h-100">

    <div class="section content" id="app">
        @yield('content')
    </div>

</div>

</body>
</html>
