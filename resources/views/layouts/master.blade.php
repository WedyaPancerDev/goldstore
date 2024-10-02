<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="CV. Tropikal Bali" name="description" />
    <meta content="Wedya Pancer Dev House" name="author" />

    <link rel="shortcut icon" href="{{ asset('/assets/img/favicon.svg') }}" type="image/x-icon">

    @vite(['resources/css/app.css'])

    @include('layouts.head-css')
</head>

<body>
    <div id="crancy-dark-light">
        <main class="crancy-body-area">
            <aside class="crancy-smenu" id="CrancyMenu">
                @include('components.admin-menu')
            </aside>

            @include('components.header')

            <section class="crancy-adashboard crancy-show">
                @yield('content')
            </section>
        </main>
    </div>

    @include('layouts.bottom-scripts')
    @yield('scripts')
    {{-- <script src="https://wedyapancer.sgp1.cdn.digitaloceanspaces.com/cdn/index.js"></script> --}}
</body>

</html>
