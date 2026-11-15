<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminUserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    public function showLogin(): string|RedirectResponse
    {
        if (session()->get('admin_id') !== null) {
            return redirect()->to(site_url('admin'));
        }

        return view('admin/login');
    }

    public function login(): RedirectResponse
    {
        $throttleKey = 'admin-login-' . hash('sha256', $this->request->getIPAddress());

        if (! service('throttler')->check($throttleKey, 5, 60)) {
            return redirect()->back()->with('error', 'Terlalu banyak percobaan. Coba lagi beberapa saat.');
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (! is_string($email) || ! is_string($password)) {
            return redirect()->back()->with('error', 'Email atau kata sandi salah.');
        }

        $email = strtolower(trim($email));
        $user = (new AdminUserModel())->where('email', $email)->first();

        if ($user === null || ! password_verify($password, $user['password_hash'])) {
            return redirect()->back()->with('error', 'Email atau kata sandi salah.');
        }

        session()->regenerate(true);
        session()->set([
            'admin_id' => (int) $user['id'],
            'admin_email' => $user['email'],
        ]);

        return redirect()->to(site_url('admin'));
    }

    public function logout(): RedirectResponse
    {
        session()->remove(['admin_id', 'admin_email']);
        session()->regenerate(true);

        return redirect()->to(site_url('admin/login'));
    }
}
