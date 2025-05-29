    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
    @if (session('success'))
        <script>
            Lobibox.notify('success', {
                pauseDelayOnHover: true,
                size: 'mini',
                rounded: true,
                icon: 'bi bi-check2-circle',
                delayIndicator: false,
                position: 'top right',
                msg: "{{ session('success') }}"
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Lobibox.notify('error', {
                pauseDelayOnHover: true,
                size: 'mini',
                rounded: true,
                icon: 'bi bi-x-circle',
                delayIndicator: false,
                position: 'top right',
                msg: "{{ session('error') }}"
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bi-eye-slash-fill");
                    $('#show_hide_password i').removeClass("bi-eye-fill");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bi-eye-slash-fill");
                    $('#show_hide_password i').addClass("bi-eye-fill");
                }
            });
        });

        $(document).ready(function() {
            $("#show_hide_password1 a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password1 input').attr("type") == "text") {
                    $('#show_hide_password1 input').attr('type', 'password');
                    $('#show_hide_password1 i').addClass("bi-eye-slash-fill");
                    $('#show_hide_password1 i').removeClass("bi-eye-fill");
                } else if ($('#show_hide_password1 input').attr("type") == "password") {
                    $('#show_hide_password1 input').attr('type', 'text');
                    $('#show_hide_password1 i').removeClass("bi-eye-slash-fill");
                    $('#show_hide_password1 i').addClass("bi-eye-fill");
                }
            });
        });
    </script>
