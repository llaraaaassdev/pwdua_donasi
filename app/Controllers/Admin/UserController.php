<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /*
    |--------------------------------------------------------------------------
    | LIST USER
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $users = $this->userModel
                        ->orderBy('id','DESC')
                        ->findAll();

        return view('admin/users/index',[
            'title'=>'Kelola User',
            'users'=>$users
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL USER
    |--------------------------------------------------------------------------
    */

    public function detail($id)
    {
        $user = $this->userModel->find($id);

        if(!$user){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/users/detail',[
            'title'=>'Detail User',
            'user'=>$user
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if(!$user){
            return redirect()->back();
        }

        return view('admin/users/edit',[
            'user'=>$user
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update($id)
    {
        $this->userModel->update($id,[

            'nama'=>$this->request->getPost('nama'),
            'email'=>$this->request->getPost('email'),
            'no_hp'=>$this->request->getPost('no_hp'),
            'role'=>$this->request->getPost('role'),
            'is_active'=>$this->request->getPost('is_active')

        ]);

        return redirect()->to('/admin/users')
                         ->with('success','User berhasil diupdate');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete($id)
{
    $user = $this->userModel->find($id);

    if (!$user) {
        return redirect()->back()->with('error', 'User tidak ditemukan.');
    }

    // Admin tidak boleh menghapus dirinya sendiri
    if ($id == session()->get('id')) {
        return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
    }

    $this->userModel->delete($id);

    return redirect()->to('/admin/users')
        ->with('success', 'User berhasil dihapus.');
}
}