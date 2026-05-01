<?php
session_start();

// 1. Tentukan bahasa: Prioritas dari URL, lalu Session, default ke 'en'
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
} else {
    $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
}

// 2. Load file JSON
$jsonFile = __DIR__ . "/{$lang}.json";
$translations = [];

if (file_exists($jsonFile)) {
    $jsonString = file_get_contents($jsonFile);
    $translations = json_decode($jsonString, true);
}

/**
 * Fungsi Helper global untuk mengambil teks (Nested Keys)
 */
function __($key, $data) {
    $keys = explode('.', $key);
    foreach ($keys as $k) {
        if (isset($data[$k])) {
            $data = $data[$k];
        } else {
            return $key; 
        }
    }
    return $data;
}