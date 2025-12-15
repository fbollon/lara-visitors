<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'LaraVisitors Dashboard')</title>

    @if (config('laravisitors.provide_assets'))
        <link rel="stylesheet" href="{{ asset('vendor/laravisitors/assets/app.css') }}">
    @endif

    @stack('styles')
</head>

<body>
    <div class="container my-4">
        <a href="{{ url(config('app.url', null)) }}">
            < Back to {{ config('app.name') }}</a>
                @yield('content')
    </div>

    @if (config('laravisitors.provide_assets'))
        <script src="{{ asset('vendor/laravisitors/assets/app.js') }}"></script>
    @endif

    @yield('scripts')
    @stack('scripts')
</body>

</html>
