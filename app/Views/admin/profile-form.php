<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
    <div class="page-heading">
        <div>
            <p class="admin-eyebrow">IDENTITAS WEBSITE</p>
            <h1>Profil</h1>
            <p>Informasi utama, kontak, dan foto profil yang tampil di halaman depan.</p>
        </div>
        <a class="button button-quiet" href="<?= site_url('admin') ?>">Kembali</a>
    </div>

    <?php $errors = session()->getFlashdata('errors') ?? []; ?>
    <section class="admin-panel form-panel">
        <form class="admin-form" method="post" enctype="multipart/form-data" action="<?= site_url('admin/profile') ?>">
            <?= csrf_field() ?>
            <?php foreach ($fields as $fieldName => $field): ?>
                <?php
                    $value = old($fieldName);
                    if ($value === null) {
                        $value = $profile[$fieldName] ?? '';
                    }
                    $required = str_contains($field['rules'], 'required');
                ?>
                <label>
                    <?= esc($field['label']) ?><?= $required ? ' *' : '' ?>
                    <?php if ($field['type'] === 'textarea'): ?>
                        <textarea name="<?= esc($fieldName, 'attr') ?>" rows="5" <?= $required ? 'required' : '' ?>><?= esc((string) $value) ?></textarea>
                    <?php else: ?>
                        <input type="<?= esc($field['type'], 'attr') ?>" name="<?= esc($fieldName, 'attr') ?>" value="<?= esc((string) $value, 'attr') ?>" <?= $required ? 'required' : '' ?>>
                    <?php endif ?>
                    <?php if (isset($errors[$fieldName])): ?><small class="field-error"><?= esc($errors[$fieldName]) ?></small><?php endif ?>
                </label>
            <?php endforeach ?>
            <label>
                Unggah foto profil (JPG/PNG/WebP, maks. 5 MB)
                <input type="file" name="avatar_file" accept=".jpg,.jpeg,.png,.webp">
                <?php if (isset($errors['avatar_file'])): ?><small class="field-error"><?= esc($errors['avatar_file']) ?></small><?php endif ?>
            </label>
            <p class="form-hint">Unggah foto baru akan mengganti URL/path pada kolom foto profil. Kolom URL/path juga dapat diisi manual.</p>
            <div class="form-actions">
                <a class="button button-quiet" href="<?= site_url('admin') ?>">Batal</a>
                <button class="button button-primary" type="submit">Simpan profil</button>
            </div>
        </form>
    </section>
<?= $this->endSection() ?>
