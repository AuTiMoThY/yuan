<?php namespace App\Controllers\Backend;

use App\Controllers\BackendController;

class Dashboard extends BackendController
{

    public function index()
    {
        $d = [
            'form_type' => '',
        ];

        return $this->renderView('backend/dashboard', '主控台', $d);
    }
}
