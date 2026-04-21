<?php
// Script Paksa Symlink untuk Jagoan Hosting
$target = __DIR__ . '/../storage/app/public';
$link = __DIR__ . '/storage';

if (file_exists($link)) {
    if (is_link($link)) {
        unlink($link);
        echo "Link lama dihapus.<br>";
    } else {
        rename($link, $link . '_backup_' . time());
        echo "Folder storage lama di-rename.<br>";
    }
}

if (symlink($target, $link)) {
    echo "Symlink BERHASIL dibuat!<br>";
    echo "Target: $target <br>";
    echo "Link: $link <br>";
} else {
    echo "Symlink GAGAL dibuat. Silakan hubungi support hosting.";
}
