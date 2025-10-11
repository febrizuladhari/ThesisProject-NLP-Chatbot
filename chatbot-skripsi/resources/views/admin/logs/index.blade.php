@extends('layouts.app')

@section('title', 'Activity Logs')

@push('styles')
    <style>
        .log-item {
            transition: all 0.3s ease;
        }

        .log-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        .activity-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        .filter-card {
            background: rgb(147, 176, 255);
        }

        /* Checkbox styling */
        .log-checkbox {
            cursor: pointer;
            width: 18px;
            height: 18px;
        }

        .log-item.selected {
            background-color: #e7f3ff;
        }

        /* Bulk action bar */
        .bulk-action-bar {
            position: sticky;
            top: 0;
            z-index: 100;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <h2><i class="bi bi-activity"></i> Activity Logs</h2>
                <p class="text-muted">Monitor semua aktivitas pengguna dalam sistem</p>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" id="bulkDeleteBtn" disabled data-bs-toggle="modal"
                        data-bs-target="#bulkDeleteModal">
                        <i class="bi bi-trash"></i> Hapus Terpilih (0)
                    </button>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#clearOldModal">
                        <i class="bi bi-calendar-x"></i> Hapus Log Lama
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#clearAllModal">
                        <i class="bi bi-trash"></i> Hapus Semua Log
                    </button>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filter Card -->
        <div class="card shadow-sm mb-4 border-0 filter-card">
            <div class="card-body text-white">
                <form method="GET" action="{{ route('admin.logs.index') }}" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-person"></i> Filter User
                            </label>
                            <select name="user_id" class="form-select">
                                <option value="">Semua User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->username }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar-range"></i> Dari Tanggal
                            </label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar-check"></i> Sampai Tanggal
                            </label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-search"></i> Cari Aktivitas
                            </label>
                            <input type="text" name="search" class="form-control" placeholder="Cari aktivitas..."
                                value="{{ request('search') }}">
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-funnel"></i> Terapkan Filter
                            </button>
                            <a href="{{ route('admin.logs.index') }}" class="btn btn-warning">
                                <i class="bi bi-x-circle"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Logs Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-list-ul text-primary"></i> Daftar Activity Logs
                    </h5>
                    <span class="badge bg-primary">Total: {{ $logs->total() }} logs</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" width="50">
                                    <input type="checkbox" id="selectAll" class="form-check-input">
                                </th>
                                <th>#</th>
                                <th>User</th>
                                <th>Activity</th>
                                <th>IP Address</th>
                                <th>Timestamp</th>
                                <th class="pe-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr class="log-item" data-log-id="{{ $log->id }}">
                                    <td class="ps-4">
                                        <input type="checkbox" class="form-check-input log-checkbox"
                                            value="{{ $log->id }}">
                                    </td>
                                    <td>{{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary bg-opacity-10 text-primary me-2"
                                                style="width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem;">
                                                {{ strtoupper(substr($log->user->username ?? 'U', 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="mb-0 fw-semibold">{{ $log->user->username ?? 'Unknown' }}</p>
                                                @if ($log->user && $log->user->personal)
                                                    <small class="text-muted">{{ $log->user->personal->first_name }}
                                                        {{ $log->user->personal->last_name }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge activity-badge
                                    @if (str_contains($log->activity, 'login')) bg-success
                                    @elseif(str_contains($log->activity, 'logout')) bg-secondary
                                    @elseif(str_contains($log->activity, 'chat')) bg-info
                                    @elseif(str_contains($log->activity, 'profile')) bg-warning
                                    @else bg-primary @endif">
                                            <i
                                                class="bi
                                        @if (str_contains($log->activity, 'login')) bi-box-arrow-in-right
                                        @elseif(str_contains($log->activity, 'logout')) bi-box-arrow-right
                                        @elseif(str_contains($log->activity, 'chat')) bi-chat-dots
                                        @elseif(str_contains($log->activity, 'profile')) bi-person-circle
                                        @else bi-circle-fill @endif">
                                            </i>
                                            {{ $log->activity }}
                                        </span>
                                    </td>
                                    <td>
                                        <code class="text-muted small">{{ $log->ip_address }}</code>
                                    </td>
                                    <td>
                                        <div>
                                            <i class="bi bi-calendar3 text-muted"></i>
                                            <strong>{{ $log->created_at->format('d M Y') }}</strong>
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i> {{ $log->created_at->format('H:i:s') }}
                                            ({{ $log->created_at->diffForHumans() }})
                                        </small>
                                    </td>
                                    <td class="pe-4 text-center">
                                        {{-- <div class="btn-group btn-group-sm"> --}}
                                            <a href="{{ route('admin.logs.show', $log) }}" class="btn btn-info"
                                                title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" title="Hapus"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteLogModal{{ $log->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        {{-- </div> --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                        <p class="text-muted mt-2 mb-0">Tidak ada log yang ditemukan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $logs->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Clear All -->
    <div class="modal fade" id="clearAllModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle"></i> Konfirmasi Hapus Semua Log
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Apakah Anda yakin ingin menghapus <strong>SEMUA</strong> log? Tindakan ini tidak
                        dapat dibatalkan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('admin.logs.clear-all') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Ya, Hapus Semua
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Clear Old -->
    <div class="modal fade" id="clearOldModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="bi bi-calendar-x"></i> Hapus Log Lama
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Hapus semua log yang lebih dari <strong>30 hari</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('admin.logs.clear-old') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check"></i> Ya, Hapus Log Lama
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Bulk Delete -->
    <div class="modal fade" id="bulkDeleteModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle-fill"></i> Konfirmasi Hapus Multiple Logs
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger border-danger">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-exclamation-octagon-fill me-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Peringatan!</h6>
                                <small>Anda akan menghapus <strong><span id="selectedCountModal">0</span> log</strong>
                                    sekaligus</small>
                            </div>
                        </div>
                        <p class="mb-0 small">Tindakan ini tidak dapat dibatalkan. Semua data log yang dipilih akan dihapus
                            secara permanen.</p>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">
                                <i class="bi bi-list-check"></i> Preview Log yang akan dihapus:
                            </h6>
                        </div>
                        <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                            <div id="selectedLogsPreview"></div>
                        </div>
                    </div>

                    <div class="mt-3 p-3 bg-warning bg-opacity-10 border border-warning rounded">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="confirmBulkDelete">
                            <label class="form-check-label fw-bold" for="confirmBulkDelete">
                                Saya memahami bahwa tindakan ini tidak dapat dibatalkan
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <form action="{{ route('admin.logs.bulk-destroy') }}" method="POST" id="bulkDeleteForm">
                        @csrf
                        <input type="hidden" name="log_ids" id="selectedLogIds">
                        <button type="submit" class="btn btn-danger" id="confirmBulkDeleteBtn" disabled>
                            <i class="bi bi-trash-fill"></i> Ya, Hapus <span id="deleteCount">0</span> Log
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete Individual Log -->
    @foreach ($logs as $log)
        <div class="modal fade" id="deleteLogModal{{ $log->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-exclamation-triangle"></i> Konfirmasi Hapus Log
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="bi bi-info-circle"></i> Anda akan menghapus log dengan detail berikut:
                        </div>

                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="120" class="fw-bold">Log ID</td>
                                <td>: <code>#{{ $log->id }}</code></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">User</td>
                                <td>: {{ $log->user->username ?? 'Unknown' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Activity</td>
                                <td>:
                                    <span class="badge bg-secondary">{{ Str::limit($log->activity, 30) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">IP Address</td>
                                <td>: <code>{{ $log->ip_address }}</code></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Waktu</td>
                                <td>: {{ $log->created_at->format('d M Y, H:i:s') }}</td>
                            </tr>
                        </table>

                        <p class="text-danger mb-0 mt-3">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <strong>Tindakan ini tidak dapat dibatalkan!</strong>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>
                        <form action="{{ route('admin.logs.destroy', $log) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Ya, Hapus Log Ini
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const logCheckboxes = document.querySelectorAll('.log-checkbox');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const confirmBulkDeleteCheckbox = document.getElementById('confirmBulkDelete');
            const confirmBulkDeleteBtn = document.getElementById('confirmBulkDeleteBtn');
            const bulkDeleteForm = document.getElementById('bulkDeleteForm');

            // Handle select all
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    logCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                        updateRowHighlight(checkbox);
                    });
                    updateBulkDeleteButton();
                });
            }

            // Handle individual checkbox
            logCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateRowHighlight(this);
                    updateBulkDeleteButton();

                    // Update select all checkbox
                    const allChecked = Array.from(logCheckboxes).every(cb => cb.checked);
                    const someChecked = Array.from(logCheckboxes).some(cb => cb.checked);

                    if (selectAllCheckbox) {
                        selectAllCheckbox.checked = allChecked;
                        selectAllCheckbox.indeterminate = someChecked && !allChecked;
                    }
                });
            });

            function updateRowHighlight(checkbox) {
                const row = checkbox.closest('tr');
                if (checkbox.checked) {
                    row.classList.add('selected');
                } else {
                    row.classList.remove('selected');
                }
            }

            function updateBulkDeleteButton() {
                const checkedBoxes = document.querySelectorAll('.log-checkbox:checked');
                const count = checkedBoxes.length;

                if (bulkDeleteBtn) {
                    bulkDeleteBtn.disabled = count === 0;
                    bulkDeleteBtn.innerHTML = `<i class="bi bi-trash"></i> Hapus Terpilih (${count})`;
                }

                // Update modal content
                updateBulkDeleteModal(checkedBoxes);
            }

            function updateBulkDeleteModal(checkedBoxes) {
                const count = checkedBoxes.length;
                const selectedCountModal = document.getElementById('selectedCountModal');
                const deleteCount = document.getElementById('deleteCount');
                const selectedLogsPreview = document.getElementById('selectedLogsPreview');

                if (selectedCountModal) selectedCountModal.textContent = count;
                if (deleteCount) deleteCount.textContent = count;

                // Build preview
                if (selectedLogsPreview) {
                    if (count === 0) {
                        selectedLogsPreview.innerHTML =
                            '<p class="text-muted text-center">Tidak ada log yang dipilih</p>';
                    } else {
                        let previewHtml = '<div class="list-group list-group-flush">';
                        checkedBoxes.forEach((checkbox, index) => {
                            const row = checkbox.closest('tr');
                            const logId = checkbox.value;
                            const user = row.querySelector('td:nth-child(3) .fw-semibold').textContent;
                            const activity = row.querySelector('.activity-badge').textContent.trim();
                            const ip = row.querySelector('code').textContent;

                            previewHtml += `
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">${index + 1}. Log ID: <code>#${logId}</code></h6>
                                    <p class="mb-1 small"><strong>User:</strong> ${user}</p>
                                    <p class="mb-1 small"><strong>Activity:</strong> ${activity}</p>
                                    <p class="mb-0 small"><strong>IP:</strong> <code>${ip}</code></p>
                                </div>
                            </div>
                        </div>
                    `;
                        });
                        previewHtml += '</div>';
                        selectedLogsPreview.innerHTML = previewHtml;
                    }
                }
            }

            // Handle bulk delete confirmation checkbox
            if (confirmBulkDeleteCheckbox && confirmBulkDeleteBtn) {
                confirmBulkDeleteCheckbox.addEventListener('change', function() {
                    confirmBulkDeleteBtn.disabled = !this.checked;
                });
            }

            // Handle bulk delete form submit
            if (bulkDeleteForm) {
                bulkDeleteForm.addEventListener('submit', function(e) {
                    const checkedBoxes = document.querySelectorAll('.log-checkbox:checked');
                    const logIds = Array.from(checkedBoxes).map(cb => cb.value);

                    if (logIds.length === 0) {
                        e.preventDefault();
                        alert('Pilih minimal satu log untuk dihapus');
                        return false;
                    }

                    document.getElementById('selectedLogIds').value = logIds.join(',');
                });
            }

            // Reset modal when closed
            const bulkDeleteModal = document.getElementById('bulkDeleteModal');
            if (bulkDeleteModal) {
                bulkDeleteModal.addEventListener('hidden.bs.modal', function() {
                    if (confirmBulkDeleteCheckbox) confirmBulkDeleteCheckbox.checked = false;
                    if (confirmBulkDeleteBtn) confirmBulkDeleteBtn.disabled = true;
                });
            }
        });
    </script>
@endpush
