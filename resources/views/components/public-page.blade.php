<!doctype html>
<html lang="{{ $lang }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="{{ mix('/css/front.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;800&display=swap" rel="stylesheet">

    @if($dontIndex)
    <meta name="robots" content="noindex,nofollow">
    @endif

    @if($alpine)
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script>
    @endif

    @include('front.partials.favicon-links')

    <meta name="og:image" content=""/>
    <meta name="og:url" content="{{ Request::url() }}"/>
    <meta name="og:title" content="{{ $title }}"/>
    <meta name="og:site_name" content="ELT Search"/>
    <meta name="og:type" content="Website"/>
    <meta name="og:description" content="{{ $description }}"/>
    <meta name="description" content="{{ $description }}">
    <meta name="twitter:card" content="summary_large_image">

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
</head>
<body class="flex flex-col text-black font-sans pt-16 h-full">
    <div class="flex-1">
        {{ $slot }}
    </div>

    @include('front.partials.footer')
    <x-main-navbar></x-main-navbar>
    <script src="{{ mix("/js/front.js") }}"></script>
</body>
</html>
