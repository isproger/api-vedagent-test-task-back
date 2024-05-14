<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Calculator</title>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div id="app">
        sdsdsd
        <calculator></calculator>
    </div>

    <script src="{{ mix('js/app.js') }}"></script> <!-- Скомпилированный Vue JS файл -->
    </body>
</html>
