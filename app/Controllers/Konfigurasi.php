<?php

namespace App\Controllers;

class Konfigurasi extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "SMAP - Profile",
            'head' => "Profile"
        ];

        return view('admin/konfigurasi/index', $data);
    }

    public function fetch_data()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $data = [
                'profile' => $this->ProfileModel->findAll()
            ];
            $msg = [
                'data' => view('admin/konfigurasi/read', $data)
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
            $valid = $this->validate([
                'nama_web' => [
                    'label' => 'Nama website',
                    'rules' => 'required|alpha_numeric_space',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'alpha_numeric_space' => 'Tidak boleh mengandung karakter unik',
                    ]
                ],
                'deskripsi' => [
                    'label' => 'Deskripsi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'instagram' => [
                    'label' => 'Instagram',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'facebook' => [
                    'label' => 'Facebook',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'whatsapp' => [
                    'label' => 'Whatsapp',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'telepon' => [
                    'label' => 'Telepon',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_web'       => $validation->getError('nama_web'),
                        'profile_pt'    => $validation->getError('deskripsi'),
                        'instagram'     => $validation->getError('instagram'),
                        'facebook'      => $validation->getError('facebook'),
                        'whatsapp'      => $validation->getError('whatsapp'),
                        'no_telp'       => $validation->getError('telepon'),
                        'email'         => $validation->getError('email'),
                        'tempat'        => $validation->getError('alamat'),
                    ]
                ];
            } else {
                $simpandata = [
                    'nama_pt'       => $request->getVar('nama_web'),
                    'profile_pt'    => $request->getVar('deskripsi'),
                    'instagram'     => $request->getVar('instagram'),
                    'facebook'      => $request->getVar('facebook'),
                    'whatsapp'      => $request->getVar('whatsapp'),
                    'no_telp'       => $request->getVar('telepon'),
                    'email'         => $request->getVar('email'),
                    'tempat'        => $request->getVar('alamat'),
                ];
                $konfigurasi_id = $request->getVar('konfigurasi_id');
                $this->ProfileModel->update($konfigurasi_id, $simpandata);
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
            $row = $this->ProfileModel->find($id);

            $data = [
                'id' => $row['id'],
                'foto' => $row['logo_pt']
            ];

            $msg = [
                'sukses' => view('admin/konfigurasi/upload', $data)
            ];

            echo json_encode($msg);
        } else {
            exit(view('error'));
        }
    }

    public function douploadlogo()
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
                $cekdata = $this->ProfileModel->find($id);
                $fotolama = $cekdata['logo_pt'];

                if ($fotolama != 'default.svg') {
                    unlink('uploads/profile' . '/' . $fotolama);
                    unlink('uploads/profile/thumb' . '/thumb_' . $fotolama);
                }

                $filegambar = $request->getFile('foto');

                $updatedata = [
                    'logo_pt' => $filegambar->getName()
                ];

                $this->ProfileModel->update($id, $updatedata);

                \Config\Services::image()
                    ->withFile($filegambar)
                    ->fit(800, 533, 'center')
                    ->save('uploads/profile/thumb/' . 'thumb_' .  $filegambar->getName());
                $filegambar->move('uploads/profile');

                $msg = [
                    'sukses' => 'Gambar berhasil diupload!'
                ];
            }
            echo json_encode($msg);
        }
    }
}
