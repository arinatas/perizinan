<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\FormSakit;
use Illuminate\Support\Facades\Hash;

class FormSakitController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan rentang tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $formsakits = FormSakit::with('devisi')
            ->whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->orderBy('id', 'desc')
            ->get();

            return view('admin.pengajuan.formsakit.index', [
                'title' => 'Pengajuan Izin Sakit',
                'section' => 'Pengajuan',
                'active' => 'Pengajuan Izin Sakit',
                'formsakits' => $formsakits,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
    }

    public function approveAtasan($id)
    {
        $formSakit = FormSakit::findOrFail($id);
        $formSakit->approve_atasan = 1; // Set to 1 for approval, 2 for rejection
        $formSakit->save();

        return redirect()->back()->with('success', 'Form approved by Atasan.');
    }

    public function approveSdm($id)
    {
        $formSakit = FormSakit::findOrFail($id);
        $formSakit->approve_sdm = 1; // Set to 1 for approval, 2 for rejection
        $formSakit->save();

        return redirect()->back()->with('success', 'Form approved by SDM.');
    }

    public function unapproveAtasan($id)
    {
        $formSakit = FormSakit::findOrFail($id);
        $formSakit->approve_atasan = 0; // Set to 0 for unapproval
        $formSakit->save();

        return redirect()->back()->with('success', 'Form unapproved by Atasan.');
    }

    public function unapproveSdm($id)
    {
        $formSakit = FormSakit::findOrFail($id);
        $formSakit->approve_sdm = 0; // Set to 0 for unapproval
        $formSakit->save();

        return redirect()->back()->with('success', 'Form unapproved by SDM.');
    }

    public function rejectAtasan($id)
    {
        $formSakit = FormSakit::findOrFail($id);
        $formSakit->approve_atasan = 2; // Set to 2 for rejection
        $formSakit->save();

        return redirect()->back()->with('success', 'Form rejected by Atasan.');
    }

    public function rejectSdm($id)
    {
        $formSakit = FormSakit::findOrFail($id);
        $formSakit->approve_sdm = 2; // Set to 2 for rejection
        $formSakit->save();

        return redirect()->back()->with('success', 'Form rejected by SDM.');
    }
}
