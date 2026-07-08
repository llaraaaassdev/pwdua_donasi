<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table = 'reports';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'campaign_id',
        'user_id',
        'judul_laporan',
        'deskripsi',
        'total_pengeluaran',
        'tanggal_laporan',
        'status',
        'status_verifikasi',
        'verified_by',
        'verified_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function baseReportSelect()
    {
        return $this->select('reports.*, campaigns.judul AS campaign_judul, campaigns.target_dana, campaigns.dana_terkumpul, campaigns.gambar AS campaign_gambar, foundations.nama_yayasan, foundations.user_id AS foundation_user_id, verifier.nama AS verifier_nama')
            ->join('campaigns', 'campaigns.id = reports.campaign_id', 'left')
            ->join('foundations', 'foundations.id = campaigns.foundation_id', 'left')
            ->join('users AS verifier', 'verifier.id = reports.verified_by', 'left');
    }

    public function getReportsByFoundation($foundationId, $keyword = null, $status = null, $perPage = 10)
    {
        $builder = $this->baseReportSelect()
            ->where('campaigns.foundation_id', $foundationId);

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('reports.judul_laporan', $keyword)
                ->orLike('campaigns.judul', $keyword)
                ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('reports.status_verifikasi', $status);
        }

        return $builder->orderBy('reports.created_at', 'DESC')
            ->paginate($perPage, 'yayasan_reports');
    }

    public function getReportDetailForFoundation($reportId, $foundationId)
    {
        return $this->baseReportSelect()
            ->where('reports.id', $reportId)
            ->where('campaigns.foundation_id', $foundationId)
            ->first();
    }

    public function getAdminReports($keyword = null, $status = null, $perPage = 15)
    {
        $builder = $this->baseReportSelect();

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('reports.judul_laporan', $keyword)
                ->orLike('campaigns.judul', $keyword)
                ->orLike('foundations.nama_yayasan', $keyword)
                ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('reports.status_verifikasi', $status);
        }

        return $builder->orderBy('reports.created_at', 'DESC')
            ->paginate($perPage, 'admin_reports');
    }

    public function getAdminReportDetail($reportId)
    {
        return $this->baseReportSelect()
            ->where('reports.id', $reportId)
            ->first();
    }

    public function publicReportSelect()
    {
        return $this->select('reports.*, campaigns.judul AS campaign_judul, campaigns.target_dana, campaigns.dana_terkumpul, campaigns.gambar AS campaign_gambar, foundations.nama_yayasan, COUNT(report_comments.id) AS total_komentar')
            ->join('campaigns', 'campaigns.id = reports.campaign_id', 'left')
            ->join('foundations', 'foundations.id = campaigns.foundation_id', 'left')
            ->join('report_comments', "report_comments.report_id = reports.id AND report_comments.status = 'published'", 'left')
            ->where('reports.status', 'published')
            ->where('reports.status_verifikasi', 'approved')
            ->groupBy('reports.id');
    }

    public function getLatestPublishedReports($limit = 3)
    {
        return $this->publicReportSelect()
            ->orderBy('reports.verified_at', 'DESC')
            ->orderBy('reports.updated_at', 'DESC')
            ->limit((int) $limit)
            ->findAll();
    }

    public function getPublishedReports($keyword = null, $perPage = 12)
    {
        $builder = $this->publicReportSelect();

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('reports.judul_laporan', $keyword)
                ->orLike('campaigns.judul', $keyword)
                ->orLike('foundations.nama_yayasan', $keyword)
                ->groupEnd();
        }

        return $builder->orderBy('reports.verified_at', 'DESC')
            ->orderBy('reports.updated_at', 'DESC')
            ->paginate($perPage, 'public_reports');
    }

    public function getPublishedReportDetail($reportId)
    {
        return $this->publicReportSelect()
            ->where('reports.id', $reportId)
            ->first();
    }

    public function getPublishedReportsByCampaign($campaignId, $limit = 4)
    {
        return $this->publicReportSelect()
            ->where('reports.campaign_id', $campaignId)
            ->orderBy('reports.verified_at', 'DESC')
            ->orderBy('reports.updated_at', 'DESC')
            ->limit((int) $limit)
            ->findAll();
    }

    public function countPublishedReports()
    {
        return (int) $this->where('status', 'published')
            ->where('status_verifikasi', 'approved')
            ->countAllResults();
    }

    public function countPublishedReportsByCampaign($campaignId)
    {
        return (int) $this->where('campaign_id', $campaignId)
            ->where('status', 'published')
            ->where('status_verifikasi', 'approved')
            ->countAllResults();
    }
}
