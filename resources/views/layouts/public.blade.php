<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Toko Emas" name="description" />
    <meta content="Wedya Pancer Dev House" name="author" />

    <link rel="shortcut icon" href="{{ asset('/assets/img/favicon.svg') }}" type="image/x-icon">

    @include('layouts.head-css')
</head>

<body>
    <div id="crancy-dark-light">
        <main class="crancy-body-area">
            @yield('content')
        </main>
    </div>

    @include('layouts.bottom-scripts')
    @yield('scripts')
    
</body>

</html>