<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
    <div class="page-heading">
        <div>
            <p class="admin-eyebrow">DASHBOARD</p>
            <h1>Kelola portofolio</h1>
            <p>Perbarui isi website tanpa mengubah kode atau membuka phpMyAdmin.</p>
        </div>
        <a class="button button-quiet" href="<?= site_url('/') ?>" target="_blank" rel="noopener noreferrer">Lihat website ↗</a>
    </div>

    <?php if ($profileCount === 0): ?>
        <div class="notice notice-error">Profil belum dibuat. Lengkapi profil sebelum menambahkan data lain.</div>
    <?php endif ?>

    <section class="summary-grid" aria-label="Ringkasan data">
        <a class="summary-card" href="<?= site_url('admin/profile') ?>">
            <span>Profil</span><strong><?= esc((string) $profileCount) ?></strong>
        </a>
        <?php foreach ($resources as $key => $resource): ?>
            <a class="summary-card" href="<?= site_url('admin/records/' . $key) ?>">
                <span><?= esc($resource['title']) ?></span><strong><?= esc((string) ($counts[$key] ?? 0)) ?></strong>
            </a>
        <?php endforeach ?>
    </section>

    <section class="admin-panel">
        <div class="panel-heading">
            <div>
                <h2>Pengelolaan konten</h2>
                <p>Pilih bagian untuk menambah, mengubah, atau menghapus datanya.</p>
            </div>
            <a class="button button-primary" href="<?= site_url('admin/profile') ?>">Edit profil</a>
        </div>
        <div class="resource-grid">
            <?php foreach ($resources as $key => $resource): ?>
                <a class="resource-card" href="<?= site_url('admin/records/' . $key) ?>">
                    <span><?= esc($resource['title']) ?></span>
                    <strong><?= esc((string) ($counts[$key] ?? 0)) ?> entri</strong>
                    <span class="resource-arrow" aria-hidden="true">↗</span>
                </a>
            <?php endforeach ?>
        </div>
    </section>
<?= $this->endSection() ?>
