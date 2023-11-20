<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\FormLembur;
use Illuminate\Support\Facades\Hash;

class FormLemburController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan rentang tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $formlemburs = FormLembur::with('devisi')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

            return view('admin.pengajuan.formlembur.index', [
                'title' => 'Pengajuan Lembur',
                'section' => 'Pengajuan',
                'active' => 'formlembur',
                'formlemburs' => $formlemburs,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
    }

    public function approveAtasan($id)
    {
        $formLembur = FormLembur::findOrFail($id);
        $formLembur->approve_atasan = 1; // Set to 1 for approval, 2 for rejection
        $formLembur->save();

        return redirect()->back()->with('success', 'Form approved by Atasan.');
    }

    public function approveSdm($id)
    {
        $formLembur = FormLembur::findOrFail($id);
        $formLembur->approve_sdm = 1; // Set to 1 for approval, 2 for rejection
        $formLembur->save();

        return redirect()->back()->with('success', 'Form approved by SDM.');
    }

    public function unapproveAtasan($id)
    {
        $formLembur = FormLembur::findOrFail($id);
        $formLembur->approve_atasan = 0; // Set to 0 for unapproval
        $formLembur->save();
    
        return redirect()->back()->with('success', 'Form unapproved by Atasan.');
    }
    
    public function unapproveSdm($id)
    {
        $formLembur = FormLembur::findOrFail($id);
        $formLembur->approve_sdm = 0; // Set to 0 for unapproval
        $formLembur->save();
    
        return redirect()->back()->with('success', 'Form unapproved by SDM.');
    }
    
    public function rejectAtasan($id)
    {
        $formLembur = FormLembur::findOrFail($id);
        $formLembur->approve_atasan = 2; // Set to 2 for rejection
        $formLembur->save();
    
        return redirect()->back()->with('success', 'Form rejected by Atasan.');
    }
    
    public function rejectSdm($id)
    {
        $formLembur = FormLembur::findOrFail($id);
        $formLembur->approve_sdm = 2; // Set to 2 for rejection
        $formLembur->save();
    
        return redirect()->back()->with('success', 'Form rejected by SDM.');
    }    
}
