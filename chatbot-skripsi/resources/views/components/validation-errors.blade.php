@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-start">
            <div class="flex-shrink-0">
                <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.5rem;"></i>
            </div>
            <div class="flex-grow-1 ms-3">
                <h5 class="alert-heading mb-2">
                    <i class="bi bi-x-circle"></i> Terjadi Kesalahan!
                </h5>
                <p class="mb-2">Mohon perbaiki kesalahan berikut:</p>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@push('styles')
    <style>
        .alert-danger {
            border-left: 4px solid #dc3545;
            background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
            border-radius: 8px;
        }

        .alert-danger .alert-heading {
            color: #842029;
            font-weight: 600;
        }

        .alert-danger ul li {
            color: #842029;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .alert-danger i.bi-exclamation-triangle-fill {
            color: #dc3545;
        }

        .alert-success {
            border-left: 4px solid #198754;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-radius: 8px;
        }

        .alert-success .alert-heading {
            color: #0f5132;
            font-weight: 600;
        }
    </style>
@endpush
