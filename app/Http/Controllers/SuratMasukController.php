<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SuratMasukController extends Controller
{
    public function create()
    {
        return view('suratmasuk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat'        => ['required', 'string', 'max:255', Rule::unique('surat_masuks', 'nomor_surat')],
            'tanggal_surat'      => 'required|date',
            'pengirim'           => 'required|string',
            'perihal'            => 'required|string',
            'kategori'           => 'required|string',
            'status_surat'       => 'required|string',
            'sifat_surat'        => 'required|string',
            'tujuan_surat'       => 'required|string',
            'petunjuk'           => 'required|string',
            'catatan'            => 'nullable|string',
            'isi_disposisi'      => 'nullable|string',
            'disposisi_kasubbag' => 'nullable|string',
            'file'               => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120', // max 5MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('surat_masuk', $originalName, 'public');
            $validated['file'] = $path;
        }

        $surat = SuratMasuk::create($validated);

        ActivityLogger::log('CREATE', "Mencatat surat masuk baru: {$surat->nomor_surat} (Asal: {$surat->pengirim})", $surat);

        return redirect()->route('suratmasuk.index')->with('success', 'Surat masuk berhasil disimpan.');
    }

    public function index(Request $request)
    {
        $search = $request->query('search');

        $suratMasuk = SuratMasuk::when($search, function ($query, $search) {
            return $query->where('nomor_surat', 'like', "%{$search}%")
                        ->orWhere('pengirim', 'like', "%{$search}%")
                        ->orWhere('perihal', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10)
        ->appends(['search' => $search]);

        return view('tablesuratmasuk', compact('suratMasuk'));
    }

    public function show($id)
    {
        $surat = SuratMasuk::with('disposisis')->findOrFail($id);
        return view('Dsuratmasuk', compact('surat'));
    }

    public function edit($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        return view('edit', compact('surat'));
    }

    public function update(Request $request, $id)
    {
        $surat = SuratMasuk::findOrFail($id);

        $request->validate([
            'nomor_surat'        => ['required', 'string', 'max:255', Rule::unique('surat_masuks', 'nomor_surat')->ignore($surat->id)],
            'tanggal_surat'      => 'required|date',
            'pengirim'           => 'required|string',
            'perihal'            => 'required|string',
            'kategori'           => 'required|string',
            'status_surat'       => 'required|string',
            'sifat_surat'        => 'required|string',
            'tujuan_surat'       => 'required|string',
            'petunjuk'           => 'required|string',
            'catatan'            => 'nullable|string',
            'isi_disposisi'      => 'nullable|string',
            'disposisi_kasubbag' => 'nullable|string',
            'file'               => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',
        ]);

        $surat->fill($request->except('file'));

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($surat->file && Storage::disk('public')->exists($surat->file)) {
                Storage::disk('public')->delete($surat->file);
            }

            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs('surat_masuk', $fileName, 'public');
            $surat->file = $path;
        }

        $surat->save();

        ActivityLogger::log('UPDATE', "Memperbarui data surat masuk: {$surat->nomor_surat}", $surat);

        return redirect()->route('suratmasuk.index')->with('success', 'Surat masuk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        $nomorSurat = $surat->nomor_surat;

        // Soft delete (data dipindahkan ke tempat sampah, file tetap aman sampai force delete)
        $surat->delete();

        ActivityLogger::log('DELETE', "Memindahkan surat masuk '{$nomorSurat}' ke tempat sampah", $surat);

        return redirect()->route('suratmasuk.index')->with('success', "Surat masuk '{$nomorSurat}' berhasil dipindahkan ke Tempat Sampah.");
    }
}
