<?php

namespace App\Controllers;

use App\Models\FoundationModel;
use App\Models\CampaignModel;
use App\Models\DonationModel;
use App\Models\CategoryModel;



class FoundationController extends BaseController
{
    protected $foundationModel;
    protected $campaignModel;
    protected $donationModel;
    protected $categoryModel;



    public function __construct()
    {
        $this->foundationModel = new FoundationModel();
        $this->campaignModel = new CampaignModel();
        $this->donationModel = new DonationModel();
    $this->categoryModel = new CategoryModel();
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

    $data = [
        'foundations' => $builder->findAll(),
        'keyword'     => $keyword,
        'status'      => $status,
    ];

    return view('admin/yayasan/index', $data);
}

   
public function dashboard()
{
    $foundationId = session()->get('foundation_id');

    // Total campaign milik yayasan
    $totalCampaign = $this->campaignModel
        ->where('foundation_id', $foundationId)
        ->countAllResults();

    // Campaign aktif
    $campaignAktif = $this->campaignModel
        ->where('foundation_id', $foundationId)
        ->where('status', 'aktif')
        ->countAllResults();

    // Ambil semua campaign yayasan
    $campaignIds = $this->campaignModel
        ->where('foundation_id', $foundationId)
        ->findColumn('id');

    $foundation = $this->foundationModel
    ->where('user_id', session()->get('id'))
    ->first();

$foundationId = $foundation['id'];

    $totalDana = 0;
    $totalDonatur = 0;

    if (!empty($campaignIds)) {
        $donasi = $this->donationModel
            ->whereIn('campaign_id', $campaignIds)
            ->where('status', 'berhasil')
            ->findAll();

        $totalDana = array_sum(array_column($donasi, 'nominal'));
        $totalDonatur = count(array_unique(array_column($donasi, 'user_id')) );
    }

    return view('yayasan/dashboard', [
        'totalCampaign' => $totalCampaign,
        'campaignAktif' => $campaignAktif,
        'totalDana' => $totalDana,
        'totalDonatur' => $totalDonatur
    ]);
}
    /*
    |--------------------------------------------------------------------------
    | Form Profil Yayasan
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $foundation = $this->foundationModel
            ->where('user_id', session()->get('user_id'))
            ->first();

        return view('yayasan/register_profile', [
            'foundation' => $foundation
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Profil Yayasan
    |--------------------------------------------------------------------------
    */

    public function store()
    {

        $rules = [

            'nama_yayasan' => 'required|min_length[5]',
            'email_yayasan' => 'required|valid_email',
            'telepon' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'nomor_izin' => 'required',

            'logo' => [
                'rules' => 'uploaded[logo]|is_image[logo]|max_size[logo,2048]',
                'errors' => [
                    'uploaded' => 'Logo wajib diupload.'
                ]
            ],

            'dokumen_verifikasi' => [
                'rules' => 'uploaded[dokumen_verifikasi]|ext_in[dokumen_verifikasi,pdf]|max_size[dokumen_verifikasi,4096]',
                'errors' => [
                    'uploaded' => 'Dokumen legalitas wajib diupload.'
                ]
            ],

        ];

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Logo
        |--------------------------------------------------------------------------
        */

        $logo = $this->request->getFile('logo');

        $logoName = $logo->getRandomName();

        $logo->move('uploads/logo', $logoName);

        /*
        |--------------------------------------------------------------------------
        | Upload PDF
        |--------------------------------------------------------------------------
        */

        $pdf = $this->request->getFile('dokumen_verifikasi');

        $pdfName = $pdf->getRandomName();

        $pdf->move('uploads/legalitas', $pdfName);

        /*
        |--------------------------------------------------------------------------
        | Simpan Database
        |--------------------------------------------------------------------------
        */

        $this->foundationModel->insert([

            'user_id' => session()->get('user_id'),

            'nama_yayasan' => $this->request->getPost('nama_yayasan'),

            'email_yayasan' => $this->request->getPost('email_yayasan'),

            'telepon' => $this->request->getPost('telepon'),

            'alamat' => $this->request->getPost('alamat'),

            'deskripsi' => $this->request->getPost('deskripsi'),

            'nomor_izin' => $this->request->getPost('nomor_izin'),

            'logo' => $logoName,

            'dokumen_verifikasi' => $pdfName,

            'status' => 'pending'

        ]);

        return redirect()->to('/yayasan/status')
            ->with('success', 'Profil berhasil dikirim.');
    }

