<?php

// cek data2 gambar
// Cek apakah file fisik ada di folder
// if (!file_exists($main_image_path)) {
//     die("Error: File 'background.jpg' tidak ditemukan di folder!");
// }
// if (!file_exists($watermark_path)) {
//     die("Error: File 'logo.png' tidak ditemukan di folder!");
// }

// // Cek apakah formatnya benar-benar valid
// $main_img = @imagecreatefromjpeg($main_image_path);
// if (!$main_img) {
//     die("Error: 'background.jpg' bukan file JPEG yang valid (mungkin korup atau format lain ganti nama).");
// }

// $watermark = @imagecreatefrompng($watermark_path);
// if (!$watermark) {
//     die("Error: 'logo.png' bukan file PNG yang valid.");
// }


// isi watermark 
// --- DEFINISI VARIABEL HARUS DI ATAS ---
$main_image_path = 'background.jpg';
$watermark_path = 'logo.png';

// 1. Diagnosa keberadaan file fisik
if (!file_exists($main_image_path)) {
    // Menampilkan folder aktif saat ini agar kamu tahu PHP sedang "melihat" ke mana
    die("Error: File '{$main_image_path}' tidak ditemukan di: " . getcwd());
}

if (!file_exists($watermark_path)) {
    die("Error: File '{$watermark_path}' tidak ditemukan di: " . getcwd());
}

// 2. Coba muat gambar
$main_img = @imagecreatefromjpeg($main_image_path);
$watermark = @imagecreatefrompng($watermark_path);

if (!$main_img) {
    die("Error: '{$main_image_path}' rusak atau bukan format JPEG asli.");
}

if (!$watermark) {
    die("Error: '{$watermark_path}' rusak atau bukan format PNG asli.");
}

// --- JIKA BERHASIL, LANJUTKAN PROSES ---
$main_w = imagesx($main_img);
$main_h = imagesy($main_img);
$wtrmrk_w = imagesx($watermark);
$wtrmrk_h = imagesy($watermark);

// Auto-resize sederhana (20% lebar background)
$max_width = $main_w * 0.2; 
if ($wtrmrk_w > $max_width) {
    $ratio = $max_width / $wtrmrk_w;
    $new_w = $max_width;
    $new_h = $wtrmrk_h * $ratio;
    $resized = imagecreatetruecolor($new_w, $new_h);
    imagealphablending($resized, false);
    imagesavealpha($resized, true);
    imagecopyresampled($resized, $watermark, 0, 0, 0, 0, $new_w, $new_h, $wtrmrk_w, $wtrmrk_h);
    $watermark = $resized;
    $wtrmrk_w = $new_w;
    $wtrmrk_h = $new_h;
}

$margin = 20;
$dest_x = $main_w - $wtrmrk_w - $margin;
$dest_y = $margin;

imagealphablending($main_img, true);
imagecopy($main_img, $watermark, $dest_x, $dest_y, 0, 0, $wtrmrk_w, $wtrmrk_h);

ob_clean(); // Bersihkan output buffer
header('Content-Type: image/jpeg');
imagejpeg($main_img, null, 90);

imagedestroy($main_img);
imagedestroy($watermark);