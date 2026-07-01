<?php

namespace App\Controllers;

class FoundationController extends BaseController
{
    public function index()
    {
        return view('yayasan/dashboard');
    }
}