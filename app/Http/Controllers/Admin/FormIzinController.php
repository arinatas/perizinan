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
    public function index(Request $request)
    {
        // Mendapatkan rentang tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $formizins = FormIzin::with('devisi')
            ->whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->orderBy('id', 'desc')
            ->get();

            return view('admin.pengajuan.formizin.index', [
                'title' => 'Pengajuan Izin',
                'section' => 'Pengajuan',
                'active' => 'Pengajuan Izin',
                'formizins' => $formizins,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
    }

    public function approveAtasan($id)
    {
        $formIzin = FormIzin::findOrFail($id);
        $formIzin->approve_atasan = 1; // Set to 1 for approval, 2 for rejection
        $formIzin->save();

        return redirect()->back()->with('success', 'Form approved by Atasan.');
    }

    public function approveSdm($id)
    {
        $formIzin = FormIzin::findOrFail($id);
        $formIzin->approve_sdm = 1; // Set to 1 for approval, 2 for rejection
        $formIzin->save();

        return redirect()->back()->with('success', 'Form approved by SDM.');
    }

    public function unapproveAtasan($id)
    {
        $formIzin = FormIzin::findOrFail($id);
        $formIzin->approve_atasan = 0; // Set to 0 for unapproval
        $formIzin->save();

        return redirect()->back()->with('success', 'Form unapproved by Atasan.');
    }

    public function unapproveSdm($id)
    {
        $formIzin = FormIzin::findOrFail($id);
        $formIzin->approve_sdm = 0; // Set to 0 for unapproval
        $formIzin->save();

        return redirect()->back()->with('success', 'Form unapproved by SDM.');
    }

    public function rejectAtasan($id)
    {
        $formIzin = FormIzin::findOrFail($id);
        $formIzin->approve_atasan = 2; // Set to 2 for rejection
        $formIzin->save();

        return redirect()->back()->with('success', 'Form rejected by Atasan.');
    }

    public function rejectSdm($id)
    {
        $formIzin = FormIzin::findOrFail($id);
        $formIzin->approve_sdm = 2; // Set to 2 for rejection
        $formIzin->save();

        return redirect()->back()->with('success', 'Form rejected by SDM.');
    }
}
