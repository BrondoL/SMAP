<?php

namespace App\Controllers;

class Jabatan extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "SMAP - Pegawai",
            'head' => "Pegawai"
        ];

        return view('admin/jabatan/index', $data);
    }
}
