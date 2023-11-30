<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript"
                src="https://app.sandbox.midtrans.com/snap/snap.js"
                data-client-key="{{config('midtrans.client_key')}}"></script>

        <title inertia>{{ config('app.name', 'Vue-Soop') }}</title>
        <link rel="icon" type="image/x-icon" href="{{ url('/images/logo.png') }}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="text-base text-body-color font-poppins bg-body dark:text-white dark:bg-zink-800">
        @inertia
    </body>
</html>
