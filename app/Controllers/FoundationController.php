<?php

namespace App\Controllers;
use App\Models\FoundationModel;

class FoundationController extends BaseController
{
    protected $foundation;
    
    public function __construct()
    {
        $this->foundation = new FoundationModel();
    }

    public function create()
    {
        return view('yayasan/register_profile');
    }

    public function store()
    {
     
    $this->foundation->save([

        'user_id' => session()->get('user_id'),

        'nama_yayasan' => $this->request->getPost('nama_yayasan'),

        'email_yayasan' => $this->request->getPost('email_yayasan'),

        'telepon' => $this->request->getPost('telepon'),

        'alamat' => $this->request->getPost('alamat'),

        'deskripsi' => $this->request->getPost('deskripsi'),

        'nomor_izin' => $this->request->getPost('nomor_izin'),

        'status' => 'pending'

    ]);

        return redirect()->to('/yayasan/status');
    }
    

    public function edit()
    {

    }

    public function update()
    {

    }

    public function profile()
    {

    }
    public function status()
    {
        $foundation = $this->foundation
                        ->where(
                            'user_id',
                            session()->get('user_id')
                        )
                        ->first();

        return view('yayasan/status',[
            'foundation'=>$foundation
        ]);
    }
}