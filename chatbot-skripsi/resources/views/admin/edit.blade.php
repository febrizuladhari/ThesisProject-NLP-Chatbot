@extends('layouts.app')

@section('title', 'Edit Profile Admin')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h2><i class="bi bi-person-gear"></i> Edit Profile Admin</h2>
                <p class="text-muted">Kelola informasi akun dan data personal Anda</p>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i> <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <!-- Edit Account Info -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-shield-lock"></i> Informasi Akun
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.profile.update-account') }}">
                            @csrf
                            @method('PUT')

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> Update username dan email yang digunakan untuk login.
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username" value="{{ old('username', $admin->username) }}"
                                        required>
                                </div>
                                <small class="text-muted d-block mt-1">Username yang digunakan untuk login</small>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                                </div>
                                <small class="text-muted d-block mt-1">Email untuk notifikasi sistem</small>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save"></i> Update Akun
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Personal Data -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-person-badge"></i> Data Personal
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.profile.update-personal') }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">Nama Depan <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ old('first_name', $admin->personal?->first_name) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Nama Belakang <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ old('last_name', $admin->personal?->last_name) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">No. Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ old('phone', $admin->personal?->phone) }}">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        <input type="date" class="form-control" id="birth_date" name="birth_date"
                                            value="{{ old('birth_date', $admin->personal?->birth_date?->format('Y-m-d')) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male"
                                        {{ old('gender', $admin->personal?->gender) == 'male' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="female"
                                        {{ old('gender', $admin->personal?->gender) == 'female' ? 'selected' : '' }}>
                                        Perempuan</option>
                                    <option value="other"
                                        {{ old('gender', $admin->personal?->gender) == 'other' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $admin->personal?->address) }}</textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-save"></i> Update Personal Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="bi bi-key"></i> Ubah Password
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.profile.update-password') }}">
                            @csrf

                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> Untuk keamanan, pastikan password baru Anda
                                cukup kuat.
                            </div>

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        id="current_password" name="current_password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password" title="Tampilkan password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password" title="Tampilkan password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-1">Minimal 8 karakter</small>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation" title="Tampilkan password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="bi bi-shield-check"></i> Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-info-circle text-primary"></i> Informasi Admin
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block mb-1">ID Admin</small>
                            <strong>{{ $admin->id }}</strong>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block mb-1">Role</small>
                            <span class="badge bg-primary">{{ $admin->role->role }}</span>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block mb-1">Status Akun</small>
                            <span class="badge bg-success">Active</span>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block mb-1">Akun Dibuat</small>
                            <strong>{{ $admin->created_at->format('d M Y') }}</strong>
                            <br>
                            <small class="text-muted">{{ $admin->created_at->diffForHumans() }}</small>
                        </div>

                        <div>
                            <small class="text-muted d-block mb-1">Terakhir Update</small>
                            <strong>{{ $admin->updated_at->format('d M Y H:i') }}</strong>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm bg-light">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-shield-check text-success"></i> Privilege Admin
                        </h6>
                        <ul class="list-unstyled small">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success"></i> Kelola semua user
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success"></i> Edit data user
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success"></i> Reset password user
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success"></i> Akses dashboard admin
                            </li>
                            <li>
                                <i class="bi bi-check-circle text-success"></i> Kelola profile sendiri
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
