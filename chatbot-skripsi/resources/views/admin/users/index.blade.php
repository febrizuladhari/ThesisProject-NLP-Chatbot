@extends('layouts.app')

@section('title', 'Kelola Users')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h2><i class="bi bi-people"></i> Kelola Users</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah User
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Nama Lengkap</th>
                                <th>Status Profile</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->personal)
                                            {{ $user->personal->first_name }} {{ $user->personal->last_name }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->is_profile_completed)
                                            <span class="badge bg-success">Lengkap</span>
                                        @else
                                            <span class="badge bg-warning">Belum Lengkap</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUser{{ $user->id }}" title="Hapus">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada user terdaftar</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Delete User -->
    @foreach ($users as $user)
        <div class="modal fade" id="deleteUser{{ $user->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-exclamation-triangle"></i> Konfirmasi Hapus User
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="bi bi-info-circle"></i> Anda akan menghapus user dengan detail berikut:
                        </div>

                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="120" class="fw-bold">User ID</td>
                                <td>: <code>#{{ $user->id }}</code></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">User</td>
                                <td>: {{ $user->username }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email</td>
                                <td>: {{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Nama</td>
                                <td>: {{ $user->personal->first_name }} {{ $user->personal->last_name }} </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">No. Telepon</td>
                                <td>: {{ $user->personal->last_name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tanggal Lahir</td>
                                <td>: {{ $user->personal->last_name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Bergabung</td>
                                <td>: {{ $user->created_at }}</td>
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
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Ya, Hapus User Ini
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
