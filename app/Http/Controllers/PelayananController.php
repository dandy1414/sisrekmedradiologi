<?php

namespace App\Http\Controllers;

use Session;
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
            Session::flash('store_layanan_succeed', 'Data layanan berhasil tersimpan');
            return redirect()->route('pelayanan.index');
        } catch (QueryException $x)
        {
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('store_layanan_failed', 'Data layanan gagal tersimpan');
            return redirect()->route('pelayanan.index');
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
            Session::flash('store_film_succeed', 'Data film berhasil tersimpan');
            return redirect()->route('pelayanan.index');
        } catch (QueryException $x)
        {
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('store_film_failed', 'Data film gagal tersimpan');
            return redirect()->route('pelayanan.index');
        }

    }

    public function updateLayanan(Request $request){
        DB::beginTransaction();

        try{
            $layanan = Layanan::where($request->id_layanan)->first();
            $layanan->nama = $request->nama;
            $layanan->id_kategori = $request->kategori;
            $layanan->tarif = $request->tarif;
            $layanan->save();

            DB::commit();

            if($layanan->wasChanged() == true){
                Session::flash('update_layanan_succeed', 'Data layanan berhasil terubah');
            }

            return redirect()->route('pelayanan.index');
        } catch(QueryException $x){
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('update_layanan_failed', 'Data layanan gagal terubah');
            return redirect()->route('pelayanan.index');
        }

    }

    public function updateFilm(Request $request){
        DB::beginTransaction();

        try{
            $film = Film::findOrFail($request->id_film);
            $film->nama = $request->nama;
            $film->harga = $request->harga;
            $film->save();

            DB::commit();

            if($film->wasChanged() == true){
                Session::flash('update_film_succeed', 'Data film berhasil terubah');
            }

            return redirect()->route('pelayanan.index');
        } catch(QueryException $x){
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('update_film_failed', 'Data film gagal terubah');
            return redirect()->route('pelayanan.index');
        }

    }

    public function deleteLayanan($id){
        Layanan::where('id', $id)->delete();

        Session::flash('delete_layanan_succeed', 'Data layanan berhasil terhapus');
        return redirect()->route('pelayanan.index');
    }

    public function deleteFilm($id){
        Film::where('id', $id)->delete();

        Session::flash('delete_film_succeed', 'Data film berhasil terhapus');
        return redirect()->route('pelayanan.index');
    }
}
