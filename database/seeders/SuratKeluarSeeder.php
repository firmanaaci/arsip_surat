<?php

namespace Database\Seeders;

use App\Models\SuratKeluar;
use Illuminate\Database\Seeder;

class SuratKeluarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nomor_surat' => 'SK-2026-0001',
                'tanggal_surat' => '2026-07-03',
                'sifat_surat' => 'Biasa',
                'lampiran' => '1 berkas',
                'hal' => 'Jawaban Permohonan Data',
                'tujuan_surat' => 'Dinas Pendidikan Kota',
                'file_path' => 'suratkeluar/sk-2026-0001.pdf',
            ],
            [
                'nomor_surat' => 'SK-2026-0002',
                'tanggal_surat' => '2026-07-18',
                'sifat_surat' => 'Segera',
                'lampiran' => '2 lembar',
                'hal' => 'Undangan Rapat Koordinasi',
                'tujuan_surat' => 'Seluruh Guru dan Staf',
                'file_path' => 'suratkeluar/sk-2026-0002.pdf',
            ],
            [
                'nomor_surat' => 'SK-2026-0003',
                'tanggal_surat' => '2026-08-02',
                'sifat_surat' => 'Penting',
                'lampiran' => '3 lembar',
                'hal' => 'Laporan Pelaksanaan Kegiatan',
                'tujuan_surat' => 'Kementerian Pendidikan',
                'file_path' => 'suratkeluar/sk-2026-0003.pdf',
            ],
        ];

        foreach ($data as $item) {
            SuratKeluar::updateOrCreate(
                ['nomor_surat' => $item['nomor_surat']],
                $item
            );
        }
    }
}