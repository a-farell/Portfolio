<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\PortfolioAdminResources;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $db = db_connect();
        $resources = PortfolioAdminResources::all();
        $counts = [
            'profiles' => $db->table('profiles')->countAllResults(),
        ];

        foreach ($resources as $key => $resource) {
            $counts[$key] = $db->table($resource['table'])->countAllResults();
        }

        return view('admin/dashboard', [
            'resources' => $resources,
            'counts' => $counts,
            'profileCount' => $counts['profiles'],
        ]);
    }
}
