<?php

namespace App\Controllers;

use App\Models\CampaignModel;
use App\Models\DonationModel;
use App\Models\ReportModel;
use App\Models\ReportDetailModel;
use App\Models\ReportCommentModel;

class HomeController extends BaseController
{
    protected $campaignModel;
    protected $donationModel;
    protected $reportModel;
    protected $reportDetailModel;
    protected $reportCommentModel;

    public function __construct()
    {
        $this->campaignModel = new CampaignModel();
        $this->donationModel = new DonationModel();
        $this->reportModel = new ReportModel();
        $this->reportDetailModel = new ReportDetailModel();
        $this->reportCommentModel = new ReportCommentModel();
    }

    public function index()
    {
        $db = db_connect();

        $campaignBuilder = static function () use ($db) {
            return $db->table('campaigns')
                ->select('campaigns.*, foundations.nama_yayasan, categories.nama_kategori')
                ->join('foundations', 'foundations.id = campaigns.foundation_id', 'left')
                ->join('categories', 'categories.id = campaigns.category_id', 'left')
                ->where('campaigns.status', 'aktif')
                ->where('campaigns.status_verifikasi', 'approved');
        };

        $campaigns = $campaignBuilder()
            ->orderBy('campaigns.created_at', 'DESC')
            ->limit(9)
            ->get()
            ->getResultArray();

        $featuredCampaigns = $campaignBuilder()
            ->orderBy('campaigns.dana_terkumpul', 'DESC')
            ->orderBy('campaigns.created_at', 'DESC')
            ->limit(3)
            ->get()
            ->getResultArray();

        $categories = $db->table('categories')
            ->select('categories.*, COUNT(campaigns.id) AS total_campaign')
            ->join(
                'campaigns',
                "campaigns.category_id = categories.id AND campaigns.status = 'aktif' AND campaigns.status_verifikasi = 'approved'",
                'left'
            )
            ->groupBy('categories.id')
            ->orderBy('categories.nama_kategori', 'ASC')
            ->get()
            ->getResultArray();

        $totalCampaign = (int) $db->table('campaigns')
            ->where('status', 'aktif')
            ->where('status_verifikasi', 'approved')
            ->countAllResults();

        $totalDana = (float) ($db->table('campaigns')
            ->selectSum('dana_terkumpul', 'total')
            ->where('status', 'aktif')
            ->where('status_verifikasi', 'approved')
            ->get()
            ->getRowArray()['total'] ?? 0);

        $totalDonatur = (int) ($db->table('campaigns')
            ->selectSum('jumlah_donatur', 'total')
            ->where('status', 'aktif')
            ->where('status_verifikasi', 'approved')
            ->get()
            ->getRowArray()['total'] ?? 0);

        $totalYayasan = (int) $db->table('foundations')
            ->where('status', 'verified')
            ->countAllResults();

        $donorStats = null;
        if (session()->get('logged_in') && session()->get('role') === 'donatur') {
            $donorStats = $this->donationModel->getDonorStats((int) session()->get('id'));
        }

        return view('home/index', [
            'title'             => 'DonasiKu | Donasi Transparan',
            'campaigns'         => $campaigns,
            'featuredCampaigns' => $featuredCampaigns,
            'categories'        => $categories,
            'stats'             => [
                'total_campaign' => $totalCampaign,
                'total_dana'     => $totalDana,
                'total_donatur'  => $totalDonatur,
                'total_yayasan'  => $totalYayasan,
            ],
            'donorStats'        => $donorStats,
            'donationNews'      => $this->donationModel->getPublicDonationNews(5),
            'publicReports'     => $this->reportModel->getLatestPublishedReports(3),
            'totalReports'      => $this->reportModel->countPublishedReports(),
        ]);
    }

    public function detail($id)
    {
        $db = db_connect();

        $campaign = $db->table('campaigns')
            ->select('campaigns.*, foundations.nama_yayasan, foundations.logo AS logo_yayasan, categories.nama_kategori')
            ->join('foundations', 'foundations.id = campaigns.foundation_id', 'left')
            ->join('categories', 'categories.id = campaigns.category_id', 'left')
            ->where('campaigns.id', $id)
            ->where('campaigns.status', 'aktif')
            ->where('campaigns.status_verifikasi', 'approved')
            ->get()
            ->getRowArray();

        if (!$campaign) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->campaignModel->update($id, [
            'views' => ((int) ($campaign['views'] ?? 0)) + 1,
        ]);

        return view('home/detail', [
            'title'       => esc($campaign['judul']) . ' | DonasiKu',
            'campaign'    => $campaign,
            'reports'     => $this->reportModel->getPublishedReportsByCampaign((int) $id, 4),
            'reportCount' => $this->reportModel->countPublishedReportsByCampaign((int) $id),
        ]);
    }

    public function beritaDonasi()
    {
        $news = $this->donationModel->getPublicDonationNewsPaginated(20);

        return view('home/berita_donasi', [
            'title' => 'Berita Donasi Real-time | DonasiKu',
            'news'  => $news,
            'pager' => $this->donationModel->pager,
        ]);
    }

    public function laporan()
    {
        $keyword = trim((string) $this->request->getGet('q'));
        $reports = $this->reportModel->getPublishedReports($keyword, 12);

        return view('home/laporan', [
            'title'   => 'Laporan Penggunaan Dana | DonasiKu',
            'reports' => $reports,
            'keyword' => $keyword,
            'pager'   => $this->reportModel->pager,
        ]);
    }

    public function detailLaporan($id)
    {
        $report = $this->reportModel->getPublishedReportDetail((int) $id);

        if (!$report) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Laporan tidak ditemukan atau belum dipublikasikan.');
        }

        return view('home/laporan_detail', [
            'title'    => esc($report['judul_laporan'] ?? 'Laporan Dana') . ' | DonasiKu',
            'report'   => $report,
            'details'  => $this->reportDetailModel->getDetailsByReport((int) $id),
            'comments' => $this->reportCommentModel->getPublishedCommentsByReport((int) $id),
        ]);
    }

    public function storeReportComment($id)
    {
        $report = $this->reportModel->getPublishedReportDetail((int) $id);
        if (!$report) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Laporan tidak ditemukan atau belum dipublikasikan.');
        }

        $isLoggedIn = (bool) session()->get('logged_in');
        $nameRules = $isLoggedIn ? 'permit_empty|max_length[100]' : 'required|min_length[2]|max_length[100]';

        $rules = [
            'nama_pengomentar' => $nameRules,
            'email_pengomentar' => 'permit_empty|valid_email|max_length[150]',
            'komentar' => 'required|min_length[3]|max_length[1000]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nama = $isLoggedIn
            ? (session()->get('nama') ?: 'Pengguna DonasiKu')
            : trim((string) $this->request->getPost('nama_pengomentar'));

        $email = $isLoggedIn
            ? (session()->get('email') ?: null)
            : trim((string) $this->request->getPost('email_pengomentar'));

        $this->reportCommentModel->insert([
            'report_id' => (int) $id,
            'user_id' => $isLoggedIn ? (int) session()->get('id') : null,
            'nama_pengomentar' => $nama,
            'email_pengomentar' => $email ?: null,
            'komentar' => trim((string) $this->request->getPost('komentar')),
            'status' => 'published',
            'ip_address' => $this->request->getIPAddress(),
        ]);

        return redirect()->to('/laporan/' . $id . '#komentar')->with('success', 'Komentar berhasil ditambahkan.');
    }
}
