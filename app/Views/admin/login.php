<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Admin — Portofolio</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>
<body class="admin-body login-body">
    <main class="login-card">
        <a class="admin-brand" href="<?= site_url('/') ?>">PORTOFOLIO <span>ADMIN</span></a>
        <p class="admin-eyebrow">AREA TERBATAS</p>
        <h1>Masuk ke admin</h1>
        <p class="form-intro">Kelola profil dan konten portofolio Anda.</p>
        <?php if ($error = session()->getFlashdata('error')): ?>
            <div class="notice notice-error"><?= esc($error) ?></div>
        <?php endif ?>
        <form method="post" action="<?= site_url('admin/login') ?>" class="admin-form">
            <?= csrf_field() ?>
            <label>
                Email
                <input type="email" name="email" value="<?= esc(old('email') ?? '', 'attr') ?>" autocomplete="username" required>
            </label>
            <label>
                Kata sandi
                <input type="password" name="password" autocomplete="current-password" required>
            </label>
            <button class="button button-primary button-wide" type="submit">Masuk</button>
        </form>
        <a class="back-to-site" href="<?= site_url('/') ?>">← Kembali ke website</a>
    </main>
</body>
</html>
