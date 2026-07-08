<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\CampaignModel;

class CategoryController extends BaseController
{
    protected $categoryModel;
    protected $campaignModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->campaignModel = new CampaignModel();
    }

    private function categoryData()
    {
        return [
            'nama_kategori' => trim((string) $this->request->getPost('nama_kategori')),
            'deskripsi'     => trim((string) $this->request->getPost('deskripsi')),
            'icon'          => trim((string) $this->request->getPost('icon')),
        ];
    }

    private function validateCategory(array $data)
    {
        $errors = [];

        if ($data['nama_kategori'] === '') {
            $errors[] = 'Nama kategori wajib diisi.';
        }

        if (mb_strlen($data['nama_kategori']) > 100) {
            $errors[] = 'Nama kategori maksimal 100 karakter.';
        }

        if (!empty($data['icon']) && mb_strlen($data['icon']) > 255) {
            $errors[] = 'Icon maksimal 255 karakter.';
        }

        return $errors;
    }

    private function countCampaignByCategory($categoryId)
    {
        try {
            return (int) $this->campaignModel
                ->where('category_id', $categoryId)
                ->countAllResults();
        } catch (\Throwable $e) {
            return 0;
        }
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $builder = $this->categoryModel;

        if (!empty($keyword)) {
            $builder = $builder->groupStart()
                ->like('nama_kategori', $keyword)
                ->orLike('deskripsi', $keyword)
                ->groupEnd();
        }

        $categories = $builder
            ->orderBy('nama_kategori', 'ASC')
            ->findAll();

        $campaignCount = [];
        foreach ($categories as $category) {
            $campaignCount[$category['id']] = $this->countCampaignByCategory($category['id']);
        }

        return view('admin/category/index', [
            'categories'    => $categories,
            'keyword'       => $keyword,
            'campaignCount' => $campaignCount,
        ]);
    }

    public function create()
    {
        return view('admin/category/create');
    }

    public function store()
    {
        $data = $this->categoryData();
        $errors = $this->validateCategory($data);

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $errors));
        }

        $this->categoryModel->insert($data);

        return redirect()->to('/admin/category')->with('success', 'Kategori donasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan.');
        }

        return view('admin/category/edit', [
            'category'      => $category,
            'campaignCount' => $this->countCampaignByCategory($id),
        ]);
    }

    public function update($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()->to('/admin/category')->with('error', 'Kategori tidak ditemukan.');
        }

        $data = $this->categoryData();
        $errors = $this->validateCategory($data);

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $errors));
        }

        $this->categoryModel->update($id, $data);

        return redirect()->to('/admin/category')->with('success', 'Kategori donasi berhasil diperbarui.');
    }

    public function delete($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        $campaignCount = $this->countCampaignByCategory($id);

        if ($campaignCount > 0) {
            return redirect()->back()->with('error', 'Kategori tidak bisa dihapus karena sudah digunakan oleh ' . $campaignCount . ' campaign. Edit nama/deskripsinya saja agar data campaign tetap aman.');
        }

        $this->categoryModel->delete($id);

        return redirect()->to('/admin/category')->with('success', 'Kategori donasi berhasil dihapus.');
    }
}
