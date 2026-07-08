<?php

namespace App\Controllers;

use App\Models\CampaignModel;
use App\Models\FoundationModel;
use App\Models\CategoryModel;
use App\Models\CampaignImageModel;
use App\Models\NotificationModel;

class CampaignController extends BaseController
{
    protected $campaignModel;
    protected $foundationModel;
    protected $categoryModel;
    protected $campaignImageModel;
    protected $notificationModel;

    public function __construct()
    {
        $this->campaignModel = new CampaignModel();
        $this->foundationModel = new FoundationModel();
        $this->categoryModel = new CategoryModel();
        $this->campaignImageModel = new CampaignImageModel();

        if (class_exists(NotificationModel::class)) {
            $this->notificationModel = new NotificationModel();
        }
    }

    private function createNotification($userId, $title, $message, $type = 'info', $link = null)
    {
        if (empty($userId) || !$this->notificationModel) {
            return;
        }

        try {
            $this->notificationModel->insert([
                'user_id' => $userId,
                'title'   => $title,
                'message' => $message,
                'type'    => $type,
                'link'    => $link,
                'is_read' => 0,
            ]);
        } catch (\Throwable $e) {
            // Notifikasi tidak boleh membuat proses utama gagal.
        }
    }

    private function getCampaignWithRelations($id)
    {
        return $this->campaignModel
            ->select('campaigns.*, foundations.nama_yayasan, foundations.email_yayasan, foundations.user_id AS foundation_user_id, categories.nama_kategori')
            ->join('foundations', 'foundations.id = campaigns.foundation_id', 'left')
            ->join('categories', 'categories.id = campaigns.category_id', 'left')
            ->where('campaigns.id', $id)
            ->first();
    }

    private function getPostValue($primary, $fallback = null)
    {
        $value = $this->request->getPost($primary);

        if (($value === null || $value === '') && $fallback) {
            $value = $this->request->getPost($fallback);
        }

        return is_string($value) ? trim($value) : $value;
    }

    private function normalizeNumber($value)
    {
        $value = (string) $value;
        $value = preg_replace('/[^0-9]/', '', $value);

        return $value === '' ? 0 : (float) $value;
    }

    private function campaignPostData()
    {
        return [
            'foundation_id'       => $this->getPostValue('foundation_id'),
            'category_id'         => $this->getPostValue('category_id'),
            'judul'               => $this->getPostValue('judul'),
            'deskripsi'           => $this->getPostValue('deskripsi'),
            'target_dana'         => $this->normalizeNumber($this->getPostValue('target_dana', 'target_donasi')),
            'lokasi'              => $this->getPostValue('lokasi'),
            'tanggal_mulai'       => $this->getPostValue('tanggal_mulai'),
            'tanggal_berakhir'    => $this->getPostValue('tanggal_berakhir', 'tanggal_selesai'),
            'status'              => $this->getPostValue('status') ?: 'aktif',
            'status_verifikasi'   => $this->getPostValue('status_verifikasi') ?: 'approved',
        ];
    }

    private function validateCampaignData(array $data)
    {
        $errors = [];

        if (empty($data['foundation_id'])) {
            $errors[] = 'Yayasan wajib dipilih.';
        }

        if (empty($data['category_id'])) {
            $errors[] = 'Kategori wajib dipilih.';
        }

        if (empty($data['judul'])) {
            $errors[] = 'Judul campaign wajib diisi.';
        }

        if (empty($data['deskripsi'])) {
            $errors[] = 'Deskripsi campaign wajib diisi.';
        }

        if ((float) $data['target_dana'] <= 0) {
            $errors[] = 'Target dana harus lebih dari 0.';
        }

        if (empty($data['tanggal_mulai'])) {
            $errors[] = 'Tanggal mulai wajib diisi.';
        }

        if (empty($data['tanggal_berakhir'])) {
            $errors[] = 'Tanggal berakhir wajib diisi.';
        }

        if (!empty($data['tanggal_mulai']) && !empty($data['tanggal_berakhir']) && $data['tanggal_berakhir'] < $data['tanggal_mulai']) {
            $errors[] = 'Tanggal berakhir tidak boleh lebih kecil dari tanggal mulai.';
        }

        if (!in_array($data['status'], ['draft', 'aktif', 'selesai'], true)) {
            $errors[] = 'Status campaign tidak valid.';
        }

        if (!in_array($data['status_verifikasi'], ['pending', 'approved', 'rejected'], true)) {
            $errors[] = 'Status verifikasi tidak valid.';
        }

        return $errors;
    }

