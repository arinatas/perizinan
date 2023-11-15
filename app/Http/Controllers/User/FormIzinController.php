<?php

namespace App\Http\Controllers\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FormIzinController extends Controller
{

    public function index()
    {
        // dd("Berhasil login");
        return view('user.dashboard.index', [
            'title' => 'Dashboard',
            'section' => 'Dashboard',
            'active' => 'Dashboard',
        ]);
    }
}
