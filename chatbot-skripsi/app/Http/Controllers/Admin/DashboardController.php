<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role_id', 2)->count();
        $totalChats = Chat::count();
        $totalMessages = Message::count();
        $completedProfiles = User::where('role_id', 2)->where('is_profile_completed', true)->count();
        $incompleteProfiles = User::where('role_id', 2)->where('is_profile_completed', false)->count();
        $recentUsers = User::with('personal')->where('role_id', 2)->latest()->take(5)->get();
        $recentLogs = Log::with('user')->latest()->take(10)->get();
        $totalLogs = Log::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalChats',
            'totalMessages',
            'completedProfiles',
            'incompleteProfiles',
            'recentUsers',
            'recentLogs',
            'totalLogs'
        ));
    }
}