    private function uploadCampaignImage($oldImage = null)
    {
        $gambar = $this->request->getFile('gambar');

        if (!$gambar || $gambar->getError() === UPLOAD_ERR_NO_FILE) {
            return $oldImage;
        }

        if (!$gambar->isValid()) {
            throw new \RuntimeException('Gambar campaign tidak valid atau gagal diupload.');
        }

        if (!str_starts_with((string) $gambar->getMimeType(), 'image/')) {
            throw new \RuntimeException('File campaign harus berupa gambar.');
        }

        if ($gambar->getSizeByUnit('mb') > 5) {
            throw new \RuntimeException('Ukuran gambar campaign maksimal 5 MB.');
        }

        $uploadPath = FCPATH . 'uploads/campaign';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        if ($oldImage) {
            $oldPaths = [
                FCPATH . 'uploads/campaign/' . $oldImage,
                FCPATH . 'uploads/campaigns/' . $oldImage,
            ];

            foreach ($oldPaths as $oldPath) {
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
        }

        $newName = $gambar->getRandomName();
        $gambar->move($uploadPath, $newName);

        return $newName;
    }

    private function hasDonationActivity(array $campaign)
    {
        if ((float) ($campaign['dana_terkumpul'] ?? 0) > 0) {
            return true;
        }

        if ((int) ($campaign['jumlah_donatur'] ?? 0) > 0) {
            return true;
        }

        try {
            $db = db_connect();

            if (!$db->tableExists('donations')) {
                return false;
            }

            $count = $db->table('donations')
                ->where('campaign_id', $campaign['id'])
                ->countAllResults();

            return $count > 0;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - Kelola Campaign
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $status  = $this->request->getGet('status');

        $campaigns = $this->campaignModel->filterCampaign($keyword, $status);

        return view('admin/campaign/index', [
            'campaigns' => $campaigns,
            'keyword'   => $keyword,
            'status'    => $status,
        ]);
    }

    public function adminList()
    {
        return $this->index();
    }

    public function create()
    {
        return view('admin/campaign/create', [
            'foundations' => $this->foundationModel
                ->where('status', 'verified')
                ->findAll(),
            'categories' => $this->categoryModel->findAll(),
        ]);
    }

    public function store()
    {
        $data = $this->campaignPostData();
        $errors = $this->validateCampaignData($data);

        if (!empty($errors)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $errors));
        }

        try {
            $namaGambar = $this->uploadCampaignImage(null);
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        if (($data['status_verifikasi'] ?? '') !== 'approved') {
            $data['status'] = 'draft';
        } elseif (empty($data['status']) || $data['status'] === 'draft') {
            $data['status'] = 'aktif';
        }

        $verifiedBy = null;
        $verifiedAt = null;

        if ($data['status_verifikasi'] === 'approved' || $data['status_verifikasi'] === 'rejected') {
            $verifiedBy = session()->get('id');
            $verifiedAt = date('Y-m-d H:i:s');
        }

        $this->campaignModel->insert([
            'foundation_id'       => $data['foundation_id'],
            'category_id'         => $data['category_id'],
            'judul'               => $data['judul'],
            'slug'                => url_title($data['judul'], '-', true),
            'deskripsi'           => $data['deskripsi'],
            'target_dana'         => $data['target_dana'],
            'dana_terkumpul'      => 0,
            'gambar'              => $namaGambar,
            'lokasi'              => $data['lokasi'],
            'tanggal_mulai'       => $data['tanggal_mulai'],
            'tanggal_berakhir'    => $data['tanggal_berakhir'],
            'status'              => $data['status'],
            'status_verifikasi'   => $data['status_verifikasi'],
            'verified_by'         => $verifiedBy,
            'verified_at'         => $verifiedAt,
            'jumlah_donatur'      => 0,
            'views'               => 0,
        ]);

        return redirect()
            ->to('/admin/campaign')
            ->with('success', 'Campaign berhasil ditambahkan.');
    }

    public function detail($id)
    {
        $campaign = $this->getCampaignWithRelations($id);

        if (!$campaign) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Campaign tidak ditemukan.');
        }

        $campaignImages = $this->campaignImageModel
            ->where('campaign_id', $id)
            ->orderBy('is_cover', 'DESC')
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        return view('admin/campaign/detail', [
            'campaign'       => $campaign,
            'campaignImages' => $campaignImages,
            'hasDonation'    => $this->hasDonationActivity($campaign),
        ]);
    }

    public function edit($id)
    {
        $campaign = $this->campaignModel->find($id);

        if (!$campaign) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Campaign tidak ditemukan.');
        }

