<script>
    $(document).ready(function () {
        $("#logout, #logoutTopbar").click(async function (e) {
            e.preventDefault();

            const csrfToken = $('meta[name="csrf-token"]').attr("content");

            try {
                const response = await $.ajax({
                    url: "/logout",
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    dataType: "json",
                });

                if (response.status === "success") {
                    window.location.replace("/login");
                    return;
                }

                console.error("Error when logout:", response);
            } catch (error) {
                console.error("Error:", error);
            }
        });
    });
</script>