<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportDetailModel extends Model
{
    protected $table = 'reports_details';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'report_id',
        'nama_pengeluaran',
        'nominal',
        'keterangan',
        'foto',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getDetailsByReport($reportId)
    {
        return $this->where('report_id', $reportId)
            ->orderBy('id', 'ASC')
            ->findAll();
    }
}
