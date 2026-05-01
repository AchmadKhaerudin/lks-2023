<?php
// 1. Baca file JSON
$json_data = file_get_contents('log_pesan.json');
$chat_log = json_decode($json_data, true);

// Inisialisasi variabel
$user_msgs = [];
$bot_msgs = [];
$total_chars_sent = 0;
$total_chars_received = 0;
$user_words = [];

// 2. Proses data dalam satu kali perulangan (Efisiensi)
foreach ($chat_log as $msg) {
    if ($msg['pengirim'] === 'user') {
        $user_msgs[] = $msg;
        $total_chars_sent += strlen($msg['pesan']);

        // Olah kata untuk Top 5 (bersihkan tanda baca)
        $clean_msg = strtolower(preg_replace('/[.,?!]/', '', $msg['pesan']));
        $words = explode(' ', $clean_msg);
        foreach ($words as $word) {
            if (strlen($word) > 1) { // Abaikan huruf tunggal
                $user_words[] = $word;
            }
        }
    } else {
        $bot_msgs[] = $msg;
        $total_chars_received += strlen($msg['pesan']);
    }
}

// 3. Hitung Statistik Utama
$total_sent = count($user_msgs);
$total_received = count($bot_msgs);

$avg_len_sent = ($total_sent > 0) ? round($total_chars_sent / $total_sent) : 0;
$avg_len_received = ($total_received > 0) ? round($total_chars_received / $total_received) : 0;

// 4. Hitung Top 5 Sent Words
$word_counts = array_count_values($user_words);
arsort($word_counts); // Urutkan dari yang terbanyak
$top_5_words = array_slice($word_counts, 0, 5, true);