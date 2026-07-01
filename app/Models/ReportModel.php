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

        'judul',

        'deskripsi',

        'total_penggunaan',

        'status'

    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}