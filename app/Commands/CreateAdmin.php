<?php

namespace App\Commands;

use App\Models\AdminUserModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateAdmin extends BaseCommand
{
    protected $group = 'Admin';
    protected $name = 'admin:create';
    protected $description = 'Create an administrator account for the portfolio panel.';
    protected $usage = 'admin:create';

    public function run(array $params)
    {
        $email = strtolower(trim(CLI::prompt('Email admin', null, 'required|valid_email')));

        if (strlen($email) > 190) {
            CLI::error('Email maksimal 190 karakter.');

            return EXIT_ERROR;
        }

        $model = new AdminUserModel();
        if ($model->where('email', $email)->first() !== null) {
            CLI::error('Akun admin dengan email tersebut sudah ada.');

            return EXIT_ERROR;
        }

        $password = CLI::prompt('Kata sandi (minimal 12 karakter)', null, 'required|min_length[12]');
        $confirmation = CLI::prompt('Ulangi kata sandi', null, 'required');

        if (! hash_equals($password, $confirmation)) {
            CLI::error('Konfirmasi kata sandi tidak cocok.');

            return EXIT_ERROR;
        }

        $created = $model->insert([
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        if ($created === false) {
            CLI::error('Akun admin gagal dibuat: ' . implode(' ', $model->errors()));

            return EXIT_ERROR;
        }

        CLI::write('Akun admin berhasil dibuat.');

        return EXIT_SUCCESS;
    }
}
