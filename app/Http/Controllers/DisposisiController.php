<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\Disposisi;
use App\Helpers\ActivityLogger;

class DisposisiController extends Controller
{
    /**
     * Simpan disposisi baru untuk surat masuk
     */
    public function store(Request $request, $suratMasukId)
    {
        $surat = SuratMasuk::findOrFail($suratMasukId);

        $validated = $request->validate([
            'pemberi_disposisi'  => 'required|string|max:255',
            'tujuan_seksi'       => 'required|string|max:255',
            'sifat_disposisi'    => 'required|string',
            'petunjuk_disposisi' => 'required|string',
            'catatan_disposisi'  => 'nullable|string',
            'tanggal_disposisi'  => 'required|date',
        ]);

        $validated['surat_masuk_id'] = $surat->id;
        $validated['status'] = 'Menunggu Tindak Lanjut';

        $disposisi = Disposisi::create($validated);

        // Update status surat masuk menjadi Didisposisikan
        $surat->update([
            'status_surat'  => 'Didisposisikan',
            'isi_disposisi' => $validated['petunjuk_disposisi'] . ($validated['catatan_disposisi'] ? ' - ' . $validated['catatan_disposisi'] : ''),
            'petunjuk'      => $validated['petunjuk_disposisi'],
            'tujuan_surat'  => $validated['tujuan_seksi'],
        ]);

        ActivityLogger::log('CREATE', "Membuat lembar disposisi baru untuk surat '{$surat->nomor_surat}' kepada {$validated['tujuan_seksi']}", $disposisi);

        return redirect()->back()->with('success', 'Disposisi berhasil dibuat dan diteruskan ke ' . $validated['tujuan_seksi'] . '!');
    }

    /**
     * Perbarui status tindak lanjut disposisi oleh penerima / admin
     */
    public function updateStatus(Request $request, $id)
    {
        $disposisi = Disposisi::with('suratMasuk')->findOrFail($id);

        $validated = $request->validate([
            'status'                => 'required|in:Menunggu Tindak Lanjut,Sedang Diproses,Selesai',
            'catatan_tindak_lanjut' => 'nullable|string',
        ]);

        if ($validated['status'] === 'Selesai') {
            $validated['tgl_selesai'] = now();
        }

        $disposisi->update($validated);

        // Sinkronisasi status surat masuk
        if ($disposisi->suratMasuk) {
            $suratStatus = match ($validated['status']) {
                'Sedang Diproses' => 'Sedang Diproses',
                'Selesai'         => 'Selesai',
                default           => 'Didisposisikan',
            };
            $disposisi->suratMasuk->update(['status_surat' => $suratStatus]);
        }

        ActivityLogger::log('UPDATE', "Memperbarui status disposisi #DSP-{$disposisi->id} menjadi: {$validated['status']}", $disposisi);

        return redirect()->back()->with('success', 'Status tindak lanjut disposisi berhasil diperbarui!');
    }

    /**
     * Hapus lembar disposisi (Soft Delete)
     */
    public function destroy($id)
    {
        $disposisi = Disposisi::findOrFail($id);
        $suratMasukId = $disposisi->surat_masuk_id;
        $dspId = $disposisi->id;

        $disposisi->delete();

        // Cek apakah masih ada disposisi aktif lain
        $sisaDisposisi = Disposisi::where('surat_masuk_id', $suratMasukId)->count();
        if ($sisaDisposisi === 0) {
            SuratMasuk::where('id', $suratMasukId)->update(['status_surat' => 'Baru Masuk']);
        }

        ActivityLogger::log('DELETE', "Memindahkan lembar disposisi #DSP-{$dspId} ke tempat sampah", $disposisi);

        return redirect()->back()->with('success', 'Lembar disposisi berhasil dipindahkan ke Tempat Sampah.');
    }

    /**
     * Cetak Lembar Disposisi Resmi Kemenag
     */
    public function cetak($suratMasukId)
    {
        $surat = SuratMasuk::with('disposisis')->findOrFail($suratMasukId);
        ActivityLogger::log('DOWNLOAD', "Membuka lembar cetak disposisi resmi untuk surat '{$surat->nomor_surat}'", $surat);
        return view('disposisi.cetak', compact('surat'));
    }
}
