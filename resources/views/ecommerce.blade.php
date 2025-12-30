<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Primary SEO --}}
    <title>
        {{ __('Shop') }}
    </title>

    <meta name="description"
        content="{{ __('E-commerce module for OAuth2 Passport Server. Sell products, manage orders, and integrate secure authorization seamlessly.') }}">

    <meta name="keywords" content="OAuth2, Passport Server, Laravel, Shop, E-commerce, API, Authentication, Elyerr Labs">

    <meta name="author" content="Elyerr Labs">

    {{-- SEO Languages --}}
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}?lang=en">
    <link rel="alternate" hreflang="es" href="{{ url()->current() }}?lang=es">
    <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ __('Shop') }} – OAuth2 Passport Server">
    <meta property="og:description"
        content="{{ __('Modern e-commerce module built for OAuth2 Passport Server with secure authorization.') }}">
    <meta property="og:site_name" content="Elyerr Labs">
    <meta property="og:locale" content="{{ app()->getLocale() }}">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ __('Shop') }} – OAuth2 Passport Server">
    <meta name="twitter:description"
        content="{{ __('Modern e-commerce module built for OAuth2 Passport Server with secure authorization.') }}">

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('third-party/shop/css/ecommerce.css') }}">

    {{-- Hide footer for public layout --}}

    <link rel="icon" href="{{ asset('third-party/shop/favicon.png') }}" type="image/png">

    {{-- Inertia SEO --}}
    @inertiaHead
</head>

<body class="bg-white dark:bg-gray-800 font-sans min-h-screen transition-colors duration-200">

    {{-- Inertia App --}}
    @inertia

    {{-- Scripts --}}

    <script src="{{ asset('third-party/shop/js/ecommerce.js') }}"></script>

</body>

</html>
