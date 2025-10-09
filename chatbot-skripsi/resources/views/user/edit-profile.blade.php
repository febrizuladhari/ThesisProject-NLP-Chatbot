@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h2><i class="bi bi-person-circle"></i> Edit Profile</h2>
                <p class="text-muted">Kelola informasi pribadi dan data akun Anda</p>
            </div>
            <div class="col text-end">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
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
                <!-- Edit Personal Data -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-person-badge"></i> Informasi Personal
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">Nama Depan <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ old('first_name', $personal->first_name) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Nama Belakang <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ old('last_name', $personal->last_name) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">No. Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ old('phone', $personal->phone) }}">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        <input type="date" class="form-control" id="birth_date" name="birth_date"
                                            value="{{ old('birth_date', $personal->birth_date?->format('Y-m-d')) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male"
                                        {{ old('gender', $personal->gender) == 'male' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="female"
                                        {{ old('gender', $personal->gender) == 'female' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Masukkan alamat lengkap Anda">{{ old('address', $personal->address) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="medical_history" class="form-label">Riwayat Medis</label>
                                <textarea class="form-control" id="medical_history" name="medical_history" rows="3"
                                    placeholder="Tuliskan riwayat penyakit atau kondisi medis Anda (opsional)">{{ old('medical_history', $personal->medical_history) }}</textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save"></i> Update Personal Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Account Security Panel -->
            <div class="col-md-4">
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-shield-check"></i> Keamanan Akun
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 pb-3 border-bottom">
                            <h6 class="fw-bold mb-2">Username</h6>
                            <p class="mb-0 text-muted">{{ auth()->user()->username }}</p>
                            <small class="text-muted d-block mt-1">Username tidak dapat diubah (hubungi admin jika perlu
                                mengubah)</small>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <h6 class="fw-bold mb-2">Email</h6>
                            <p class="mb-0 text-muted">{{ auth()->user()->email }}</p>
                            <small class="text-muted d-block mt-1">Email tidak dapat diubah (hubungi admin jika perlu
                                mengubah)</small>
                        </div>

                        <div>
                            <h6 class="fw-bold mb-2">Password</h6>
                            <p class="text-muted mb-3">Ubah password Anda secara berkala untuk keamanan maksimal.</p>
                            <a href="{{ route('change-password') }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-key"></i> Ubah Password
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mt-4 bg-light">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill text-warning"></i> Catatan
                            Penting</h6>
                        <small class="text-muted d-block mb-2">
                            Anda hanya dapat mengubah data personal dan password. Username dan email hanya dapat diubah oleh
                            administrator.
                        </small>
                        <small class="text-muted">
                            Untuk kebutuhan lain, silakan hubungi administrator sistem.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
