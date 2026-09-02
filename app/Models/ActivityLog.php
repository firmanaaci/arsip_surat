<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_role',
        'action',
        'model_type',
        'model_id',
        'description',
        'ip_address',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Badge color mapping for actions
     */
    public function getActionBadgeAttribute(): array
    {
        return match(strtoupper($this->action)) {
            'CREATE'       => ['bg' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'add_circle', 'label' => 'Tambah Data'],
            'UPDATE'       => ['bg' => 'bg-blue-50 text-blue-700 border-blue-200', 'icon' => 'edit', 'label' => 'Perbarui Data'],
            'DELETE'       => ['bg' => 'bg-amber-50 text-amber-700 border-amber-200', 'icon' => 'delete', 'label' => 'Hapus ke Sampah'],
            'RESTORE'      => ['bg' => 'bg-purple-50 text-purple-700 border-purple-200', 'icon' => 'restore_from_trash', 'label' => 'Pulihkan Data'],
            'FORCE_DELETE' => ['bg' => 'bg-red-50 text-red-700 border-red-200', 'icon' => 'delete_forever', 'label' => 'Hapus Permanen'],
            'DOWNLOAD'     => ['bg' => 'bg-cyan-50 text-cyan-700 border-cyan-200', 'icon' => 'download', 'label' => 'Unduh Berkas'],
            'LOGIN'        => ['bg' => 'bg-indigo-50 text-indigo-700 border-indigo-200', 'icon' => 'login', 'label' => 'Masuk Sistem'],
            'LOGOUT'       => ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'icon' => 'logout', 'label' => 'Keluar Sistem'],
            default        => ['bg' => 'bg-slate-100 text-slate-600 border-slate-200', 'icon' => 'info', 'label' => $this->action],
        };
    }
}
