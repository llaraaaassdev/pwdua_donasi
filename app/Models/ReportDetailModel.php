<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportDetailModel extends Model
{
    protected $table = 'report_details';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [

        'report_id',

        'keterangan',

        'jumlah',

        'bukti'

    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}