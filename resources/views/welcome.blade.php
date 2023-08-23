<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Monitoring Menu Bar</title>

        @vite(['resources/js/app.js'])
        @livewireStyles
    </head>
    <body>
        <div id="container" class="container mt-5">
            <livewire:computer-info />
        </div>

        @livewireScripts
    </body>
</html>
