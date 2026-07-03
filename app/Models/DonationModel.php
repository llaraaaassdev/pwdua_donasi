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

        'bukti_pembayaran',

        'pesan',

        'status',
        'invoice',
        'tanggal_donasi',
        'anonim'

    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
    

    public function getDonations()
{
    return $this->select('
            donations.*,
            users.nama,
            campaigns.judul
        ')
        ->join('users', 'users.id = donations.user_id')
        ->join('campaigns', 'campaigns.id = donations.campaign_id')
        ->findAll();
}
public function getDonationDetail($id)
{
    return $this->select('
            donations.*,
            users.nama,
            users.email,
            campaigns.judul
        ')
        ->join('users','users.id = donations.user_id')
        ->join('campaigns','campaigns.id = donations.campaign_id')
        ->where('donations.id',$id)
        ->first();
}
public function verify($id)
{
    $donation = $this->donationModel->find($id);

    if (!$donation) {
        return redirect()->back()->with('error', 'Donasi tidak ditemukan.');
    }

    // Hindari verifikasi dua kali
    if ($donation['status'] == 'berhasil') {
        return redirect()->back()->with('error', 'Donasi sudah diverifikasi.');
    }

    // Update status donasi
    $this->donationModel->update($id, [
        'status' => 'berhasil'
    ]);

    // Ambil data campaign
    $campaign = $this->campaignModel->find($donation['campaign_id']);

    // Tambahkan nominal ke dana terkumpul
    $this->campaignModel->update($campaign['id'], [
        'terkumpul' => $campaign['terkumpul'] + $donation['nominal']
    ]);

    return redirect()->to('/admin/donation')
                     ->with('success', 'Donasi berhasil diverifikasi.');
}

public function filterDonation($keyword = null, $status = null)
{
    $builder = $this->select('
            donations.*,
            users.nama,
            campaigns.judul
        ')
        ->join('users', 'users.id = donations.user_id')
        ->join('campaigns', 'campaigns.id = donations.campaign_id');

    if (!empty($keyword)) {

        $builder->groupStart()
                ->like('users.nama', $keyword)
                ->orLike('campaigns.judul', $keyword)
                ->groupEnd();

    }

    if (!empty($status)) {

        $builder->where('donations.status', $status);

    }

    return $builder->findAll();
}
}