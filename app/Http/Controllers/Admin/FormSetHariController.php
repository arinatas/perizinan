<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\FormSetHari;
use Illuminate\Support\Facades\Hash;

class FormSetHariController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan rentang tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $formsetharis = FormSetHari::with('devisi')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();
            return view('admin.pengajuan.formsethari.index', [
                'title' => 'Pengajuan Izin Setengah Hari',
                'section' => 'Pengajuan',
                'active' => 'formsethari',
                'formsetharis' => $formsetharis,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
    }

    public function approveAtasan($id)
    {
        $formSetHari = FormSetHari::findOrFail($id);
        $formSetHari->approve_atasan = 1; // Set to 1 for approval, 2 for rejection
        $formSetHari->save();

        return redirect()->back()->with('success', 'Form approved by Atasan.');
    }

    public function approveSdm($id)
    {
        $formSetHari = FormSetHari::findOrFail($id);
        $formSetHari->approve_sdm = 1; // Set to 1 for approval, 2 for rejection
        $formSetHari->save();

        return redirect()->back()->with('success', 'Form approved by SDM.');
    }

    public function unapproveAtasan($id)
    {
        $formSetHari = FormSetHari::findOrFail($id);
        $formSetHari->approve_atasan = 0; // Set to 0 for unapproval
        $formSetHari->save();
    
        return redirect()->back()->with('success', 'Form unapproved by Atasan.');
    }
    
    public function unapproveSdm($id)
    {
        $formSetHari = FormSetHari::findOrFail($id);
        $formSetHari->approve_sdm = 0; // Set to 0 for unapproval
        $formSetHari->save();
    
        return redirect()->back()->with('success', 'Form unapproved by SDM.');
    }
    
    public function rejectAtasan($id)
    {
        $formSetHari = FormSetHari::findOrFail($id);
        $formSetHari->approve_atasan = 2; // Set to 2 for rejection
        $formSetHari->save();
    
        return redirect()->back()->with('success', 'Form rejected by Atasan.');
    }
    
    public function rejectSdm($id)
    {
        $formSetHari = FormSetHari::findOrFail($id);
        $formSetHari->approve_sdm = 2; // Set to 2 for rejection
        $formSetHari->save();
    
        return redirect()->back()->with('success', 'Form rejected by SDM.');
    }    
}