        return view('admin/campaign/edit', [
            'campaign'    => $campaign,
            'foundations' => $this->foundationModel
                ->where('status', 'verified')
                ->findAll(),
            'categories'  => $this->categoryModel->findAll(),
            'hasDonation' => $this->hasDonationActivity($campaign),
        ]);
    }

    public function update($id)
    {
        $campaign = $this->campaignModel->find($id);

        if (!$campaign) {
            return redirect()
                ->to('/admin/campaign')
                ->with('error', 'Campaign tidak ditemukan.');
        }

        $data = $this->campaignPostData();
        $errors = $this->validateCampaignData($data);

        if ($this->hasDonationActivity($campaign) && $data['status_verifikasi'] === 'rejected') {
            $errors[] = 'Campaign yang sudah memiliki donasi tidak boleh ditolak agar riwayat donasi tetap aman.';
        }

        if (!empty($errors)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $errors));
        }

        if (($data['status_verifikasi'] ?? '') !== 'approved') {
            $data['status'] = 'draft';
        } elseif (empty($data['status']) || $data['status'] === 'draft') {
            $data['status'] = 'aktif';
        }

        try {
            $namaGambar = $this->uploadCampaignImage($campaign['gambar'] ?? null);
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        $updateData = [
            'foundation_id'       => $data['foundation_id'],
            'category_id'         => $data['category_id'],
            'judul'               => $data['judul'],
            'slug'                => url_title($data['judul'], '-', true),
            'deskripsi'           => $data['deskripsi'],
            'target_dana'         => $data['target_dana'],
            'lokasi'              => $data['lokasi'],
            'tanggal_mulai'       => $data['tanggal_mulai'],
            'tanggal_berakhir'    => $data['tanggal_berakhir'],
            'gambar'              => $namaGambar,
            'status'              => $data['status'],
            'status_verifikasi'   => $data['status_verifikasi'],
        ];

        if (($campaign['status_verifikasi'] ?? null) !== $data['status_verifikasi']) {
            $updateData['verified_by'] = session()->get('id');
            $updateData['verified_at'] = date('Y-m-d H:i:s');
        }

        $this->campaignModel->update($id, $updateData);

        $campaignRel = $this->getCampaignWithRelations($id);
        $this->createNotification(
            $campaignRel['foundation_user_id'] ?? null,
            'Campaign diperbarui admin',
            'Campaign "' . ($campaignRel['judul'] ?? '-') . '" telah diperbarui oleh admin.',
            'info',
            base_url('yayasan/campaign/detail/' . $id)
        );

        return redirect()
            ->to('/admin/campaign')
            ->with('success', 'Campaign berhasil diperbarui.');
    }

    public function approve($id)
    {
        $campaign = $this->getCampaignWithRelations($id);

        if (!$campaign) {
            return redirect()
                ->back()
                ->with('error', 'Campaign tidak ditemukan.');
        }

        $this->campaignModel->update($id, [
            'status_verifikasi' => 'approved',
            'status'            => 'aktif',
            'verified_by'       => session()->get('id'),
            'verified_at'       => date('Y-m-d H:i:s'),
        ]);

        $this->createNotification(
            $campaign['foundation_user_id'] ?? null,
            'Campaign disetujui',
            'Campaign "' . ($campaign['judul'] ?? '-') . '" telah disetujui admin dan sekarang aktif menerima donasi.',
            'success',
            base_url('yayasan/campaign/index')
        );

        return redirect()
            ->back()
            ->with('success', 'Campaign berhasil disetujui dan status di akun yayasan menjadi Aktif.');
    }

    public function reject($id)
    {
        $campaign = $this->getCampaignWithRelations($id);

        if (!$campaign) {
            return redirect()
                ->back()
                ->with('error', 'Campaign tidak ditemukan.');
        }

        if ($this->hasDonationActivity($campaign)) {
            return redirect()
                ->back()
                ->with('error', 'Campaign yang sudah memiliki donasi tidak boleh ditolak agar riwayat donasi tetap aman.');
        }

        $this->campaignModel->update($id, [
            'status_verifikasi' => 'rejected',
            'status'            => 'draft',
            'verified_by'       => session()->get('id'),
            'verified_at'       => date('Y-m-d H:i:s'),
        ]);

        $this->createNotification(
            $campaign['foundation_user_id'] ?? null,
            'Campaign ditolak',
            'Campaign "' . ($campaign['judul'] ?? '-') . '" ditolak admin. Silakan perbaiki dan ajukan ulang.',
            'danger',
            base_url('yayasan/campaign/edit/' . $id)
        );

        return redirect()
            ->back()
            ->with('success', 'Campaign berhasil ditolak.');
    }

    public function delete($id)
    {
        $campaign = $this->campaignModel->find($id);

        if (!$campaign) {
            return redirect()
                ->back()
                ->with('error', 'Campaign tidak ditemukan.');
        }

        if ($this->hasDonationActivity($campaign)) {
            return redirect()
                ->back()
                ->with('error', 'Campaign yang sudah memiliki donasi tidak boleh dihapus agar data donasi tidak rusak.');
        }

        $images = $this->campaignImageModel
            ->where('campaign_id', $id)
            ->findAll();

        foreach ($images as $image) {
            $paths = [
                FCPATH . 'uploads/campaign/' . ($image['image'] ?? ''),
                FCPATH . 'uploads/campaigns/' . ($image['image'] ?? ''),
            ];

            foreach ($paths as $path) {
                if (!empty($image['image']) && file_exists($path)) {
                    @unlink($path);
                }
            }

            $this->campaignImageModel->delete($image['id']);
        }

        if (!empty($campaign['gambar'])) {
            $paths = [
                FCPATH . 'uploads/campaign/' . $campaign['gambar'],
                FCPATH . 'uploads/campaigns/' . $campaign['gambar'],
            ];

            foreach ($paths as $path) {
                if (file_exists($path)) {
                    @unlink($path);
                }
            }
        }

        $this->campaignModel->delete($id);

        return redirect()
            ->to('/admin/campaign')
            ->with('success', 'Campaign berhasil dihapus.');
    }
}
