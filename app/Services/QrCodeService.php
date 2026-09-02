<?php

namespace App\Services;

class QrCodeService
{
    /**
     * Generate URL verifikasi publik untuk token UUID yang dapat diakses oleh HP (LAN / Wi-Fi)
     */
    public static function getVerificationUrl(string $uuid): string
    {
        // 1. Jika ada QR_BASE_URL custom di .env (misal ngrok atau domain publik)
        $customBase = env('QR_BASE_URL');
        if (!empty($customBase)) {
            return rtrim($customBase, '/') . '/verifikasi/' . $uuid;
        }

        // 2. Deteksi host saat ini
        $request = request();
        $host = $request->getHost();
        $port = $request->getPort();
        $scheme = $request->getScheme();

        // Jika diakses dari localhost / 127.0.0.1, gunakan IP lokal komputer agar HP di jaringan Wi-Fi sama bisa akses
        if (in_array($host, ['localhost', '127.0.0.1', '::1', '0.0.0.0'])) {
            $localIp = gethostbyname(gethostname());
            if ($localIp && $localIp !== '127.0.0.1') {
                $portStr = ($port && !in_array($port, [80, 443])) ? ':' . $port : ':8000';
                return "{$scheme}://{$localIp}{$portStr}/verifikasi/{$uuid}";
            }
        }

        // 3. Fallback jika sudah di hosting / IP publik
        return route('verifikasi.public', $uuid);
    }

    /**
     * Render SVG QR Code via pure PHP SVG generator / vector API endpoint
     */
    public static function generateSvg(string $data, int $size = 180): string
    {
        $encodedData = urlencode($data);
        return "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data={$encodedData}&format=svg";
    }

    /**
     * Render PNG QR Code
     */
    public static function generatePng(string $data, int $size = 200): string
    {
        $encodedData = urlencode($data);
        return "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data={$encodedData}";
    }
}
