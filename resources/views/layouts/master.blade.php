<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token"/>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script>
        window.app = {!! json_encode([
            'signedIn' => Auth::check(),
            'user' => Auth::user(),
        ]) !!}
    </script>

    <script src="{{ asset('js/app.js') }}" defer async></script>

    @stack('scripts')

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" data-turbolinks-track="true">

    @stack('styles')
</head>
<body style="background-image: url( {{asset('storage/patterns/email-pattern.png')}} );">

@yield('body')

{!! NoCaptcha::renderJs() !!}
<script>
    $('div[role="alert"]').delay(3000).fadeOut(1000);
</script>

</body>
</html>
