@extends('layouts.app')

@section('title', 'Ubah Password')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h2><i class="bi bi-shield-lock"></i> Ubah Password</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('profile.edit') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="alert alert-info mb-4">
                            <i class="bi bi-info-circle"></i> Untuk keamanan akun Anda, pastikan password baru cukup kuat.
                        </div>

                        <form method="POST" action="{{ route('update-password') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        id="current_password" name="current_password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-2">Masukkan password Anda saat ini untuk
                                    verifikasi</small>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-2">Minimal 8 karakter. Gunakan kombinasi huruf besar,
                                    huruf kecil, angka, dan simbol untuk keamanan maksimal.</small>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" name="password_confirmation" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-2">Ketikkan ulang password baru yang sama</small>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle"></i> Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm bg-light">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-lightbulb"></i> Tips Keamanan</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Gunakan Huruf Besar</strong>
                                <small class="d-block text-muted">Minimal 1 huruf besar (A-Z)</small>
                            </li>
                            <li class="mb-2">
                                <strong>Gunakan Huruf Kecil</strong>
                                <small class="d-block text-muted">Minimal 1 huruf kecil (a-z)</small>
                            </li>
                            <li class="mb-2">
                                <strong>Gunakan Angka</strong>
                                <small class="d-block text-muted">Minimal 1 angka (0-9)</small>
                            </li>
                            <li class="mb-2">
                                <strong>Gunakan Simbol</strong>
                                <small class="d-block text-muted">Minimal 1 simbol (!@#$%^&*)</small>
                            </li>
                            <li>
                                <strong>Hindari Informasi Pribadi</strong>
                                <small class="d-block text-muted">Jangan gunakan nama, tanggal lahir</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
