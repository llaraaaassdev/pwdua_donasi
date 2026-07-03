<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\FoundationModel;
use App\Models\CampaignModel;
use App\Models\DonationModel;

class AdminController extends BaseController
{
    protected $userModel;
    protected $foundationModel;
    protected $campaignModel;
    protected $donationModel;

    public function index()
    {
        return $this->dashboard();
    }
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->foundationModel = new FoundationModel();
        $this->campaignModel = new CampaignModel();
        $this->donationModel = new DonationModel();
    }

    public function dashboard()
    {
        $data = [
            'totalUser' => $this->userModel->countAll(),
            'totalFoundation' => $this->foundationModel->countAll(),
            'waitingFoundation' => $this->foundationModel
                                        ->where('status', 'pending')
                                        ->countAllResults(),
            'totalCampaign' => $this->campaignModel->countAll(),
            'totalDonation' => $this->donationModel
                                    ->selectSum('nominal')
                                    ->first()['nominal'] ?? 0,

            'latestCampaign' => $this->campaignModel
                                        ->orderBy('created_at','DESC')
                                        ->findAll(5),

            'latestFoundation' => $this->foundationModel
                                        ->where('status','pending')
                                        ->findAll(5)
        ];

        return view('admin/dashboard',$data);
    }
    
}