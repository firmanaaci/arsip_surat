<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;

class VerifikasiController extends Controller
{
    /**
     * Halaman Publik Verifikasi Keaslian Dokumen
     */
    public function verify(string $kode)
    {
        $suratMasuk = SuratMasuk::where('kode_verifikasi', $kode)
            ->orWhere('nomor_surat', $kode)
            ->first();

        $suratKeluar = null;
        if (!$suratMasuk) {
            $suratKeluar = SuratKeluar::where('kode_verifikasi', $kode)
                ->orWhere('nomor_surat', $kode)
                ->first();
        }

        $surat = $suratMasuk ?? $suratKeluar;
        $jenis = $suratMasuk ? 'Surat Masuk' : ($suratKeluar ? 'Surat Keluar' : null);
        $isValid = $surat !== null;

        return view('public.verifikasi', [
            'isValid' => $isValid,
            'surat' => $surat,
            'jenis' => $jenis,
            'kode' => $kode,
        ]);
    }
}
