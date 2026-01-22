<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- SEO Meta Tags -->
        <title>Estilo Mafia Hats | Gorras con Carácter y Exclusividad</title>
        <meta name="description" content="Estilo Mafia Hats: Gorras con carácter para quienes entienden que el estilo es una declaración. Diseños exclusivos, producción cuidada y detalles que marcan diferencia. No sigues tendencias, las representas.">
        <meta name="keywords" content="gorras exclusivas, caps premium, estilo mafia hats, gorras con carácter, moda urbana, streetwear, gorras México, snapback, trucker hat">
        <meta name="author" content="Estilo Mafia Hats">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:title" content="Estilo Mafia Hats | Gorras con Carácter">
        <meta property="og:description" content="Diseños con carácter, producción cuidada y detalles que marcan diferencia. Exclusividad real: piezas pensadas para destacar sin pedir permiso.">
        <meta property="og:image" content="{{ asset('og-image.jpg') }}">
        <meta property="og:site_name" content="Estilo Mafia Hats">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url('/') }}">
        <meta property="twitter:title" content="Estilo Mafia Hats | Gorras con Carácter">
        <meta property="twitter:description" content="No somos lujo, somos exclusividad real. Gorras pensadas para destacar sin pedir permiso.">
        <meta property="twitter:image" content="{{ asset('twitter-image.jpg') }}">

        <!-- Favicons -->
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <meta name="theme-color" content="#740d11">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div id="app"></div>
    </body>
</html>
