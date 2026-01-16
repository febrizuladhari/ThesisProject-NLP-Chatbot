<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Log;
use Illuminate\Support\Facades\Http;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// class ChatController extends Controller
// {
//     public function index()
//     {
//         $chats = Chat::where('user_id', Auth::id())->latest()->get();
//         return view('user.chat.index', compact('chats'));
//     }

//     public function show(Chat $chat)
//     {
//         if ($chat->user_id !== Auth::id()) {
//             abort(403);
//         }

//         $messages = $chat->messages()->orderBy('created_at', 'asc')->get();
//         return view('user.chat.show', compact('chat', 'messages'));
//     }

//     public function store(Request $request)
//     {
//         $chat = Chat::create([
//             'user_id' => Auth::id(),
//             'title' => 'Chat ' . now()->format('Y-m-d H:i'),
//         ]);

//         LogHelper::chatCreatedLog($chat->id);

//         return redirect()->route('chat.show', $chat);
//     }

//     public function sendMessage(Request $request, Chat $chat)
//     {
//         $request->validate([
//             'message' => 'required|string',
//         ]);

//         if ($chat->user_id !== Auth::id()) {
//             abort(403);
//         }

//         // Save user message
//         Message::create([
//             'chat_id' => $chat->id,
//             'sender' => 'user',
//             'qa_message' => $request->message,
//         ]);

//         // Call NusaBERT API
//         try {
//             $response = Http::timeout(30)->post(env('NUSABERT_API_URL') . '/chat', [
//                 'message' => $request->message,
//                 'user_id' => Auth::id(),
//             ]);

//             $botResponse = $response->json()['response'] ?? 'Maaf, saya tidak dapat memproses pesan Anda saat ini.';
//         } catch (\Exception $e) {
//             $botResponse = 'Maaf, terjadi kesalahan dalam memproses pesan Anda.';
//         }

//         // Save bot response
//         Message::create([
//             'chat_id' => $chat->id,
//             'sender' => 'bot',
//             'qa_message' => $botResponse,
//         ]);

//         LogHelper::chatCreatedLog($chat->id);

//         return response()->json([
//             'success' => true,
//             'bot_response' => $botResponse,
//         ]);
//     }

//     public function destroy(Chat $chat)
//     {
//         if ($chat->user_id !== Auth::id()) {
//             abort(403);
//         }

//         $chat->delete();
//         return redirect()->route('chat.index')->with('success', 'Chat berhasil dihapus!');
//     }
// }

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.chat.index', compact('chats'));
    }

    public function show(Chat $chat)
    {
        abort_if($chat->user_id !== Auth::id(), 403);

        $messages = $chat->messages()
            ->orderBy('created_at')
            // ->with('feedback')
            ->get();

        return view('user.chat.show', compact('chat', 'messages'));
    }

    /**
     * CREATE CHAT BARU
     */
    public function store()
    {
        $chat = Chat::create([
            'user_id' => Auth::id(),
            'title' => 'Chat Baru'
        ]);

        LogHelper::chatCreatedLog($chat->id);

        return redirect()->route('chat.show', $chat);
    }

    /**
     * KIRIM PESAN
     */
    public function sendMessage(Request $request, Chat $chat)
    {
        abort_if($chat->user_id !== Auth::id(), 403);

        $request->validate([
            'message' => 'required|string|min:3'
        ]);

        $userMessage = trim($request->message);

        // =====================
        // 1. SIMPAN PESAN USER
        // =====================
        Message::create([
            'chat_id' => $chat->id,
            'sender' => 'user',
            'qa_message' => $userMessage,
        ]);

        // =====================
        // 2. SET JUDUL CHAT (PERTAMA SAJA)
        // =====================
        if ($chat->messages()->count() === 1) {
            $chat->update([
                'title' => Str::limit($userMessage, 50)
            ]);
        }

        // =====================
        // 3. CALL FASTAPI
        // =====================
        try {
            $response = Http::timeout(20)
                ->post(config('services.nusabert.url') . '/chat', [
                    'text' => $userMessage
                ]);

            if (!$response->successful()) {
                throw new \Exception('API error');
            }

            $data = $response->json();

            $botResponse = $data['response'] ?? 'Maaf, saya belum bisa menjawab.';
            $intent = $data['intent'] ?? null;
            $confidence = $data['confidence'] ?? null;

        } catch (\Exception $e) {
            $botResponse = 'Maaf, sistem sedang mengalami gangguan.';
            $intent = null;
            $confidence = null;
        }

        // =====================
        // 4. SIMPAN PESAN BOT
        // =====================
        Message::create([
            'chat_id' => $chat->id,
            'sender' => 'bot',
            'qa_message' => $botResponse,
        ]);

        // =====================
        // 5. LOG (OPSIONAL)
        // =====================
        LogHelper::messageLog($chat->id, $intent, $confidence);

        return response()->json([
            'success' => true,
            'bot_response' => $botResponse
        ]);
    }


    public function destroy(Chat $chat)
    {
        abort_if($chat->user_id !== Auth::id(), 403);

        $chat->delete();

        return redirect()
            ->route('chat.index')
            ->with('success', 'Chat berhasil dihapus');
    }
}

