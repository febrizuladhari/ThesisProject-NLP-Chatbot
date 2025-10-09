{{-- @extends('layouts.app')

@section('title', 'Chat - ' . $chat->title)

@push('styles')
    <style>
        .chat-container {
            height: 70vh;
            display: flex;
            flex-direction: column;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .message {
            margin-bottom: 15px;
            display: flex;
        }

        .message.user {
            justify-content: flex-end;
        }

        .message.bot {
            justify-content: flex-start;
        }

        .message-content {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            word-wrap: break-word;
        }

        .message.user .message-content {
            background-color: #0d6efd;
            color: white;
        }

        .message.bot .message-content {
            background-color: white;
            border: 1px solid #dee2e6;
        }

        .typing-indicator {
            display: none;
            padding: 10px;
        }

        .typing-indicator span {
            height: 10px;
            width: 10px;
            background-color: #6c757d;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
            animation: bounce 1.3s linear infinite;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: -1.1s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: -0.9s;
        }

        @keyframes bounce {

            0%,
            60%,
            100% {
                transform: translateY(0);
            }

            30% {
                transform: translateY(-10px);
            }
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <h4><i class="bi bi-chat-dots"></i> {{ $chat->title }}</h4>
            </div>
            <div class="col text-end">
                <a href="{{ route('chat.index') }}" class="btn btn-sm btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card shadow-sm chat-container">
            <div class="chat-messages" id="chatMessages">
                @foreach ($messages as $message)
                    <div class="message {{ $message->sender }}">
                        <div class="message-content">
                            {{ $message->qa_message }}
                        </div>
                    </div>
                @endforeach
                <div class="typing-indicator" id="typingIndicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <div class="card-footer bg-white">
                <form id="chatForm">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control" id="messageInput" placeholder="Ketik pesan Anda..."
                            required>
                        <button class="btn btn-primary" type="submit" id="sendButton">
                            <i class="bi bi-send"></i> Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const chatMessages = $('#chatMessages');
            const chatForm = $('#chatForm');
            const messageInput = $('#messageInput');
            const sendButton = $('#sendButton');
            const typingIndicator = $('#typingIndicator');

            // Scroll to bottom
            function scrollToBottom() {
                chatMessages.scrollTop(chatMessages[0].scrollHeight);
            }

            scrollToBottom();

            // Add message to chat
            function addMessage(message, sender) {
                const messageHtml = `
            <div class="message ${sender}">
                <div class="message-content">
                    ${message}
                </div>
            </div>
        `;
                typingIndicator.before(messageHtml);
                scrollToBottom();
            }

            // Handle form submit
            chatForm.on('submit', function(e) {
                e.preventDefault();

                const message = messageInput.val().trim();
                if (!message) return;

                // Disable input
                messageInput.prop('disabled', true);
                sendButton.prop('disabled', true);

                // Add user message
                addMessage(message, 'user');
                messageInput.val('');

                // Show typing indicator
                typingIndicator.show();

                // Send AJAX request
                $.ajax({
                    url: '{{ route('chat.message', $chat) }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        message: message
                    },
                    success: function(response) {
                        typingIndicator.hide();

                        if (response.success) {
                            addMessage(response.bot_response, 'bot');
                        } else {
                            addMessage('Maaf, terjadi kesalahan.', 'bot');
                        }

                        messageInput.prop('disabled', false);
                        sendButton.prop('disabled', false);
                        messageInput.focus();
                    },
                    error: function() {
                        typingIndicator.hide();
                        addMessage('Maaf, terjadi kesalahan dalam mengirim pesan.', 'bot');

                        messageInput.prop('disabled', false);
                        sendButton.prop('disabled', false);
                        messageInput.focus();
                    }
                });
            });
        });
    </script>
@endpush --}}
