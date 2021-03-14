<?php

namespace App\Controllers;

class Auth extends BaseController
{

    public function index()
    {
        if (session('login')) {
            return redirect()->to('/Dashboard');
        }
        $data = [
            'title' => 'SMAP - Login'
        ];
        return view('admin/login', $data);
    }

    public function validasi()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $username = $request->getVar('username');
            $password = $request->getVar('password');

            if ($username == NULL or $password == NULL) {
                $msg = [
                    'error' => 'Harap mengisi Username dan Password !'
                ];
            } else {
                $row = $this->UserModel->where('username', $username)->get();

                if ($row->getNumRows() > 0) {
                    $row = $row->getRowArray();
                    $password_user = $row['password'];

                    if (password_verify($password, $password_user)) {
                        $simpan_session = [
                            'login' => true,
                            'user_id' => $row['id_user'],
                            'username' => $row['username'],
                            'email'  => $row['email'],
                            'foto'  => $row['foto'],
                            'role' => $row['role_id'],
                        ];

                        $this->session->set($simpan_session);

                        $msg = [
                            'sukses' => [
                                'link' => base_url('Dashboard')
                            ]
                        ];
                    } else {
                        $msg = [
                            'error' => 'Password salah!'
                        ];
                    }
                } else {
                    $msg = [
                        'error' => 'User tidak ditemukan!'
                    ];
                }
            }
            echo json_encode($msg);
        } else {
            exit(view('error'));
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('Auth'));
    }
}
