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

    public function fetch_data()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $data = [
                'jabatan' => $this->JabatanModel->orderBy('level', 'ASC')->get()->getResultArray()
            ];
            $msg = [
                'data' => view('admin/jabatan/read', $data)
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
                'jumlah' => $this->JabatanModel->selectCount('id_jabatan')->get()->getRowArray()
            ];
            $msg = [
                'data' => $data['jumlah']['id_jabatan']
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

            $jumlah = $this->JabatanModel->selectCount('id_jabatan')->get()->getRowArray();
            $jumlah = $jumlah['id_jabatan'] + 1;
            $data['jumlah'] = $jumlah;

            $msg = [
                'data' => view('admin/jabatan/create', $data)
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
                'nama' => [
                    'label' => 'Jabatan',
                    'rules' => 'required|is_unique[jabatan.nama_jabatan]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tersebut sudah ada'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'  => $validation->getError('nama')
                    ]
                ];
            } else {
                $simpandata = [
                    'nama_jabatan'  => $request->getVar('nama'),
                    'level'         => $request->getVar('level')
                ];

                $this->JabatanModel->insert($simpandata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit(view('error'));
        }
    }

    public function form_edit()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {

            $jumlah = $this->JabatanModel->selectCount('id_jabatan')->get()->getRowArray();
            $jumlah = $jumlah['id_jabatan'];

            $id_jabatan = $request->getVar('id');
            $row = $this->JabatanModel->find($id_jabatan);

            $data = [
                'id' => $row['id_jabatan'],
                'nama_jabatan' => $row['nama_jabatan'],
                'level' => $row['level'],
                'jumlah' => $jumlah
            ];

            $msg = [
                'sukses' => view('admin/jabatan/update', $data)
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
                'nama_jabatan'  => $request->getVar('nama'),
                'level'         => $request->getVar('level')
            ];

            $id_jabatan = $request->getVar('id');

            $this->JabatanModel->update($id_jabatan, $simpandata);
            $msg = [
                'sukses' => 'Data berhasil diupdate'
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

            $id_jabatan = $request->getVar('id');

            $this->JabatanModel->delete($id_jabatan);
            $msg = [
                'sukses' => 'Data berhasil dihapus'
            ];

            echo json_encode($msg);
        }
    }
}
