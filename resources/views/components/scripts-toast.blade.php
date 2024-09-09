<script src="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.js"></script>

<script>
    $(document).ready(function() {
		@if (session('success'))
			$.toast({
				heading: "<p class='fw-bold text-white'>Yey!</p>",
				text: "<span class='fw-semibold text-white'>{{ session('success') }}</span>",
				position: 'top-right',
				bgColor: '#16a34a',
				stack: true
			})
		@endif

		@if (session('error'))
			$.toast({
				heading: "<p class='fw-bold text-white'>Oops!</p>",
				text: "<span class='fw-semibold text-white'>{{ session('error') }}</span>",
				position: 'top-right',
				bgColor: '#ef4444',
				stack: true
			})
		@endif
	})
</script>