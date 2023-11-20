<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\FormTgsKlrKantor;
use Illuminate\Support\Facades\Hash;

class FormTgsKlrKantorController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan rentang tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $formtgsklrkantors = FormTgsKlrKantor::with('devisi')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

            return view('admin.pengajuan.form_tgs_klr_kantor.index', [
                'title' => 'Pengajuan Izin Tugas Keluar Kantor',
                'section' => 'Pengajuan',
                'active' => 'formtgsklrkantor',
                'formtgsklrkantors' => $formtgsklrkantors,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
    }

    public function approveAtasan($id)
    {
        $formTgsKlrKantor = FormTgsKlrKantor::findOrFail($id);
        $formTgsKlrKantor->approve_atasan = 1; // Set to 1 for approval, 2 for rejection
        $formTgsKlrKantor->save();

        return redirect()->back()->with('success', 'Form approved by Atasan.');
    }

    public function approveSdm($id)
    {
        $formTgsKlrKantor = FormTgsKlrKantor::findOrFail($id);
        $formTgsKlrKantor->approve_sdm = 1; // Set to 1 for approval, 2 for rejection
        $formTgsKlrKantor->save();

        return redirect()->back()->with('success', 'Form approved by SDM.');
    }

    public function unapproveAtasan($id)
    {
        $formTgsKlrKantor = FormTgsKlrKantor::findOrFail($id);
        $formTgsKlrKantor->approve_atasan = 0; // Set to 0 for unapproval
        $formTgsKlrKantor->save();
    
        return redirect()->back()->with('success', 'Form unapproved by Atasan.');
    }
    
    public function unapproveSdm($id)
    {
        $formTgsKlrKantor = FormTgsKlrKantor::findOrFail($id);
        $formTgsKlrKantor->approve_sdm = 0; // Set to 0 for unapproval
        $formTgsKlrKantor->save();
    
        return redirect()->back()->with('success', 'Form unapproved by SDM.');
    }
    
    public function rejectAtasan($id)
    {
        $formTgsKlrKantor = FormTgsKlrKantor::findOrFail($id);
        $formTgsKlrKantor->approve_atasan = 2; // Set to 2 for rejection
        $formTgsKlrKantor->save();
    
        return redirect()->back()->with('success', 'Form rejected by Atasan.');
    }
    
    public function rejectSdm($id)
    {
        $formTgsKlrKantor = FormTgsKlrKantor::findOrFail($id);
        $formTgsKlrKantor->approve_sdm = 2; // Set to 2 for rejection
        $formTgsKlrKantor->save();
    
        return redirect()->back()->with('success', 'Form rejected by SDM.');
    }    
}
