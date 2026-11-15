<?php

namespace App\Controllers;

use App\Models\PortfolioModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('portfolio', (new PortfolioModel())->getPortfolio());
    }
}
