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

        // Inisiasi Array untuk menyimpan Sum jumlah hari atau jam TOTAL
        $jumlahIzinCounts = []; 
        $jumlahSakitCounts = [];
        $jumlahCutiCounts = [];
        $jumlahLemburCounts = [];

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

            // Ambil Total jumlah izin berdasarkan id_user dari tabel izin
            $jumlahIzinCount = FormIzin::where('id_user', $akun->id)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->sum('jumlah_izin');
            $jumlahIzinCounts[$akun->id] = $jumlahIzinCount;

            // Ambil Total jumlah sakit berdasarkan id_user dari tabel sakit
            $jumlahSakitCount = FormSakit::where('id_user', $akun->id)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->sum('jumlah_izin');
            $jumlahSakitCounts[$akun->id] = $jumlahSakitCount;

            // Ambil Total Cuti berdasarkan id_user dari tabel Cuti
            $jumlahCutiCount = FormCuti::where('id_user', $akun->id)
                ->whereBetween('tanggal_mulai', [$startDate, $endDate])
                ->sum('jumlah_cuti');
            $jumlahCutiCounts[$akun->id] = $jumlahCutiCount;

            // Ambil Total Durasi Lembur berdasarkan id_user dari tabel Lembur
            $totalLemburDurationInSeconds = FormLembur::where('id_user', $akun->id)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->selectRaw('SUM(TIME_TO_SEC(durasi_lembur)) as total_duration')
                ->value('total_duration');

            $jumlahLemburCounts[$akun->id] = $totalLemburDurationInSeconds;
            // Convert totalLemburDurationInSeconds to time format (HH:MM:SS)
            $totalLemburDuration = gmdate('H:i:s', $totalLemburDurationInSeconds);
            $totalLemburDurations[$akun->id] = $totalLemburDuration;
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
            'jumlahIzinCounts' => $jumlahIzinCounts,
            'jumlahSakitCounts' => $jumlahSakitCounts,
            'jumlahCutiCounts' => $jumlahCutiCounts,
            'totalLemburDurations' => $totalLemburDurations,
        ]);
    }

    public function detail($id)
    {
        // Find the user based on the provided ID
        $akun = Akun::with(['devisi', 'devisi.atasanUser'])->findOrFail($id);

        // Use the same start and end dates from the index
        $startDate = request()->input('start_date');
        $endDate = request()->input('end_date');

        // Get izin details for the user
        $izinDetails = FormIzin::where('id_user', $id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        // Get izin sakit details for the user
        $sakitDetails = FormSakit::where('id_user', $id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        // Get izin 1/2 hari details for the user
        $sethariDetails = FormSetHari::where('id_user', $id)
        ->whereBetween('tanggal', [$startDate, $endDate])
        ->get();

        // Get izin Meninggalkan Tugas details for the user
        $meninggalkantugasDetails = FormMeninggalkanTugas::where('id_user', $id)
        ->whereBetween('tanggal', [$startDate, $endDate])
        ->get();

        // Get izin Tugas Keluar Kantor details for the user
        $tgsklrkantorDetails = FormTgsKlrKantor::where('id_user', $id)
        ->whereBetween('tanggal', [$startDate, $endDate])
        ->get();

        // Get Cuti details for the user
        $cutiDetails = FormCuti::with('jenisCuti')
            ->where('id_user', $id)
            ->whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->get();

        // Get Lembur details for the user
        $lemburDetails = Formlembur::where('id_user', $id)
        ->whereBetween('tanggal', [$startDate, $endDate])
        ->get();

        return view('admin.rekapan.detail', [
            'title' => 'Detail Rekapan',
            'section' => 'Laporan',
            'active' => 'rekapan',
            'akun' => $akun,
            'izinDetails' => $izinDetails,
            'sakitDetails' => $sakitDetails,
            'sethariDetails' => $sethariDetails,
            'meninggalkantugasDetails' => $meninggalkantugasDetails,
            'tgsklrkantorDetails' => $tgsklrkantorDetails,
            'cutiDetails' => $cutiDetails,
            'lemburDetails' => $lemburDetails,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
