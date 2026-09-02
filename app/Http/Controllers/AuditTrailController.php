<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    /**
     * Display a listing of the audit activity logs.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $actionFilter = $request->query('action');
        $userFilter = $request->query('user_id');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = ActivityLog::with('user')->latest('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        if ($actionFilter) {
            $query->where('action', strtoupper($actionFilter));
        }

        if ($userFilter) {
            $query->where('user_id', $userFilter);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $logs = $query->paginate(20)->withQueryString();

        $users = User::orderBy('name')->get();

        $stats = [
            'total'   => ActivityLog::count(),
            'today'   => ActivityLog::whereDate('created_at', today())->count(),
            'creates' => ActivityLog::where('action', 'CREATE')->count(),
            'deletes' => ActivityLog::whereIn('action', ['DELETE', 'FORCE_DELETE'])->count(),
        ];

        return view('audit.index', compact(
            'logs', 'users', 'stats',
            'search', 'actionFilter', 'userFilter', 'startDate', 'endDate'
        ));
    }
}
