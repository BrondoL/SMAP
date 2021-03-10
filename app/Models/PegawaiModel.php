<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nip', 'foto', 'nama', 'telepon', 'email', 'jabatan', 'gaji_pokok', 'mulai_bekerja'];
}
