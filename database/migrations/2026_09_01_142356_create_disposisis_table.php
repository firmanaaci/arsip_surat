<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('disposisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_masuk_id')->constrained('surat_masuks')->onDelete('cascade');
            $table->string('pemberi_disposisi')->default('Kepala Kantor');
            $table->string('tujuan_seksi'); // e.g., Kasubbag TU, Seksi Penma, Seksi Bimas Islam, dll.
            $table->string('sifat_disposisi')->default('Biasa'); // Sangat Segera, Segera, Biasa, Rahasia
            $table->string('petunjuk_disposisi'); // Tindak Lanjuti, Pelajari/Kaji, Siapkan Bahan/Konsep, dll.
            $table->text('catatan_disposisi')->nullable(); // Instruksi khusus pimpinan
            $table->string('status')->default('Menunggu Tindak Lanjut'); // Menunggu Tindak Lanjut, Sedang Diproses, Selesai
            $table->date('tanggal_disposisi');
            $table->text('catatan_tindak_lanjut')->nullable(); // Laporan penyelesaian dari penerima
            $table->timestamp('tgl_selesai')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisis');
    }
};
