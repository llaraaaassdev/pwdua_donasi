<?php

namespace App\Controllers;

use App\Models\FoundationModel;
use App\Models\FoundationProfileChangeModel;
use App\Models\CampaignModel;
use App\Models\DonationModel;
use App\Models\CategoryModel;
use App\Models\CampaignImageModel;
use App\Models\UserModel;
use App\Models\NotificationModel;
use App\Models\ReportModel;
use App\Models\ReportDetailModel;

class FoundationController extends BaseController
{
    protected $foundationModel;
    protected $profileChangeModel;
    protected $campaignModel;
    protected $donationModel;
    protected $categoryModel;
    protected $campaignImageModel;
    protected $userModel;
    protected $notificationModel;

    public function __construct()
    {
        $this->foundationModel = new FoundationModel();
        $this->profileChangeModel = new FoundationProfileChangeModel();
        $this->campaignModel = new CampaignModel();
        $this->donationModel = new DonationModel();
        $this->categoryModel = new CategoryModel();
        $this->campaignImageModel = new CampaignImageModel();
        $this->userModel = new UserModel();
        $this->notificationModel = new NotificationModel();
    }

    private function getLoggedInFoundation()
    {
        return $this->foundationModel
            ->where('user_id', session()->get('id'))
            ->first();
    }

    private function getPendingProfileChange($foundationId)
    {
        if (empty($foundationId)) {
            return null;
        }

        return $this->profileChangeModel
            ->where('foundation_id', $foundationId)
            ->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->first();
    }

    private function redirectIfFoundationNotVerified($foundation)
    {
        if (!$foundation) {
            return redirect()
                ->to('/yayasan/profile')
                ->with('error', 'Silakan lengkapi profil yayasan terlebih dahulu.');
        }

        if (($foundation['status'] ?? '') !== 'verified') {
            return redirect()
                ->to('/yayasan/status')
                ->with('error', 'Akun yayasan belum diverifikasi admin. Anda hanya dapat mengelola profil dan melihat status verifikasi.');
        }

        return null;
    }

    private function ensureUploadDirectories()
    {
        $logoPath = FCPATH . 'uploads/logo';
        $dokumenPath = FCPATH . 'uploads/dokumen';

        if (!is_dir($logoPath)) {
            mkdir($logoPath, 0777, true);
        }

        if (!is_dir($dokumenPath)) {
            mkdir($dokumenPath, 0777, true);
        }
    }

    private function createNotification($userId, $title, $message, $type = 'info', $link = null)
    {
        if (empty($userId)) {
            return;
        }

        try {
            $this->notificationModel->insert([
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'link' => $link,
                'is_read' => 0,
            ]);
        } catch (\Throwable $e) {
            // Notifikasi tidak boleh membuat proses utama gagal.
        }
    }

    private function notifyAdmins($title, $message, $type = 'info', $link = null)
    {
        $admins = $this->userModel
            ->where('role', 'admin')
            ->findAll();

        foreach ($admins as $admin) {
            $this->createNotification($admin['id'], $title, $message, $type, $link);
        }
    }

