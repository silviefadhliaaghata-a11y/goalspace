<?php
// Script Setup Jalur Brutal (Deteksi Otomatis public_html)
$base = dirname(__DIR__);
$publicFolder = file_exists($base . '/public_html') ? $base . '/public_html' : $base . '/public';
$path = $publicFolder . '/uploads';

echo "Deteksi folder publik: " . $publicFolder . "<br>";

if (!file_exists($path)) {
    if (mkdir($path, 0755, true)) {
        echo "Folder 'uploads' BERHASIL dibuat.<br>";
    } else {
        echo "GAGAL membuat folder uploads. Cek permission.<br>";
    }
} else {
    echo "Folder 'uploads' sudah ada.<br>";
}

$subfolders = ['lapangan', 'bukti-pembayaran'];
foreach ($subfolders as $sub) {
    if (!file_exists($path . '/' . $sub)) {
        mkdir($path . '/' . $sub, 0755, true);
        echo "Subfolder '$sub' BERHASIL dibuat.<br>";
    } else {
        echo "Subfolder '$sub' sudah ada.<br>";
    }
}

echo "<br><b>Setup Selesai! Silakan coba upload foto lapangan lagi.</b>";
