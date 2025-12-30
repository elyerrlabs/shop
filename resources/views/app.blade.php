<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- Primary SEO --}}
    <title>
        {{ __('Shop Administration') }} – OAuth2 Passport Server
    </title>

    <meta name="description"
        content="{{ __('Administration panel for the Shop module of OAuth2 Passport Server. Manage products, orders, and subscriptions securely and efficiently.') }}">

    <meta name="keywords"
        content="OAuth2, Passport Server, Laravel, Shop Module, E-commerce, Admin Panel, API, Authentication">

    <meta name="author" content="Elyerr Labs">

    {{-- Language / SEO --}}
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}?lang=en">
    <link rel="alternate" hreflang="es" href="{{ url()->current() }}?lang=es">
    <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ __('Shop Administration') }} – OAuth2 Passport Server">
    <meta property="og:description"
        content="{{ __('Secure e-commerce administration module built for OAuth2 Passport Server.') }}">
    <meta property="og:site_name" content="Elyerr Labs">
    <meta property="og:locale" content="{{ app()->getLocale() }}">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ __('Shop Administration') }} – OAuth2 Passport Server">
    <meta name="twitter:description"
        content="{{ __('Secure e-commerce administration module built for OAuth2 Passport Server.') }}">

    <link rel="icon" href="{{ asset('third-party/shop/favicon.png') }}" type="image/png">

    {{-- Styles --}}
    <link nonce="{{ $nonce }}" href="{{ asset('third-party/shop/css/app.css') }}" rel="stylesheet">

    {{-- Translations --}}
    <x-shop-translator />

    {{-- Inertia --}}
    @inertiaHead
</head>

<body class="bg-white dark:bg-gray-800 font-sans min-h-screen transition-colors duration-200">

    @inertia

    <script nonce="{{ $nonce }}" src="{{ asset('third-party/shop/js/app.js') }}"></script>
</body>

</html>
