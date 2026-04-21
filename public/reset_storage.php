<?php
// Script Hapus Link Rusak & Buat Folder Fisik
$path = __DIR__ . '/storage';

if (file_exists($path)) {
    if (is_link($path)) {
        unlink($path);
        echo "Link rusak dihapus.<br>";
    } else {
        // Jika folder ada tapi isinya kosong/bermasalah, kita hapus isinya
        echo "Folder sudah ada.<br>";
    }
}

if (!file_exists($path)) {
    if (mkdir($path, 0755, true)) {
        echo "Folder 'public/storage' BERHASIL dibuat sebagai folder fisik.<br>";
        // Buat subfolder lapangan agar tidak error saat upload
        mkdir($path . '/lapangan', 0755, true);
        echo "Subfolder 'lapangan' dibuat.<br>";
    } else {
        echo "GAGAL membuat folder. Cek permission hosting Anda.<br>";
    }
} else {
    if (!file_exists($path . '/lapangan')) {
        mkdir($path . '/lapangan', 0755, true);
        echo "Subfolder 'lapangan' ditambahkan ke folder yang sudah ada.<br>";
    }
}

echo "<br><b>Selesai! Sekarang silakan coba upload foto lapangan lagi.</b>";
