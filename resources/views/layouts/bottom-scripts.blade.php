<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/phosphor-icons@1.4.2/src/index.min.js"></script>

@vite(['resources/js/app.js'])

{{-- zomur template script --}}
{{-- <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script> --}}
<script src="{{ URL::asset('assets/js/jquery-migrate.js') }}"></script>
<script src="{{ URL::asset('assets/js/datatables.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/popper.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/circle-progress.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/nice-select.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/main.js') }}"></script>

@include('components.scripts-logout')
@yield('script')
@include('components.scripts-toast')