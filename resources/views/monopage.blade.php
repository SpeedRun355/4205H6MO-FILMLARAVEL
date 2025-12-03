<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrl - token" content="{{ csrf_token() }}"/>
    <title>Monopage</title>
    <link href="{{ asset('../css/app.css') }}" type="text/css" rel="stylesheet">
    <!-- reCAPTCHA v2 (render=explicit obligatoire pour Vue) -->
    <script src="https://www.google.com/recaptcha/api.js?render=explicit" async defer></script>

</head>

<body>
    @if (Auth::check())
        @php
            $user_auth_data = [
                'isLoggerdIn' => true,
                'user' => Auth::user()
                ];
        @endphp
    @else
        @php
            $user_auth_data = [
                'isLoggerdIn' => false
                ];
        @endphp   
    @endif
    <script>
        window.Laravel = JSON.parse(atob('{{ base64_encode(json_encode($user_auth_data)) }}'));
    </script>

    <div id="app">
    </div>
    <script src="{{ asset('../js/app.js') }}" type="text/javascript"></script>
</body>
</html>