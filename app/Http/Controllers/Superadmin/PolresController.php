<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Polres;

class PolresController extends Controller
{
    public function index(){
        $polres = Polres::select('id','nama','stok_beras','distribusi_beras')->paginate(10);
        return view('superadmin.polres.page',compact('polres'));
    }

    public function tambahPage(){
        return view('superadmin.polres.tambah');
    }

    public function store(Request $request){
        $request->validate([
            'nama' => 'required|string|max:255',   
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 255 karakter.',
        ]);

        try {
            Polres::create([
                'nama' => $request->nama,
            ]);
            return redirect()->route('superadmin.polres')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Data Polres/ta Berhasil Di Tambah!'
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
        $polres = Polres::select('id','nama')->where('id',$id)->first();
        return view('superadmin.polres.edit',compact('polres'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'nama' => 'required|string|max:255',   
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 255 karakter.',
        ]);

        try {
            $polres = Polres::findOrFail($id);
            $polres->nama = $request->nama;

            $polres->save();

            return redirect()->route('superadmin.polres')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Data Polres/ta berhasil diperbarui!'
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
            $polres = Polres::where('id', $id)->firstOrFail();
            $polres->delete();

            return redirect()->route('superadmin.polres')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Data polres berhasil dihapus.',
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('superadmin.polres')->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.',
            ]);
        }
        

    }
}
