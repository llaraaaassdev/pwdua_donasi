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
        'verified_at',
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
        return $this->where('status_verifikasi', 'approved')->findAll();
    }

    public function getPending()
    {
        return $this->where('status_verifikasi', 'pending')->findAll();
    }

    public function getByFoundation($foundationId)
    {
        return $this->where('foundation_id', $foundationId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function search($keyword)
    {
        return $this->like('judul', $keyword)->findAll();
    }

    public function baseCampaignSelect()
    {
        return $this->select('
                campaigns.*,
                foundations.nama_yayasan,
                foundations.email_yayasan,
                foundations.user_id AS foundation_user_id,
                categories.nama_kategori,
                categories.nama_kategori AS kategori,
                campaigns.target_dana AS target
            ')
            ->join('foundations', 'foundations.id = campaigns.foundation_id', 'left')
            ->join('categories', 'categories.id = campaigns.category_id', 'left');
    }

    public function getCampaigns()
    {
        return $this->baseCampaignSelect()
            ->orderBy('campaigns.created_at', 'DESC')
            ->findAll();
    }

    public function searchCampaign($keyword)
    {
        return $this->baseCampaignSelect()
            ->groupStart()
                ->like('campaigns.judul', $keyword)
                ->orLike('foundations.nama_yayasan', $keyword)
                ->orLike('categories.nama_kategori', $keyword)
            ->groupEnd()
            ->orderBy('campaigns.created_at', 'DESC')
            ->findAll();
    }

    public function filterCampaign($keyword = null, $status = null)
    {
        $builder = $this->baseCampaignSelect();

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('campaigns.judul', $keyword)
                ->orLike('foundations.nama_yayasan', $keyword)
                ->orLike('categories.nama_kategori', $keyword)
                ->orLike('campaigns.lokasi', $keyword)
                ->groupEnd();
        }

        if (!empty($status)) {
            if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
                $builder->where('campaigns.status_verifikasi', $status);
            } elseif (in_array($status, ['draft', 'aktif', 'selesai'], true)) {
                $builder->where('campaigns.status', $status);
            }
        }

        return $builder
            ->orderBy('campaigns.created_at', 'DESC')
            ->findAll();
    }
}
