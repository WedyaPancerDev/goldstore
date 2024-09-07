<script>
    $(document).ready(function () {
        $("#logout, #logoutTopbar").click(function (e) {
            e.preventDefault();

            const csrfToken = $('meta[name="csrf-token"]').attr("content");

            $.ajax({
                url: "/logout",
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        // window.location.href = "/login";
                        window.location.replace("/login");
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });
        });
    });
</script>