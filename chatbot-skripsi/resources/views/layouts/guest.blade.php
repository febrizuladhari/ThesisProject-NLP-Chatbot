<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NusaBERT Chatbot')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        .toggle-password:active {
            transform: scale(0.95);
        }

        .toggle-password i {
            transition: all 0.3s ease;
        }
    </style>

</head>
<body class="bg-light">

    <div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Handle click on toggle password buttons
            $(document).on('click', '.toggle-password', function(e) {
                e.preventDefault();

                var targetId = $(this).data('target');
                var $input = $('#' + targetId);
                var $icon = $(this).find('i');

                if ($input.length) {
                    if ($input.attr('type') === 'password') {
                        $input.attr('type', 'text');
                        $icon.removeClass('bi-eye').addClass('bi-eye-slash');
                        $(this).attr('title', 'Sembunyikan password');
                    } else {
                        $input.attr('type', 'password');
                        $icon.removeClass('bi-eye-slash').addClass('bi-eye');
                        $(this).attr('title', 'Tampilkan password');
                    }
                }
            });

            // Set initial titles
            $('.toggle-password').attr('title', 'Tampilkan password');
        });
    </script>

</body>
</html>
