<?php

namespace App\Http\Controllers\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\FormSakit;


class SakitController extends Controller
{

    public function sakit()
    {
        $myFormSakit = FormSakit::where('id_user', auth()->user()->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('user.form.sakit', [
            'title' => 'Sakit',
            'section' => 'Form',
            'myFormSakit' => $myFormSakit,
            'active' => 'Sakit',
        ]);
    }

    public function storeRequestSakit (Request $request) {
        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'id_devisi' => 'required',
            'approve_atasan' => 'required',
            'approve_sdm' => 'required',
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah_izin' => 'required',
            'no_hp' => 'required|string|max:100',
            'bukti_pendukung' => 'required|file|max:2048|mimes:jpeg,png',
            'keterangan' => 'required|string|max:255',
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
            $FormSakit = FormSakit::create([
                'id_user' => $request->id_user,
                'id_devisi' => $request->id_devisi,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'tanggal' => $request->tanggal,
                'jumlah_izin' => $request->jumlah_izin,
                'no_hp' => $request->no_hp,
                'keterangan' => $request->keterangan,
                'bukti_pendukung' => $fileName,
                'approve_atasan' => $request->approve_atasan,
                'approve_sdm' => $request->approve_sdm,
            ]);

            DB::commit();

            return redirect('/requestFormSakit')->with('insertSuccess', 'Request created successfully.');

        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return redirect()->back()->with('insertFail', 'Failed to create request.');
        }
    }
}