<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ELTSearch | {{ $name }}</title>

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    <META NAME="ROBOTS"
          CONTENT="NOINDEX, NOFOLLOW">

        <script>
            window.currentProfile = {
                name: "{{ $name }}",
                email: "{{ $email }}",
                avatar: "{{ $avatar }}",
                account_type: "{{ $account }}",
            }
        </script>
</head>
<body>
<div id="app">
    <app-shell></app-shell>
</div>
<script src="{{ mix("/js/{$script}") }}"></script>
</body>
</html>
