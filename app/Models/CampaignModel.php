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
}