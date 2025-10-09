@extends('layouts.app')

@section('title', 'Riwayat Chat')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h2><i class="bi bi-chat-left-text"></i> Riwayat Chat</h2>
            </div>
            <div class="col text-end">
                <form method="POST" action="{{ route('chat.store') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Chat Baru
                    </button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            @forelse($chats as $chat)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $chat->title }}</h5>
                            <p class="text-muted small">
                                <i class="bi bi-clock"></i> {{ $chat->created_at->format('d M Y H:i') }}
                            </p>
                            <p class="text-muted small">
                                <i class="bi bi-chat-dots"></i> {{ $chat->messages->count() }} pesan
                            </p>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('chat.show', $chat) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-arrow-right"></i> Buka
                                </a>
                                <form method="POST" action="{{ route('chat.destroy', $chat) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus chat ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle"></i> Belum ada riwayat chat. Mulai chat baru sekarang!
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
