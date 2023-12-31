<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\FormCuti;
use App\Models\Cuti;
use Illuminate\Support\Facades\Hash;

class FormCutiController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan rentang tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $formcutis = FormCuti::with(['devisi', 'jenisCuti'])
            ->whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->orderBy('id', 'desc')
            ->get();

            return view('admin.pengajuan.formcuti.index', [
                'title' => 'Pengajuan Cuti',
                'section' => 'Pengajuan',
                'active' => 'Pengajuan Cuti',
                'formcutis' => $formcutis,
                'startDate' => $startDate,
                'endDate' => $endDate,
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
    
        // Periksa apakah approve_sdm awalnya adalah 0
        if ($formCuti->approve_sdm == 0) {
            $formCuti->approve_sdm = 1; // Setujui dengan nilai 1
            $formCuti->save();
        } elseif ($formCuti->approve_sdm == 2) {
            // Jika approve_sdm awalnya adalah 2, kurangkan jumlah_cuti dari master_cuti
            $masterCuti = Cuti::where('id_user', $formCuti->id_user)
                ->where('tahun', date('Y')) // Asumsi bahwa Anda ingin mengurangkan dari tahun saat ini
                ->first();
    
            // Periksa apakah ada catatan master_cuti
            if ($masterCuti) {
                $masterCuti->jumlah_cuti -= $formCuti->jumlah_cuti;
                $masterCuti->save();
            }
            
            $formCuti->approve_sdm = 1; // Setujui dengan nilai 1
            $formCuti->save();
        }
    
        return redirect()->back()->with('success', 'Form approved by SDM.');
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

        // Check if the request has already been rejected
        if ($formCuti->approve_sdm == 2) {
            return redirect()->back()->with('info', 'Form has already been rejected by SDM.');
        }

        // Set to 2 for rejection
        $formCuti->approve_sdm = 2;
        $formCuti->save();

        // Update jumlah_cuti in the master_cuti table
        $masterCuti = Cuti::where('id_user', $formCuti->id_user)
            ->where('tahun', date('Y')) // Assuming you want to update for the current year
            ->first();

        if ($masterCuti) {
            // Increase the jumlah_cuti by the rejected amount
            $masterCuti->jumlah_cuti += $formCuti->jumlah_cuti;
            $masterCuti->save();
        }

        return redirect()->back()->with('success', 'Form rejected by SDM.');
    }   
}
