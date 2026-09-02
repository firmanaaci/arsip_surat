<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Record an audit activity log entry
     *
     * @param string $action (CREATE, UPDATE, DELETE, RESTORE, FORCE_DELETE, DOWNLOAD, LOGIN, LOGOUT)
     * @param string $description
     * @param \Illuminate\Database\Eloquent\Model|null $model
     * @param \App\Models\User|null $user
     * @return \App\Models\ActivityLog
     */
    public static function log(string $action, string $description, $model = null, $user = null)
    {
        $user = $user ?? Auth::user();

        $modelType = null;
        $modelId = null;

        if ($model) {
            $modelType = class_basename($model);
            $modelId = $model->id ?? null;
        }

        return ActivityLog::create([
            'user_id'     => $user?->id,
            'user_name'   => $user?->name ?? 'Tamu / Sistem',
            'user_role'   => $user?->role ?? 'tamu',
            'action'      => strtoupper($action),
            'model_type'  => $modelType,
            'model_id'    => $modelId,
            'description' => $description,
            'ip_address'  => Request::ip(),
            'user_agent'  => Request::userAgent(),
        ]);
    }
}
