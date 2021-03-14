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

    public function fetch_data()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $data = [
                'pegawai' => $this->PegawaiModel->join('jabatan', 'jabatan.id_jabatan = pegawai.jabatan')->get()->getResultArray()
            ];
            $msg = [
                'data' => view('admin/pegawai/read', $data)
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
                'jumlah' => $this->PegawaiModel->selectCount('id_pegawai')->get()->getRowArray()
            ];
            $msg = [
                'data' => $data['jumlah']['id_pegawai']
            ];

            echo json_encode($msg);
        } else {
            exit(view('error'));
        }
    }

    public function getGaji()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $data = [
                'jumlah' => $this->PegawaiModel->selectSum('gaji_pokok')->get()->getRowArray()
            ];
            $msg = [
                'data' => number_format($data['jumlah']['gaji_pokok'], 2, ',', '.')
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

            $jabatan = $this->JabatanModel->findAll();
            $data['jabatan'] = $jabatan;

            $msg = [
                'data' => view('admin/pegawai/create', $data)
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
                'nip' => [
                    'label' => 'NIP',
                    'rules' => 'required|is_unique[pegawai.nip]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tersebut sudah ada'
                    ]
                ],
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'telepon' => [
                    'label' => 'Nomor Telepon',
                    'rules' => 'required|is_unique[pegawai.telepon]|integer',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tersebut sudah ada',
                        'integer' => '{field} salah'
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|is_unique[pegawai.email]|valid_email',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tersebut sudah ada',
                        'valid_email' => '{field} salah'
                    ]
                ],
                'gaji' => [
                    'label' => 'Gaji',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'mulai' => [
                    'label' => 'Tanggal Mulai Bekerja',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nip'       => $validation->getError('nip'),
                        'nama'      => $validation->getError('nama'),
                        'telepon'   => $validation->getError('telepon'),
                        'email'     => $validation->getError('email'),
                        'gaji'      => $validation->getError('gaji'),
                        'mulai'     => $validation->getError('mulai')
                    ]
                ];
            } else {
                $simpandata = [
                    'nip'           => $request->getVar('nip'),
                    'nama'          => $request->getVar('nama'),
                    'telepon'       => $request->getVar('telepon'),
                    'email'         => $request->getVar('email'),
                    'gaji_pokok'    => $request->getVar('gaji'),
                    'mulai_bekerja' => $request->getVar('mulai'),
                    'jabatan'       => $request->getVar('jabatan'),
                    'foto'          => "default.png"
                ];

                $this->PegawaiModel->insert($simpandata);
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
            $row = $this->PegawaiModel->find($id);

            $data = [
                'id' => $row['id_pegawai'],
                'foto' => $row['foto']
            ];

            $msg = [
                'sukses' => view('admin/pegawai/upload', $data)
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
                    'label' => 'Foto Pegawai',
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
                $cekdata = $this->PegawaiModel->find($id);
                $fotolama = $cekdata['foto'];

                if ($fotolama != 'default.png') {
                    unlink('uploads/pegawai' . '/' . $fotolama);
                    unlink('uploads/pegawai/thumb' . '/thumb_' . $fotolama);
                }

                $filegambar = $request->getFile('foto');

                $updatedata = [
                    'foto' => $filegambar->getName()
                ];

                $this->PegawaiModel->update($id, $updatedata);

                \Config\Services::image()
                    ->withFile($filegambar)
                    ->fit(800, 533, 'center')
                    ->save('uploads/pegawai/thumb/' . 'thumb_' .  $filegambar->getName());
                $filegambar->move('uploads/pegawai');
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
            $row = $this->PegawaiModel->find($id);

            $jabatan = $this->JabatanModel->findAll();

            $data = [
                'id' => $row['id_pegawai'],
                'nip' => $row['nip'],
                'nama' => $row['nama'],
                'telepon' => $row['telepon'],
                'email' => $row['email'],
                'jabatan' => $row['jabatan'],
                'gaji' => $row['gaji_pokok'],
                'mulai' => $row['mulai_bekerja'],
                'nama_jabatan' => $jabatan
            ];

            $msg = [
                'sukses' => view('admin/pegawai/update', $data)
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
            $simpandata = [
                'nip'           => $request->getVar('nip'),
                'nama'          => $request->getVar('nama'),
                'telepon'       => $request->getVar('telepon'),
                'email'         => $request->getVar('email'),
                'gaji_pokok'    => $request->getVar('gaji'),
                'mulai_bekerja' => $request->getVar('mulai'),
                'jabatan'       => $request->getVar('jabatan'),
            ];

            $id = $request->getVar('id');

            $this->PegawaiModel->update($id, $simpandata);
            $msg = [
                'sukses' => 'Data berhasil diupdate'
            ];

            echo json_encode($msg);
        } else {
            exit(view('error'));
        }
    }

    public function show_detail()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {

            $id = $request->getVar('id');
            $row = $this->PegawaiModel->join('jabatan', 'jabatan.id_jabatan = pegawai.jabatan')->where('id_pegawai', $id)->get()->getRowArray();

            $data = [
                'id'        => $row['id_pegawai'],
                'nip'       => $row['nip'],
                'nama'      => $row['nama'],
                'telepon'   => $row['telepon'],
                'email'     => $row['email'],
                'jabatan'   => $row['nama_jabatan'],
                'gaji'      => $row['gaji_pokok'],
                'mulai'     => $row['mulai_bekerja'],
                'foto'      => $row['foto']
            ];

            $msg = [
                'sukses' => view('admin/pegawai/detail', $data)
            ];

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

            $cekdata = $this->PegawaiModel->find($id);
            $fotolama = $cekdata['foto'];
            if ($fotolama != "default.png") {
                unlink('uploads/pegawai' . '/' . $fotolama);
                unlink('uploads/pegawai/thumb' . '/thumb_' . $fotolama);
            }

            $this->PegawaiModel->delete($id);

            $msg = [
                'sukses' => 'Data berhasil dihapus'
            ];

            echo json_encode($msg);
        }
    }
}
