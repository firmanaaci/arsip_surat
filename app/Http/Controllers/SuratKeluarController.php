<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratKeluar;
use App\Helpers\KlasifikasiSuratHelper;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SuratKeluarController extends Controller
{
    public function create()
    {
        return view('suratkeluar.create');
    }

    /**
     * API Generator Nomor Surat Keluar Otomatis
     */
    public function generateNomor(Request $request)
    {
        $unitCode = $request->query('unit', '1');
        $klasifikasiCode = $request->query('klasifikasi', 'KP.01.2');
        $tanggal = $request->query('tanggal', null);

        $result = KlasifikasiSuratHelper::generateNomorSuratKeluar($unitCode, $klasifikasiCode, $tanggal);

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat'      => ['required', 'string', 'max:255', Rule::unique('surat_keluars', 'nomor_surat')],
            'tanggal_surat'    => 'required|date',
            'sifat_surat'      => 'required|string',
            'lampiran'         => 'required|string|max:255',
            'hal'              => 'required|string|max:255',
            'tujuan_surat'     => 'required|string|max:255',
            'kode_klasifikasi' => 'nullable|string|max:100',
            'file'             => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('suratkeluar', $originalName, 'public');
            $validated['file_path'] = $path;
        }

        $surat = SuratKeluar::create($validated);

        ActivityLogger::log('CREATE', "Menerbitkan surat keluar baru: {$surat->nomor_surat} (Tujuan: {$surat->tujuan_surat})", $surat);

        return redirect()->route('suratkeluar.index')->with('success', 'Surat keluar berhasil disimpan & nomor surat terdaftar.');
    }

    public function index(Request $request)
    {
        $search = $request->query('search');

        $suratKeluar = SuratKeluar::when($search, function ($query, $search) {
            return $query->where('nomor_surat', 'like', "%{$search}%")
                        ->orWhere('hal', 'like', "%{$search}%")
                        ->orWhere('tujuan_surat', 'like', "%{$search}%")
                        ->orWhere('kode_klasifikasi', 'like', "%{$search}%");
        })
        ->latest('tanggal_surat')
        ->paginate(10)
        ->appends(['search' => $search]);

        return view('tablesuratkeluar', compact('suratKeluar'));
    }

    public function show($id)
    {
        $surat = SuratKeluar::findOrFail($id);

        // Metadata file
        $fileInfo = [
            'exists' => false,
            'size'   => '-',
            'mime'   => '-',
            'hash'   => '-',
            'ext'    => '-',
        ];

        if ($surat->file_path && Storage::disk('public')->exists($surat->file_path)) {
            $fullPath = Storage::disk('public')->path($surat->file_path);
            $bytes = Storage::disk('public')->size($surat->file_path);
            $fileInfo = [
                'exists' => true,
                'size'   => $bytes > 1048576 ? round($bytes / 1048576, 2) . ' MB' : round($bytes / 1024, 2) . ' KB',
                'mime'   => Storage::disk('public')->mimeType($surat->file_path),
                'hash'   => file_exists($fullPath) ? strtoupper(hash_file('sha256', $fullPath)) : '-',
                'ext'    => pathinfo($surat->file_path, PATHINFO_EXTENSION),
            ];
        }

        return view('Dsuratkeluar', compact('surat', 'fileInfo'));
    }

    public function edit($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        return view('editkeluar', compact('surat'));
    }

    public function update(Request $request, $id)
    {
        $surat = SuratKeluar::findOrFail($id);

        $request->validate([
            'nomor_surat'   => ['required', 'string', 'max:255', Rule::unique('surat_keluars', 'nomor_surat')->ignore($surat->id)],
            'tanggal_surat' => 'required|date',
            'sifat_surat'   => 'required|string',
            'lampiran'      => 'nullable|string|max:255',
            'hal'           => 'required|string|max:255',
            'tujuan_surat'  => 'required|string|max:255',
            'file'          => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',
        ]);

        $surat->fill($request->except('file'));

        if ($request->hasFile('file')) {
            if ($surat->file_path && Storage::disk('public')->exists($surat->file_path)) {
                Storage::disk('public')->delete($surat->file_path);
            }

            $file = $request->file('file');
            $originalName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('suratkeluar', $originalName, 'public');
            $surat->file_path = $path;
        }

        $surat->save();

        ActivityLogger::log('UPDATE', "Memperbarui data surat keluar: {$surat->nomor_surat}", $surat);

        return redirect()->route('suratkeluar.index')->with('success', 'Surat keluar berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        $nomorSurat = $surat->nomor_surat;

        // Soft delete
        $surat->delete();

        ActivityLogger::log('DELETE', "Memindahkan surat keluar '{$nomorSurat}' ke tempat sampah", $surat);

        return redirect()->route('suratkeluar.index')->with('success', "Surat keluar '{$nomorSurat}' berhasil dipindahkan ke Tempat Sampah.");
    }
}
