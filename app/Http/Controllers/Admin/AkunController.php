<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Akun;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $akuns = Akun::all();
            return view('admin.master.akun.index', [
                'title' => 'User',
                'section' => 'Master',
                'active' => 'user',
                'akuns' => $akuns,
            ]);
    }

    public function store(Request $request)
    {
        // Pengecekan apakah email sudah ada
        $existingEmail = Akun::where('email', $request->email)->exists();
    
        if ($existingEmail) {
            return redirect()->back()->withInput()->with('insertFail', 'Email sudah digunakan.');
        }
    
        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'is_admin' => 'required|integer|between:0,1',
            'id_devisi' => 'required|integer'
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
    
            // insert ke tabel users
            Akun::create([
                'email' => $request->email,
                'password' => $hashedPassword,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'is_admin' => $request->is_admin,
                'id_devisi' => $request->id_devisi
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
        $akun = Akun::find($id);

        if (!$akun) {
            return redirect()->back()->with('dataNotFound', 'Data tidak ditemukan');
        }

        return view('admin.master.akun.edit', [
            'title' => 'User',
            'secction' => 'Master',
            'active' => 'user',
            'akun' => $akun,
        ]);
    }

    public function update(Request $request, $id)
    {
        $akun = Akun::find($id);

        if (!$akun) {
            return redirect()->back()->with('dataNotFound', 'Data tidak ditemukan');
        }

        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'is_admin' => 'required|integer|between:0,1',
            'id_devisi' => 'required|integer',
            'is_aktif' => 'required|integer|between:0,1'
        ]);

        // kalau ada error kembalikan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $akun->email = $request->email;
            $akun->nama = $request->nama;
            $akun->jabatan = $request->jabatan;
            $akun->is_admin = $request->is_admin;
            $akun->id_devisi = $request->id_devisi;
            $akun->is_aktif = $request->is_aktif;

            $akun->save();

            return redirect('/akun')->with('updateSuccess', 'Data berhasil di Update');
        } catch(Exception $e) {
            dd($e);
            return redirect()->back()->with('updateFail', 'Data gagal di Update');
        }
    }

    public function destroy($id)
    {
        // Cari data pengguna berdasarkan ID
        $position = Akun::find($id);

        try {
            // Hapus data pengguna
            $position->delete();
            return redirect()->back()->with('deleteSuccess', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('deleteFail', $e->getMessage());
        }
    }

    public function reset($id)
    {
        $akun = Akun::find($id);

        if (!$akun) {
            return redirect()->back()->with('dataNotFound', 'Data tidak ditemukan');
        }

        return view('admin.master.akun.reset', [
            'title' => 'User',
            'secction' => 'Master',
            'active' => 'user',
            'akun' => $akun,
        ]);
    }

    public function resetupdate(Request $request, $id)
    {
        $akun = Akun::find($id);

        if (!$akun) {
            return redirect()->back()->with('dataNotFound', 'Data tidak ditemukan');
        }

        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255'
        ]);

        // kalau ada error kembalikan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $akun->email = $request->email;
            // Hash password sebelum menyimpannya ke database
            $akun->password = Hash::make($request->password);

            $akun->save();

            return redirect('/akun')->with('updateSuccess', 'Password berhasil di Reset');
        } catch(Exception $e) {
            dd($e);
            return redirect()->back()->with('updateFail', 'Password gagal di Reset');
        }
    }

}
