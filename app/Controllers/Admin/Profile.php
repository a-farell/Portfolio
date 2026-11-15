<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\PortfolioAdminResources;
use App\Libraries\PortfolioUploader;
use CodeIgniter\HTTP\RedirectResponse;
use InvalidArgumentException;
use RuntimeException;

class Profile extends BaseController
{
    public function edit(): string
    {
        $profile = db_connect()->table('profiles')->orderBy('id', 'ASC')->get()->getRowArray();

        return view('admin/profile-form', [
            'fields' => PortfolioAdminResources::profileFields(),
            'profile' => $profile ?? [],
        ]);
    }

    public function save(): RedirectResponse
    {
        $post = $this->request->getPost();
        $fields = PortfolioAdminResources::profileFields();
        $data = $this->validatedData($post, $fields);

        if ($data === null) {
            return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
        }

        $file = $this->request->getFile('avatar_file');
        if ($file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            try {
                $data['avatar_url'] = (new PortfolioUploader())->store($file, 'avatar');
            } catch (InvalidArgumentException $exception) {
                return redirect()->back()->withInput()->with('errors', ['avatar_file' => $exception->getMessage()]);
            }
        }

        $db = db_connect();
        $profile = $db->table('profiles')->orderBy('id', 'ASC')->get()->getRowArray();

        if ($profile === null) {
            $saved = $db->table('profiles')->insert($data);
        } else {
            $saved = $db->table('profiles')->where('id', $profile['id'])->update($data);
        }

        if (! $saved) {
            throw new RuntimeException('Data profil gagal disimpan.');
        }

        return redirect()->to(site_url('admin/profile'))->with('success', 'Profil berhasil disimpan.');
    }

    /**
     * @param array<string, mixed> $post
     * @param array<string, array{label: string, type: string, rules: string}> $fields
     *
     * @return array<string, string|null>|null
     */
    private function validatedData(array $post, array $fields): ?array
    {
        $rules = [];
        $data = [];

        foreach ($fields as $name => $field) {
            $rules[$name] = ['label' => $field['label'], 'rules' => $field['rules']];
            $value = $post[$name] ?? '';

            if (! is_string($value)) {
                $value = '';
            }

            $value = trim($value);
            $data[$name] = $value === '' ? null : $value;
        }

        $validation = service('validation');
        $validation->setRules($rules);

        return $validation->run($post) ? $data : null;
    }
}
