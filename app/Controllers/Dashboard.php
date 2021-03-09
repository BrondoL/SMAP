<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "SMAP - Dashboard",
            'head' => "Dashboard"
        ];

        return view('admin/dashboard/index', $data);
    }
}
