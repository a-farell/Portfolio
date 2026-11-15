<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run()
    {
        $profile = $this->db->table('profiles')->get()->getRowArray();

        if ($profile !== null) {
            return;
        }

        $this->db->table('profiles')->insert([
            'full_name' => 'Nama Anda',
            'role' => 'Mahasiswa & Web Developer',
            'tagline' => 'Membangun pengalaman digital yang bermanfaat.',
            'bio' => 'Saya adalah mahasiswa yang tertarik pada pengembangan web. Saya senang mengubah ide menjadi produk digital yang mudah digunakan, rapi, dan bermanfaat.',
            'location' => 'Indonesia',
            'email' => 'nama@email.com',
            'phone' => '+62 812 0000 0000',
            'avatar_url' => null,
            'availability' => 'Terbuka untuk kolaborasi',
        ]);
        $profileId = (int) $this->db->insertID();

        $this->insertRows('education', $profileId, [
            [
                'institution' => 'Universitas Anda',
                'degree' => 'S1 Informatika',
                'study_period' => '2023 - sekarang',
                'description' => 'Mempelajari dasar pemrograman, basis data, rekayasa perangkat lunak, dan pengembangan aplikasi web.',
            ],
        ]);

        $this->insertRows('experiences', $profileId, [
            [
                'organization' => 'Organisasi Kampus',
                'role' => 'Anggota Divisi Teknologi',
                'period' => '2024 - sekarang',
                'description' => 'Berkolaborasi dalam kegiatan dan proyek digital organisasi serta membantu kebutuhan teknis tim.',
            ],
        ]);

        $this->insertRows('skills', $profileId, [
            ['name' => 'PHP', 'category' => 'Backend', 'proficiency' => 75],
            ['name' => 'CodeIgniter', 'category' => 'Backend', 'proficiency' => 70],
            ['name' => 'MySQL', 'category' => 'Database', 'proficiency' => 70],
            ['name' => 'HTML & CSS', 'category' => 'Frontend', 'proficiency' => 80],
            ['name' => 'JavaScript', 'category' => 'Frontend', 'proficiency' => 65],
            ['name' => 'Git', 'category' => 'Tools', 'proficiency' => 65],
        ]);

        $this->insertRows('achievements', $profileId, [
            [
                'title' => 'Sertifikat Dasar Pemrograman Web',
                'organization' => 'Program Pelatihan',
                'awarded_at' => '2025',
                'description' => 'Menyelesaikan pelatihan dasar pengembangan aplikasi web.',
            ],
        ]);

        $this->insertRows('projects', $profileId, [
            [
                'title' => 'Website Portofolio',
                'description' => 'Website CV pribadi dengan informasi profil yang dikelola secara dinamis dari database.',
                'stack' => 'CodeIgniter 4, PHP 8.4, MySQL',
                'project_url' => null,
                'repository_url' => null,
            ],
            [
                'title' => 'Aplikasi Catatan',
                'description' => 'Aplikasi sederhana untuk mencatat dan mengelola daftar aktivitas harian.',
                'stack' => 'PHP, MySQL, Bootstrap',
                'project_url' => null,
                'repository_url' => null,
            ],
            [
                'title' => 'Web Portfolio',
                'description' => 'Website portofolio pribadi untuk menampilkan profil, keahlian, pengalaman, dan proyek.',
                'stack' => 'CodeIgniter 4, PHP, MySQL, HTML, CSS, JavaScript',
                'project_url' => null,
                'repository_url' => null,
                'image_url' => 'assets/images/portfolio.jpg',
            ],
        ]);

        $this->insertRows('social_links', $profileId, [
            ['label' => 'GitHub', 'handle' => '@username', 'url' => 'https://github.com/'],
            ['label' => 'LinkedIn', 'handle' => 'Profil profesional', 'url' => 'https://www.linkedin.com/'],
        ]);
    }

    /**
     * @param list<array<string, int|string|null>> $rows
     */
    private function insertRows(string $table, int $profileId, array $rows): void
    {
        foreach ($rows as $order => &$row) {
            $row['profile_id'] = $profileId;
            $row['sort_order'] = $order;
        }
        unset($row);

        $this->db->table($table)->insertBatch($rows);
    }

}
