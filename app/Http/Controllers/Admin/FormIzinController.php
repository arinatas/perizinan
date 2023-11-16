<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\FormIzin;
use Illuminate\Support\Facades\Hash;

class FormIzinController extends Controller
{
    public function index()
    {
        $formizins = FormIzin::all();
            return view('admin.pengajuan.formizin.index', [
                'title' => 'Pengajuan Izin',
                'section' => 'Pengajuan',
                'active' => 'formizin',
                'formizins' => $formizins,
            ]);
    }

}
