<script src="{{ URL::asset('assets/js/datatables.min.js') }}"></script>

<script>
    $(document).ready(function () {
        let table = $("#table-container").DataTable({
            searching: true,
            info: true,
            lengthChange: true,
            pageLength: 8,
            responsive: true,
            lengthMenu: [
                [8, 14, 25, 50, -1],
                [8, 14, 25, 50, "All"],
            ],
            language: {
                paginate: {
                    next: '<i class="fas fa-angle-right"></i>',
                    previous: '<i class="fas fa-angle-left"></i>',
                },
                lengthMenu: "Show result: _MENU_ ",
            },
            dom: 'rt<"crancy-table-bottom"flp><"clear">',
        });

        // Hubungkan form pencarian kustom dengan DataTables
        $('#customSearchBox').on('keyup', function () {
            table.search(this.value).draw();
        });

        // Jika Anda ingin melakukan pencarian ketika tombol search diklik
        $('.search-btn').on('click', function (e) {
            e.preventDefault();
            table.search($('#customSearchBox').val()).draw();
        });
    });
</script>