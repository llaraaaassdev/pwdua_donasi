<?php

namespace App\Controllers;

use App\Models\CampaignModel;
use App\Models\DonationModel;

class DonaturController extends BaseController
{
    protected CampaignModel $campaignModel;
    protected DonationModel $donationModel;

    public function __construct()
    {
        $this->campaignModel = new CampaignModel();
        $this->donationModel = new DonationModel();
    }

    public function dashboard()
    {
        return redirect()->to('/')->with('success', 'Halo ' . session()->get('nama') . ', Anda masuk sebagai donatur.');
    }

    public function campaign()
    {
        return redirect()->to('/#campaign');
    }

    public function detailCampaign($id)
    {
        return redirect()->to('/campaign/' . $id);
    }

    public function createDonation($campaignId)
    {
        $campaign = $this->getActiveCampaign((int) $campaignId);

        if (!$campaign) {
            return redirect()->to('/#campaign')->with('error', 'Campaign tidak ditemukan atau belum aktif.');
        }

        return view('donatur/donation/create', [
            'title'    => 'Buat Donasi | DonasiKu',
            'campaign' => $campaign,
        ]);
    }

    public function storeDonation()
    {
        $campaignId = (int) $this->request->getPost('campaign_id');
        $campaign = $this->getActiveCampaign($campaignId);

        if (!$campaign) {
            return redirect()->to('/#campaign')->with('error', 'Campaign tidak ditemukan atau belum aktif.');
        }

        $nominal = (int) preg_replace('/[^0-9]/', '', (string) $this->request->getPost('nominal'));

        if ($nominal < 1000) {
            return redirect()->back()->withInput()->with('error', 'Nominal donasi minimal Rp 1.000.');
        }

        $invoice = 'INV-' . date('YmdHis') . '-' . random_int(100, 999);

        $this->donationModel->insert([
            'campaign_id'        => $campaignId,
            'user_id'            => (int) session()->get('id'),
            'invoice'            => $invoice,
            'nominal'            => $nominal,
            'gross_amount'       => $nominal,
            'metode_pembayaran'  => 'midtrans',
            'payment_type'       => null,
            'pesan'              => trim((string) $this->request->getPost('pesan')),
            'anonim'             => $this->request->getPost('anonim') ? 1 : 0,
            'status'             => 'pending',
            'transaction_status' => 'pending',
            'tanggal_donasi'     => date('Y-m-d H:i:s'),
        ]);

        $donationId = $this->donationModel->getInsertID();

        return redirect()->to('/payment/checkout/' . $donationId)
            ->with('success', 'Donasi berhasil dibuat. Silakan lanjutkan pembayaran melalui Midtrans.');
    }

    public function history()
    {
        $userId = (int) session()->get('id');
        $stats = $this->donationModel->getDonorStats($userId);
        $donations = $this->donationModel->getDonorHistory($userId, 10);

        return view('donatur/history/index', [
            'title'     => 'Riwayat Donasi | DonasiKu',
            'donations' => $donations,
            'stats'     => $stats,
            'pager'     => $this->donationModel->pager,
        ]);
    }

    public function detailHistory($id)
    {
        $userId = (int) session()->get('id');
        $donation = $this->donationModel->getDonorDonationDetail((int) $id, $userId);

        if (!$donation) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('donatur/history/detail', [
            'title'    => 'Detail Donasi | DonasiKu',
            'donation' => $donation,
        ]);
    }

    public function uploadBukti($id)
    {
        return redirect()->to('/donatur/history/' . $id)
            ->with('error', 'Pembayaran menggunakan Midtrans, jadi bukti pembayaran tidak perlu diupload manual.');
    }

    public function saveBukti($id)
    {
        return redirect()->to('/donatur/history/' . $id)
            ->with('error', 'Pembayaran menggunakan Midtrans, jadi bukti pembayaran tidak perlu diupload manual.');
    }

    private function getActiveCampaign(int $campaignId): ?array
    {
        return $this->campaignModel
            ->select('campaigns.*, foundations.nama_yayasan, categories.nama_kategori')
            ->join('foundations', 'foundations.id = campaigns.foundation_id', 'left')
            ->join('categories', 'categories.id = campaigns.category_id', 'left')
            ->where('campaigns.id', $campaignId)
            ->where('campaigns.status', 'aktif')
            ->where('campaigns.status_verifikasi', 'approved')
            ->first();
    }
}
