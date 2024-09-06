<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/phosphor-icons@1.4.2/src/index.min.js"></script>

@vite(['resources/js/app.js'])

{{-- zomur template script --}}
<script src="{{ URL::asset('assets/js/jquery-migrate.js') }}"></script>
<script src="{{ URL::asset('assets/js/charts.js') }}"></script>
<script src="{{ URL::asset('assets/js/fancy-box.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/circle-progress.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/nice-select.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pikaday.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/main.js') }}"></script>

@include('components.scripts-logout')

<script>
    $(document).ready(function() {
		@if (session('success'))
			$.toast({
				heading: "<p class='fs-6 fw-bold'>Yey!</p>",
				text: "<p class='fw-semibold'>{{ session('success') }}</p>",
				position: 'top-right',
				bgColor: '#16a34a',
				stack: true
			})
		@endif

		@if (session('error'))
			$.toast({
				heading: "<p class='fs-6 fw-bold'>Oops!</p>",
				text: "<p class='fw-semibold'>{{ session('error') }}</p>",
				position: 'top-right',
				bgColor: '#ef4444',
				stack: true
			})
		@endif
	})
</script>

@yield('script')