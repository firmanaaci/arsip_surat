<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratMasuk extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'pengirim',
        'perihal',
        'kategori',
        'status_surat',
        'sifat_surat',
        'tujuan_surat',
        'petunjuk',
        'catatan',
        'isi_disposisi',
        'disposisi_kasubbag',
        'kode_klasifikasi',
        'file',
    ];

    public function disposisis()
    {
        return $this->hasMany(Disposisi::class, 'surat_masuk_id')->latest('id');
    }
}