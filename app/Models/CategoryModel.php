<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'nama_kategori',
        'deskripsi',
        'icon'
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}