    /*
    |--------------------------------------------------------------------------
    | Status Verifikasi
    |--------------------------------------------------------------------------
    */

    public function status()
    {

        $foundation = $this->foundationModel
            ->where('user_id', session()->get('user_id'))
            ->first();

        return view('yayasan/status', [
            'foundation' => $foundation
        ]);
    }
    // ================
    // ADMIN 
    // ================
    public function adminList()
    {
        $model = new \App\Models\FoundationModel();

        $data['foundations'] = $model
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

    return view('admin/yayasan/detail', [
        'foundation' => $foundation
    ]);
}

 public function approve($id)
{
    $foundation = $this->foundationModel->find($id);

    if (!$foundation) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    $this->foundationModel->update($id, [
        'status' => 'verified',
        'verified_by' => session()->get('id'),
        'verified_at' => date('Y-m-d H:i:s')
    ]);

    return redirect()->to('/admin/yayasan')
                     ->with('success', 'Yayasan berhasil diverifikasi');
}

    public function reject(int $id)
    {
        $model = new \App\Models\FoundationModel();

        $model->update($id,[

            'status'=>'rejected',

            'verified_by'=>session()->get('id'),

            'verified_at'=>date('Y-m-d H:i:s')

        ]);

        return redirect()
                ->to('/admin/yayasan')
                ->with('success','Pengajuan ditolak.');
    } 
    public function delete($id)
{
    $foundation = $this->foundationModel->find($id);

    if (!$foundation) {
        return redirect()->back()->with('error', 'Data yayasan tidak ditemukan.');
    }

    $this->foundationModel->delete($id);

    return redirect()->to('/admin/yayasan')
        ->with('success', 'Data yayasan berhasil dihapus.');
}
    

public function myCampaign()
{
    $foundation = $this->foundationModel
        ->where('user_id', session()->get('id'))
        ->first();

    if (!$foundation) {
        return redirect()->back()->with('error', 'Profil yayasan belum dibuat.');
    }

    $campaigns = $this->campaignModel
        ->where('foundation_id', $foundation['id'])
        ->findAll();

    return view('yayasan/campaign/index', [
        'campaigns' => $campaigns
    ]);
}
public function detailCampaign($id)
{
    $foundation = $this->foundationModel
        ->where('user_id', session()->get('id'))
        ->first();

    if (!$foundation) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Profil yayasan belum dibuat.');
    }

    $campaign = $this->campaignModel
        ->where('id', $id)
        ->where('foundation_id', $foundation['id'])
        ->first();

    if (!$campaign) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Campaign tidak ditemukan.');
    }

    return view('yayasan/campaign/detail', [
        'campaign' => $campaign
    ]);
}

public function createCampaign()
{
    return view('yayasan/campaign/create', [
        'categories' => $this->categoryModel->findAll()
    ]);
}

public function storeCampaign()
{
    // ==========================================================
    // Validasi Input
    // ==========================================================
    $rules = [

        'judul'            => 'required',

        'deskripsi'        => 'required',
        'target_dana'    => 'required|numeric',
        'tanggal_mulai'    => 'required',
        'tanggal_berakhir'  => 'required',

        'gambar' => [
            'rules' => 'permit_empty|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,2048]',
            'errors' => [
                'is_image' => 'File harus berupa gambar.',
                'mime_in'  => 'Format gambar harus JPG, JPEG atau PNG.',
                'max_size' => 'Ukuran gambar maksimal 2 MB.'
            ]
        ]

    ];

    if (!$this->validate($rules)) {

        return redirect()
            ->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());

    }

    // ==========================================================
    // Ambil Data Yayasan Berdasarkan User Login
    // ==========================================================
    $foundation = $this->foundationModel
        ->where('user_id', session()->get('id'))
        ->first();

    if (!$foundation) {

        return redirect()
            ->back()
            ->with('error', 'Profil yayasan belum dibuat.');

    }

    // ==========================================================
    // Upload Gambar
    // ==========================================================
    $gambar = $this->request->getFile('gambar');

    $namaGambar = null;

    if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {

        $namaGambar = $gambar->getRandomName();

        $gambar->move(
            FCPATH . 'uploads/campaign',
            $namaGambar
        );

    }

    // ==========================================================
    // Simpan Data Campaign
    // ==========================================================
    $this->campaignModel->save([

    'foundation_id'      => $foundation['id'],

    'category_id'        => $this->request->getPost('category_id'),

    'judul'              => $this->request->getPost('judul'),

    'slug'               => url_title(
                                $this->request->getPost('judul'),
                                '-',
                                true
                            ),

    'deskripsi'          => $this->request->getPost('deskripsi'),

    'target_dana'        => $this->request->getPost('target_dana'),

    'dana_terkumpul'     => 0,

    'gambar'             => $namaGambar,

    'tanggal_mulai'      => $this->request->getPost('tanggal_mulai'),

    'tanggal_berakhir'   => $this->request->getPost('tanggal_berakhir'),

    'status'             => 'aktif',

    'status_verifikasi'  => 'pending',

    'jumlah_donatur'     => 0,

    'views'              => 0
]);

    // ==========================================================
    // Redirect
    // ==========================================================
    return redirect()
        ->to('/yayasan/campaign/index')
        ->with(
            'success',
            'Campaign berhasil dibuat dan menunggu persetujuan Admin.'
        );
}

