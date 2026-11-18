<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratKeluar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surat_keluars';

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'sifat_surat',
        'lampiran',
        'hal',
        'tujuan_surat',
        'kode_klasifikasi',
        'file_path',
    ];

    protected $dates = ['tanggal_surat'];
}
