<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Polsek;
use App\Models\Polres;


class PolsekController extends Controller
{
    public function index(){
        $polsek = Polsek::select('id','nama','stok_beras','distribusi_beras')->paginate(10);
        return view('superadmin.polsek.page',compact('polsek'));
    }

    public function tambahPage(){
        $polres = Polres::select('id','nama')->get();
        return view('superadmin.polsek.tambah',compact('polres'));
    }

    public function store(Request $request){
        $request->validate([
            'nama' => 'required|string|max:255',   
            'polres_id' => 'required',   
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'polres_id.required' => 'Polres wajib dipilih.',
        ]);

        try {
            Polsek::create([
                'polres_id' => $request->polres_id,
                'nama' => $request->nama,
            ]);
            return redirect()->route('superadmin.polsek')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Data Polsek Berhasil Di Tambah!'
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi kesalahan saat menambah data. Silakan coba lagi.'
            ]);
        }
    }

    public function editPage($id){
        $polsek = Polsek::select('id','polres_id','nama')->where('id', $id)->first();
        $polres = Polres::select('id','nama')->get();
        return view('superadmin.polsek.edit',compact('polsek','polres'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'nama' => 'required|string|max:255',   
            'polres_id' => 'required',   
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'polres_id.required' => 'Polres wajib dipilih.',
        ]);

        try {
            $polsek = Polsek::findOrFail($id);
            $polsek->polres_id = $request->polres_id;
            $polsek->nama = $request->nama;

            $polsek->save();

            return redirect()->route('superadmin.polsek')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Data Polsek berhasil diperbarui!'
            ]);
            
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi kesalahan saat update data. Silakan coba lagi.'
            ]);
        }

    }
    public function destroy($id){
        try {
            $polsek = Polsek::where('id', $id)->firstOrFail();
            $polsek->delete();

            return redirect()->route('superadmin.polsek')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Data polsek berhasil dihapus.',
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('superadmin.polsek')->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.',
            ]);
        }
        

    }
}
