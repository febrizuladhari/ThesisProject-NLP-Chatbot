<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    // public function index()
    // {
    //     $chats = Chat::where('user_id', auth()->id())->latest()->get();
    //     return view('user.chat.index', compact('chats'));
    // }

    // public function show(Chat $chat)
    // {
    //     if ($chat->user_id !== auth()->id()) {
    //         abort(403);
    //     }

    //     $messages = $chat->messages()->orderBy('created_at', 'asc')->get();
    //     return view('user.chat.show', compact('chat', 'messages'));
    // }

    // public function store(Request $request)
    // {
    //     $chat = Chat::create([
    //         'user_id' => auth()->id(),
    //         'title' => 'Chat ' . now()->format('Y-m-d H:i'),
    //     ]);

    //     return redirect()->route('chat.show', $chat);
    // }

    // public function sendMessage(Request $request, Chat $chat)
    // {
    //     $request->validate([
    //         'message' => 'required|string',
    //     ]);

    //     if ($chat->user_id !== auth()->id()) {
    //         abort(403);
    //     }

    //     // Save user message
    //     Message::create([
    //         'chat_id' => $chat->id,
    //         'sender' => 'user',
    //         'qa_message' => $request->message,
    //     ]);

    //     // Call NusaBERT API
    //     try {
    //         $response = Http::timeout(30)->post(env('NUSABERT_API_URL') . '/chat', [
    //             'message' => $request->message,
    //             'user_id' => auth()->id(),
    //         ]);

    //         $botResponse = $response->json()['response'] ?? 'Maaf, saya tidak dapat memproses pesan Anda saat ini.';
    //     } catch (\Exception $e) {
    //         $botResponse = 'Maaf, terjadi kesalahan dalam memproses pesan Anda.';
    //     }

    //     // Save bot response
    //     Message::create([
    //         'chat_id' => $chat->id,
    //         'sender' => 'bot',
    //         'qa_message' => $botResponse,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'bot_response' => $botResponse,
    //     ]);
    // }

    // public function destroy(Chat $chat)
    // {
    //     if ($chat->user_id !== auth()->id()) {
    //         abort(403);
    //     }

    //     $chat->delete();
    //     return redirect()->route('chat.index')->with('success', 'Chat berhasil dihapus!');
    // }
}
