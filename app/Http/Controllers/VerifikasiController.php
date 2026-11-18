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
            'surat'   => $surat,
            'jenis'   => $jenis,
            'kode'    => $kode,
        ]);
    }

    /**
     * Endpoint JSON untuk modal popup verifikasi (AJAX)
     */
    public function verifyJson(string $kode)
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

        if (!$surat) {
            return response()->json(['valid' => false, 'kode' => $kode]);
        }

        return response()->json([
            'valid'           => true,
            'jenis'           => $jenis,
            'nomor_surat'     => $surat->nomor_surat,
            'tanggal_surat'   => \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y'),
            'sifat_surat'     => $surat->sifat_surat ?? 'Biasa',
            'perihal'         => $surat->perihal ?? $surat->hal ?? '-',
            'pengirim'        => $jenis === 'Surat Masuk' ? ($surat->pengirim ?? '-') : ($surat->tujuan_surat ?? '-'),
            'kode_verifikasi' => $surat->kode_verifikasi,
            'created_at'      => $surat->created_at ? $surat->created_at->format('d M Y, H:i:s') . ' WIB' : '-',
        ]);
    }
}
