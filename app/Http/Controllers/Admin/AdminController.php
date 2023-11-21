<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Akun;
use App\Models\FormIzin;
use App\Models\FormSakit;
use App\Models\FormSetHari;
use App\Models\FormMeninggalkanTugas;
use App\Models\FormTgsKlrKantor;
use App\Models\FormCuti;
use App\Models\FormLembur;
use Carbon\Carbon; // Import the Carbon class

class AdminController extends Controller
{

    public function index()
    {
        $getBulan = Carbon::now()->format('m'); // Get the current month

        $totalIzin = FormIzin::whereMonth('created_at', $getBulan)->count();
        $totalSakit = FormSakit::whereMonth('created_at', $getBulan)->count();
        $totalSetengahHari = FormSetHari::whereMonth('created_at', $getBulan)->count();
        $totalMeninggalkanTugas = FormMeninggalkanTugas::whereMonth('created_at', $getBulan)->count();
        $totalTugasKeluarKantor = FormTgsKlrKantor::whereMonth('created_at', $getBulan)->count();
        $totalCuti = FormCuti::whereMonth('created_at', $getBulan)->count();
        $totalLembur = FormLembur::whereMonth('created_at', $getBulan)->count();
        
        return view('admin.dashboard.index', [
            'title' => 'Dashboard Admin',
            'section' => 'Dashboard',
            'active' => 'Dashboard',
            'totalIzin' => $totalIzin,
            'totalSakit' => $totalSakit,
            'totalSetengahHari' => $totalSetengahHari,
            'totalMeninggalkanTugas' => $totalMeninggalkanTugas,
            'totalTugasKeluarKantor' => $totalTugasKeluarKantor,
            'totalCuti' => $totalCuti,
            'totalLembur' => $totalLembur,
        ]);
    }
}
