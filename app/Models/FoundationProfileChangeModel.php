<?php

namespace App\Models;

use CodeIgniter\Model;

class FoundationProfileChangeModel extends Model
{
    protected $table            = 'foundation_profile_changes';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'foundation_id',
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
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'foundation_id' => 'required',
        'user_id' => 'required',
        'nama_yayasan' => 'required|min_length[3]',
        'email_yayasan' => 'required|valid_email',
        'telepon' => 'required',
        'alamat' => 'required',
        'nomor_izin' => 'required',
        'status' => 'required|in_list[pending,approved,rejected]',
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getPendingByFoundation($foundationId)
    {
        return $this->where('foundation_id', $foundationId)
            ->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->first();
    }
}
