@extends('layouts.app')

@section('title', 'Detail Log')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h2><i class="bi bi-file-text"></i> Detail Activity Log</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.logs.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle"></i> Informasi Log
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td width="200" class="fw-bold text-muted">Log ID</td>
                                <td>: {{ $log->id }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Activity</td>
                                <td>:
                                    <span
                                        class="badge
                                    @if (str_contains($log->activity, 'login')) bg-success
                                    @elseif(str_contains($log->activity, 'logout')) bg-secondary
                                    @elseif(str_contains($log->activity, 'chat')) bg-info
                                    @elseif(str_contains($log->activity, 'profile')) bg-warning
                                    @else bg-primary @endif">
                                        {{ $log->activity }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">IP Address</td>
                                <td>: <code>{{ $log->ip_address }}</code></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Timestamp</td>
                                <td>:
                                    <strong>{{ $log->created_at->format('d F Y, H:i:s') }}</strong>
                                    <br>
                                    <small class="text-muted">({{ $log->created_at->diffForHumans() }})</small>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-exclamation-triangle"></i> Zona Berbahaya
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">Hapus log ini secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteLogDetailModal">
                            <i class="bi bi-trash"></i> Hapus Log
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-person-circle text-primary"></i> Informasi User
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($log->user)
                            <div class="text-center mb-3">
                                <div class="avatar-circle bg-primary bg-opacity-10 text-primary mx-auto"
                                    style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 2rem;">
                                    {{ strtoupper(substr($log->user->username, 0, 2)) }}
                                </div>
                            </div>

                            <div class="mb-3 pb-3 border-bottom">
                                <small class="text-muted d-block mb-1">Username</small>
                                <strong>{{ $log->user->username }}</strong>
                            </div>

                            <div class="mb-3 pb-3 border-bottom">
                                <small class="text-muted d-block mb-1">Email</small>
                                <strong>{{ $log->user->email }}</strong>
                            </div>

                            @if ($log->user->personal)
                                <div class="mb-3 pb-3 border-bottom">
                                    <small class="text-muted d-block mb-1">Nama Lengkap</small>
                                    <strong>{{ $log->user->personal->first_name }}
                                        {{ $log->user->personal->last_name }}</strong>
                                </div>

                                @if ($log->user->personal->phone)
                                    <div class="mb-3 pb-3 border-bottom">
                                        <small class="text-muted d-block mb-1">Telepon</small>
                                        <strong>{{ $log->user->personal->phone }}</strong>
                                    </div>
                                @endif
                            @endif

                            <div class="mb-3 pb-3 border-bottom">
                                <small class="text-muted d-block mb-1">Role</small>
                                <span class="badge bg-primary">{{ $log->user->role->role }}</span>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Status Profile</small>
                                @if ($log->user->is_profile_completed)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Lengkap
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="bi bi-exclamation-circle"></i> Belum Lengkap
                                    </span>
                                @endif
                            </div>

                            <div class="d-grid mt-4">
                                <a href="{{ route('admin.users.edit', $log->user) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-person-gear"></i> Kelola User
                                </a>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> User tidak ditemukan
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete Log Detail -->
    <div class="modal fade" id="deleteLogDetailModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle-fill"></i> Konfirmasi Hapus Log
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger border-danger">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-exclamation-octagon-fill text-danger me-2" style="font-size: 2rem;"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Peringatan!</h6>
                                <small>Tindakan ini bersifat permanen</small>
                            </div>
                        </div>
                        <p class="mb-0 small">Anda akan menghapus log ini secara permanen dari sistem. Data yang telah
                            dihapus tidak dapat dipulihkan kembali.</p>
                    </div>

                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Detail Log yang akan dihapus:</h6>
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td width="120" class="text-muted">
                                        <i class="bi bi-hash"></i> Log ID
                                    </td>
                                    <td class="fw-bold">: {{ $log->id }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <i class="bi bi-person"></i> User
                                    </td>
                                    <td class="fw-bold">: {{ $log->user->username ?? 'Unknown' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <i class="bi bi-activity"></i> Activity
                                    </td>
                                    <td>
                                        : <span class="badge bg-secondary">{{ $log->activity }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <i class="bi bi-geo-alt"></i> IP Address
                                    </td>
                                    <td>: <code>{{ $log->ip_address }}</code></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <i class="bi bi-clock"></i> Timestamp
                                    </td>
                                    <td class="fw-bold">: {{ $log->created_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-3 p-3 bg-warning bg-opacity-10 border border-warning rounded">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="confirmDelete">
                            <label class="form-check-label fw-bold" for="confirmDelete">
                                Saya memahami bahwa tindakan ini tidak dapat dibatalkan
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <form action="{{ route('admin.logs.destroy', $log) }}" method="POST" id="deleteLogForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="confirmDeleteBtn" disabled>
                            <i class="bi bi-trash-fill"></i> Ya, Hapus Log Ini
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkbox = document.getElementById('confirmDelete');
                const deleteBtn = document.getElementById('confirmDeleteBtn');

                if (checkbox && deleteBtn) {
                    checkbox.addEventListener('change', function() {
                        deleteBtn.disabled = !this.checked;
                    });
                }

                // Reset checkbox when modal is closed
                const modal = document.getElementById('deleteLogDetailModal');
                if (modal) {
                    modal.addEventListener('hidden.bs.modal', function() {
                        if (checkbox) checkbox.checked = false;
                        if (deleteBtn) deleteBtn.disabled = true;
                    });
                }
            });
        </script>
    @endpush
@endsection
