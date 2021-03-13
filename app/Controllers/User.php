<?php

namespace App\Controllers;

class User extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "SMAP - User",
            'head' => "User"
        ];

        return view('admin/user/index', $data);
    }

    public function fetch_data()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $data = [
                'user' => $this->UserModel->join('role', 'role.role = user.role_id')->get()->getResultArray()
            ];
            $msg = [
                'data' => view('admin/user/read', $data)
            ];

            echo json_encode($msg);
        } else {
            exit(view('error'));
        }
    }

    public function getJumlah()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $data = [
                'jumlah' => $this->UserModel->selectCount('id_user')->get()->getRowArray()
            ];
            $msg = [
                'data' => $data['jumlah']['id_user']
            ];

            echo json_encode($msg);
        } else {
            exit(view('error'));
        }
    }


    public function form_tambah()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {

            $builder = $this->db->table('role');
            $role = $builder->get()->getResultArray();
            $data['role'] = $role;

            $msg = [
                'data' => view('admin/user/create', $data)
            ];

            echo json_encode($msg);
        } else {
            exit(view('error'));
        }
    }

    public function simpan()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required|is_unique[user.username]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tersebut sudah ada'
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|is_unique[user.email]|valid_email',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tersebut sudah ada',
                        'valid_email' => '{field} salah'
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|min_length[3]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} terlalu pendek'
                    ]
                ],
                'password2' => [
                    'label' => 'Confirm Password',
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'matches' => '{field} tidak cocok'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'username'       => $validation->getError('username'),
                        'email'      => $validation->getError('email'),
                        'password'   => $validation->getError('password'),
                        'password2'     => $validation->getError('password2')
                    ]
                ];
            } else {
                $simpandata = [
                    'username'           => $request->getVar('username'),
                    'email'          => $request->getVar('email'),
                    'password'       => password_hash($request->getVar('telepon'), PASSWORD_DEFAULT),
                    'role_id'         => $request->getVar('role'),
                    'foto'          => "default.png"
                ];

                $this->UserModel->insert($simpandata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit(view('error'));
        }
    }

    public function form_upload()
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
                'sukses' => view('admin/user/upload', $data)
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
                    'label' => 'Foto User',
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
                $msg = [
                    'sukses' => 'Gambar berhasil diupload!'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function form_edit()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {

            $id = $request->getVar('id');
            $row = $this->UserModel->find($id);

            $builder = $this->db->table('role');
            $role = $builder->get()->getResultArray();

            $data = [
                'id' => $row['id_user'],
                'username' => $row['username'],
                'email' => $row['email'],
                'role_id' => $row['role_id'],
                'role' => $role
            ];

            $msg = [
                'sukses' => view('admin/user/update', $data)
            ];

            echo json_encode($msg);
        } else {
            exit(view('error'));
        }
    }

    public function edit()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
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
                        'username'   => $validation->getError('username'),
                        'email'      => $validation->getError('email'),
                        'password2'  => $validation->getError('password2')
                    ]
                ];
            } else {
                $simpandata = [
                    'username'  => $request->getVar('username'),
                    'email'     => $request->getVar('email'),
                    'role_id'      => $request->getVar('role'),
                ];

                if ($request->getVar('password') != NULL) {
                    $simpandata['password'] = password_hash($request->getVar('password'), PASSWORD_DEFAULT);
                }

                $id = $request->getVar('id');

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

    public function hapus()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {

            $id = $request->getVar('id');

            $cekdata = $this->UserModel->find($id);
            $fotolama = $cekdata['foto'];
            if ($fotolama != "default.png") {
                unlink('uploads/user' . '/' . $fotolama);
                unlink('uploads/user/thumb' . '/thumb_' . $fotolama);
            }

            $this->UserModel->delete($id);

            $msg = [
                'sukses' => 'Data berhasil dihapus'
            ];

            echo json_encode($msg);
        }
    }
}
