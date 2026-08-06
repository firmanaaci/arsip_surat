<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Minimal valid PDF content
function createMinimalPdf($title) {
    $pdf = "%PDF-1.4\n";
    $pdf .= "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj\n";
    $pdf .= "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj\n";
    $pdf .= "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >> endobj\n";
    $stream = "BT /F1 24 Tf 50 700 Td ($title) Tj ET";
    $pdf .= "4 0 obj << /Length " . strlen($stream) . " >> stream\n" . $stream . "\nendstream\nendobj\n";
    $pdf .= "5 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj\n";
    $pdf .= "xref\n0 6\n0000000000 65535 f \n0000000009 00000 n \n0000000058 00000 n \n0000000115 00000 n \n0000000244 00000 n \n0000000345 00000 n \ntrailer << /Size 6 /Root 1 0 R >>\nstartxref\n424\n%%EOF";
    return $pdf;
}

foreach (App\Models\SuratMasuk::all() as $s) {
    if ($s->file) {
        $fullPath = storage_path('app/public/' . $s->file);
        $dir = dirname($fullPath);
        if (!is_dir($dir)) mkdir($dir, 0777, true);
        if (!file_exists($fullPath)) {
            file_put_contents($fullPath, createMinimalPdf("Surat Masuk: " . $s->nomor_surat));
            echo "Created sample PDF for SuratMasuk: {$s->file}\n";
        }
    }
}

foreach (App\Models\SuratKeluar::all() as $s) {
    if ($s->file_path) {
        $fullPath = storage_path('app/public/' . $s->file_path);
        $dir = dirname($fullPath);
        if (!is_dir($dir)) mkdir($dir, 0777, true);
        if (!file_exists($fullPath)) {
            file_put_contents($fullPath, createMinimalPdf("Surat Keluar: " . $s->nomor_surat));
            echo "Created sample PDF for SuratKeluar: {$s->file_path}\n";
        }
    }
}
