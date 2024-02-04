<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Reddit Pixel -->
    <script>
        !function(w,d){if(!w.rdt){var p=w.rdt=function(){p.sendEvent?p.sendEvent.apply(p,arguments):p.callQueue.push(arguments)};p.callQueue=[];var t=d.createElement("script");t.src="https://www.redditstatic.com/ads/pixel.js",t.async=!0;var s=d.getElementsByTagName("script")[0];s.parentNode.insertBefore(t,s)}}(window,document);rdt('init','a2_efqu8k3neqv9', {"useDecimalCurrencyValues":true});rdt('track', 'PageVisit');
    </script>
    <!-- DO NOT MODIFY UNLESS TO REPLACE A USER IDENTIFIER -->
    <!-- End Reddit Pixel -->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js','resources/css/app.css', 'resources/scss/app.scss', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead


    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
