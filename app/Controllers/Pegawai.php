<?php

namespace App\Controllers;

class Pegawai extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "SMAP - Pegawai",
            'head' => "Pegawai"
        ];

        return view('admin/pegawai/index', $data);
    }
}
