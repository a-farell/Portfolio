<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Files\UploadedFile;
use InvalidArgumentException;
use RuntimeException;

class PortfolioUploader
{
    private const MIME_EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'application/pdf' => 'pdf',
    ];

    private const DIRECTORIES = [
        'avatar' => 'avatars',
        'project' => 'projects',
        'certificate' => 'certificates',
    ];

    public function store(UploadedFile $file, string $kind): string
    {
        if (! isset(self::DIRECTORIES[$kind])) {
            throw new InvalidArgumentException('Jenis file tidak didukung.');
        }

        if (! $file->isValid()) {
            throw new InvalidArgumentException('Unggahan gagal. Pastikan file tidak melebihi 5 MB.');
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            throw new InvalidArgumentException('Ukuran file maksimal 5 MB.');
        }

        $mimeType = $file->getMimeType();
        $extension = self::MIME_EXTENSIONS[$mimeType] ?? null;

        if ($extension === null || ($kind !== 'certificate' && $mimeType === 'application/pdf')) {
            throw new InvalidArgumentException('Format file tidak didukung.');
        }

        if ($mimeType === 'application/pdf') {
            $handle = fopen($file->getTempName(), 'rb');
            if ($handle === false) {
                throw new RuntimeException('File sertifikat tidak dapat dibaca.');
            }
            $signature = fread($handle, 5);
            fclose($handle);

            if ($signature !== '%PDF-') {
                throw new InvalidArgumentException('File tidak dikenali sebagai PDF yang valid.');
            }
        }

        $directory = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . self::DIRECTORIES[$kind];
        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Folder unggahan tidak dapat dibuat.');
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $extension;
        $file->move($directory, $filename);

        return 'assets/uploads/' . self::DIRECTORIES[$kind] . '/' . $filename;
    }
}
