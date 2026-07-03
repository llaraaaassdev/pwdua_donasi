<?php

namespace App\Models;

use CodeIgniter\Model;

class FoundationModel extends Model
{
    protected $table            = 'foundations';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';

    protected $useAutoIncrement = true;

    protected $protectFields    = true;

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

        'verified_at',

        'created_at',

        'updated_at'

    ];

    protected bool $allowEmptyInserts = false;

    protected bool $updateOnlyChanged = true;
 
    protected array $casts = [];

    protected array $castHandlers = [];

    // Timestamp otomatis
    protected $useTimestamps = true;

    protected $dateFormat = 'datetime';

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';

    protected $deletedField = '';

    // Validation (opsional)
    protected $validationRules = [

        'nama_yayasan' => 'required|min_length[3]',

        'email_yayasan' => 'required|valid_email',

        'telepon' => 'required',

        'alamat' => 'required',

        'nomor_izin' => 'required'

    ];

    protected $validationMessages = [

        'nama_yayasan' => [

            'required' => 'Nama yayasan wajib diisi.'

        ],

        'email_yayasan' => [

            'required' => 'Email wajib diisi.',

            'valid_email' => 'Format email tidak valid.'

        ],

        'telepon' => [

            'required' => 'Nomor telepon wajib diisi.'

        ],

        'alamat' => [

            'required' => 'Alamat wajib diisi.'

        ],

        'nomor_izin' => [

            'required' => 'Nomor izin wajib diisi.'

        ]

    ];

    protected $skipValidation = false;

    protected $cleanValidationRules = true;

    public function search($keyword)
    {
        return $this->select('foundations.*, users.nama')
                    ->join('users', 'users.id = foundations.user_id')
                    ->like('nama_yayasan', $keyword)
                    ->findAll();
    }
    public function filterStatus($status)
{
    return $this->select('foundations.*, users.nama')
                ->join('users', 'users.id = foundations.user_id')
                ->where('foundations.status', $status)
                ->findAll();
}
}