<?php

namespace App\Controllers;

class Profile extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "SMAP - Profile User",
            'head' => "Profile User"
        ];

        return view('admin/profile/index', $data);
    }

    public function fetch_data()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $id = session()->get('user_id');
            $data = [
                'profile' => $this->UserModel->join('role', 'role.role = user.role_id')->where('id_user', $id)->get()->getRowArray()
            ];
            $msg = [
                'data' => view('admin/profile/read', $data)
            ];

            echo json_encode($msg);
        } else {
            exit(view('error'));
        }
    }

    public function submit()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rulesUsername = 'required';
            if ($request->getVar('username') != session()->get('username')) {
                $rulesUsername = 'required|is_unique[user.username]';
            }
            $rulesEmail = 'required|valid_email';
            if ($request->getVar('email') != session()->get('email')) {
                $rulesEmail = 'required|is_unique[user.email]';
            }
            $valid = $this->validate([
                'username' => [
                    'label' => 'Username',
                    'rules' => $rulesUsername,
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tersebut sudah ada'
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => $rulesEmail,
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tersebut sudah ada',
                        'valid_email' => '{field} salah'
                    ]
                ],
                'password2' => [
                    'label' => 'Confirm Password',
                    'rules' => 'matches[password]',
                    'errors' => [
                        'matches' => '{field} tidak cocok'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'username'  => $validation->getError('username'),
                        'email'     => $validation->getError('email'),
                        'password' => $validation->getError('password2'),
                    ]
                ];
            } else {
                $simpandata = [
                    'username'      => $request->getVar('username'),
                    'email'         => $request->getVar('email')
                ];
                if ($request->getVar('password') != NULL) {
                    $simpandata['password'] = password_hash($request->getVar('password'), PASSWORD_DEFAULT);
                }

                $id = session()->get('user_id');
                $this->UserModel->update($id, $simpandata);
                $msg = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        } else {
            exit(view('error'));
        }
    }

    public function formuploadlogo()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {

            $id = $request->getVar('id');
            $row = $this->UserModel->find($id);

            $data = [
                'id' => $row['id_user'],
                'foto' => $row['foto']
            ];

            $msg = [
                'sukses' => view('admin/profile/upload', $data)
            ];

            echo json_encode($msg);
        } else {
            exit(view('error'));
        }
    }

    public function doupload()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'foto' => [
                    'label' => 'Logo',
                    'rules' => 'uploaded[foto]|max_size[foto, 1024]|mime_in[foto,image/png,image/jpg,image/jpeg]|is_image[foto]',
                    'errors' => [
                        'uploaded'  => '{field} belum diupload',
                        'max_size'  => 'Ukuran {field} Melebihi 1 MB',
                        'mime_in'   => 'File yang diupload harus gambar!',
                        'is_image'  => 'File yang diupload harus gambar!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'foto' => $validation->getError('foto')
                    ]
                ];
            } else {

                $id = $request->getVar('id');
                $cekdata = $this->UserModel->find($id);
                $fotolama = $cekdata['foto'];

                if ($fotolama != 'default.png') {
                    unlink('uploads/user' . '/' . $fotolama);
                    unlink('uploads/user/thumb' . '/thumb_' . $fotolama);
                }

                $filegambar = $request->getFile('foto');

                $updatedata = [
                    'foto' => $filegambar->getName()
                ];

                $this->UserModel->update($id, $updatedata);

                \Config\Services::image()
                    ->withFile($filegambar)
                    ->fit(800, 533, 'center')
                    ->save('uploads/user/thumb/' . 'thumb_' .  $filegambar->getName());
                $filegambar->move('uploads/user');

                session()->set(['foto' => $filegambar->getName()]);

                $msg = [
                    'sukses' => 'Gambar berhasil diupload!'
                ];
            }
            echo json_encode($msg);
        }
    }
}
