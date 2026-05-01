<?php require_once 'analisis.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PHP Chat Analytics</title>
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: 'Courier New', monospace;
            padding: 50px;
        }
        .analytics-card {
            background: #000;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #333;
        }
        ul { list-style: none; padding: 0; }
        li { margin-bottom: 12px; font-size: 1.1rem; }
        .top-words { margin-left: 25px; color: #888; }
        .val { color: #00ff00; font-weight: bold; }
        h2 { border-bottom: 1px solid #333; padding-bottom: 10px; }
    </style>
</head>
<body>

    <div class="analytics-card">
        <h2>&gt; CHAT_ANALYTICS.EXE</h2>
        <ul>
            <li>
                <strong>Top 5 sent words:</strong>
                <ul class="top-words">
                    <?php foreach ($top_5_words as $word => $count): ?>
                        <li>• <?= $word ?> (<span class="val"><?= $count ?>x</span>)</li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li>Total message sent: <span class="val"><?= $total_sent ?></span></li>
            <li>Total message received: <span class="val"><?= $total_received ?></span></li>
            <li>Average characters length sent: <span class="val"><?= $avg_len_sent ?></span></li>
            <li>Average characters length received: <span class="val"><?= $avg_len_received ?></span></li>
        </ul>
    </div>

</body>
</html>