<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disposisi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'surat_masuk_id',
        'pemberi_disposisi',
        'tujuan_seksi',
        'sifat_disposisi',
        'petunjuk_disposisi',
        'catatan_disposisi',
        'status',
        'tanggal_disposisi',
        'catatan_tindak_lanjut',
        'tgl_selesai',
    ];

    protected $casts = [
        'tanggal_disposisi' => 'date',
        'tgl_selesai' => 'datetime',
    ];

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }
}
