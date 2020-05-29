<!doctype html>
<html lang="{{ $lang }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="{{ mix('/css/front.css') }}">

    <meta name="og:image" content=""/>
    <meta name="og:url" content="{{ Request::url() }}"/>
    <meta name="og:title" content="{{ $title }}"/>
    <meta name="og:site_name" content="ELT Search"/>
    <meta name="og:type" content="Website"/>
    <meta name="og:description" content="{{ $description }}"/>
    <meta name="description" content="{{ $description }}">
    <meta name="twitter:card" content="summary_large_image">
</head>
<body>
    {{ $slot }}
    <script src="{{ mix("/js/front.js") }}"></script>
</body>
</html>
