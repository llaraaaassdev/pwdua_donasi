<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table            = 'notifications';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'user_id',
        'title',
        'message',
        'type',
        'link',
        'is_read',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $skipValidation = true;

    public function getLatestByUser($userId, $limit = 5)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function countUnreadByUser($userId)
    {
        return $this->where('user_id', $userId)
            ->where('is_read', 0)
            ->countAllResults();
    }

    public function markAllAsRead($userId)
    {
        return $this->where('user_id', $userId)
            ->set(['is_read' => 1])
            ->update();
    }
}
