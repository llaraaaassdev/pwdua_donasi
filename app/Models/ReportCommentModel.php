<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportCommentModel extends Model
{
    protected $table = 'report_comments';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'report_id',
        'user_id',
        'nama_pengomentar',
        'email_pengomentar',
        'komentar',
        'status',
        'ip_address',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getPublishedCommentsByReport($reportId)
    {
        return $this->where('report_id', $reportId)
            ->where('status', 'published')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
}
