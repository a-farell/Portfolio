<?php

namespace App\Models;

use CodeIgniter\Model;

class PortfolioModel extends Model
{
    protected $table = 'profiles';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'full_name',
        'role',
        'tagline',
        'bio',
        'location',
        'email',
        'phone',
        'avatar_url',
        'availability',
    ];

    /**
     * @return array{
     *     profile: array<string, mixed>|null,
     *     education: list<array<string, mixed>>,
     *     experiences: list<array<string, mixed>>,
     *     skills: list<array<string, mixed>>,
     *     achievements: list<array<string, mixed>>,
     *     projects: list<array<string, mixed>>,
     *     socialLinks: list<array<string, mixed>>
     * }
     */
    public function getPortfolio(): array
    {
        $profile = $this->first();

        if ($profile === null) {
            return [
                'profile' => null,
                'education' => [],
                'experiences' => [],
                'skills' => [],
                'achievements' => [],
                'projects' => [],
                'socialLinks' => [],
            ];
        }

        $profileId = (int) $profile['id'];

        return [
            'profile' => $profile,
            'education' => $this->rows('education', $profileId),
            'experiences' => $this->rows('experiences', $profileId),
            'skills' => $this->rows('skills', $profileId),
            'achievements' => $this->rows('achievements', $profileId),
            'projects' => $this->rows('projects', $profileId),
            'socialLinks' => $this->rows('social_links', $profileId),
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function rows(string $table, int $profileId): array
    {
        return $this->db->table($table)
            ->where('profile_id', $profileId)
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->getResultArray();
    }
}
