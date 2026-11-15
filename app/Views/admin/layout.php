<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($pageTitle ?? 'Admin Panel') ?> — Portofolio</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>
<body class="admin-body">
    <header class="admin-topbar">
        <a class="admin-brand" href="<?= site_url('admin') ?>">PORTOFOLIO <span>ADMIN</span></a>
        <div class="admin-account">
            <span><?= esc((string) session()->get('admin_email')) ?></span>
            <form method="post" action="<?= site_url('admin/logout') ?>">
                <?= csrf_field() ?>
                <button class="button button-quiet" type="submit">Keluar</button>
            </form>
        </div>
    </header>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a href="<?= site_url('admin') ?>">Ringkasan</a>
            <a href="<?= site_url('admin/profile') ?>">Profil</a>
            <a href="<?= site_url('admin/records/projects') ?>">Proyek</a>
            <a href="<?= site_url('admin/records/achievements') ?>">Milestones</a>
            <a href="<?= site_url('admin/records/experiences') ?>">Pengalaman</a>
            <a href="<?= site_url('admin/records/education') ?>">Pendidikan</a>
            <a href="<?= site_url('admin/records/skills') ?>">Keahlian</a>
            <a href="<?= site_url('admin/records/social_links') ?>">Tautan sosial</a>
            <a class="public-site-link" href="<?= site_url('/') ?>" target="_blank" rel="noopener noreferrer">Lihat website ↗</a>
        </aside>
        <main class="admin-main">
            <?php if ($success = session()->getFlashdata('success')): ?>
                <div class="notice notice-success"><?= esc($success) ?></div>
            <?php endif ?>
            <?php if ($error = session()->getFlashdata('error')): ?>
                <div class="notice notice-error"><?= esc($error) ?></div>
            <?php endif ?>
            <?= $this->renderSection('content') ?>
        </main>
    </div>
    <script src="<?= base_url('assets/js/admin.js') ?>" defer></script>
</body>
</html>
