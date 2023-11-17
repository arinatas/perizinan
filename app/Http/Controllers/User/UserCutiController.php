<?php

namespace App\Http\Controllers\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\FormCuti;
use App\Models\Cuti;
use App\Models\JenisCuti;


class UserCutiController extends Controller
{

    public function cuti()
    {
        $jenisCuti = JenisCuti::all();

        // Mendapatkan tahun sekarang
        $tahunSekarang = Carbon::now()->year;

        $sisaCutiTahunIni = Cuti::where('id_user', auth()->user()->id)
                            ->where('tahun', $tahunSekarang)
                            ->value('jumlah_cuti');

        $myFormCuti = FormCuti::where('id_user', auth()->user()->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('user.form.cuti', [
            'title' => 'Cuti',
            'section' => 'Form',
            'myFormCuti' => $myFormCuti,
            'sisaCutiTahunIni' => $sisaCutiTahunIni,
            'jenisCuti' => $jenisCuti,
            'active' => 'Cuti',
        ]);
    }

    public function storeRequestCuti(Request $request) {

        // cek jenis cuti tahunan yang diambil atau yang lain
        if ($request->jenis_cuti == 1) {
            // Mendapatkan tahun sekarang
            $tahunSekarang = Carbon::now()->year;

            $sisaCutiTahunIni = Cuti::where('id_user', auth()->user()->id)
                                ->where('tahun', $tahunSekarang)
                                ->value('jumlah_cuti');

            // cek user punya cuti ga tahun ini
            if($sisaCutiTahunIni || $sisaCutiTahunIni > 0){
                // cek jumlah cuti ga boleh lebih dari 3
                if($request->jumlah_cuti <= 3) {
                    // cek jika sisa cuti kurang dari jumlah cuti yang di ajukan
                    if($sisaCutiTahunIni >= $request->jumlah_cuti) {
                        // lanjut disini dulu
                        // insert cuti dan update sisa cuti disini
                        $cuti = Cuti::where('id_user', auth()->user()->id)->first();

                        try{
                            $cuti->jumlah_cuti = $cuti->jumlah_cuti - $request->jumlah_cuti;

                            $cuti->save();

                            dd($cuti);

                        } catch(Exception $e) {
                            dd($e);
                        }
                    } else {
                        return redirect()->back()->with('insertFail', 'Jumlah cuti yang di ajukan melebihi jatah cuti yang dimiliki.');
                    }
                } else {
                    return redirect()->back()->with('insertFail', 'Hanya di perbolehkan mengambil cuti maksimal 3 hari saja.');
                }
            } else {
                return redirect()->back()->with('insertFail', 'Jatah Cuti sudah 0.');
            }
        }

        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'id_devisi' => 'required',
            'approve_atasan' => 'required',
            'approve_sdm' => 'required',
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'jumlah_cuti' => 'required',
            'jenis_cuti' => 'required',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:100',
            'bukti_pendukung' => 'required|file|max:2048|mimes:jpeg,png,pdf,jpg',
            'keperluan' => 'required|string|max:255',
        ]);

        // kalau ada error kembalikan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan data ke database
        // mulai try catch untuk menangkap error jika terjadi error pada saat penginputan database
        try{
            DB::beginTransaction();
            // cek jika ada file upload
            $fileName = null;
            if ($request->file('bukti_pendukung')) {
                $file = $request->file('bukti_pendukung');
                $fileName = Str::slug(Carbon::now()) . '-' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $fileName);
            }

            // insert data pada tabel t_jurnal
            $FormCuti = FormCuti::create([
                'id_user' => $request->id_user,
                'id_devisi' => $request->id_devisi,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'jumlah_cuti' => $request->jumlah_cuti,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'jenis_cuti' => $request->jenis_cuti,
                'keperluan' => $request->keperluan,
                'bukti_pendukung' => $fileName,
                'approve_atasan' => $request->approve_atasan,
                'approve_sdm' => $request->approve_sdm,
            ]);

            DB::commit();

            return redirect('/requestFormCuti')->with('insertSuccess', 'Request created successfully.');

        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return redirect()->back()->with('insertFail', 'Failed to create request.');
        }
    }
}
