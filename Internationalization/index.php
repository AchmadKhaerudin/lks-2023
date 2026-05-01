<?php require_once 'i18n.php'; ?>

<!DOCTYPE html>
<html lang="<?= $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page - PHP i18n</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; }
        nav { display: flex; justify-content: space-between; padding: 20px 5%; background: #fff; border-bottom: 1px solid #eee; }
        .hero { height: 40vh; display: flex; flex-direction: column; justify-content: center; align-items: center; background: #f9f9f9; text-align: center; }
        .nav-links { display: flex; list-style: none; gap: 20px; align-items: center; }
        select { padding: 5px; border-radius: 4px; }
    </style>
</head>
<body>

    <nav>
        <div class="logo"><strong>DEV.PHP</strong></div>
        <ul class="nav-links">
            <li><?= __('nav.home', $translations); ?></li>
            <li><?= __('nav.services', $translations); ?></li>
            <li><?= __('nav.contact', $translations); ?></li>
            <li>
                <form method="GET">
                    <select name="lang" onchange="this.form.submit()">
                        <option value="en" <?= $lang == 'en' ? 'selected' : ''; ?>>EN</option>
                        <option value="id" <?= $lang == 'id' ? 'selected' : ''; ?>>ID</option>
                    </select>
                </form>
            </li>
        </ul>
    </nav>

    <header class="hero">
        <h1><?= __('hero.title', $translations); ?></h1>
        <p><?= __('hero.subtitle', $translations); ?></p>
    </header>

</body>
</html>