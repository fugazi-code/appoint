<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Limelight&display=swap" rel="stylesheet">
    <style>
        .lime-light {
            font-family: 'Limelight', cursive;
        }
    </style>
</head>

<body class="app app-login p-0">
<main class="d-flex w-100">
    <div id="app" class="container d-flex flex-column">
        @isset($component)
            <{{$component}} data="{{ json_encode($data) }}">
    </{{$component}}>
    @else
    @yield('content')
    @endisset
    </div>
</main>
<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <span class="text-muted">
            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                                <a target="_blank" href="{{ env('APP_LINK') }}">
                                    {{ env('APP_NAME') }}
                                </a>
                            </p>
        </span>
    </div>
</footer>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script>
        @isset($component)
    const app = new Vue({
            el: '#app'
        });
    @endisset
</script>

@yield('scripts')
<!-- Author: Renier R. Trenuela II -->
</body>
</html>
