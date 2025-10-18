<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        /* Input group styling when password is visible */
        .input-group:has(input[type="text"]) .toggle-password {
            background-color: #d1e7fd;
            color: #0d6efd;
        }

        /* Pagination Custom Styling */
        .pagination {
            margin: 1rem 0;
            gap: 0.25rem;
        }

        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            color: #0d6efd;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            min-height: 38px;
            transition: all 0.2s ease;
            font-size: 0.875rem;
            text-decoration: none;
        }

        .pagination .page-link:hover {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .pagination .page-link i {
            font-size: 0.875rem !important;
            line-height: 1 !important;
        }

        .pagination .page-item {
            margin: 0 2px;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(13, 110, 253, 0.3);
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #f8f9fa;
            border-color: #dee2e6;
            opacity: 0.6;
        }

        @media (max-width: 576px) {
            .pagination .page-link {
                padding: 0.375rem 0.5rem;
                min-width: 35px;
                min-height: 35px;
                font-size: 0.8125rem;
            }

            .pagination .page-item {
                margin: 0 1px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    @include('layouts.navbar')

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Password Toggle Script -->
    <script>
        $(document).ready(function() {
            // Delegate event to handle dynamically added buttons too
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

    @stack('scripts')

</body>

</html>
