<?php

namespace App\Http\Controllers\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\FormTgsKlrKantor;


class OutOfficeAssignController extends Controller
{

    public function outOfficeAssign()
    {
        $myFormTgsKlrKantor = FormTgsKlrKantor::where('id_user', auth()->user()->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('user.form.outOfficeAssign', [
            'title' => 'Tugas Keluar Kantor',
            'section' => 'Form',
            'myFormTgsKlrKantor' => $myFormTgsKlrKantor,
            'active' => 'Tugas Keluar Kantor',
        ]);
    }

    public function storeRequestOutOfficeAssign(Request $request) {
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
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
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
            if ($request->file('bukti_pendukung')) {
                $fileName = $request->file('bukti_pendukung')->store('images');
            }

            // insert data pada tabel t_jurnal
            $FormTgsKlrKantor = FormTgsKlrKantor::create([
                'id_user' => $request->id_user,
                'id_devisi' => $request->id_devisi,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'no_hp' => $request->no_hp,
                'keperluan' => $request->keperluan,
                'bukti_pendukung' => $fileName,
                'approve_atasan' => $request->approve_atasan,
                'approve_sdm' => $request->approve_sdm,
            ]);

            DB::commit();

            return redirect('/requestFormOutOfficeAssign')->with('insertSuccess', 'Request created successfully.');

        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return redirect()->back()->with('insertFail', 'Failed to create request.');
        }
    }
}
