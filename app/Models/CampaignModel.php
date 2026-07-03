<?php

namespace App\Models;

use CodeIgniter\Model;

class CampaignModel extends Model
{
    protected $table = 'campaigns';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [

        'category_id',

        'foundation_id',

        'judul',

        'slug',

        'deskripsi',

        'target_dana',

        'dana_terkumpul',

        'gambar',

        'lokasi',

        'tanggal_mulai',

        'tanggal_berakhir',

        'status',

        'jumlah_donatur',

        'views',

        'status_verifikasi',

        'verified_by',

        'verified_at'

    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
    public function getActive()
{
    return $this->where('status', 'aktif')
                ->where('status_verifikasi', 'approved')
                ->findAll();
}
public function getApproved()
{
    return $this->where('status_verifikasi', 'approved')
                ->findAll();
}
public function getPending()
{
    return $this->where('status_verifikasi', 'pending')
                ->findAll();
}
public function getByFoundation($foundationId)
{
    return $this->where('foundation_id', $foundationId)
                ->findAll();
}
public function search($keyword)
{
    return $this->like('judul', $keyword)
                ->findAll();
}
public function getCampaigns()
{
    return $this->select('
            campaigns.*,
            foundations.nama_yayasan,
            categories.nama_kategori
        ')
        ->join('foundations', 'foundations.id = campaigns.foundation_id')
        ->join('categories', 'categories.id = campaigns.category_id')
        ->findAll();
}
public function searchCampaign($keyword)
{
    return $this->select('
            campaigns.*,
            foundations.nama_yayasan,
            categories.nama_kategori
        ')
        ->join('foundations', 'foundations.id = campaigns.foundation_id')
        ->join('categories', 'categories.id = campaigns.category_id')
        ->groupStart()
            ->like('campaigns.judul', $keyword)
            ->orLike('foundations.nama_yayasan', $keyword)
            ->orLike('categories.nama_kategori', $keyword)
        ->groupEnd()
        ->findAll();
}
public function filterCampaign($keyword = null, $status = null)
{
    $builder = $this->select('
            campaigns.*,
            foundations.nama_yayasan,
            categories.nama_kategori
        ')
        ->join('foundations', 'foundations.id = campaigns.foundation_id')
        ->join('categories', 'categories.id = campaigns.category_id');

    if (!empty($keyword)) {
        $builder->groupStart()
                ->like('campaigns.judul', $keyword)
                ->orLike('foundations.nama_yayasan', $keyword)
                ->orLike('categories.nama_kategori', $keyword)
                ->groupEnd();
    }

    if (!empty($status)) {
        $builder->where('campaigns.status', $status);
    }

    return $builder->findAll();
}
}