<?php

namespace App\Controllers;

use App\Models\DonationModel;
use App\Models\CampaignModel;


class DonationController extends BaseController
{
    protected $donationModel;
    protected $campaignModel;
    public function __construct()
    {
        $this->donationModel = new DonationModel();
        $this->campaignModel = new CampaignModel();
    }
    
    public function index()
{
    $keyword = $this->request->getGet('keyword');

    $status = $this->request->getGet('status');

    $donations = $this->donationModel
                      ->filterDonation($keyword, $status);

    return view('admin/donation/index',[

        'donations'=>$donations,

        'keyword'=>$keyword,

        'status'=>$status

    ]);
}

    public function detail($id)
{
    $donation = $this->donationModel
                     ->getDonationDetail($id);

    if(!$donation){
        throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }

    return view('admin/donation/detail',[
        'donation'=>$donation
    ]);
}

public function reject($id)
{
    $donation = $this->donationModel->find($id);

    if (!$donation) {

        return redirect()->back()
                         ->with('error', 'Donasi tidak ditemukan.');

    }

    if ($donation['status'] != 'pending') {

        return redirect()->back()
                         ->with('error', 'Donasi sudah diproses.');

    }

    $this->donationModel->update($id, [

        'status' => 'ditolak'

    ]);

    return redirect()->to('/admin/donation')
                     ->with('success', 'Donasi berhasil ditolak.');
}
}