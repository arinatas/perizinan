<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Cuti;
use App\Models\Akun;
use Illuminate\Support\Facades\Hash;

class CutiController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year');

        $cutis = Cuti::whereHas('user', function ($query) {
            $query->where('is_admin', 0);
        })->with('user');

        if ($year) {
            $cutis->where('tahun', $year);
        }
    
        $cutis = $cutis->get();
    
        // Ambil semua User dengan is_admin = 0 untuk tambah master cuti user baru
        $users = Akun::where('is_admin', 0)->get();

        // Ambil tahun unique di tabel cuti untuk pilihan di filter tahun
        $uniqueYears = Cuti::select('tahun')->distinct()->pluck('tahun');

        return view('admin.master.cuti.index', [
            'title' => 'Cuti',
            'section' => 'Master',
            'active' => 'cuti',
            'cutis' => $cutis,
            'users' => $users,
            'uniqueYears' => $uniqueYears,
        ]);
    }

    public function store(Request $request)
    {
        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|integer',
            'tahun' => 'required|date_format:Y',
            'jumlah_cuti' => 'required|integer',
        ]);
    
        // kalau ada error kembalikan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // cek apakah data dengan id_user dan tahun sudah ada
        $existingData = Cuti::where('id_user', $request->id_user)
            ->where('tahun', $request->tahun)
            ->first();

        if ($existingData) {
            // Jika data sudah ada, tampilkan pesan dan mungkin berikan tindakan sesuai kebutuhan
            return redirect()->back()->with('insertFail', 'Data untuk user dengan tahun tersebut sudah ada.');
        }
    
        // simpan data ke database
        try {
            DB::beginTransaction();
    
            // Hash password sebelum menyimpannya ke database
            $hashedPassword = Hash::make($request->password);
    
            // insert ke tabel users
            Cuti::create([
                'id_user' => $request->id_user,
                'tahun' => $request->tahun,
                'jumlah_cuti' => $request->jumlah_cuti,
            ]);
    
            DB::commit();
    
            return redirect()->back()->with('insertSuccess', 'Data berhasil diinputkan');
    
        } catch(Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('insertFail', $e->getMessage());
        }
    }    

    public function edit($id)
    {
        $cuti = Cuti::find($id);

        if (!$cuti) {
            return redirect()->back()->with('dataNotFound', 'Data tidak ditemukan');
        }

        $users = Akun::where('is_admin', 0)->get();

        return view('admin.master.cuti.edit', [
            'title' => 'Cuti',
            'section' => 'Master',
            'active' => 'cuti',
            'cuti' => $cuti,
            'users' => $users,
        ]);
    }

    public function update(Request $request, $id)
    {
        $cuti = Cuti::find($id);

        if (!$cuti) {
            return redirect()->back()->with('dataNotFound', 'Data tidak ditemukan');
        }

        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|integer',
            'tahun' => 'required|date_format:Y',
            'jumlah_cuti' => 'required|integer',
        ]);

        // kalau ada error kembalikan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // cek apakah data dengan id_user dan tahun sudah ada, kecuali data yang sedang diupdate
        $existingData = Cuti::where('id_user', $request->id_user)
            ->where('tahun', $request->tahun)
            ->where('id', '!=', $id)
            ->first();

        if ($existingData) {
            // Jika data sudah ada, tampilkan pesan berikut
            return redirect()->back()->with('updateFail', 'Data untuk user dengan tahun tersebut sudah ada.');
        }

        try{
            $cuti->id_user = $request->id_user;
            $cuti->tahun = $request->tahun;
            $cuti->jumlah_cuti = $request->jumlah_cuti;

            $cuti->save();

            return redirect('/cuti')->with('updateSuccess', 'Data berhasil di Update');
        } catch(Exception $e) {
            dd($e);
            return redirect()->back()->with('updateFail', 'Data gagal di Update');
        }
    }

    public function destroy($id)
    {
        // Cari data pengguna berdasarkan ID
        $position = Cuti::find($id);

        try {
            // Hapus data pengguna
            $position->delete();
            return redirect()->back()->with('deleteSuccess', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('deleteFail', $e->getMessage());
        }
    }

}
