<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Atasan;
use App\Models\Akun;
use Illuminate\Support\Facades\Hash;

class AtasanController extends Controller
{
    public function index()
    {
        // Mendapatkan semua data user dari tabel users dengan is_admin = 0
        $users = Akun::where('is_admin', 0)->get();

        // Mendapatkan data atasan beserta data user yang terkait
        $atasans = Atasan::with('atasanUser')->get();

        return view('admin.master.atasan.index', [
            'title' => 'Atasan',
            'section' => 'Master',
            'active' => 'atasan',
            'atasans' => $atasans,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'nama_devisi' => 'required|string|max:255',
            'id_atasan' => 'nullable|integer'
        ]);
    
        // kalau ada error kembalikan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // simpan data ke database
        try {
            DB::beginTransaction();
    
            // Hash password sebelum menyimpannya ke database
            $hashedPassword = Hash::make($request->password);
    
            // insert ke tabel Devisi
            Atasan::create([
                'nama_devisi' => $request->nama_devisi,
                'id_atasan' => $request->id_atasan
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
        $atasan = Atasan::find($id);

        if (!$atasan) {
            return redirect()->back()->with('dataNotFound', 'Data tidak ditemukan');
        }
        $users = Akun::where('is_admin', 0)->get();

        return view('admin.master.atasan.edit', [
            'title' => 'Atasan',
            'secction' => 'Master',
            'active' => 'atasan',
            'atasan' => $atasan,
            'users' => $users
        ]);
    }

    public function update(Request $request, $id)
    {
        $atasan = Atasan::find($id);

        if (!$atasan) {
            return redirect()->back()->with('dataNotFound', 'Data tidak ditemukan');
        }

        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'nama_devisi' => 'required|string|max:255',
            'id_atasan' => 'nullable|integer'
        ]);

        // kalau ada error kembalikan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $atasan->nama_devisi = $request->nama_devisi;
            $atasan->id_atasan = $request->id_atasan;

            $atasan->save();

            return redirect('/atasan')->with('updateSuccess', 'Data berhasil di Update');
        } catch(Exception $e) {
            dd($e);
            return redirect()->back()->with('updateFail', 'Data gagal di Update');
        }
    }

    public function destroy($id)
    {
        // Cari data pengguna berdasarkan ID
        $position = Atasan::find($id);

        try {
            // Hapus data pengguna
            $position->delete();
            return redirect()->back()->with('deleteSuccess', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('deleteFail', $e->getMessage());
        }
    }
}