public function editCampaign($id)
{
    $campaign = $this->campaignModel
        ->where('id', $id)
        ->where('foundation_id', session()->get('foundation_id'))
        ->first();

    if (!$campaign) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    return view('yayasan/campaign/edit', [
        'campaign'   => $campaign,
        'categories' => $this->categoryModel->findAll()
    ]);
}
public function updateCampaign($id)
{
     
    $campaign = $this->campaignModel
        ->where('id',$id)
        ->where('foundation_id', session()->get('foundation_id'))
        ->first();

    if(!$campaign){

        return redirect()->back()
                         ->with('error','Campaign tidak ditemukan.');

    }

    $slug = url_title(
        $this->request->getPost('judul'),
        '-',
        true
    );
    $gambar = $this->request->getFile('gambar');
    $namaGambar = $campaign['gambar'];
    if($gambar && $gambar->isValid() && !$gambar->hasMoved())
{

    if(!empty($campaign['gambar']))
    {

        $old = FCPATH.'uploads/campaign/'.$campaign['gambar'];

        if(file_exists($old))
        {

            unlink($old);

        }

    }

    $namaGambar = $gambar->getRandomName();

    $gambar->move(

        FCPATH.'uploads/campaign',

        $namaGambar

    );

}

    $this->campaignModel->update($id,[

    'judul'             => $this->request->getPost('judul'),

    'slug'              => $slug,

    'category_id'       => $this->request->getPost('category_id'),

    'deskripsi'         => $this->request->getPost('deskripsi'),

    'target_dana'       => $this->request->getPost('target_dana'),

    'tanggal_mulai'     => $this->request->getPost('tanggal_mulai'),

    'tanggal_berakhir'  => $this->request->getPost('tanggal_berakhir'),

    'gambar'            => $namaGambar,

]);

    return redirect()->route('yayasan/campaign/index')
                     ->with('success','Campaign berhasil diperbarui.');
}

public function deleteCampaign($id)
{
    $campaign = $this->campaignModel
        ->where('id', $id)
        ->where('foundation_id', session()->get('foundation_id'))
        ->first();

    if (!$campaign) {
        return redirect()
            ->back()
            ->with('error', 'Campaign tidak ditemukan.');
    }

    // Hapus gambar jika ada
    if (!empty($campaign['gambar'])) {

        $path = FCPATH . 'uploads/campaign/' . $campaign['gambar'];

        if (file_exists($path)) {
            unlink($path);
        }
    }

    $this->campaignModel->delete($id);

    return redirect()
        ->to('yayasan/campaign/index')
        ->with('success', 'Campaign berhasil dihapus.');
}


public function donations()
{
    $foundationId = session()->get('foundation_id');

    $donations = $this->donationModel
        ->select('
            donations.*,
            campaigns.judul,
            users.nama
        ')
        ->join('campaigns', 'campaigns.id = donations.campaign_id')
        ->join('users', 'users.id = donations.user_id')
        ->where('campaigns.foundation_id', $foundationId)
        ->orderBy('donations.created_at', 'DESC')
        ->findAll();

    return view('yayasan/donation/index', [
        'donations' => $donations
    ]);
}
}

