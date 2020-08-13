<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Film;
use App\Models\Layanan;
use App\Models\Kategori;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PelayananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $jadwal = Jadwal::all();
        $layanan = Layanan::all();
        $kategori = Kategori::all();
        $film = Film::all();

        // dd($layanan->id_kategori);

        return view('admin.pelayanan.index_pelayanan', ['jadwal'=> $jadwal, 'layanan' => $layanan, 'film' => $film, 'kategori' => $kategori]);
    }

    public function storeLayanan(Request $request){
        DB::beginTransaction();

        try {
            $new_layanan = new \App\Models\Layanan;
            $new_layanan->nama = $request->nama;
            $new_layanan->id_kategori = $request->kategori;
            $new_layanan->tarif = $request->tarif;
            $new_layanan->save();

            DB::commit();
            return redirect()->route('pelayanan.index')->with(['success' => 'Layanan berhasil ditambahkan']);
        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('pelayanan.index')->with(['error' => 'Layanan gagal ditambahkan']);
        }

    }

    public function storeFilm(Request $request){
        DB::beginTransaction();

        try {
            $new_film = new \App\Models\Film;
            $new_film->nama = $request->nama;
            $new_film->harga = $request->harga;
            $new_film->save();

            DB::commit();
            return redirect()->route('pelayanan.index')->with(['success' => 'Film berhasil ditambahkan']);
        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('pelayanan.index')->with(['error' => 'Film gagal ditambahkan']);
        }

    }

    public function updateLayanan(Request $request){
        DB::beginTransaction();

        try{
            $layanan = Layanan::findOrFail($request->id_layanan);
            $layanan->nama = $request->nama;
            $layanan->id_kategori = $request->kategori;
            $layanan->tarif = $request->tarif;
            $layanan->save();

            DB::commit();

            return redirect()->route('pelayanan.index')->with(['success' => 'Layanan berhasil diubah']);
        } catch(QueryException $x){
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('pelayanan.index')->with(['success' => 'Layanan gagal diubah']);
        }

    }

    public function updateFilm(Request $request){
        DB::beginTransaction();

        try{
            $film = FIlm::findOrFail($request->id_film);
            $film->nama = $request->nama;
            $film->harga = $request->harga;
            $film->save();

            DB::commit();

            return redirect()->route('pelayanan.index')->with(['success' => 'FIlm berhasil diubah']);
        } catch(QueryException $x){
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('pelayanan.index')->with(['success' => 'Film gagal diubah']);
        }

    }

    public function deleteLayanan($id){
        Layanan::where('id', $id)->delete();

        return redirect()->route('pelayanan.index')->with(['success' => 'Layanan berhasil dihapus']);
    }

    public function deleteFilm($id){
        Film::where('id', $id)->delete();

        return redirect()->route('pelayanan.index')->with(['success' => 'Film berhasil dihapus']);
    }
}
