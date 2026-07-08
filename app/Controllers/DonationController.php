<?php

namespace App\Controllers;

use App\Models\DonationModel;

class DonationController extends BaseController
{
    protected $donationModel;

    public function __construct()
    {
        $this->donationModel = new DonationModel();
    }

    public function index()
    {
        $keyword = trim((string) $this->request->getGet('keyword'));
        $status  = $this->request->getGet('status');
        $perPage = 25;

        $donations = $this->donationModel->filterDonationPaginated($keyword, $status, $perPage);
        $stats     = $this->donationModel->getDashboardStats();

        return view('admin/donation/index', [
            'title'     => 'Kelola Donasi',
            'donations' => $donations,
            'pager'     => $this->donationModel->pager,
            'keyword'   => $keyword,
            'status'    => $status,
            'stats'     => $stats,
            'perPage'   => $perPage,
        ]);
    }

    public function detail($id)
    {
        $donation = $this->donationModel->getDonationDetail($id);

        if (!$donation) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Donasi tidak ditemukan.');
        }

        return view('admin/donation/detail', [
            'title'    => 'Detail Donasi',
            'donation' => $donation,
        ]);
    }

    public function verify($id)
    {
        return redirect()->to('/admin/donation')
            ->with('error', 'Pembayaran tidak diverifikasi manual oleh admin. Status donasi mengikuti callback Midtrans.');
    }

    public function reject($id)
    {
        return redirect()->to('/admin/donation')
            ->with('error', 'Donasi Midtrans tidak ditolak manual oleh admin. Status transaksi mengikuti Midtrans.');
    }
}
