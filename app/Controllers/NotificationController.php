<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class NotificationController extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    public function index()
    {
        $userId = session()->get('id');

        $notifications = $this->notificationModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $this->notificationModel->markAllAsRead($userId);

        return view('notifications/index', [
            'notifications' => $notifications,
            'title' => 'Notifikasi'
        ]);
    }
}
