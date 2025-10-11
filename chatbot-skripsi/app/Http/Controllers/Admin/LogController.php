<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\User;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = Log::with('user');

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by activity
        if ($request->has('search') && $request->search) {
            $query->where('activity', 'like', '%' . $request->search . '%');
        }

        $logs = $query->paginate(20);

        // Get all users for filter dropdown
        $users = User::where('role_id', 2)->get();

        return view('admin.logs.index', compact('logs', 'users'));
    }

    public function show(Log $log)
    {
        $log->load('user.personal');
        return view('admin.logs.show', compact('log'));
    }

    public function destroy(Log $log)
    {
        $log->delete();
        return redirect()->route('admin.logs.index')->with('success', 'Log berhasil dihapus!');
    }

    public function clearAll()
    {
        Log::truncate();
        return redirect()->route('admin.logs.index')->with('success', 'Semua log berhasil dihapus!');
    }

    public function clearOld()
    {
        // Hapus log lebih dari 30 hari
        Log::where('created_at', '<', now()->subDays(30))->delete();
        return redirect()->route('admin.logs.index')->with('success', 'Log lama berhasil dihapus!');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'log_ids' => 'required|string',
        ]);

        $logIds = explode(',', $request->log_ids);

        if (empty($logIds)) {
            return redirect()->route('admin.logs.index')->with('error', 'Tidak ada log yang dipilih!');
        }

        $deletedCount = Log::whereIn('id', $logIds)->delete();

        return redirect()->route('admin.logs.index')
            ->with('success', "Berhasil menghapus {$deletedCount} log!");
    }
}
