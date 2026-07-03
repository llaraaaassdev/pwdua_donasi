<?php

namespace App\Controllers;

use App\Models\CampaignModel;
use App\Models\DonationModel;

class DonaturController extends BaseController
{
    protected $campaignModel;
    protected $donationModel;

    public function __construct()
    {
        $this->campaignModel = new CampaignModel();
        $this->donationModel = new DonationModel();
    }

    public function dashboard()
    {
        return view('donatur/dashboard');
    }

    public function campaign()
{
    $campaigns = $this->campaignModel
        ->where('status', 'aktif')
        ->where('status_verifikasi', 'approved')
        ->orderBy('created_at', 'DESC')
        ->findAll();

    return view('donatur/campaign/index', [
        'campaigns' => $campaigns
    ]);
}
public function detailCampaign($id)
{
    $campaign = $this->campaignModel
        ->where('id', $id)
        ->where('status', 'aktif')
        ->where('status_verifikasi', 'approved')
        ->first();

    if (!$campaign) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    return view('donatur/campaign/detail', [
        'campaign' => $campaign
    ]);
}

public function createDonation($campaignId)
{
    $campaign = $this->campaignModel->find($campaignId);

    if(!$campaign){

        throw new \CodeIgniter\Exceptions\PageNotFoundException();

    }

    return view('donatur/donation/create',[

        'campaign'=>$campaign

    ]);
}
public function storeDonation()
{
    $invoice = 'INV-' . time();

    $this->donationModel->save([

        'campaign_id'=>$this->request->getPost('campaign_id'),

        'user_id'=>session()->get('user_id'),

        'invoice'=>$invoice,

        'nominal'=>$this->request->getPost('nominal'),

        'metode_pembayaran'=>$this->request->getPost('metode_pembayaran'),

        'pesan'=>$this->request->getPost('pesan'),

        'anonim'=>$this->request->getPost('anonim') ? 1 : 0,

        'status'=>'pending',

        'tanggal_donasi'=>date('Y-m-d')

    ]);

    $id = $this->donationModel->getInsertID();

return redirect()->to('/donatur/donation/upload/'.$id)
                 ->with('success','Silakan upload bukti pembayaran.');
}
public function uploadBukti($id)
{
    $donation = $this->donationModel
        ->where('id', $id)
        ->where('user_id', session()->get('user_id'))
        ->first();

    if (!$donation) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    return view('donatur/donation/upload', [
        'donation' => $donation
    ]);
}
public function saveBukti($id)
{
    $donation = $this->donationModel
        ->where('id', $id)
        ->where('user_id', session()->get('user_id'))
        ->first();

    if (!$donation) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $file = $this->request->getFile('bukti');

    if ($file && $file->isValid() && !$file->hasMoved()) {

        $namaFile = $file->getRandomName();

        $file->move(
            FCPATH . 'uploads/bukti_pembayaran',
            $namaFile
        );

        $this->donationModel->update($id, [
            'bukti_pembayaran' => $namaFile
        ]);
    }

    return redirect()->to('/donatur/history')
                     ->with('success', 'Bukti pembayaran berhasil diupload.');
}
public function history()
{
    $userId = session()->get('user_id'); // sesuaikan dengan session login

    $donations = $this->donationModel
        ->select('donations.*, campaigns.judul')
        ->join('campaigns', 'campaigns.id = donations.campaign_id')
        ->where('donations.user_id', $userId)
        ->orderBy('donations.created_at', 'DESC')
        ->findAll();

    return view('donatur/history/index', [
        'donations' => $donations
    ]);
}
public function detailHistory($id)
{
    $userId = session()->get('user_id');

    $donation = $this->donationModel
        ->select('donations.*, campaigns.judul')
        ->join('campaigns', 'campaigns.id = donations.campaign_id')
        ->where('donations.id', $id)
        ->where('donations.user_id', $userId)
        ->first();

    if (!$donation) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    return view('donatur/history/detail', [
        'donation' => $donation
    ]);
}
}