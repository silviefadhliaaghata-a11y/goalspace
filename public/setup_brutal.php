<?php
// Script Perbaikan Izin & Setup Uploads
$base = dirname(__DIR__);
$publicFolder = file_exists($base . '/public_html') ? $base . '/public_html' : $base . '/public';
$path = $publicFolder . '/uploads';

echo "Deteksi folder publik: " . $publicFolder . "<br>";

// Set izin folder publik ke 0755 agar bisa diakses sistem
chmod($publicFolder, 0755);
echo "Izin folder publik diatur ke 0755.<br>";

if (!file_exists($path)) {
    mkdir($path, 0777, true);
    echo "Folder 'uploads' dibuat.<br>";
} else {
    chmod($path, 0777);
    echo "Izin folder 'uploads' diatur ke 0777.<br>";
}

$subfolders = ['lapangan', 'bukti-pembayaran'];
foreach ($subfolders as $sub) {
    $subPath = $path . '/' . $sub;
    if (!file_exists($subPath)) {
        mkdir($subPath, 0777, true);
        echo "Subfolder '$sub' dibuat.<br>";
    } else {
        chmod($subPath, 0777);
        echo "Izin subfolder '$sub' diatur ke 0777.<br>";
    }
}

echo "<br><b>Selesai! Sekarang silakan coba upload foto lapangan lagi.</b>";
