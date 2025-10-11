@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('styles')
    <style>
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <h2 class="mb-1"><i class="bi bi-speedometer2"></i> Admin Dashboard</h2>
                <p class="text-muted">Selamat datang kembali, <strong>{{ auth()->user()->username }}</strong>! 👋</p>
            </div>
            <div class="col-auto">
                <div class="text-end">
                    <small class="text-muted d-block">Server Time</small>
                    <span id="clock" class="fw-bold"></span><br>
                    <small id="date" class="text-muted"></small>
                    {{-- <strong>{{ now()->format('d M Y, H:i') }}</strong> --}}
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <h5 class="mb-2 fw-bold">
            <i class="bi bi-activity text-danger"></i> System Activity Overview
        </h5>
        <div class="row g-4 mb-4">
            <div class="col-xl-4 col-md-6">
                <div class="card stat-card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 fw-semibold">Total Users</p>
                                <h2 class="mb-0 fw-bold">{{ $totalUsers }}</h2>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> Active users
                                </small>
                            </div>
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card stat-card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 fw-semibold">Total Chats</p>
                                <h2 class="mb-0 fw-bold">{{ $totalChats }}</h2>
                                <small class="text-info">
                                    <i class="bi bi-chat-dots"></i> Conversations
                                </small>
                            </div>
                            <div class="stat-icon bg-success bg-opacity-10 text-success">
                                <i class="bi bi-chat-left-text-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card stat-card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 fw-semibold">Total Messages</p>
                                <h2 class="mb-0 fw-bold">{{ $totalMessages }}</h2>
                                <small class="text-warning">
                                    <i class="bi bi-arrow-up-right"></i> All messages
                                </small>
                            </div>
                            <div class="stat-icon bg-info bg-opacity-10 text-info">
                                <i class="bi bi-chat-dots-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card stat-card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 fw-semibold">Avg Messages/Chat</p>
                                <h2 class="mb-0 fw-bold">
                                    {{ $totalChats > 0 ? number_format($totalMessages / $totalChats, 1) : 0 }}</h2>
                                <small class="text-primary">
                                    <i class="bi bi-graph-up"></i> Average
                                </small>
                            </div>
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-bar-chart-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card stat-card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 fw-semibold">Activity Logs</p>
                                <h2 class="mb-0 fw-bold">{{ $totalLogs }}</h2>
                                <small class="text-muted">
                                    <i class="bi bi-clock-history"></i> Total activities
                                </small>
                            </div>
                            <div class="stat-icon bg-dark bg-opacity-10 text-dark">
                                <i class="bi bi-activity"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-4">
            <!-- Recent Users -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-person-plus text-primary"></i> User Terbaru
                            </h5>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">
                                Lihat Semua <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">User</th>
                                        <th class="border-0">Email</th>
                                        <th class="border-0">Status Profile</th>
                                        <th class="border-0">Bergabung</th>
                                        <th class="border-0 pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentUsers as $user)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle bg-primary bg-opacity-10 text-primary me-3"
                                                        style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                                        {{ strtoupper(substr($user->username, 0, 2)) }}
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 fw-semibold">{{ $user->username }}</p>
                                                        @if ($user->personal)
                                                            <small class="text-muted">{{ $user->personal->first_name }}
                                                                {{ $user->personal->last_name }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $user->email }}</span>
                                            </td>
                                            <td>
                                                @if ($user->is_profile_completed)
                                                    <span
                                                        class="badge bg-success-subtle text-success border border-success-subtle">
                                                        <i class="bi bi-check-circle"></i> Lengkap
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                                        <i class="bi bi-exclamation-circle"></i> Belum Lengkap
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar3"></i>
                                                    {{ $user->created_at->format('d M Y') }}
                                                </small>
                                            </td>
                                            <td class="pe-4">
                                                <a href="{{ route('admin.users.edit', $user) }}"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                                <p class="text-muted mt-2 mb-0">Belum ada user terdaftar</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Stats -->
            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-lightning-charge text-warning"></i> Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <i class="bi bi-person-plus"></i> Tambah User Baru
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-people"></i> Kelola Users
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System Info -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-info-circle text-info"></i> System Info
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">
                                    <i class="bi bi-person-check"></i> Complete Profiles
                                </span>
                                <span class="fw-bold">{{ $completedProfiles ?? 0 }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $totalUsers > 0 ? ($completedProfiles / $totalUsers) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">
                                    <i class="bi bi-person-x"></i> Incomplete Profiles
                                </span>
                                <span class="fw-bold">{{ $incompleteProfiles ?? 0 }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" role="progressbar"
                                    style="width: {{ $totalUsers > 0 ? ($incompleteProfiles / $totalUsers) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Logs Section - Tambahkan setelah Activity Overview -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-clock-history text-success"></i> Recent Activity Logs (10 Terbaru)
                            </h5>
                            <a href="{{ route('admin.logs.index') }}" class="btn btn-sm btn-outline-primary">
                                Lihat Semua <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">#</th>
                                        <th>User</th>
                                        <th>Activity</th>
                                        <th>IP Address</th>
                                        <th class="pe-4">Timestamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentLogs as $log)
                                        <tr>
                                            <td class="ps-4">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle bg-primary bg-opacity-10 text-primary me-2"
                                                        style="width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.7rem;">
                                                        {{ strtoupper(substr($log->user->username ?? 'U', 0, 2)) }}
                                                    </div>
                                                    <span
                                                        class="fw-semibold">{{ $log->user->username ?? 'Unknown' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge
                                        @if (str_contains($log->activity, 'login')) bg-success-subtle text-success
                                        @elseif(str_contains($log->activity, 'logout')) bg-secondary-subtle text-secondary
                                        @elseif(str_contains($log->activity, 'chat')) bg-info-subtle text-info
                                        @elseif(str_contains($log->activity, 'profile')) bg-warning-subtle text-warning
                                        @else bg-primary-subtle text-primary @endif border
                                        @if (str_contains($log->activity, 'login')) border-success-subtle
                                        @elseif(str_contains($log->activity, 'logout')) border-secondary-subtle
                                        @elseif(str_contains($log->activity, 'chat')) border-info-subtle
                                        @elseif(str_contains($log->activity, 'profile')) border-warning-subtle
                                        @else border-primary-subtle @endif">
                                                    <i
                                                        class="bi
                                            @if (str_contains($log->activity, 'login')) bi-box-arrow-in-right
                                            @elseif(str_contains($log->activity, 'logout')) bi-box-arrow-right
                                            @elseif(str_contains($log->activity, 'chat')) bi-chat-dots
                                            @elseif(str_contains($log->activity, 'profile')) bi-person-circle
                                            @else bi-circle-fill @endif">
                                                    </i>
                                                    {{ Str::limit($log->activity, 30) }}
                                                </span>
                                            </td>
                                            <td>
                                                <code class="text-muted small">{{ $log->ip_address }}</code>
                                            </td>
                                            <td class="pe-4">
                                                <small class="text-muted">
                                                    <i class="bi bi-clock"></i>
                                                    {{ $log->created_at->format('d M Y, H:i') }}
                                                    <br>
                                                    <span
                                                        class="text-muted small">({{ $log->created_at->diffForHumans() }})</span>
                                                </small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                                                <p class="text-muted mt-2 mb-0">Belum ada activity log</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // Auto refresh time
        // setInterval(function() {
        //     const now = new Date();
        //     const timeString = now.toLocaleTimeString('id-ID', {
        //         hour: '2-digit',
        //         minute: '2-digit',
        //         second: '2-digit'
        //     });
        //     document.querySelectorAll('.server-time').forEach(el => {
        //         if (el) el.textContent = timeString;
        //     });
        // }, 1000);

        function updateClock() {
            const now = new Date();
            document.getElementById('clock').textContent =
                now.toLocaleTimeString('id-ID', {
                    hour12: false
                });
            document.getElementById('date').textContent =
                now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
@endpush
