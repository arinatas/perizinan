<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Akun;
use App\Models\FormIzin;
use App\Models\FormSakit;
use App\Models\FormSetHari;
use App\Models\FormMeninggalkanTugas;
use App\Models\FormTgsKlrKantor;
use App\Models\FormCuti;
use App\Models\FormLembur;
use Illuminate\Support\Facades\Hash;

class RekapanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua User
        $akuns = Akun::all();

        // Inisialisasi array untuk menyimpan jumlah per user
        $izinCounts = [];
        $izinSakitCounts = [];
        $izinSetengahHariCounts = [];
        $izinMeninggalkanTugasCounts = [];
        $izinTgsKlrKantorCounts = [];
        $izinCutiCounts = [];
        $izinLemburCounts = [];

        // Mendapatkan rentang tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Iterasi setiap user
        foreach ($akuns as $akun) {
            // Ambil jumlah izin berdasarkan id_user dan rentang tanggal dari tabel izin
            $izinCount = FormIzin::where('id_user', $akun->id)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->count();
            $izinCounts[$akun->id] = $izinCount;

            // Ambil jumlah izin sakit berdasarkan id_user dari tabel sakit
            $izinSakitCount = FormSakit::where('id_user', $akun->id)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->count();
            $izinSakitCounts[$akun->id] = $izinSakitCount;

            // Ambil jumlah izin setengah hari berdasarkan id_user dari tabel setengah hari
            $izinSetengahHariCount = FormSetHari::where('id_user', $akun->id)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->count();
            $izinSetengahHariCounts[$akun->id] = $izinSetengahHariCount;

            // Ambil jumlah izin meninggalkan tugas berdasarkan id_user dari tabel meninggalkan tugas
            $izinMeninggalkanTugasCount = FormMeninggalkanTugas::where('id_user', $akun->id)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->count();
            $izinMeninggalkanTugasCounts[$akun->id] = $izinMeninggalkanTugasCount;

            // Ambil jumlah izin tugas keluar kantor berdasarkan id_user dari tabel tugas keluar kantor
            $izinTgsKlrKantorCount = FormTgsKlrKantor::where('id_user', $akun->id)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->count();
            $izinTgsKlrKantorCounts[$akun->id] = $izinTgsKlrKantorCount;

            // Ambil jumlah izin cuti berdasarkan id_user dari tabel cuti
            $izinCutiCount = FormCuti::where('id_user', $akun->id)
                ->whereBetween('tanggal_mulai', [$startDate, $endDate])
                ->count();
            $izinCutiCounts[$akun->id] = $izinCutiCount;

            // Ambil jumlah izin lembur berdasarkan id_user dari tabel lembur
            $izinLemburCount = FormLembur::where('id_user', $akun->id)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->count();
            $izinLemburCounts[$akun->id] = $izinLemburCount;
        }

        return view('admin.rekapan.index', [
            'title' => 'Rekapan Pengajuan Form',
            'section' => 'Laporan',
            'active' => 'rekapan',
            'akuns' => $akuns,
            'izinCounts' => $izinCounts,
            'izinSakitCounts' => $izinSakitCounts,
            'izinSetengahHariCounts' => $izinSetengahHariCounts,
            'izinMeninggalkanTugasCounts' => $izinMeninggalkanTugasCounts,
            'izinTgsKlrKantorCounts' => $izinTgsKlrKantorCounts,
            'izinCutiCounts' => $izinCutiCounts,
            'izinLemburCounts' => $izinLemburCounts,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
