<?php

namespace App\Controllers;

use App\Models\CampaignModel;
use App\Models\FoundationModel;
use App\Models\CategoryModel;


class CampaignController extends BaseController
{
    protected $campaignModel;
    protected $foundationModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->campaignModel = new CampaignModel();
        $this->foundationModel = new FoundationModel();
        $this->categoryModel = new CategoryModel();
    }
    /*
    |--------------------------------------------------------------------------
    | Yayasan
    |--------------------------------------------------------------------------
    */
public function index()
{
    $keyword = $this->request->getGet('keyword');
    $status  = $this->request->getGet('status');

    $campaigns = $this->campaignModel
                      ->filterCampaign($keyword, $status);

    return view('admin/campaign/index', [

        'campaigns' => $campaigns,

        'keyword' => $keyword,

        'status' => $status

    ]);
}
public function create()
{
    $data = [

        'foundations' => $this->foundationModel
                                ->where('status','verified')
                                ->findAll(),

        'categories' => $this->categoryModel
                                ->findAll()

    ];

    return view('admin/campaign/create',$data);
}

   public function store()
{
    $gambar = $this->request->getFile('gambar');

    $namaGambar = null;

    if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {

        $namaGambar = $gambar->getRandomName();

        $gambar->move(ROOTPATH.'public/uploads/campaigns', $namaGambar);

    }

    $this->campaignModel->save([

        'foundation_id' => $this->request->getPost('foundation_id'),

        'category_id' => $this->request->getPost('category_id'),

        'judul' => $this->request->getPost('judul'),

        'slug' => url_title(
            $this->request->getPost('judul'),
            '-',
            true
        ),

        'deskripsi' => $this->request->getPost('deskripsi'),

        'target_donasi' => $this->request->getPost('target_donasi'),

        'terkumpul' => 0,

        'gambar' => $namaGambar,

        'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),

        'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),

        'status' => 'aktif'

    ]);

    return redirect()->to('/admin/campaign')
                     ->with('success','Campaign berhasil ditambahkan');
}

    public function detail($id)
    {
        $campaign = $this->campaignModel->find($id);

        return view('admin/campaign/detail', [
            'campaign' => $campaign
        ]);
    }

public function edit($id)
{
    $campaign = $this->campaignModel->find($id);

    if(!$campaign){
        throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }

    return view('admin/campaign/edit',[

        'campaign'=>$campaign,

        'foundations'=>$this->foundationModel
                            ->where('status','verified')
                            ->findAll(),

        'categories'=>$this->categoryModel
                            ->findAll()

    ]);
}

public function update($id)
{
    $campaign = $this->campaignModel->find($id);

$gambar = $this->request->getFile('gambar');

$namaGambar = $campaign['gambar'];

if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {

    if ($namaGambar &&
        file_exists(ROOTPATH.'public/uploads/campaigns/'.$namaGambar))
    {
        unlink(ROOTPATH.'public/uploads/campaigns/'.$namaGambar);
    }

    $namaGambar = $gambar->getRandomName();

    $gambar->move(
        ROOTPATH.'public/uploads/campaigns',
        $namaGambar
    );
}
    $this->campaignModel->update($id, [

        'foundation_id'   => $this->request->getPost('foundation_id'),
        'category_id'     => $this->request->getPost('category_id'),
        'judul'           => $this->request->getPost('judul'),
        'slug'            => url_title($this->request->getPost('judul'), '-', true),
        'deskripsi'       => $this->request->getPost('deskripsi'),
        'target_donasi'   => $this->request->getPost('target_donasi'),
        'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
        'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
        'gambar'=>$namaGambar,
        'status'=>$this->request->getPost('status')
        

    ]);

    return redirect()->to('/admin/campaign')
                     ->with('success', 'Campaign berhasil diperbarui.');
              

}

    public function delete($id)
{
    $campaign = $this->campaignModel->find($id);

    if (!$campaign) {
        return redirect()->back()
                         ->with('error', 'Campaign tidak ditemukan.');
    }

    $this->campaignModel->delete($id);

    return redirect()->to('/admin/campaign')
                     ->with('success', 'Campaign berhasil dihapus.');
}

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    public function adminList()
    {
        $campaigns = $this->campaignModel->findAll();

        return view('admin/campaign/index', [

            'campaigns' => $campaigns

        ]);
    }

    public function approve($id)
    {
        $this->campaignModel->update($id, [

            'status_verifikasi' => 'approved',

            'verified_by' => session()->get('id'),

            'verified_at' => date('Y-m-d H:i:s')

        ]);

        return redirect()->back()
            ->with('success', 'Campaign disetujui.');
    }

    public function reject($id)
    {
        $this->campaignModel->update($id, [

            'status_verifikasi' => 'rejected',

            'verified_by' => session()->get('id'),

            'verified_at' => date('Y-m-d H:i:s')

        ]);

        return redirect()->back()
            ->with('success', 'Campaign ditolak.');
    }

    
}