    private function deleteUploadedDocument($filename)
    {
        if (empty($filename)) {
            return;
        }

        $paths = [
            FCPATH . 'uploads/dokumen/' . $filename,
            FCPATH . 'uploads/legalitas/' . $filename,
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    private function deleteUploadedLogo($filename)
    {
        if (empty($filename)) {
            return;
        }

        $path = FCPATH . 'uploads/logo/' . $filename;

        if (file_exists($path)) {
            unlink($path);
        }
    }

    private function deletePendingChangeFiles($change, $foundation = null)
    {
        if (!$change) {
            return;
        }

        if (!empty($change['logo']) && (!$foundation || ($foundation['logo'] ?? null) !== $change['logo'])) {
            $this->deleteUploadedLogo($change['logo']);
        }

        if (!empty($change['dokumen_verifikasi']) && (!$foundation || ($foundation['dokumen_verifikasi'] ?? null) !== $change['dokumen_verifikasi'])) {
            $this->deleteUploadedDocument($change['dokumen_verifikasi']);
        }
    }

    private function countActiveCampaigns($foundationId)
    {
        if (empty($foundationId)) {
            return 0;
        }

        return $this->campaignModel
            ->where('foundation_id', $foundationId)
            ->groupStart()
                ->where('LOWER(status)', 'aktif')
                ->orWhere('LOWER(status_verifikasi)', 'approved')
            ->groupEnd()
            ->countAllResults();
    }

    private function countFoundationDonations($foundationId)
    {
        if (empty($foundationId)) {
            return 0;
        }

        return (int) db_connect()->table('donations')
            ->join('campaigns', 'campaigns.id = donations.campaign_id', 'inner')
            ->where('campaigns.foundation_id', $foundationId)
            ->countAllResults();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $status  = $this->request->getGet('status');

        $builder = $this->foundationModel
            ->select('foundations.*, users.nama')
            ->join('users', 'users.id = foundations.user_id');

        if (!empty($keyword)) {
            $builder->like('foundations.nama_yayasan', $keyword);
        }

        if (!empty($status)) {
            $builder->where('foundations.status', $status);
        }

        $foundations = $builder->orderBy('foundations.created_at', 'DESC')->findAll();

        $pendingChanges = $this->profileChangeModel
            ->where('status', 'pending')
            ->findAll();

        $pendingChangeMap = [];
        foreach ($pendingChanges as $change) {
            $pendingChangeMap[$change['foundation_id']] = $change;
        }

        foreach ($foundations as &$foundation) {
            $foundation['pending_profile_change'] = $pendingChangeMap[$foundation['id']] ?? null;
            $foundation['active_campaign_count'] = $this->countActiveCampaigns($foundation['id']);
            $foundation['donation_count'] = $this->countFoundationDonations($foundation['id']);
            $foundation['can_disable_account'] = ((int) $foundation['active_campaign_count']) === 0 && ((int) $foundation['donation_count']) === 0;
        }
        unset($foundation);

        return view('admin/yayasan/index', [
            'foundations' => $foundations,
            'keyword'     => $keyword,
            'status'      => $status,
        ]);
    }

    public function dashboard()
    {
        $foundation = $this->getLoggedInFoundation();

        if ($redirect = $this->redirectIfFoundationNotVerified($foundation)) {
            return $redirect;
        }

        $foundationId = $foundation['id'];
        $db = db_connect();
        $reportModel = new ReportModel();

        $totalCampaign = $this->campaignModel
            ->where('foundation_id', $foundationId)
            ->countAllResults();

        $campaignAktif = $this->campaignModel
            ->where('foundation_id', $foundationId)
            ->where('status', 'aktif')
            ->where('status_verifikasi', 'approved')
            ->countAllResults();

        $campaignPending = $this->campaignModel
            ->where('foundation_id', $foundationId)
            ->where('status_verifikasi', 'pending')
            ->countAllResults();

        $campaigns = $this->campaignModel
            ->where('foundation_id', $foundationId)
            ->findAll();

        $campaignIds = array_column($campaigns, 'id');

        $totalDana = 0;
        $totalDonatur = 0;
        $recentDonation = [];

        if (!empty($campaignIds)) {
            $successBuilder = $db->table('donations')
                ->select('COALESCE(SUM(donations.nominal), 0) AS total_dana, COUNT(DISTINCT donations.user_id) AS total_donatur', false)
                ->whereIn('donations.campaign_id', $campaignIds)
                ->groupStart()
                    ->whereIn('donations.status', ['berhasil', 'verified', 'success', 'paid'])
                    ->orWhereIn('donations.transaction_status', ['settlement', 'capture'])
                ->groupEnd()
                ->get()
                ->getRowArray();

            $totalDana = (float) ($successBuilder['total_dana'] ?? 0);
            $totalDonatur = (int) ($successBuilder['total_donatur'] ?? 0);

            $recentDonation = $db->table('donations')
                ->select('donations.*, campaigns.judul, users.nama AS donor_nama, users.email AS donor_email')
                ->join('campaigns', 'campaigns.id = donations.campaign_id', 'left')
                ->join('users', 'users.id = donations.user_id', 'left')
                ->whereIn('donations.campaign_id', $campaignIds)
                ->orderBy('COALESCE(donations.paid_at, donations.created_at)', 'DESC', false)
                ->limit(5)
                ->get()
                ->getResultArray();
        }

        $campaignProgress = $this->campaignModel
            ->where('foundation_id', $foundationId)
            ->orderBy('created_at', 'DESC')
            ->limit(6)
            ->findAll();

        $reportPending = $reportModel->baseReportSelect()
            ->where('campaigns.foundation_id', $foundationId)
            ->where('reports.status_verifikasi', 'pending')
            ->countAllResults();

        $recentReports = $reportModel->baseReportSelect()
            ->where('campaigns.foundation_id', $foundationId)
            ->orderBy('reports.created_at', 'DESC')
            ->limit(5)
            ->findAll();

        $pendingProfileChange = $this->getPendingProfileChange($foundationId);

        return view('yayasan/dashboard', [
            'foundation'            => $foundation,
            'pendingProfileChange'  => $pendingProfileChange,
            'totalCampaign'         => $totalCampaign,
            'campaignAktif'         => $campaignAktif,
            'campaignPending'       => $campaignPending,
            'totalDana'             => $totalDana,
            'totalDonatur'          => $totalDonatur,
            'recentDonation'        => $recentDonation,
            'campaignProgress'      => $campaignProgress,
            'reportPending'         => $reportPending,
            'recentReports'         => $recentReports,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CRUD PROFIL YAYASAN SENDIRI
    |--------------------------------------------------------------------------
    | Registrasi yayasan sudah lengkap dan langsung berstatus pending.
    | Setelah verified, yayasan tetap bisa mengajukan perubahan profil.
    | Perubahan profil verified tidak langsung mengubah data utama; admin harus
    | approve/reject dulu lewat menu verifikasi yayasan.
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return $this->profile();
    }

    public function profile()
    {
        $foundation = $this->getLoggedInFoundation();
        $pendingProfileChange = $foundation ? $this->getPendingProfileChange($foundation['id']) : null;
        $activeCampaignCount = $foundation ? $this->countActiveCampaigns($foundation['id']) : 0;

        return view('yayasan/profile', [
            'foundation' => $foundation,
            'pendingProfileChange' => $pendingProfileChange,
            'activeCampaignCount' => $activeCampaignCount,
        ]);
    }

    public function store()
    {
        $existingFoundation = $this->getLoggedInFoundation();

        if ($existingFoundation) {
            return redirect()
                ->to('/yayasan/profile')
                ->with('error', 'Profil yayasan sudah ada. Silakan gunakan fitur edit profil.');
        }

        $rules = $this->profileValidationRules(true);

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->ensureUploadDirectories();

        $logoName = null;
        $logo = $this->request->getFile('logo');

        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $logoName = $logo->getRandomName();
            $logo->move(FCPATH . 'uploads/logo', $logoName);
        }

        $dokumen = $this->request->getFile('dokumen_verifikasi');
        $dokumenName = $dokumen->getRandomName();
        $dokumen->move(FCPATH . 'uploads/dokumen', $dokumenName);

        $this->foundationModel->insert([
            'user_id' => session()->get('id'),
            'nama_yayasan' => $this->request->getPost('nama_yayasan'),
            'email_yayasan' => $this->request->getPost('email_yayasan'),
            'telepon' => $this->request->getPost('telepon'),
            'alamat' => $this->request->getPost('alamat'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'nomor_izin' => $this->request->getPost('nomor_izin'),
            'logo' => $logoName,
            'dokumen_verifikasi' => $dokumenName,
            'status' => 'pending',
            'verified_by' => null,
            'verified_at' => null
        ]);

        $foundationId = $this->foundationModel->getInsertID();

        if ($foundationId) {
            session()->set('foundation_id', $foundationId);
        }

        $this->userModel->update(session()->get('id'), [
            'status_verifikasi' => 'pending'
        ]);

        $this->createNotification(
            session()->get('id'),
            'Profil yayasan dikirim',
            'Data yayasan berhasil dikirim dan sedang menunggu verifikasi admin.',
            'info',
            base_url('yayasan/status')
        );

        $this->notifyAdmins(
            'Verifikasi yayasan baru',
            'Ada data yayasan baru yang menunggu verifikasi admin.',
            'warning',
            base_url('admin/yayasan/detail/' . $foundationId)
        );

        return redirect()
            ->to('/yayasan/status')
            ->with('success', 'Profil berhasil dikirim dan menunggu verifikasi admin.');
    }

    public function updateProfile()
    {
        $foundation = $this->getLoggedInFoundation();

        if (!$foundation) {
            return redirect()
                ->to('/yayasan/profile')
                ->with('error', 'Profil yayasan belum ditemukan. Silakan lengkapi profil terlebih dahulu.');
        }

        $rules = $this->profileValidationRules(false);

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->ensureUploadDirectories();

        if (($foundation['status'] ?? '') === 'verified') {
            return $this->submitVerifiedProfileChange($foundation);
        }

        return $this->resubmitUnverifiedProfile($foundation);
    }

    private function profileValidationRules($requireDocument = false)
    {
        return [
            'nama_yayasan' => 'required|min_length[5]',
            'email_yayasan' => 'required|valid_email',
            'telepon' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'nomor_izin' => 'required',
            'logo' => [
                'rules' => 'permit_empty|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png,image/webp]|max_size[logo,2048]',
                'errors' => [
                    'is_image' => 'Logo harus berupa gambar.',
                    'mime_in'  => 'Format logo harus JPG, JPEG, PNG, atau WEBP.',
                    'max_size' => 'Ukuran logo maksimal 2 MB.'
                ]
            ],
            'dokumen_verifikasi' => [
                'rules' => ($requireDocument ? 'uploaded[dokumen_verifikasi]|' : 'permit_empty|') . 'ext_in[dokumen_verifikasi,pdf,jpg,jpeg,png]|max_size[dokumen_verifikasi,4096]',
                'errors' => [
                    'uploaded' => 'Dokumen legalitas wajib diupload.',
                    'ext_in'   => 'Format dokumen legalitas harus PDF, JPG, JPEG, atau PNG.',
                    'max_size' => 'Ukuran dokumen legalitas maksimal 4 MB.'
                ]
            ],
        ];
    }

    private function collectProfileInput($foundation)
    {
        $data = [
            'nama_yayasan' => $this->request->getPost('nama_yayasan'),
            'email_yayasan' => $this->request->getPost('email_yayasan'),
            'telepon' => $this->request->getPost('telepon'),
            'alamat' => $this->request->getPost('alamat'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'nomor_izin' => $this->request->getPost('nomor_izin'),
            'logo' => $foundation['logo'] ?? null,
            'dokumen_verifikasi' => $foundation['dokumen_verifikasi'] ?? null,
        ];

        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $logoName = $logo->getRandomName();
            $logo->move(FCPATH . 'uploads/logo', $logoName);
            $data['logo'] = $logoName;
        }

        $dokumen = $this->request->getFile('dokumen_verifikasi');
        if ($dokumen && $dokumen->isValid() && !$dokumen->hasMoved()) {
            $dokumenName = $dokumen->getRandomName();
            $dokumen->move(FCPATH . 'uploads/dokumen', $dokumenName);
            $data['dokumen_verifikasi'] = $dokumenName;
        }

        return $data;
    }

    private function submitVerifiedProfileChange($foundation)
    {
        $pendingChange = $this->getPendingProfileChange($foundation['id']);
        $changeData = $this->collectProfileInput($pendingChange ?: $foundation);

        $saveData = array_merge($changeData, [
            'foundation_id' => $foundation['id'],
            'user_id' => $foundation['user_id'],
            'status' => 'pending',
            'verified_by' => null,
            'verified_at' => null,
        ]);

        if ($pendingChange) {
            if (($pendingChange['logo'] ?? null) !== ($saveData['logo'] ?? null) && ($pendingChange['logo'] ?? null) !== ($foundation['logo'] ?? null)) {
                $this->deleteUploadedLogo($pendingChange['logo']);
            }

            if (($pendingChange['dokumen_verifikasi'] ?? null) !== ($saveData['dokumen_verifikasi'] ?? null) && ($pendingChange['dokumen_verifikasi'] ?? null) !== ($foundation['dokumen_verifikasi'] ?? null)) {
                $this->deleteUploadedDocument($pendingChange['dokumen_verifikasi']);
            }

            $this->profileChangeModel->update($pendingChange['id'], $saveData);
            $changeId = $pendingChange['id'];
        } else {
            $this->profileChangeModel->insert($saveData);
            $changeId = $this->profileChangeModel->getInsertID();
        }

        $this->createNotification(
            $foundation['user_id'],
            'Perubahan profil dikirim',
            'Perubahan profil yayasan berhasil dikirim dan menunggu verifikasi admin.',
            'info',
            base_url('yayasan/status')
        );

        $this->notifyAdmins(
            'Perubahan profil yayasan',
            'Ada perubahan profil yayasan yang menunggu verifikasi admin.',
            'warning',
            base_url('admin/yayasan/detail/' . $foundation['id'])
        );

        return redirect()
            ->to('/yayasan/status')
            ->with('success', 'Perubahan profil berhasil dikirim dan menunggu verifikasi admin.');
    }

    private function resubmitUnverifiedProfile($foundation)
    {
        $updateData = $this->collectProfileInput($foundation);
        $updateData['status'] = 'pending';
        $updateData['verified_by'] = null;
        $updateData['verified_at'] = null;

        if (($updateData['logo'] ?? null) !== ($foundation['logo'] ?? null) && !empty($foundation['logo'])) {
            $this->deleteUploadedLogo($foundation['logo']);
        }

        if (($updateData['dokumen_verifikasi'] ?? null) !== ($foundation['dokumen_verifikasi'] ?? null) && !empty($foundation['dokumen_verifikasi'])) {
            $this->deleteUploadedDocument($foundation['dokumen_verifikasi']);
        }

        $this->foundationModel->update($foundation['id'], $updateData);

        session()->set('foundation_id', $foundation['id']);

        $this->userModel->update($foundation['user_id'], [
            'status_verifikasi' => 'pending',
            'is_active' => 1,
        ]);

        $this->createNotification(
            $foundation['user_id'],
            'Data yayasan dikirim ulang',
            'Data yayasan berhasil diperbarui dan dikirim ulang untuk verifikasi admin.',
            'info',
            base_url('yayasan/status')
        );

        $this->notifyAdmins(
            'Verifikasi ulang yayasan',
            'Ada data yayasan yang dikirim ulang dan menunggu verifikasi admin.',
            'warning',
            base_url('admin/yayasan/detail/' . $foundation['id'])
        );

        return redirect()
            ->to('/yayasan/status')
            ->with('success', 'Profil yayasan berhasil diperbarui dan dikirim ulang untuk verifikasi admin.');
    }

    public function deleteProfile()
    {
        $foundation = $this->getLoggedInFoundation();

        if (!$foundation) {
            return redirect()
                ->to('/yayasan/profile')
                ->with('error', 'Profil yayasan belum ditemukan.');
        }

        if ($this->countActiveCampaigns($foundation['id']) > 0 || $this->countFoundationDonations($foundation['id']) > 0) {
            return redirect()
                ->to('/yayasan/profile')
                ->with('error', 'Akun yayasan tidak dapat dihapus/dinonaktifkan karena masih memiliki campaign aktif atau data donasi. Nonaktifkan campaign selesai tanpa menghapus histori donasi.');
        }

        $pendingChange = $this->getPendingProfileChange($foundation['id']);
        $this->deletePendingChangeFiles($pendingChange, $foundation);

        if ($pendingChange) {
            $this->profileChangeModel->update($pendingChange['id'], [
                'status' => 'rejected',
                'verified_by' => null,
                'verified_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $this->userModel->update($foundation['user_id'], [
            'is_active' => 0
        ]);

        session()->destroy();

        return redirect()
            ->to('/login')
            ->with('success', 'Akun yayasan berhasil dinonaktifkan.');
    }

    public function status()
    {
        $foundation = $this->getLoggedInFoundation();
        $pendingProfileChange = $foundation ? $this->getPendingProfileChange($foundation['id']) : null;

        return view('yayasan/status', [
            'foundation' => $foundation,
            'pendingProfileChange' => $pendingProfileChange,
        ]);
    }

    public function adminList()
    {
        $data['foundations'] = $this->foundationModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/yayasan/index', $data);
    }

    public function detail($id)
    {
        $foundation = $this->foundationModel
            ->select('foundations.*, users.nama')
            ->join('users', 'users.id = foundations.user_id')
            ->where('foundations.id', $id)
            ->first();

        $pendingProfileChange = $foundation ? $this->getPendingProfileChange($foundation['id']) : null;

        $activeCampaignCount = $foundation ? $this->countActiveCampaigns($foundation['id']) : 0;
        $donationCount = $foundation ? $this->countFoundationDonations($foundation['id']) : 0;

        return view('admin/yayasan/detail', [
            'foundation' => $foundation,
            'pendingProfileChange' => $pendingProfileChange,
            'activeCampaignCount' => $activeCampaignCount,
            'donationCount' => $donationCount,
        ]);
    }

    public function approve($id)
    {
        $foundation = $this->foundationModel->find($id);

        if (!$foundation) {
            return redirect()->back()->with('error', 'Data yayasan tidak ditemukan.');
        }

        $pendingProfileChange = $this->getPendingProfileChange($foundation['id']);

        if (($foundation['status'] ?? '') === 'verified' && $pendingProfileChange) {
            return $this->approveProfileChange($foundation, $pendingProfileChange);
        }

        if (($foundation['status'] ?? '') === 'verified' && !$pendingProfileChange) {
            return redirect()
                ->back()
                ->with('error', 'Akun yayasan sudah verified dan tidak memiliki pengajuan perubahan profil yang perlu disetujui.');
        }

        $this->foundationModel->update($id, [
            'status'      => 'verified',
            'verified_by' => session()->get('id'),
            'verified_at' => date('Y-m-d H:i:s')
        ]);

        $this->userModel->update($foundation['user_id'], [
            'status_verifikasi' => 'verified',
            'is_active'         => 1
        ]);

        $this->createNotification(
            $foundation['user_id'],
            'Akun yayasan disetujui',
            'Selamat, akun yayasan Anda telah disetujui oleh admin.',
            'success',
            base_url('yayasan/dashboard')
        );

        return redirect()
            ->to('/admin/yayasan')
            ->with('success', 'Yayasan berhasil diverifikasi.');
    }

    private function approveProfileChange($foundation, $pendingProfileChange)
    {
        if (!empty($pendingProfileChange['logo']) && ($foundation['logo'] ?? null) !== $pendingProfileChange['logo']) {
            $this->deleteUploadedLogo($foundation['logo'] ?? null);
        }

        if (!empty($pendingProfileChange['dokumen_verifikasi']) && ($foundation['dokumen_verifikasi'] ?? null) !== $pendingProfileChange['dokumen_verifikasi']) {
            $this->deleteUploadedDocument($foundation['dokumen_verifikasi'] ?? null);
        }

        $this->foundationModel->update($foundation['id'], [
            'nama_yayasan' => $pendingProfileChange['nama_yayasan'],
            'email_yayasan' => $pendingProfileChange['email_yayasan'],
            'telepon' => $pendingProfileChange['telepon'],
            'alamat' => $pendingProfileChange['alamat'],
            'deskripsi' => $pendingProfileChange['deskripsi'],
            'nomor_izin' => $pendingProfileChange['nomor_izin'],
            'logo' => $pendingProfileChange['logo'],
            'dokumen_verifikasi' => $pendingProfileChange['dokumen_verifikasi'],
            'status' => 'verified',
            'verified_by' => session()->get('id'),
            'verified_at' => date('Y-m-d H:i:s'),
        ]);

        $this->profileChangeModel->update($pendingProfileChange['id'], [
            'status' => 'approved',
            'verified_by' => session()->get('id'),
            'verified_at' => date('Y-m-d H:i:s'),
        ]);

        $this->userModel->update($foundation['user_id'], [
            'status_verifikasi' => 'verified',
            'is_active' => 1,
        ]);

        $this->createNotification(
            $foundation['user_id'],
            'Perubahan profil disetujui',
            'Perubahan profil yayasan Anda telah disetujui oleh admin.',
            'success',
            base_url('yayasan/profile')
        );

        return redirect()
            ->to('/admin/yayasan/detail/' . $foundation['id'])
            ->with('success', 'Perubahan profil yayasan berhasil disetujui.');
    }

    public function reject($id)
    {
        $foundation = $this->foundationModel->find($id);

        if (!$foundation) {
            return redirect()->back()->with('error', 'Data yayasan tidak ditemukan.');
        }

        $pendingProfileChange = $this->getPendingProfileChange($foundation['id']);

        if (($foundation['status'] ?? '') === 'verified' && $pendingProfileChange) {
            return $this->rejectProfileChange($foundation, $pendingProfileChange);
        }

        if (($foundation['status'] ?? '') === 'verified' && !$pendingProfileChange) {
            return redirect()
                ->back()
                ->with('error', 'Akun yayasan yang sudah verified tidak bisa di-reject. Jika yayasan mengajukan edit profil, admin hanya menolak pengajuan perubahan profilnya.');
        }

        if ($this->countActiveCampaigns($foundation['id']) > 0) {
            return redirect()
                ->back()
                ->with('error', 'Akun yayasan tidak dapat di-reject karena masih memiliki campaign aktif.');
        }

        $this->foundationModel->update($id, [
            'status'      => 'rejected',
            'verified_by' => session()->get('id'),
            'verified_at' => date('Y-m-d H:i:s')
        ]);

        $this->userModel->update($foundation['user_id'], [
            'status_verifikasi' => 'rejected',
            'is_active'         => 1
        ]);

        $this->createNotification(
            $foundation['user_id'],
            'Pengajuan yayasan ditolak',
            'Pengajuan yayasan Anda ditolak. Silakan perbaiki data profil dan kirim ulang verifikasi.',
            'danger',
            base_url('yayasan/profile')
        );

        return redirect()
            ->to('/admin/yayasan')
            ->with('success', 'Pengajuan yayasan berhasil ditolak.');
    }

    private function rejectProfileChange($foundation, $pendingProfileChange)
    {
        $this->deletePendingChangeFiles($pendingProfileChange, $foundation);

        $this->profileChangeModel->update($pendingProfileChange['id'], [
            'status' => 'rejected',
            'verified_by' => session()->get('id'),
            'verified_at' => date('Y-m-d H:i:s'),
        ]);

        $this->foundationModel->update($foundation['id'], [
            'status' => 'verified',
            'verified_by' => session()->get('id'),
            'verified_at' => date('Y-m-d H:i:s'),
        ]);

        $this->userModel->update($foundation['user_id'], [
            'status_verifikasi' => 'verified',
            'is_active' => 1,
        ]);

        $this->createNotification(
            $foundation['user_id'],
            'Perubahan profil ditolak',
            'Perubahan profil yayasan Anda ditolak oleh admin. Data lama tetap digunakan.',
            'danger',
            base_url('yayasan/profile')
        );

        return redirect()
            ->to('/admin/yayasan/detail/' . $foundation['id'])
            ->with('success', 'Perubahan profil yayasan berhasil ditolak.');
    }

    public function delete($id)
    {
        $foundation = $this->foundationModel->find($id);

        if (!$foundation) {
            return redirect()->back()->with('error', 'Data yayasan tidak ditemukan.');
        }

        if ($this->countActiveCampaigns($foundation['id']) > 0 || $this->countFoundationDonations($foundation['id']) > 0) {
            return redirect()
                ->back()
                ->with('error', 'Akun yayasan tidak dapat dihapus/dinonaktifkan karena masih memiliki campaign aktif atau data donasi. Nonaktifkan akun hanya boleh jika tidak ada campaign aktif dan tidak ada histori donasi.');
        }

        $pendingChange = $this->getPendingProfileChange($foundation['id']);
        $this->deletePendingChangeFiles($pendingChange, $foundation);

        if ($pendingChange) {
            $this->profileChangeModel->update($pendingChange['id'], [
                'status' => 'rejected',
                'verified_by' => session()->get('id'),
                'verified_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $this->userModel->update($foundation['user_id'], [
            'is_active' => 0
        ]);

        $this->createNotification(
            $foundation['user_id'],
            'Akun yayasan dinonaktifkan',
            'Akun yayasan Anda telah dinonaktifkan oleh admin.',
            'danger',
            base_url('login')
        );

        return redirect()
            ->to('/admin/yayasan')
            ->with('success', 'Akun yayasan berhasil dinonaktifkan.');
    }

    public function myCampaign()
    {
        helper('text');

        $foundation = $this->getLoggedInFoundation();

        if ($redirect = $this->redirectIfFoundationNotVerified($foundation)) {
            return $redirect;
        }

        $campaigns = $this->campaignModel
            ->where('foundation_id', $foundation['id'])
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('yayasan/campaign/index', [
            'campaigns' => $campaigns
        ]);
    }

    public function detailCampaign($id)
    {
        $foundation = $this->getLoggedInFoundation();

        if ($redirect = $this->redirectIfFoundationNotVerified($foundation)) {
            return $redirect;
        }

        $campaign = $this->campaignModel
            ->where('id', $id)
            ->where('foundation_id', $foundation['id'])
            ->first();

        if (!$campaign) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Campaign tidak ditemukan.');
        }

        $campaignImages = $this->campaignImageModel
            ->where('campaign_id', $campaign['id'])
            ->orderBy('is_cover', 'DESC')
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        return view('yayasan/campaign/detail', [
            'campaign' => $campaign,
            'campaignImages' => $campaignImages
        ]);
    }

    public function createCampaign()
    {
        $foundation = $this->getLoggedInFoundation();

        if ($redirect = $this->redirectIfFoundationNotVerified($foundation)) {
            return $redirect;
        }

        return view('yayasan/campaign/create', [
            'categories' => $this->categoryModel->findAll()
        ]);
    }

    public function storeCampaign()
    {
        $foundation = $this->getLoggedInFoundation();

        if ($redirect = $this->redirectIfFoundationNotVerified($foundation)) {
            return $redirect;
        }

        $today = date('Y-m-d');

        $rules = [
            'judul'             => 'required',
            'category_id'       => 'required',
            'deskripsi'         => 'required',
            'target_dana'       => 'required|numeric',
            'tanggal_mulai'     => 'required|valid_date[Y-m-d]',
            'tanggal_berakhir'  => 'required|valid_date[Y-m-d]',
            'gambar.*' => [
                'rules' => 'permit_empty|is_image[gambar.*]|mime_in[gambar.*,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar.*,2048]',
                'errors' => [
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in'  => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
                    'max_size' => 'Ukuran gambar maksimal 2 MB.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $errors))
                ->with('errors', $errors);
        }

        $tanggalMulai = $this->request->getPost('tanggal_mulai');
        $tanggalBerakhir = $this->request->getPost('tanggal_berakhir');

        if ($tanggalMulai < $today) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Tanggal mulai tidak boleh kurang dari hari ini.');
        }

        if ($tanggalBerakhir <= $tanggalMulai) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Tanggal berakhir harus lebih besar dari tanggal mulai.');
        }

        $this->campaignModel->insert([
            'foundation_id'       => $foundation['id'],
            'category_id'         => $this->request->getPost('category_id'),
            'judul'               => $this->request->getPost('judul'),
            'slug'                => url_title($this->request->getPost('judul'), '-', true),
            'deskripsi'           => $this->request->getPost('deskripsi'),
            'target_dana'         => $this->request->getPost('target_dana'),
            'dana_terkumpul'      => 0,
            'gambar'              => null,
            'tanggal_mulai'       => $tanggalMulai,
            'tanggal_berakhir'    => $tanggalBerakhir,
            'status'              => 'draft',
            'status_verifikasi'   => 'pending',
            'jumlah_donatur'      => 0,
            'views'               => 0
        ]);

        $campaignId = $this->campaignModel->getInsertID();

        if (!$campaignId) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Campaign gagal disimpan ke database.');
        }

        $uploadPath = FCPATH . 'uploads/campaign';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $files = $this->request->getFiles();
        $coverImage = null;
        $sort = 1;

        if (isset($files['gambar']) && is_array($files['gambar'])) {
            foreach ($files['gambar'] as $index => $file) {
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    $namaGambar = $file->getRandomName();
                    $file->move($uploadPath, $namaGambar);

                    $this->campaignImageModel->insert([
                        'campaign_id' => $campaignId,
                        'image'       => $namaGambar,
                        'is_cover'    => $index === 0 ? 1 : 0,
                        'sort_order'  => $sort
                    ]);

                    if ($index === 0) {
                        $coverImage = $namaGambar;
                    }

                    $sort++;
                }
            }
        }

        if ($coverImage) {
            $this->campaignModel->update($campaignId, [
                'gambar' => $coverImage
            ]);
        }

        $this->notifyAdmins(
            'Campaign baru menunggu verifikasi',
            'Yayasan ' . ($foundation['nama_yayasan'] ?? 'Yayasan') . ' mengajukan campaign baru: "' . $this->request->getPost('judul') . '".',
            'info',
            base_url('admin/campaign/detail/' . $campaignId)
        );

        return redirect()
            ->to('/yayasan/campaign/index')
            ->with('success', 'Campaign berhasil dibuat dan menunggu persetujuan Admin.');
    }

    public function editCampaign($id)
    {
        $foundation = $this->getLoggedInFoundation();

        if ($redirect = $this->redirectIfFoundationNotVerified($foundation)) {
            return $redirect;
        }

        $campaign = $this->campaignModel
            ->where('id', $id)
            ->where('foundation_id', $foundation['id'])
            ->first();

        if (!$campaign) {
            return redirect()
                ->to('/yayasan/campaign/index')
                ->with('error', 'Campaign tidak ditemukan.');
        }

        $campaignImages = $this->campaignImageModel
            ->where('campaign_id', $campaign['id'])
            ->orderBy('is_cover', 'DESC')
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        return view('yayasan/campaign/edit', [
            'campaign' => $campaign,
            'categories' => $this->categoryModel->findAll(),
            'campaignImages' => $campaignImages
        ]);
    }

    public function updateCampaign($id)
    {
        $foundation = $this->getLoggedInFoundation();

        if ($redirect = $this->redirectIfFoundationNotVerified($foundation)) {
            return $redirect;
        }

        $campaign = $this->campaignModel
            ->where('id', $id)
            ->where('foundation_id', $foundation['id'])
            ->first();

        if (!$campaign) {
            return redirect()
                ->to('/yayasan/campaign/index')
                ->with('error', 'Campaign tidak ditemukan.');
        }

        $rules = [
            'judul'             => 'required',
            'category_id'       => 'required',
            'deskripsi'         => 'required',
            'target_dana'       => 'required|numeric',
            'tanggal_mulai'     => 'required|valid_date[Y-m-d]',
            'tanggal_berakhir'  => 'required|valid_date[Y-m-d]',
            'gambar.*' => [
                'rules' => 'permit_empty|is_image[gambar.*]|mime_in[gambar.*,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar.*,2048]',
                'errors' => [
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in'  => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
                    'max_size' => 'Ukuran gambar maksimal 2 MB.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $errors))
                ->with('errors', $errors);
        }

        $tanggalMulai = $this->request->getPost('tanggal_mulai');
        $tanggalBerakhir = $this->request->getPost('tanggal_berakhir');

        if ($tanggalBerakhir <= $tanggalMulai) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Tanggal berakhir harus lebih besar dari tanggal mulai.');
        }

        $slug = url_title($this->request->getPost('judul'), '-', true);

        $this->campaignModel->update($id, [
            'judul'             => $this->request->getPost('judul'),
            'slug'              => $slug,
            'category_id'       => $this->request->getPost('category_id'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'target_dana'       => $this->request->getPost('target_dana'),
            'tanggal_mulai'     => $tanggalMulai,
            'tanggal_berakhir'  => $tanggalBerakhir,
            'status'            => 'draft',
            'status_verifikasi' => 'pending'
        ]);

        $hapusGambar = $this->request->getPost('hapus_gambar');

        if (!empty($hapusGambar) && is_array($hapusGambar)) {
            foreach ($hapusGambar as $imageId) {
                $image = $this->campaignImageModel
                    ->where('id', $imageId)
                    ->where('campaign_id', $id)
                    ->first();

                if ($image) {
                    $path = FCPATH . 'uploads/campaign/' . $image['image'];

                    if (file_exists($path)) {
                        unlink($path);
                    }

                    $this->campaignImageModel->delete($image['id']);
                }
            }
        }

        $existingImages = $this->campaignImageModel
            ->where('campaign_id', $id)
            ->orderBy('sort_order', 'DESC')
            ->findAll();

        $sort = !empty($existingImages)
            ? ((int) $existingImages[0]['sort_order'] + 1)
            : 1;

        $uploadPath = FCPATH . 'uploads/campaign';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $files = $this->request->getFiles();

        if (isset($files['gambar']) && is_array($files['gambar'])) {
            foreach ($files['gambar'] as $file) {
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    $namaGambar = $file->getRandomName();
                    $file->move($uploadPath, $namaGambar);

                    $this->campaignImageModel->insert([
                        'campaign_id' => $id,
                        'image'       => $namaGambar,
                        'is_cover'    => 0,
                        'sort_order'  => $sort
                    ]);

                    $sort++;
                }
            }
        }

        $imagesAfterUpdate = $this->campaignImageModel
            ->where('campaign_id', $id)
            ->orderBy('is_cover', 'DESC')
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        if (!empty($imagesAfterUpdate)) {
            $hasCover = false;

            foreach ($imagesAfterUpdate as $image) {
                if ((int) $image['is_cover'] === 1) {
                    $hasCover = true;
                    $this->campaignModel->update($id, [
                        'gambar' => $image['image']
                    ]);
                    break;
                }
            }

            if (!$hasCover) {
                $firstImage = $imagesAfterUpdate[0];

                $this->campaignImageModel->update($firstImage['id'], [
                    'is_cover' => 1
                ]);

                $this->campaignModel->update($id, [
                    'gambar' => $firstImage['image']
                ]);
            }
        } else {
            $this->campaignModel->update($id, [
                'gambar' => null
            ]);
        }

        $this->notifyAdmins(
            'Perubahan campaign menunggu verifikasi',
            'Yayasan ' . ($foundation['nama_yayasan'] ?? 'Yayasan') . ' memperbarui campaign: "' . $this->request->getPost('judul') . '". Mohon lakukan verifikasi ulang.',
            'warning',
            base_url('admin/campaign/detail/' . $id)
        );

        return redirect()
            ->to('/yayasan/campaign/index')
            ->with('success', 'Campaign berhasil diperbarui dan menunggu persetujuan Admin.');
    }

    public function deleteCampaign($id)
    {
        $foundation = $this->getLoggedInFoundation();

        if ($redirect = $this->redirectIfFoundationNotVerified($foundation)) {
            return $redirect;
        }

        $campaign = $this->campaignModel
            ->where('id', $id)
            ->where('foundation_id', $foundation['id'])
            ->first();

        if (!$campaign) {
            return redirect()
                ->to('/yayasan/campaign/index')
                ->with('error', 'Campaign tidak ditemukan.');
        }

        if (($campaign['status_verifikasi'] ?? '') === 'approved') {
            return redirect()
                ->to('/yayasan/campaign/index')
                ->with('error', 'Campaign yang sudah disetujui Admin tidak dapat dihapus.');
        }

        $images = $this->campaignImageModel
            ->where('campaign_id', $id)
            ->findAll();

        foreach ($images as $image) {
            $path = FCPATH . 'uploads/campaign/' . $image['image'];

            if (file_exists($path)) {
                unlink($path);
            }

            $this->campaignImageModel->delete($image['id']);
        }

        if (!empty($campaign['gambar'])) {
            $path = FCPATH . 'uploads/campaign/' . $campaign['gambar'];

            if (file_exists($path)) {
                unlink($path);
            }
        }

        $this->campaignModel->delete($id);

        return redirect()
            ->to('/yayasan/campaign/index')
            ->with('success', 'Campaign berhasil dihapus.');
    }

    public function donations()
    {
        $foundation = $this->getLoggedInFoundation();

        if ($redirect = $this->redirectIfFoundationNotVerified($foundation)) {
            return $redirect;
        }

        $keyword = trim((string) $this->request->getGet('keyword'));
        $status = trim((string) $this->request->getGet('status'));
        $db = db_connect();

        $builder = $db->table('donations')
            ->select('donations.*, campaigns.judul, campaigns.foundation_id, categories.nama_kategori, users.nama AS donor_nama, users.email AS donor_email')
            ->join('campaigns', 'campaigns.id = donations.campaign_id', 'left')
            ->join('categories', 'categories.id = campaigns.category_id', 'left')
            ->join('users', 'users.id = donations.user_id', 'left')
            ->where('campaigns.foundation_id', $foundation['id']);

        if ($keyword !== '') {
            $builder->groupStart()
                ->like('campaigns.judul', $keyword)
                ->orLike('donations.invoice', $keyword)
                ->groupEnd();
        }

        if ($status !== '') {
            if ($status === 'berhasil') {
                $builder->groupStart()
                    ->whereIn('donations.status', ['berhasil', 'verified', 'success', 'paid'])
                    ->orWhereIn('donations.transaction_status', ['settlement', 'capture'])
                    ->groupEnd();
            } elseif ($status === 'expired') {
                $builder->groupStart()
                    ->where('donations.status', 'expired')
                    ->orWhereIn('donations.transaction_status', ['expire', 'expired'])
                    ->groupEnd();
            } elseif ($status === 'dibatalkan') {
                $builder->groupStart()
                    ->whereIn('donations.status', ['dibatalkan', 'cancel', 'cancelled'])
                    ->orWhere('donations.transaction_status', 'cancel')
                    ->groupEnd();
            } else {
                $builder->where('donations.status', $status);
            }
        }

        $donations = $builder
            ->orderBy('donations.created_at', 'DESC')
            ->limit(75)
            ->get()
            ->getResultArray();

        $campaignIds = array_column($this->campaignModel->where('foundation_id', $foundation['id'])->findAll(), 'id');
        $stats = [
            'total_berhasil' => 0,
            'transaksi_berhasil' => 0,
            'pending' => 0,
        ];

        if (!empty($campaignIds)) {
            $success = $db->table('donations')
                ->select('COALESCE(SUM(nominal), 0) AS total_berhasil, COUNT(id) AS transaksi_berhasil', false)
                ->whereIn('campaign_id', $campaignIds)
                ->groupStart()
                    ->whereIn('status', ['berhasil', 'verified', 'success', 'paid'])
                    ->orWhereIn('transaction_status', ['settlement', 'capture'])
                ->groupEnd()
                ->get()
                ->getRowArray();

            $pending = $db->table('donations')
                ->whereIn('campaign_id', $campaignIds)
                ->groupStart()
                    ->where('status', 'pending')
                    ->orWhere('transaction_status', 'pending')
                ->groupEnd()
                ->countAllResults();

            $stats = [
                'total_berhasil' => (float) ($success['total_berhasil'] ?? 0),
                'transaksi_berhasil' => (int) ($success['transaksi_berhasil'] ?? 0),
                'pending' => (int) $pending,
            ];
        }

        return view('yayasan/donation/index', [
            'donations' => $donations,
            'stats' => $stats,
            'keyword' => $keyword,
            'status' => $status,
        ]);
    }

    public function reports()
    {
        $foundation = $this->getLoggedInFoundation();

        if ($redirect = $this->redirectIfFoundationNotVerified($foundation)) {
            return $redirect;
        }

        $reportModel = new ReportModel();
        $keyword = trim((string) $this->request->getGet('keyword'));
        $status = trim((string) $this->request->getGet('status'));

        $reports = $reportModel->getReportsByFoundation($foundation['id'], $keyword, $status, 10);

        $stats = [
            'total' => $reportModel->baseReportSelect()->where('campaigns.foundation_id', $foundation['id'])->countAllResults(),
            'pending' => $reportModel->baseReportSelect()->where('campaigns.foundation_id', $foundation['id'])->where('reports.status_verifikasi', 'pending')->countAllResults(),
            'approved' => $reportModel->baseReportSelect()->where('campaigns.foundation_id', $foundation['id'])->where('reports.status_verifikasi', 'approved')->countAllResults(),
        ];

        return view('yayasan/report/index', [
            'reports' => $reports,
            'pager' => $reportModel->pager,
            'stats' => $stats,
            'keyword' => $keyword,
            'status' => $status,
        ]);
    }

    public function createReport()
    {
        $foundation = $this->getLoggedInFoundation();

        if ($redirect = $this->redirectIfFoundationNotVerified($foundation)) {
            return $redirect;
        }

        $campaigns = $this->campaignModel
            ->where('foundation_id', $foundation['id'])
            ->where('status', 'aktif')
            ->where('status_verifikasi', 'approved')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('yayasan/report/create', [
            'campaigns' => $campaigns,
        ]);
    }

    public function storeReport()
    {
        $foundation = $this->getLoggedInFoundation();

        if ($redirect = $this->redirectIfFoundationNotVerified($foundation)) {
            return $redirect;
        }

        $rules = [
            'campaign_id' => 'required|numeric',
            'judul_laporan' => 'required|min_length[5]',
            'deskripsi' => 'required|min_length[10]',
            'tanggal_laporan' => 'required|valid_date[Y-m-d]',
            'nama_pengeluaran.*' => 'required',
            'nominal.*' => 'required|numeric',
            'foto.*' => 'permit_empty|max_size[foto.*,4096]|ext_in[foto.*,jpg,jpeg,png,webp,pdf]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $campaign = $this->campaignModel
            ->where('id', $this->request->getPost('campaign_id'))
            ->where('foundation_id', $foundation['id'])
            ->where('status', 'aktif')
            ->where('status_verifikasi', 'approved')
            ->first();

        if (!$campaign) {
            return redirect()->back()->withInput()->with('error', 'Campaign tidak valid atau belum disetujui admin.');
        }

        $names = $this->request->getPost('nama_pengeluaran') ?? [];
        $nominals = $this->request->getPost('nominal') ?? [];
        $notes = $this->request->getPost('keterangan') ?? [];

        $total = 0;
        foreach ($nominals as $nominal) {
            $total += (float) $nominal;
        }

        if ($total <= 0) {
            return redirect()->back()->withInput()->with('error', 'Total pengeluaran harus lebih dari 0.');
        }

        $reportModel = new ReportModel();
        $detailModel = new ReportDetailModel();

        $reportModel->insert([
            'campaign_id' => $campaign['id'],
            'user_id' => session()->get('id'),
            'judul_laporan' => $this->request->getPost('judul_laporan'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'total_pengeluaran' => $total,
            'tanggal_laporan' => $this->request->getPost('tanggal_laporan'),
            'status' => 'draft',
            'status_verifikasi' => 'pending',
            'verified_by' => null,
            'verified_at' => null,
        ]);

        $reportId = $reportModel->getInsertID();
        $uploadPath = FCPATH . 'uploads/laporan';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $files = $this->request->getFiles();
        $uploadedFiles = $files['foto'] ?? [];

        foreach ($names as $i => $name) {
            if (trim((string) $name) === '') {
                continue;
            }

            $fileName = null;
            if (isset($uploadedFiles[$i]) && $uploadedFiles[$i]->isValid() && !$uploadedFiles[$i]->hasMoved()) {
                $fileName = $uploadedFiles[$i]->getRandomName();
                $uploadedFiles[$i]->move($uploadPath, $fileName);
            }

            $detailModel->insert([
                'report_id' => $reportId,
                'nama_pengeluaran' => $name,
                'nominal' => (float) ($nominals[$i] ?? 0),
                'keterangan' => $notes[$i] ?? null,
                'foto' => $fileName,
            ]);
        }

        $this->createNotification(session()->get('id'), 'Laporan dana dikirim', 'Laporan penggunaan dana berhasil dikirim dan menunggu verifikasi admin.', 'info', base_url('yayasan/report/detail/' . $reportId));
        $this->notifyAdmins('Laporan dana menunggu verifikasi', 'Yayasan ' . ($foundation['nama_yayasan'] ?? 'Yayasan') . ' mengirim laporan penggunaan dana untuk campaign "' . ($campaign['judul'] ?? '-') . '".', 'warning', base_url('admin/report/detail/' . $reportId));

        return redirect()->to('/yayasan/report')->with('success', 'Laporan berhasil dikirim dan menunggu verifikasi admin.');
    }

    public function detailReport($id)
    {
        $foundation = $this->getLoggedInFoundation();

        if ($redirect = $this->redirectIfFoundationNotVerified($foundation)) {
            return $redirect;
        }

        $reportModel = new ReportModel();
        $detailModel = new ReportDetailModel();
        $report = $reportModel->getReportDetailForFoundation($id, $foundation['id']);

        if (!$report) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Laporan tidak ditemukan.');
        }

        return view('yayasan/report/detail', [
            'report' => $report,
            'details' => $detailModel->getDetailsByReport($id),
        ]);
    }


    public function editReport($id)
    {
        $foundation = $this->getLoggedInFoundation();

        if ($redirect = $this->redirectIfFoundationNotVerified($foundation)) {
            return $redirect;
        }

        $reportModel = new ReportModel();
        $detailModel = new ReportDetailModel();
        $report = $reportModel->getReportDetailForFoundation($id, $foundation['id']);

        if (!$report) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Laporan tidak ditemukan.');
        }

        if (($report['status_verifikasi'] ?? '') === 'approved') {
            return redirect()->to('/yayasan/report/detail/' . $id)
                ->with('error', 'Laporan yang sudah disetujui tidak dapat diedit. Buat laporan baru jika ada penggunaan dana lanjutan.');
        }

        $campaigns = $this->campaignModel
            ->where('foundation_id', $foundation['id'])
            ->where('status_verifikasi', 'approved')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('yayasan/report/edit', [
            'report' => $report,
            'details' => $detailModel->getDetailsByReport($id),
            'campaigns' => $campaigns,
        ]);
    }

    public function updateReport($id)
    {
        $foundation = $this->getLoggedInFoundation();

        if ($redirect = $this->redirectIfFoundationNotVerified($foundation)) {
            return $redirect;
        }

        $reportModel = new ReportModel();
        $detailModel = new ReportDetailModel();
        $report = $reportModel->getReportDetailForFoundation($id, $foundation['id']);

        if (!$report) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Laporan tidak ditemukan.');
        }

        if (($report['status_verifikasi'] ?? '') === 'approved') {
            return redirect()->to('/yayasan/report/detail/' . $id)
                ->with('error', 'Laporan yang sudah disetujui tidak dapat diedit.');
        }

        $rules = [
            'campaign_id' => 'required|numeric',
            'judul_laporan' => 'required|min_length[5]',
            'deskripsi' => 'required|min_length[10]',
            'tanggal_laporan' => 'required|valid_date[Y-m-d]',
            'nama_pengeluaran.*' => 'required',
            'nominal.*' => 'required|numeric',
            'foto.*' => 'permit_empty|max_size[foto.*,4096]|ext_in[foto.*,jpg,jpeg,png,webp,pdf]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $campaign = $this->campaignModel
            ->where('id', $this->request->getPost('campaign_id'))
            ->where('foundation_id', $foundation['id'])
            ->where('status_verifikasi', 'approved')
            ->first();

        if (!$campaign) {
            return redirect()->back()->withInput()->with('error', 'Campaign tidak valid atau belum disetujui admin.');
        }

        $names = $this->request->getPost('nama_pengeluaran') ?? [];
        $nominals = $this->request->getPost('nominal') ?? [];
        $notes = $this->request->getPost('keterangan') ?? [];
        $oldPhotos = $this->request->getPost('old_foto') ?? [];

        $total = 0;
        foreach ($nominals as $nominal) {
            $total += (float) $nominal;
        }

        if ($total <= 0) {
            return redirect()->back()->withInput()->with('error', 'Total pengeluaran harus lebih dari 0.');
        }

        $reportModel->update($id, [
            'campaign_id' => $campaign['id'],
            'judul_laporan' => $this->request->getPost('judul_laporan'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'total_pengeluaran' => $total,
            'tanggal_laporan' => $this->request->getPost('tanggal_laporan'),
            'status' => 'draft',
            'status_verifikasi' => 'pending',
            'verified_by' => null,
            'verified_at' => null,
        ]);

        $uploadPath = FCPATH . 'uploads/laporan';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $files = $this->request->getFiles();
        $uploadedFiles = $files['foto'] ?? [];

        $detailModel->where('report_id', $id)->delete();

        foreach ($names as $i => $name) {
            if (trim((string) $name) === '') {
                continue;
            }

            $fileName = $oldPhotos[$i] ?? null;
            if (isset($uploadedFiles[$i]) && $uploadedFiles[$i]->isValid() && !$uploadedFiles[$i]->hasMoved()) {
                $fileName = $uploadedFiles[$i]->getRandomName();
                $uploadedFiles[$i]->move($uploadPath, $fileName);
            }

            $detailModel->insert([
                'report_id' => $id,
                'nama_pengeluaran' => $name,
                'nominal' => (float) ($nominals[$i] ?? 0),
                'keterangan' => $notes[$i] ?? null,
                'foto' => $fileName ?: null,
            ]);
        }

        $this->createNotification(session()->get('id'), 'Perbaikan laporan dikirim', 'Perbaikan laporan penggunaan dana berhasil dikirim ulang dan menunggu verifikasi admin.', 'info', base_url('yayasan/report/detail/' . $id));
        $this->notifyAdmins('Perbaikan laporan menunggu verifikasi', 'Yayasan ' . ($foundation['nama_yayasan'] ?? 'Yayasan') . ' mengirim ulang perbaikan laporan dana untuk campaign "' . ($campaign['judul'] ?? '-') . '".', 'warning', base_url('admin/report/detail/' . $id));

        return redirect()->to('/yayasan/report/detail/' . $id)->with('success', 'Perbaikan laporan berhasil dikirim ulang dan menunggu verifikasi admin.');
    }

    public function adminReports()
    {
        $reportModel = new ReportModel();
        $keyword = trim((string) $this->request->getGet('keyword'));
        $status = trim((string) $this->request->getGet('status'));

        return view('admin/report/index', [
            'reports' => $reportModel->getAdminReports($keyword, $status, 15),
            'pager' => $reportModel->pager,
            'keyword' => $keyword,
            'status' => $status,
        ]);
    }

    public function adminReportDetail($id)
    {
        $reportModel = new ReportModel();
        $detailModel = new ReportDetailModel();
        $report = $reportModel->getAdminReportDetail($id);

        if (!$report) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Laporan tidak ditemukan.');
        }

        return view('admin/report/detail', [
            'report' => $report,
            'details' => $detailModel->getDetailsByReport($id),
        ]);
    }

    public function approveReport($id)
    {
        $reportModel = new ReportModel();
        $report = $reportModel->getAdminReportDetail($id);

        if (!$report) {
            return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
        }

        $reportModel->update($id, [
            'status' => 'published',
            'status_verifikasi' => 'approved',
            'verified_by' => session()->get('id'),
            'verified_at' => date('Y-m-d H:i:s'),
        ]);

        $this->createNotification($report['foundation_user_id'] ?? $report['user_id'] ?? null, 'Laporan dana disetujui', 'Laporan penggunaan dana Anda telah disetujui dan dipublikasikan.', 'success', base_url('yayasan/report/detail/' . $id));

        return redirect()->to('/admin/report/detail/' . $id)->with('success', 'Laporan berhasil disetujui.');
    }

    public function rejectReport($id)
    {
        $reportModel = new ReportModel();
        $report = $reportModel->getAdminReportDetail($id);

        if (!$report) {
            return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
        }

        $reportModel->update($id, [
            'status' => 'draft',
            'status_verifikasi' => 'rejected',
            'verified_by' => session()->get('id'),
            'verified_at' => date('Y-m-d H:i:s'),
        ]);

        $this->createNotification($report['foundation_user_id'] ?? $report['user_id'] ?? null, 'Laporan dana perlu perbaikan', 'Admin meminta perbaikan laporan penggunaan dana. Silakan cek detail laporan.', 'warning', base_url('yayasan/report/detail/' . $id));

        return redirect()->to('/admin/report/detail/' . $id)->with('success', 'Laporan ditandai perlu perbaikan.');
    }
}
