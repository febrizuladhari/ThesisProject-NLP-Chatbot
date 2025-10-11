<?php

namespace App\Helpers;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LogHelper
{
    public static function log($activity, $userId = null, $ipAddress = null)
    {
        Log::create([
            'user_id' => $userId ?? Auth::id(),
            'activity' => $activity,
            'ip_address' => $ipAddress ?? request()->ip(),
        ]);
    }

    public static function loginLog($userId = null)
    {
        self::log('User login', $userId);
    }

    public static function logoutLog($userId = null)
    {
        self::log('User logout', $userId);
    }

    public static function profileUpdateLog($userId = null)
    {
        self::log('Profile updated', $userId);
    }

    public static function passwordChangeLog($userId = null)
    {
        self::log('Password changed', $userId);
    }

    public static function chatCreatedLog($chatId, $userId = null)
    {
        self::log("Chat created (ID: {$chatId})", $userId);
    }

    public static function messageLog($chatId, $userId = null)
    {
        self::log("Message sent in chat (ID: {$chatId})", $userId);
    }
}
