<?php
// Script Hapus Link Rusak & Buat Folder Fisik (Versi Lengkap)
$path = __DIR__ . '/storage';

if (file_exists($path)) {
    if (is_link($path)) {
        unlink($path);
        echo "Link rusak dihapus.<br>";
    }
}

if (!file_exists($path)) {
    mkdir($path, 0755, true);
    echo "Folder 'public/storage' dibuat.<br>";
}

// Pastikan semua subfolder yang dibutuhkan ada
$subfolders = ['lapangan', 'bukti-pembayaran'];
foreach ($subfolders as $sub) {
    if (!file_exists($path . '/' . $sub)) {
        mkdir($path . '/' . $sub, 0755, true);
        echo "Subfolder '$sub' BERHASIL dibuat.<br>";
    } else {
        echo "Subfolder '$sub' sudah ada.<br>";
    }
}

echo "<br><b>Siap digunakan! Silakan coba upload foto lapangan sekarang.</b>";
