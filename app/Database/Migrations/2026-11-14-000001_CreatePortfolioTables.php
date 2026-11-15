<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePortfolioTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'full_name' => ['type' => 'VARCHAR', 'constraint' => 120],
            'role' => ['type' => 'VARCHAR', 'constraint' => 160],
            'tagline' => ['type' => 'VARCHAR', 'constraint' => 255],
            'bio' => ['type' => 'TEXT'],
            'location' => ['type' => 'VARCHAR', 'constraint' => 150],
            'email' => ['type' => 'VARCHAR', 'constraint' => 190],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 40, 'null' => true],
            'avatar_url' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'availability' => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('profiles');

        $this->createChildTable('education', [
            'institution' => ['type' => 'VARCHAR', 'constraint' => 180],
            'degree' => ['type' => 'VARCHAR', 'constraint' => 180],
            'study_period' => ['type' => 'VARCHAR', 'constraint' => 80],
            'description' => ['type' => 'TEXT', 'null' => true],
        ]);

        $this->createChildTable('experiences', [
            'organization' => ['type' => 'VARCHAR', 'constraint' => 180],
            'role' => ['type' => 'VARCHAR', 'constraint' => 180],
            'period' => ['type' => 'VARCHAR', 'constraint' => 80],
            'description' => ['type' => 'TEXT'],
        ]);

        $this->createChildTable('skills', [
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'category' => ['type' => 'VARCHAR', 'constraint' => 100],
            'proficiency' => ['type' => 'TINYINT', 'unsigned' => true],
        ]);

        $this->createChildTable('achievements', [
            'title' => ['type' => 'VARCHAR', 'constraint' => 180],
            'organization' => ['type' => 'VARCHAR', 'constraint' => 180],
            'awarded_at' => ['type' => 'VARCHAR', 'constraint' => 80],
            'description' => ['type' => 'TEXT', 'null' => true],
        ]);

        $this->createChildTable('projects', [
            'title' => ['type' => 'VARCHAR', 'constraint' => 180],
            'description' => ['type' => 'TEXT'],
            'stack' => ['type' => 'VARCHAR', 'constraint' => 255],
            'project_url' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'repository_url' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
        ]);

        $this->createChildTable('social_links', [
            'label' => ['type' => 'VARCHAR', 'constraint' => 80],
            'handle' => ['type' => 'VARCHAR', 'constraint' => 120],
            'url' => ['type' => 'VARCHAR', 'constraint' => 500],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('social_links', true);
        $this->forge->dropTable('projects', true);
        $this->forge->dropTable('achievements', true);
        $this->forge->dropTable('skills', true);
        $this->forge->dropTable('experiences', true);
        $this->forge->dropTable('education', true);
        $this->forge->dropTable('profiles', true);
    }

    /**
     * @param array<string, array<string, mixed>> $fields
     */
    private function createChildTable(string $table, array $fields): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'profile_id' => ['type' => 'INT', 'unsigned' => true],
            ...$fields,
            'sort_order' => ['type' => 'INT', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('profile_id');
        $this->forge->addForeignKey('profile_id', 'profiles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable($table);
    }
}
