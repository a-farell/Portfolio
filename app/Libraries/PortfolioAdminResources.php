<?php

namespace App\Libraries;

class PortfolioAdminResources
{
    /**
     * @return array<string, array{
     *     title: string,
     *     table: string,
     *     columns: list<string>,
     *     fields: array<string, array{label: string, type: string, rules: string}>,
     *     upload?: array{field: string, column: string, kind: string, label: string, accept: string}
     * }>
     */
    public static function all(): array
    {
        return [
            'education' => [
                'title' => 'Pendidikan',
                'table' => 'education',
                'columns' => ['degree', 'institution', 'study_period'],
                'fields' => [
                    'institution' => ['label' => 'Institusi', 'type' => 'text', 'rules' => 'required|max_length[180]'],
                    'degree' => ['label' => 'Gelar/Jurusan', 'type' => 'text', 'rules' => 'required|max_length[180]'],
                    'study_period' => ['label' => 'Periode', 'type' => 'text', 'rules' => 'required|max_length[80]'],
                    'description' => ['label' => 'Deskripsi', 'type' => 'textarea', 'rules' => 'permit_empty'],
                    'sort_order' => ['label' => 'Urutan', 'type' => 'number', 'rules' => 'permit_empty|is_natural'],
                ],
            ],
            'experiences' => [
                'title' => 'Pengalaman',
                'table' => 'experiences',
                'columns' => ['role', 'organization', 'period'],
                'fields' => [
                    'organization' => ['label' => 'Organisasi/Perusahaan', 'type' => 'text', 'rules' => 'required|max_length[180]'],
                    'role' => ['label' => 'Jabatan', 'type' => 'text', 'rules' => 'required|max_length[180]'],
                    'period' => ['label' => 'Periode', 'type' => 'text', 'rules' => 'required|max_length[80]'],
                    'description' => ['label' => 'Deskripsi', 'type' => 'textarea', 'rules' => 'required'],
                    'sort_order' => ['label' => 'Urutan', 'type' => 'number', 'rules' => 'permit_empty|is_natural'],
                ],
            ],
            'skills' => [
                'title' => 'Keahlian',
                'table' => 'skills',
                'columns' => ['name', 'category', 'proficiency'],
                'fields' => [
                    'name' => ['label' => 'Nama keahlian', 'type' => 'text', 'rules' => 'required|max_length[100]'],
                    'category' => ['label' => 'Kategori', 'type' => 'text', 'rules' => 'required|max_length[100]'],
                    'proficiency' => ['label' => 'Tingkat (0-100)', 'type' => 'number', 'rules' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]'],
                    'sort_order' => ['label' => 'Urutan', 'type' => 'number', 'rules' => 'permit_empty|is_natural'],
                ],
            ],
            'achievements' => [
                'title' => 'Milestones',
                'table' => 'achievements',
                'columns' => ['title', 'organization', 'awarded_at'],
                'fields' => [
                    'title' => ['label' => 'Nama pencapaian/sertifikat', 'type' => 'text', 'rules' => 'required|max_length[180]'],
                    'organization' => ['label' => 'Penyelenggara', 'type' => 'text', 'rules' => 'required|max_length[180]'],
                    'awarded_at' => ['label' => 'Tahun/Tanggal', 'type' => 'text', 'rules' => 'required|max_length[80]'],
                    'description' => ['label' => 'Deskripsi', 'type' => 'textarea', 'rules' => 'permit_empty'],
                    'certificate_url' => ['label' => 'URL/path sertifikat', 'type' => 'text', 'rules' => 'permit_empty|max_length[500]'],
                    'sort_order' => ['label' => 'Urutan', 'type' => 'number', 'rules' => 'permit_empty|is_natural'],
                ],
                'upload' => [
                    'field' => 'certificate_file',
                    'column' => 'certificate_url',
                    'kind' => 'certificate',
                    'label' => 'Unggah sertifikat (PDF/JPG/PNG/WebP, maks. 5 MB)',
                    'accept' => '.pdf,.jpg,.jpeg,.png,.webp',
                ],
            ],
            'projects' => [
                'title' => 'Proyek',
                'table' => 'projects',
                'columns' => ['title', 'stack', 'sort_order'],
                'fields' => [
                    'title' => ['label' => 'Nama proyek', 'type' => 'text', 'rules' => 'required|max_length[180]'],
                    'description' => ['label' => 'Deskripsi', 'type' => 'textarea', 'rules' => 'required'],
                    'stack' => ['label' => 'Teknologi', 'type' => 'text', 'rules' => 'required|max_length[255]'],
                    'project_url' => ['label' => 'URL proyek', 'type' => 'text', 'rules' => 'permit_empty|max_length[500]'],
                    'repository_url' => ['label' => 'URL repositori', 'type' => 'text', 'rules' => 'permit_empty|max_length[500]'],
                    'image_url' => ['label' => 'URL/path gambar', 'type' => 'text', 'rules' => 'permit_empty|max_length[500]'],
                    'sort_order' => ['label' => 'Urutan', 'type' => 'number', 'rules' => 'permit_empty|is_natural'],
                ],
                'upload' => [
                    'field' => 'project_image',
                    'column' => 'image_url',
                    'kind' => 'project',
                    'label' => 'Unggah gambar proyek (JPG/PNG/WebP, maks. 5 MB)',
                    'accept' => '.jpg,.jpeg,.png,.webp',
                ],
            ],
            'social_links' => [
                'title' => 'Tautan sosial',
                'table' => 'social_links',
                'columns' => ['label', 'handle', 'url'],
                'fields' => [
                    'label' => ['label' => 'Nama platform', 'type' => 'text', 'rules' => 'required|max_length[80]'],
                    'handle' => ['label' => 'Nama pengguna/keterangan', 'type' => 'text', 'rules' => 'required|max_length[120]'],
                    'url' => ['label' => 'URL', 'type' => 'text', 'rules' => 'required|max_length[500]'],
                    'sort_order' => ['label' => 'Urutan', 'type' => 'number', 'rules' => 'permit_empty|is_natural'],
                ],
            ],
        ];
    }

    /**
     * @return array<string, array{label: string, type: string, rules: string}>
     */
    public static function profileFields(): array
    {
        return [
            'full_name' => ['label' => 'Nama lengkap', 'type' => 'text', 'rules' => 'required|max_length[120]'],
            'role' => ['label' => 'Peran/Jabatan', 'type' => 'text', 'rules' => 'required|max_length[160]'],
            'tagline' => ['label' => 'Tagline', 'type' => 'text', 'rules' => 'required|max_length[255]'],
            'bio' => ['label' => 'Tentang saya', 'type' => 'textarea', 'rules' => 'required'],
            'location' => ['label' => 'Lokasi', 'type' => 'text', 'rules' => 'required|max_length[150]'],
            'email' => ['label' => 'Email', 'type' => 'email', 'rules' => 'required|valid_email|max_length[190]'],
            'phone' => ['label' => 'Nomor telepon', 'type' => 'text', 'rules' => 'permit_empty|max_length[40]'],
            'avatar_url' => ['label' => 'URL/path foto profil', 'type' => 'text', 'rules' => 'permit_empty|max_length[500]'],
            'availability' => ['label' => 'Status ketersediaan', 'type' => 'text', 'rules' => 'required|max_length[100]'],
        ];
    }
}
