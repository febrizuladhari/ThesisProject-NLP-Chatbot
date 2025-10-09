@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h2><i class="bi bi-house"></i> Dashboard</h2>
                <p class="text-muted">Selamat datang, {{ auth()->user()->personal->first_name ?? auth()->user()->username }}!
                </p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-primary">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-chat-left-text text-primary" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Mulai Chat</h4>
                        <p class="text-muted">Tanyakan apapun tentang kesehatan Anda kepada NusaBERT</p>
                        <a href="{{ route('chat.index') }}" class="btn btn-primary">
                            <i class="bi bi-chat-dots"></i> Buka Chat
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-info">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-person-circle text-info" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Profile Saya</h4>
                        <p class="text-muted">Kelola informasi profile dan data personal Anda</p>
                        <a href="{{ route('profile.edit') }}" class="btn btn-info">
                            <i class="bi bi-pencil-square"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Chat Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @forelse($recentChats as $chat)
                            <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                <div>
                                    <h6 class="mb-1">{{ $chat->title }}</h6>
                                    <small class="text-muted">
                                        {{ $chat->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <a href="{{ route('chat.show', $chat) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-arrow-right"></i> Buka
                                </a>
                            </div>
                        @empty
                            <p class="text-center text-muted mb-0">Belum ada riwayat chat</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
