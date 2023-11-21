<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\FormMeninggalkanTugas;
use Illuminate\Support\Facades\Hash;

class FormMeninggalkanTugasController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan rentang tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $formmeninggalkantugass = FormMeninggalkanTugas::with('devisi')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('id', 'desc')
            ->get();
            return view('admin.pengajuan.formmeninggalkantugas.index', [
                'title' => 'Pengajuan Izin Meninggalkan Tugas',
                'section' => 'Pengajuan',
                'active' => 'Pengajuan Izin Meninggalkan Tugas',
                'formmeninggalkantugass' => $formmeninggalkantugass,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
    }

    public function approveAtasan($id)
    {
        $formMeninggalkanTugas = FormMeninggalkanTugas::findOrFail($id);
        $formMeninggalkanTugas->approve_atasan = 1; // Set to 1 for approval, 2 for rejection
        $formMeninggalkanTugas->save();

        return redirect()->back()->with('success', 'Form approved by Atasan.');
    }

    public function approveSdm($id)
    {
        $formMeninggalkanTugas = FormMeninggalkanTugas::findOrFail($id);
        $formMeninggalkanTugas->approve_sdm = 1; // Set to 1 for approval, 2 for rejection
        $formMeninggalkanTugas->save();

        return redirect()->back()->with('success', 'Form approved by SDM.');
    }

    public function unapproveAtasan($id)
    {
        $formMeninggalkanTugas = FormMeninggalkanTugas::findOrFail($id);
        $formMeninggalkanTugas->approve_atasan = 0; // Set to 0 for unapproval
        $formMeninggalkanTugas->save();
    
        return redirect()->back()->with('success', 'Form unapproved by Atasan.');
    }
    
    public function unapproveSdm($id)
    {
        $formMeninggalkanTugas = FormMeninggalkanTugas::findOrFail($id);
        $formMeninggalkanTugas->approve_sdm = 0; // Set to 0 for unapproval
        $formMeninggalkanTugas->save();
    
        return redirect()->back()->with('success', 'Form unapproved by SDM.');
    }
    
    public function rejectAtasan($id)
    {
        $formMeninggalkanTugas = FormMeninggalkanTugas::findOrFail($id);
        $formMeninggalkanTugas->approve_atasan = 2; // Set to 2 for rejection
        $formMeninggalkanTugas->save();
    
        return redirect()->back()->with('success', 'Form rejected by Atasan.');
    }
    
    public function rejectSdm($id)
    {
        $formMeninggalkanTugas = FormMeninggalkanTugas::findOrFail($id);
        $formMeninggalkanTugas->approve_sdm = 2; // Set to 2 for rejection
        $formMeninggalkanTugas->save();
    
        return redirect()->back()->with('success', 'Form rejected by SDM.');
    }    
}
