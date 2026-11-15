<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
    <div class="page-heading">
        <div>
            <p class="admin-eyebrow">DATA PORTOFOLIO</p>
            <h1><?= esc($resource['title']) ?></h1>
            <p>Atur isi dan urutan data yang ditampilkan pada website.</p>
        </div>
        <a class="button button-primary" href="<?= site_url('admin/records/' . $name . '/new') ?>">Tambah data</a>
    </div>

    <section class="admin-panel">
        <?php if ($rows === []): ?>
            <div class="empty-state">
                <h2>Belum ada data</h2>
                <p>Tambahkan entri pertama untuk bagian <?= esc(strtolower($resource['title'])) ?>.</p>
                <a class="button button-primary" href="<?= site_url('admin/records/' . $name . '/new') ?>">Tambah data</a>
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <?php foreach ($resource['columns'] as $column): ?>
                                <th><?= esc($resource['fields'][$column]['label']) ?></th>
                            <?php endforeach ?>
                            <th>Urutan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <?php foreach ($resource['columns'] as $column): ?>
                                    <td><?= esc((string) ($row[$column] ?? '')) ?></td>
                                <?php endforeach ?>
                                <td><?= esc((string) ($row['sort_order'] ?? '0')) ?></td>
                                <td class="table-actions">
                                    <a class="text-action" href="<?= site_url('admin/records/' . $name . '/' . $row['id'] . '/edit') ?>">Ubah</a>
                                    <form method="post" action="<?= site_url('admin/records/' . $name . '/' . $row['id'] . '/delete') ?>" data-confirm-delete data-delete-label="<?= esc((string) ($row[$resource['columns'][0]] ?? 'data ini'), 'attr') ?>" onsubmit="return confirm('Hapus data ini?')">
                                        <?= csrf_field() ?>
                                        <button class="text-action text-danger" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php endif ?>
    </section>

    <dialog class="confirm-dialog" data-delete-dialog aria-labelledby="delete-dialog-title" aria-describedby="delete-dialog-description">
        <div class="confirm-dialog-content">
            <p class="admin-eyebrow">KONFIRMASI HAPUS</p>
            <h2 id="delete-dialog-title">Hapus data ini?</h2>
            <p id="delete-dialog-description">Data <strong data-delete-label></strong> akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.</p>
            <div class="confirm-dialog-actions">
                <button class="button button-quiet" type="button" data-cancel-delete>Batal</button>
                <button class="button button-danger" type="button" data-confirm-delete-action>Ya, hapus</button>
            </div>
        </div>
    </dialog>
<?= $this->endSection() ?>
