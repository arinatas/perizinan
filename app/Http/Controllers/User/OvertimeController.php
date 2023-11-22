<?php

namespace App\Http\Controllers\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\FormLembur;


class OvertimeController extends Controller
{

    public function overtime()
    {
        $myFormLembur = FormLembur::where('id_user', auth()->user()->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('user.form.overtime', [
            'title' => 'Lembur',
            'section' => 'Form',
            'myFormLembur' => $myFormLembur,
            'active' => 'Lembur',
        ]);
    }

    public function storeRequestOvertime(Request $request) {
        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'id_devisi' => 'required',
            'approve_atasan' => 'required',
            'approve_sdm' => 'required',
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'durasi_lembur' => 'required',
            'bukti_pendukung' => 'required|file|max:2048|mimes:jpeg,png,pdf,jpg',
            'keterangan_pekerjaan' => 'required|string|max:255',
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
            if ($request->file('bukti_pendukung')) {
                $fileName = $request->file('bukti_pendukung')->store('images');
            }

            // insert data pada tabel t_jurnal
            $FormLembur = FormLembur::create([
                'id_user' => $request->id_user,
                'id_devisi' => $request->id_devisi,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'durasi_lembur' => $request->durasi_lembur,
                'keterangan_pekerjaan' => $request->keterangan_pekerjaan,
                'bukti_pendukung' => $fileName,
                'approve_atasan' => $request->approve_atasan,
                'approve_sdm' => $request->approve_sdm,
            ]);

            DB::commit();

            return redirect('/requestFormOvertime')->with('insertSuccess', 'Request created successfully.');

        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return redirect()->back()->with('insertFail', 'Failed to create request.');
        }
    }
}
