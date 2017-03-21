<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cpanel - {{ config('app.name', 'Jblog') }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app"></div>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
