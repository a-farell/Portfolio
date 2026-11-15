<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProjectImagesAndCertificateLinks extends Migration
{
    public function up()
    {
        $this->forge->addColumn('projects', [
            'image_url' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
        ]);
        $this->forge->addColumn('achievements', [
            'certificate_url' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('projects', 'image_url');
        $this->forge->dropColumn('achievements', 'certificate_url');
    }
}
