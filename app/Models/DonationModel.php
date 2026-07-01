<?php

namespace App\Models;

use CodeIgniter\Model;

class DonationModel extends Model
{
    protected $table = 'donations';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [

        'campaign_id',

        'user_id',

        'nominal',

        'metode_pembayaran',

        'bukti_transfer',

        'pesan',

        'status'

    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}