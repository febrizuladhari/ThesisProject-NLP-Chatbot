@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h2><i class="bi bi-pencil-square"></i> Edit User</h2>
                <p class="text-muted">Username: <strong>{{ $user->username }}</strong></p>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
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

        <!-- Validation Errors Alert -->
        <x-validation-errors />

        <div class="row">
            <div class="col-md-8">
                <!-- Edit Account Info -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-person-circle"></i> Informasi Akun
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.users.update', $user) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="username" name="username"
                                        value="{{ old('username', $user->username) }}" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted d-block mt-1">Username unik untuk login</small>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted d-block mt-1">Email untuk reset password dan komunikasi</small>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password" title="Tampilkan password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted d-block mt-1">Kosongkan jika tidak ingin mengubah password</small>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation" title="Tampilkan password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save"></i> Update Akun User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Personal Data -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-person-badge"></i> Data Personal User
                            </h5>
                            @if ($user->personal)
                                <span class="badge bg-success">Sudah Diisi</span>
                            @else
                                <span class="badge bg-warning">Belum Diisi</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.users.update-personal', $user) }}">
                            @csrf
                            @method('PUT')

                            <div class="alert alert-info mb-4">
                                <i class="bi bi-info-circle"></i> Edit data personal user di sini. Data ini akan ditampilkan
                                di profile user.
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">Nama Depan <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ old('first_name', $user->personal?->first_name) }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Nama Belakang <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ old('last_name', $user->personal?->last_name) }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">No. Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ old('phone', $user->personal?->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        <i class="bi bi-info-circle"></i> Format: 08xx atau 62xx (11-13 digit)
                                    </small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        <input type="date" class="form-control" id="birth_date" name="birth_date"
                                            value="{{ old('birth_date', $user->personal?->birth_date?->format('Y-m-d')) }}">
                                        @error('birth_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        <i class="bi bi-info-circle"></i> Usia minimal 12 tahun
                                    </small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male"
                                        {{ old('gender', $user->personal?->gender) == 'male' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="female"
                                        {{ old('gender', $user->personal?->gender) == 'female' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $user->personal?->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="medical_history" class="form-label">Riwayat Medis</label>
                                <textarea class="form-control" id="medical_history" name="medical_history" rows="3">{{ old('medical_history', $user->personal?->medical_history) }}</textarea>
                                @error('medical_history')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-save"></i> Update Data Personal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Panel -->
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-info-circle"></i> Informasi User
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted">ID User</small>
                            <p class="mb-0 fw-bold">{{ $user->id }}</p>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted">Status Profile</small>
                            <p class="mb-0">
                                @if ($user->is_profile_completed)
                                    <span class="badge bg-success">Lengkap</span>
                                @else
                                    <span class="badge bg-warning">Belum Lengkap</span>
                                @endif
                            </p>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted">Role</small>
                            <p class="mb-0 fw-bold">{{ $user->role->role }}</p>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted">Bergabung</small>
                            <p class="mb-0">{{ $user->created_at->format('d M Y H:i') }}</p>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">Terakhir Update</small>
                            <p class="mb-0">{{ $user->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                @if($user->role->user)
                    <div class="card shadow-sm border-danger">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-exclamation-triangle"></i> Zona Berbahaya
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-3">Hapus user ini secara permanen. Tindakan ini tidak dapat
                                dibatalkan.</p>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus user ini? Data ini tidak dapat dipulihkan.')">
                                    <i class="bi bi-trash"></i> Hapus User
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                @endif

            </div>
        </div>
    </div>
@endsection
