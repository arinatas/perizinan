<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\JenisCuti;
use Illuminate\Support\Facades\Hash;

class JenisCutiController extends Controller
{
    public function index()
    {
        $jeniscutis = JenisCuti::all();
            return view('admin.master.jenis_cuti.index', [
                'title' => 'Jenis Cuti',
                'section' => 'Master',
                'active' => 'jeniscuti',
                'jeniscutis' => $jeniscutis,
            ]);
    }

    public function store(Request $request)
    {
        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'nama_cuti' => 'required|string|max:255',
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
            JenisCuti::create([
                'nama_cuti' => $request->nama_cuti,
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
        $jeniscuti = JenisCuti::find($id);

        if (!$jeniscuti) {
            return redirect()->back()->with('dataNotFound', 'Data tidak ditemukan');
        }

        return view('admin.master.jenis_cuti.edit', [
            'title' => 'Jenis Cuti',
            'secction' => 'Master',
            'active' => 'jeniscuti',
            'jeniscuti' => $jeniscuti,
        ]);
    }

    public function update(Request $request, $id)
    {
        $jeniscuti = JenisCuti::find($id);

        if (!$jeniscuti) {
            return redirect()->back()->with('dataNotFound', 'Data tidak ditemukan');
        }

        // validasi input yang didapatkan dari request
        $validator = Validator::make($request->all(), [
            'nama_cuti' => 'required|string|max:255',
        ]);

        // kalau ada error kembalikan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $jeniscuti->nama_cuti = $request->nama_cuti;

            $jeniscuti->save();

            return redirect('/jeniscuti')->with('updateSuccess', 'Data berhasil di Update');
        } catch(Exception $e) {
            dd($e);
            return redirect()->back()->with('updateFail', 'Data gagal di Update');
        }
    }

    public function destroy($id)
    {
        // Cari data pengguna berdasarkan ID
        $position = JenisCuti::find($id);

        try {
            // Hapus data pengguna
            $position->delete();
            return redirect()->back()->with('deleteSuccess', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('deleteFail', $e->getMessage());
        }
    }

}
