<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\FormCuti;
use Illuminate\Support\Facades\Hash;

class FormCutiController extends Controller
{
    public function index()
    {
        $formcutis = FormCuti::with(['devisi', 'jenisCuti'])->get();
            return view('admin.pengajuan.formcuti.index', [
                'title' => 'Pengajuan Cuti',
                'section' => 'Pengajuan',
                'active' => 'formcuti',
                'formcutis' => $formcutis,
            ]);
    }

    public function approveAtasan($id)
    {
        $formCuti = FormCuti::findOrFail($id);
        $formCuti->approve_atasan = 1; // Set to 1 for approval, 2 for rejection
        $formCuti->save();

        return redirect()->back()->with('success', 'Form approved by Atasan.');
    }

    public function approveSdm($id)
    {
        $formCuti = FormCuti::findOrFail($id);
        $formCuti->approve_sdm = 1; // Set to 1 for approval, 2 for rejection
        $formCuti->save();

        return redirect()->back()->with('success', 'Form approved by SDM.');
    }

    public function unapproveAtasan($id)
    {
        $formCuti = FormCuti::findOrFail($id);
        $formCuti->approve_atasan = 0; // Set to 0 for unapproval
        $formCuti->save();
    
        return redirect()->back()->with('success', 'Form unapproved by Atasan.');
    }
    
    public function unapproveSdm($id)
    {
        $formCuti = FormCuti::findOrFail($id);
        $formCuti->approve_sdm = 0; // Set to 0 for unapproval
        $formCuti->save();
    
        return redirect()->back()->with('success', 'Form unapproved by SDM.');
    }
    
    public function rejectAtasan($id)
    {
        $formCuti = FormCuti::findOrFail($id);
        $formCuti->approve_atasan = 2; // Set to 2 for rejection
        $formCuti->save();
    
        return redirect()->back()->with('success', 'Form rejected by Atasan.');
    }
    
    public function rejectSdm($id)
    {
        $formCuti = FormCuti::findOrFail($id);
        $formCuti->approve_sdm = 2; // Set to 2 for rejection
        $formCuti->save();
    
        return redirect()->back()->with('success', 'Form rejected by SDM.');
    }    
}
