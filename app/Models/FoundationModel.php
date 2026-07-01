<?php

namespace App\Models;

use CodeIgniter\Model;

class FoundationModel extends Model
{
    protected $table = 'foundations';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [

        'user_id',

        'nama_yayasan',

        'email_yayasan',

        'telepon',

        'alamat',

        'deskripsi',

        'logo',

        'dokumen_verifikasi',

        'nomor_izin',

        'status',

        'verified_by',

        'verified_at'

    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}