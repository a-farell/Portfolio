<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\PortfolioAdminResources;
use App\Libraries\PortfolioUploader;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use InvalidArgumentException;
use RuntimeException;

class Records extends BaseController
{
    public function index(string $name): string|RedirectResponse
    {
        $resource = $this->resource($name);
        $profileId = $this->profileId();

        if ($profileId === null) {
            return redirect()->to(site_url('admin/profile'))->with('error', 'Isi data profil terlebih dahulu.');
        }

        $rows = db_connect()->table($resource['table'])
            ->where('profile_id', $profileId)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/records', [
            'name' => $name,
            'resource' => $resource,
            'rows' => $rows,
        ]);
    }

    public function newForm(string $name): string
    {
        return view('admin/record-form', [
            'name' => $name,
            'resource' => $this->resource($name),
            'record' => [],
            'mode' => 'create',
        ]);
    }

    public function create(string $name): RedirectResponse
    {
        return $this->save($name);
    }

    public function edit(string $name, int $id): string
    {
        $resource = $this->resource($name);
        $record = $this->findRecord($resource['table'], $id);

        return view('admin/record-form', [
            'name' => $name,
            'resource' => $resource,
            'record' => $record,
            'mode' => 'edit',
        ]);
    }

    public function update(string $name, int $id): RedirectResponse
    {
        return $this->save($name, $id);
    }

    public function delete(string $name, int $id): RedirectResponse
    {
        $resource = $this->resource($name);
        $profileId = $this->profileId();

        if ($profileId === null) {
            return redirect()->to(site_url('admin/profile'))->with('error', 'Profil tidak ditemukan.');
        }

        $deleted = db_connect()->table($resource['table'])
            ->where('profile_id', $profileId)
            ->where('id', $id)
            ->delete();

        if (! $deleted) {
            throw PageNotFoundException::forPageNotFound();
        }

        return redirect()->to(site_url('admin/records/' . $name))->with('success', 'Data berhasil dihapus.');
    }

    private function save(string $name, ?int $id = null): RedirectResponse
    {
        $resource = $this->resource($name);
        $profileId = $this->profileId();

        if ($profileId === null) {
            return redirect()->to(site_url('admin/profile'))->with('error', 'Isi data profil terlebih dahulu.');
        }

        $post = $this->request->getPost();
        $rules = [];
        $data = [];

        foreach ($resource['fields'] as $fieldName => $field) {
            $rules[$fieldName] = ['label' => $field['label'], 'rules' => $field['rules']];
            $value = $post[$fieldName] ?? '';

            if (! is_string($value)) {
                $value = '';
            }

            $value = trim($value);
            $data[$fieldName] = $value === '' ? null : $value;
        }

        $validation = service('validation');
        $validation->setRules($rules);

        if (! $validation->run($post)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        if (isset($resource['upload'])) {
            $upload = $resource['upload'];
            $file = $this->request->getFile($upload['field']);

            if ($file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                try {
                    $data[$upload['column']] = (new PortfolioUploader())->store($file, $upload['kind']);
                } catch (InvalidArgumentException $exception) {
                    return redirect()->back()->withInput()->with('errors', [$upload['field'] => $exception->getMessage()]);
                }
            }
        }

        $db = db_connect();
        $builder = $db->table($resource['table'])->where('profile_id', $profileId);

        if ($id === null) {
            if (! isset($data['sort_order'])) {
                $highest = $db->table($resource['table'])
                    ->selectMax('sort_order', 'highest_order')
                    ->where('profile_id', $profileId)
                    ->get()
                    ->getRowArray();
                $data['sort_order'] = ((int) ($highest['highest_order'] ?? -1)) + 1;
            }

            $data['profile_id'] = $profileId;
            $saved = $db->table($resource['table'])->insert($data);
        } else {
            $record = $this->findRecord($resource['table'], $id);
            if (! isset($data['sort_order'])) {
                $data['sort_order'] = $record['sort_order'];
            }
            $builder->where('id', $id);
            $saved = $builder->update($data);
        }

        if (! $saved) {
            throw new RuntimeException('Data gagal disimpan.');
        }

        return redirect()->to(site_url('admin/records/' . $name))->with('success', 'Data berhasil disimpan.');
    }

    /**
     * @return array<string, mixed>
     */
    private function resource(string $name): array
    {
        $resources = PortfolioAdminResources::all();
        if (! isset($resources[$name])) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $resources[$name];
    }

    private function profileId(): ?int
    {
        $profile = db_connect()->table('profiles')->select('id')->orderBy('id', 'ASC')->get()->getRowArray();

        return $profile === null ? null : (int) $profile['id'];
    }

    /**
     * @return array<string, mixed>
     */
    private function findRecord(string $table, int $id): array
    {
        $profileId = $this->profileId();
        $record = $profileId === null
            ? null
            : db_connect()->table($table)
                ->where('profile_id', $profileId)
                ->where('id', $id)
                ->get()
                ->getRowArray();

        if ($record === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $record;
    }
}
