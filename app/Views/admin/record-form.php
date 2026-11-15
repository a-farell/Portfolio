<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
    <?php $isEdit = $mode === 'edit'; ?>
    <div class="page-heading">
        <div>
            <p class="admin-eyebrow"><?= esc(strtoupper($resource['title'])) ?></p>
            <h1><?= $isEdit ? 'Ubah data' : 'Tambah data' ?></h1>
            <p>Kolom bertanda * wajib diisi.</p>
        </div>
        <a class="button button-quiet" href="<?= site_url('admin/records/' . $name) ?>">Kembali</a>
    </div>

    <?php $errors = session()->getFlashdata('errors') ?? []; ?>
    <section class="admin-panel form-panel">
        <form class="admin-form" method="post" enctype="multipart/form-data" action="<?= site_url('admin/records/' . $name . '/' . ($isEdit ? $record['id'] . '/update' : 'create')) ?>">
            <?= csrf_field() ?>
            <?php foreach ($resource['fields'] as $fieldName => $field): ?>
                <?php
                    $value = old($fieldName);
                    if ($value === null) {
                        $value = $record[$fieldName] ?? '';
                    }
                    $required = str_contains($field['rules'], 'required');
                ?>
                <label>
                    <?= esc($field['label']) ?><?= $required ? ' *' : '' ?>
                    <?php if ($field['type'] === 'textarea'): ?>
                        <textarea name="<?= esc($fieldName, 'attr') ?>" rows="4" <?= $required ? 'required' : '' ?>><?= esc((string) $value) ?></textarea>
                    <?php else: ?>
                        <input type="<?= esc($field['type'], 'attr') ?>" name="<?= esc($fieldName, 'attr') ?>" value="<?= esc((string) $value, 'attr') ?>" <?= $fieldName === 'proficiency' ? 'min="0" max="100"' : '' ?> <?= $required ? 'required' : '' ?>>
                    <?php endif ?>
                    <?php if (isset($errors[$fieldName])): ?><small class="field-error"><?= esc($errors[$fieldName]) ?></small><?php endif ?>
                </label>
            <?php endforeach ?>

            <?php if (isset($resource['upload'])): ?>
                <label>
                    <?= esc($resource['upload']['label']) ?>
                    <input type="file" name="<?= esc($resource['upload']['field'], 'attr') ?>" accept="<?= esc($resource['upload']['accept'], 'attr') ?>">
                    <?php if (isset($errors[$resource['upload']['field']])): ?><small class="field-error"><?= esc($errors[$resource['upload']['field']]) ?></small><?php endif ?>
                </label>
                <p class="form-hint">Unggah file baru akan mengganti path pada kolom terkait. Kolom URL/path di atas juga dapat diisi manual.</p>
            <?php endif ?>

            <div class="form-actions">
                <a class="button button-quiet" href="<?= site_url('admin/records/' . $name) ?>">Batal</a>
                <button class="button button-primary" type="submit">Simpan data</button>
            </div>
        </form>
    </section>
<?= $this->endSection() ?>
