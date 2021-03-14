<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table = 'profile';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_pt', 'profile_pt', 'logo_pt', 'no_telp', 'email', 'tempat', 'instagram', 'facebook', 'whatsapp'];
}
