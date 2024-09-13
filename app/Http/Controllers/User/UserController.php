<?php

namespace App\Http\Controllers\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Atasan;
use App\Models\FormIzin;
use App\Models\FormSakit;
use App\Models\FormSetHari;
use App\Models\FormMeninggalkanTugas;
use App\Models\FormTgsKlrKantor;
use App\Models\FormCuti;
use App\Models\FormLembur;



class UserController extends Controller
{

    public function index()
    {

        $isIAmLeader = Atasan::where('id_atasan', auth()->user()->id)->exists();

        return view('user.dashboard.index', [
            'title' => 'Dashboard',
            'section' => 'Dashboard',
            'isIAmLeader' => $isIAmLeader,
            'active' => 'Dashboard',
        ]);
    }

    public function rekapanAtasan(){

        $isIAmLeader = Atasan::where('id_atasan', auth()->user()->id)->exists();

        if($isIAmLeader) {

            $devisiId = Atasan::where('id_atasan', auth()->user()->id)->value('id');

            $tahunSekarang = Carbon::now()->year;

            // form izin
            $formIzin = FormIzin::where('id_devisi', $devisiId)
                        ->where('tanggal_mulai', 'like', '%' . $tahunSekarang . '%')
                        ->orderBy('id', 'desc')
                        ->get();

            // form sakit
            $formSakit = FormSakit::where('id_devisi', $devisiId)
                        ->where('tanggal_mulai', 'like', '%' . $tahunSekarang . '%')
                        ->orderBy('id', 'desc')
                        ->get();

            // izin 1/2 hari
            $formSetHari = FormSetHari::where('id_devisi', $devisiId)
                        ->where('tanggal', 'like', '%' . $tahunSekarang . '%')
                        ->orderBy('id', 'desc')
                        ->get();

            // izin meninggalkan tugas
            $formMeninggalkanTugas = FormMeninggalkanTugas::where('id_devisi', $devisiId)
                        ->where('tanggal', 'like', '%' . $tahunSekarang . '%')
                        ->orderBy('id', 'desc')
                        ->get();

            // izin keluar kantor
            $formFormTgsKlrKantor = FormTgsKlrKantor::where('id_devisi', $devisiId)
                        ->where('tanggal_mulai', 'like', '%' . $tahunSekarang . '%')
                        ->orderBy('id', 'desc')
                        ->get();

            // cuti
            $formCuti = FormCuti::where('id_devisi', $devisiId)
                        ->where('tanggal_mulai', 'like', '%' . $tahunSekarang . '%')
                        ->orderBy('id', 'desc')
                        ->get();

            // lemburs
            $formLembur = FormLembur::where('id_devisi', $devisiId)
                        ->where('tanggal', 'like', '%' . $tahunSekarang . '%')
                        ->orderBy('id', 'desc')
                        ->get();


            return view('user.dashboard.rekap', [
                'title' => 'Dashboard',
                'section' => 'Dashboard',
                'isIAmLeader' => $isIAmLeader,
                'formIzin' => $formIzin,
                'formSakit' => $formSakit,
                'formSetHari' => $formSetHari,
                'formMeninggalkanTugas' => $formMeninggalkanTugas,
                'formFormTgsKlrKantor' => $formFormTgsKlrKantor,
                'formCuti' => $formCuti,
                'formLembur' => $formLembur,
                'active' => 'Dashboard',
            ]);
        } else {
            return redirect()->back()->with('insertFail', 'Anda Bukan Atasan !');
        }
    }
}
