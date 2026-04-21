<?php
// Script Setup Jalur Brutal
$path = __DIR__ . '/uploads';

if (!file_exists($path)) {
    mkdir($path, 0755, true);
    echo "Folder 'public/uploads' BERHASIL dibuat.<br>";
}

$subfolders = ['lapangan', 'bukti-pembayaran'];
foreach ($subfolders as $sub) {
    if (!file_exists($path . '/' . $sub)) {
        mkdir($path . '/' . $sub, 0755, true);
        echo "Subfolder '$sub' BERHASIL dibuat.<br>";
    }
}

echo "<br><b>Setup Selesai! Sekarang silakan coba upload foto lapangan lagi.</b>";
