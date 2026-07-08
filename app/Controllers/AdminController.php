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

    public function __construct()
    {
        $this->userModel       = new UserModel();
        $this->foundationModel = new FoundationModel();
        $this->campaignModel   = new CampaignModel();
        $this->donationModel   = new DonationModel();
    }

    public function index()
    {
        return $this->dashboard();
    }

    public function dashboard()
    {
        $db = db_connect();

        $successStatuses = ['berhasil', 'verified'];
        $successTransactionStatuses = ['settlement', 'capture'];

        $totalDonationNominal = (float) ($db->table('donations')
            ->selectSum('nominal', 'total')
            ->groupStart()
                ->whereIn('status', $successStatuses)
                ->orWhereIn('transaction_status', $successTransactionStatuses)
            ->groupEnd()
            ->get()
            ->getRowArray()['total'] ?? 0);

        $totalDonationTransaction = (int) $db->table('donations')->countAllResults();

        $successDonationTransaction = (int) $db->table('donations')
            ->groupStart()
                ->whereIn('status', $successStatuses)
                ->orWhereIn('transaction_status', $successTransactionStatuses)
            ->groupEnd()
            ->countAllResults();

        $pendingCampaign = (int) $db->table('campaigns')
            ->where('status_verifikasi', 'pending')
            ->countAllResults();

        $activeCampaign = (int) $db->table('campaigns')
            ->where('status', 'aktif')
            ->where('status_verifikasi', 'approved')
            ->countAllResults();

        $totalDonatur = (int) $db->table('users')
            ->where('role', 'donatur')
            ->countAllResults();

        $latestDonations = $db->table('donations')
            ->select('donations.id, donations.invoice, donations.status, donations.transaction_status, donations.created_at, campaigns.judul, foundations.nama_yayasan, users.nama AS donor_nama')
            ->join('campaigns', 'campaigns.id = donations.campaign_id', 'left')
            ->join('foundations', 'foundations.id = campaigns.foundation_id', 'left')
            ->join('users', 'users.id = donations.user_id', 'left')
            ->orderBy('donations.created_at', 'DESC')
            ->limit(6)
            ->get()
            ->getResultArray();

        $data = [
            'title'                      => 'Dashboard Admin',
            'totalUser'                  => $this->userModel->countAllResults(),
            'totalFoundation'            => $this->foundationModel->countAllResults(),
            'waitingFoundation'          => $this->foundationModel->where('status', 'pending')->countAllResults(),
            'totalCampaign'              => $this->campaignModel->countAllResults(),
            'pendingCampaign'            => $pendingCampaign,
            'activeCampaign'             => $activeCampaign,
            'totalDonation'              => $totalDonationNominal,
            'totalDonationTransaction'   => $totalDonationTransaction,
            'successDonationTransaction' => $successDonationTransaction,
            'totalDonatur'               => $totalDonatur,
            'latestCampaign'             => $this->campaignModel->orderBy('created_at', 'DESC')->findAll(5),
            'latestFoundation'           => $this->foundationModel->where('status', 'pending')->findAll(5),
            'latestDonations'            => $latestDonations,
        ];

        return view('admin/dashboard', $data);
    }
}
