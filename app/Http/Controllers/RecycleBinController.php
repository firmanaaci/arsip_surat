<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecycleBinController extends Controller
{
    /**
     * Display the recycle bin view.
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'masuk');
        $search = $request->query('search');

        // Trashed Surat Masuk
        $queryMasuk = SuratMasuk::onlyTrashed()->latest('deleted_at');
        if ($search && $tab === 'masuk') {
            $queryMasuk->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('pengirim', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%");
            });
        }
        $trashedMasuk = $queryMasuk->paginate(10, ['*'], 'masuk_page')->withQueryString();

        // Trashed Surat Keluar
        $queryKeluar = SuratKeluar::onlyTrashed()->latest('deleted_at');
        if ($search && $tab === 'keluar') {
            $queryKeluar->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('tujuan_surat', 'like', "%{$search}%")
                  ->orWhere('hal', 'like', "%{$search}%");
            });
        }
        $trashedKeluar = $queryKeluar->paginate(10, ['*'], 'keluar_page')->withQueryString();

        // Trashed Disposisi
        $queryDisposisi = Disposisi::onlyTrashed()->with('suratMasuk')->latest('deleted_at');
        if ($search && $tab === 'disposisi') {
            $queryDisposisi->where(function ($q) use ($search) {
                $q->where('tujuan_seksi', 'like', "%{$search}%")
                  ->orWhere('petunjuk_disposisi', 'like', "%{$search}%")
                  ->orWhere('catatan_disposisi', 'like', "%{$search}%");
            });
        }
        $trashedDisposisi = $queryDisposisi->paginate(10, ['*'], 'disposisi_page')->withQueryString();

        $counts = [
            'masuk'     => SuratMasuk::onlyTrashed()->count(),
            'keluar'    => SuratKeluar::onlyTrashed()->count(),
            'disposisi' => Disposisi::onlyTrashed()->count(),
            'total'     => SuratMasuk::onlyTrashed()->count() + SuratKeluar::onlyTrashed()->count() + Disposisi::onlyTrashed()->count(),
        ];

        return view('recyclebin.index', compact(
            'trashedMasuk', 'trashedKeluar', 'trashedDisposisi',
            'counts', 'tab', 'search'
        ));
    }

    /**
     * Restore a soft-deleted item.
     */
    public function restore($type, $id)
    {
        $restoredItem = null;
        $label = '';

        switch ($type) {
            case 'masuk':
                $item = SuratMasuk::onlyTrashed()->findOrFail($id);
                $item->restore();
                $restoredItem = $item;
                $label = "Surat Masuk '{$item->nomor_surat}'";
                break;

            case 'keluar':
                $item = SuratKeluar::onlyTrashed()->findOrFail($id);
                $item->restore();
                $restoredItem = $item;
                $label = "Surat Keluar '{$item->nomor_surat}'";
                break;

            case 'disposisi':
                $item = Disposisi::onlyTrashed()->findOrFail($id);
                $item->restore();
                $restoredItem = $item;
                $label = "Lembar Disposisi #DSP-{$item->id}";
                break;

            default:
                return redirect()->back()->with('error', 'Tipe dokumen tidak valid.');
        }

        ActivityLogger::log('RESTORE', "Memulihkan {$label} dari tempat sampah", $restoredItem);

        return redirect()->route('recyclebin.index', ['tab' => $type])->with('success', "{$label} berhasil dipulihkan.");
    }

    /**
     * Permanently delete an item and clean its physical storage.
     */
    public function forceDelete($type, $id)
    {
        $label = '';

        switch ($type) {
            case 'masuk':
                $item = SuratMasuk::onlyTrashed()->findOrFail($id);
                $label = "Surat Masuk '{$item->nomor_surat}'";
                // Delete physical file if exists
                if ($item->file && Storage::disk('public')->exists($item->file)) {
                    Storage::disk('public')->delete($item->file);
                }
                $item->forceDelete();
                break;

            case 'keluar':
                $item = SuratKeluar::onlyTrashed()->findOrFail($id);
                $label = "Surat Keluar '{$item->nomor_surat}'";
                // Delete physical file if exists
                if ($item->file_path && Storage::disk('public')->exists($item->file_path)) {
                    Storage::disk('public')->delete($item->file_path);
                }
                $item->forceDelete();
                break;

            case 'disposisi':
                $item = Disposisi::onlyTrashed()->findOrFail($id);
                $label = "Lembar Disposisi #DSP-{$item->id}";
                $item->forceDelete();
                break;

            default:
                return redirect()->back()->with('error', 'Tipe dokumen tidak valid.');
        }

        ActivityLogger::log('FORCE_DELETE', "Menghapus permanen {$label} beserta berkas fisiknya");

        return redirect()->route('recyclebin.index', ['tab' => $type])->with('success', "{$label} telah dihapus permanen dari sistem.");
    }

    /**
     * Empty an entire trash tab or all tabs.
     */
    public function emptyTrash(Request $request, $type = 'all')
    {
        $count = 0;

        if ($type === 'masuk' || $type === 'all') {
            $masukList = SuratMasuk::onlyTrashed()->get();
            foreach ($masukList as $item) {
                if ($item->file && Storage::disk('public')->exists($item->file)) {
                    Storage::disk('public')->delete($item->file);
                }
                $item->forceDelete();
                $count++;
            }
        }

        if ($type === 'keluar' || $type === 'all') {
            $keluarList = SuratKeluar::onlyTrashed()->get();
            foreach ($keluarList as $item) {
                if ($item->file_path && Storage::disk('public')->exists($item->file_path)) {
                    Storage::disk('public')->delete($item->file_path);
                }
                $item->forceDelete();
                $count++;
            }
        }

        if ($type === 'disposisi' || $type === 'all') {
            $disposisiList = Disposisi::onlyTrashed()->get();
            foreach ($disposisiList as $item) {
                $item->forceDelete();
                $count++;
            }
        }

        ActivityLogger::log('FORCE_DELETE', "Mengosongkan tempat sampah ({$count} dokumen dihapus permanen)");

        return redirect()->route('recyclebin.index')->with('success', "Tempat sampah berhasil dikosongkan ({$count} data dihapus permanen).");
    }
}
