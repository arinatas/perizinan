<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Akun;

class AdminController extends Controller
{

    public function index()
    {
        // dd("Berhasil login");
        return view('admin.dashboard.index', [
            'title' => 'Dashboard Admin',
            'section' => 'Dashboard',
            'active' => 'Dashboard',
        ]);
    }
}
