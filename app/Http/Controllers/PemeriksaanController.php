<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Pasien;
use App\Models\Layanan;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use App\Models\Film;
use App\Models\Tagihan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TagihanNotifikasi;
use App\Notifications\PemeriksaanNotifikasi;

class PemeriksaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexPasienUmum(){
        $pasien = Pasien::where('jenis_pasien', 'umum')->orderBy('created_at', 'desc')->get();

        return view('radiografer.umum.index_pasien_umum', ['pasien'=> $pasien]);
    }

    public function indexPasienRs(){
        $pasien = Pasien::where('jenis_pasien', 'rs')->orderBy('created_at', 'desc')->get();

        return view('radiografer.rs.index_pasien_rs', ['pasien'=> $pasien]);
    }

    public function detailPasienUmum($id){
        $pasien = Pasien::findOrFail($id);
        $pemeriksaan = Pemeriksaan::where('pasien_id', $id)->where('status_pemeriksaan', 'selesai')->orderBy('created_at', 'desc')->get();

        return view('radiografer.umum.detail_pasien_umum', ['pasien'=> $pasien, 'pemeriksaan'=> $pemeriksaan]);
    }

    public function detailPasienRs($id){
        $pasien = Pasien::findOrFail($id);
        $pemeriksaan = Pemeriksaan::where('pasien_id', $id)->where('status_pemeriksaan', 'selesai')->orderBy('created_at', 'desc')->get();

        return view('radiografer.rs.detail_pasien_rs', ['pasien'=> $pasien, 'pemeriksaan'=> $pemeriksaan]);
    }

    public function indexPemeriksaan(){
        $total_belum = Pemeriksaan::where('status_pemeriksaan', 'belum')->count();
        $total_pending = Pemeriksaan::where('status_pemeriksaan', 'pending')->count();
        $total_selesai = Pemeriksaan::where('status_pemeriksaan', 'selesai')->count();

        $belum = Pemeriksaan::where('status_pemeriksaan', 'belum')->orderBy('created_at', 'desc')->get();
        $pending = Pemeriksaan::where('status_pemeriksaan', 'pending')->orderBy('created_at', 'desc')->get();
        $selesai = Pemeriksaan::where('status_pemeriksaan', 'selesai')->orderBy('created_at', 'desc')->get();

        return view('radiografer.index_pemeriksaan', ['belum'=> $belum, 'pending'=>$pending, 'selesai'=>$selesai, 'total_belum'=>$total_belum, 'total_pending'=>$total_pending, 'total_selesai'=>$total_selesai]);
    }

    public function uploadHasilExpertise(Request $request, $id){
        $upload_expertise = Pemeriksaan::findOrFail($id);
        DB::beginTransaction();
        try{
            if($upload_expertise->expertise_pdf_radiografer == null){
                if($request->hasFile('hasil')){
                    $resource = $request->hasil;
                    $name = Str::slug('Radiografer-'.$upload_expertise->pasien->nama."_".time()).".".$resource->getClientOriginalExtension();
                    $resource->move(\base_path() ."/public/storage/hasil_expertise", $name);
                    $upload_expertise->expertise_pdf_radiografer = $name;
                }
            }
            $upload_expertise->save();

            DB::commit();
            Session::flash('upload_succeed', 'Upload hasil expertise berhasil');
            return redirect()->route('radiografer.pasien.index-pemeriksaan');
        }catch (QueryException $x){
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('upload_failed', 'Upload hasil expertise gagal');
            return view('hasilExpertise.hasil_expertise', compact('upload_expertise'));
        }
    }

    public function detailPemeriksaan($id){
        $pemeriksaan = Pemeriksaan::findOrFail($id);

        return view('radiografer.detail_pemeriksaan', ['pemeriksaan'=> $pemeriksaan]);
    }

    public function pemeriksaanPasien($id){
        $pemeriksaan = Pemeriksaan::where('id', $id)->firstOrFail();
        $id = DB::table('notifications')->where('data', 'like', '%"id":'.$id.'%')->value('id');
        $this->markAsReadNotification($id);

        $film = Film::all();

        return view('radiografer.pemeriksaan_pasien', ['pemeriksaan'=>$pemeriksaan, 'film'=>$film]);
    }

    public function storePemeriksaanPasien(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "hasilFoto" => '|required|file|image|mimes:jpeg,png,webp|max:2048',
            "film" =>'required',
        ])->validate();

        $pemeriksaan = Pemeriksaan::where('id', $id)->firstOrFail();
        $penerima_kasir = User::where('role', 'kasir')->get();
        $penerima_dokterRadiologi = User::where('id', $pemeriksaan->id_dokterRadiologi)->first();
        $penerima_dokterPoli = User::where('id', $pemeriksaan->id_dokterPoli)->first();
        $id_jadwal = $pemeriksaan->id_jadwal;
        $pasien_id = $pemeriksaan->pasien_id;
        $id_layanan = $pemeriksaan->id_layanan;
        $layanan = Layanan::where('id', $id_layanan)->first();
        $tarif_layanan = $layanan->tarif;
        $film = Film::where('id', $request->film)->firstOrFail();
        $id_film = $film->id;
        $harga_film = $film->harga;

        if($pemeriksaan->jenis_pemeriksaan == 'biasa'){
            DB::beginTransaction();
            try
            {
            $timestamp = date('Y-m-d H:i:s');
            $new_pemeriksaan = Pemeriksaan::findOrFail($id);
            if($pemeriksaan->hasil_foto == null){
                if($request->hasFile('hasilFoto')){
                    $resource = $request->hasilFoto;
                    $name = Str::slug($request->name."_".time()).".".$resource->getClientOriginalExtension();
                    $resource->move(\base_path() ."/public/storage/hasil_foto", $name);
                    $new_pemeriksaan->hasil_foto = $name;
                    $new_pemeriksaan->waktu_kirim = $timestamp;
                }
            }
            $new_pemeriksaan->id_radiografer = Auth::user()->id;
            $new_pemeriksaan->waktu_selesai = $timestamp;
            $new_pemeriksaan->id_film = $request->film;
            $new_pemeriksaan->catatan = $request->catatan;
            $new_pemeriksaan->arus_listrik = $request->arus;
            $new_pemeriksaan->ffd = $request->ffd;
            $new_pemeriksaan->bsf = $request->bsf;
            $new_pemeriksaan->jumlah_penyinaran = $request->jumlah;
            $new_pemeriksaan->dosis_penyinaran = $request->dosis;
            $new_pemeriksaan->status_pemeriksaan = "selesai";
            $total_tarif = $tarif_layanan + $harga_film;
            $new_pemeriksaan->total_tarif = $total_tarif;
            $new_pemeriksaan->save();

            if($pemeriksaan->pasien->jenis_pasien == 'rs' && $pemeriksaan->id_dokterPoli > 0){
                $nama_pasien = $new_pemeriksaan->pasien->nama;

                Notification::send($penerima_dokterPoli, new ExpertisePoliNotifikasi($new_pemeriksaan, $nama_pasien));
            }

            $new_tagihan = new Tagihan;
            $new_tagihan->pasien_id = $pasien_id;
            $new_tagihan->id_pemeriksaan = $id;
            $new_tagihan->id_layanan = $id_layanan;
            $new_tagihan->id_jadwal = $id_jadwal;
            $new_tagihan->id_film = $id_film;
            $new_tagihan->status_pembayaran = "belum";
            $new_tagihan->tarif_dokter = (30/100)*$tarif_layanan;
            $new_tagihan->tarif_jasa = (10/100)*$tarif_layanan;
            $new_tagihan->total_harga = $total_tarif;
            $new_tagihan->save();

            $nama_pasien_tagihan = $new_tagihan->pasien->nama;
            Notification::send($penerima_kasir, new TagihanNotifikasi($new_tagihan, $nama_pasien_tagihan));

            DB::commit();

            Session::flash('store_succeed', 'Pemeriksaan berhasil tersimpan');
            return redirect()->route('radiografer.pasien.index-pemeriksaan');

            } catch (QueryException $x)
            {
                DB::rollBack();
                // dd($x->getMessage());
                Session::flash('store_failed', 'Pemeriksaan gagal tersimpan');
                return redirect()->route('radiografer.pasien.pemeriksaan-pasien');
            }
        } else {
            DB::beginTransaction();
            try
            {
            $timestamp = date('Y-m-d H:i:s');
            $new_pemeriksaan = Pemeriksaan::findOrFail($id);
            if($pemeriksaan->hasil_foto == null){
                if($request->hasFile('hasilFoto')){
                    $resource = $request->hasilFoto;
                    $name = Str::slug($request->name."_".time()).".".$resource->getClientOriginalExtension();
                    $resource->move(\base_path() ."/public/storage/hasil_foto", $name);
                    $new_pemeriksaan->hasil_foto = $name;
                    $new_pemeriksaan->waktu_kirim = $timestamp;
                }
            }
            $new_pemeriksaan->id_radiografer = Auth::user()->id;
            $new_pemeriksaan->id_film = $request->film;
            $new_pemeriksaan->catatan = $request->catatan;
            $new_pemeriksaan->arus_listrik = $request->arus;
            $new_pemeriksaan->ffd = $request->ffd;
            $new_pemeriksaan->bsf = $request->bsf;
            $new_pemeriksaan->jumlah_penyinaran = $request->jumlah;
            $new_pemeriksaan->dosis_penyinaran = $request->dosis;
            $new_pemeriksaan->status_pemeriksaan = "pending";
            $total_tarif = $tarif_layanan + $harga_film;
            $new_pemeriksaan->total_tarif = $total_tarif;
            $new_pemeriksaan->save();

            $nama_pasien = $pemeriksaan->pasien->nama;

            Notification::send($penerima_dokterRadiologi, new PemeriksaanNotifikasi($pemeriksaan, $nama_pasien));

            $new_tagihan = new Tagihan;
            $new_tagihan->pasien_id = $pasien_id;
            $new_tagihan->id_pemeriksaan = $id;
            $new_tagihan->id_layanan = $id_layanan;
            $new_tagihan->id_jadwal = $id_jadwal;
            $new_tagihan->id_film = $id_film;
            $new_tagihan->status_pembayaran = "belum";
            $new_tagihan->tarif_dokter = (30/100)*$tarif_layanan;
            $new_tagihan->tarif_jasa = (10/100)*$tarif_layanan;
            $new_tagihan->total_harga = $total_tarif;
            $new_tagihan->save();

            $nama_pasien_tagihan = $new_tagihan->pasien->nama;
            Notification::send($penerima_kasir, new TagihanNotifikasi($new_tagihan, $nama_pasien_tagihan));

            DB::commit();

            Session::flash('store_succeed', 'Pemeriksaan berhasil tersimpan');
            return redirect()->route('radiografer.pasien.index-pemeriksaan');

            } catch (QueryException $x)
            {
                DB::rollBack();
                // dd($x->getMessage());
                Session::flash('store_failed', 'Pemeriksaan gagal tersimpan');
                return redirect()->route('radiografer.pasien.pemeriksaan-pasien');
            }
        }
    }

    public function detailSuratRujukan($id){
        $pendaftaran = Pendaftaran::findOrFail($id);

        return view('suratRujukan.surat_rujukan', compact('pendaftaran'));
    }

    public function markAsReadNotification($id){
        auth()->user()
        ->unreadNotifications
        ->when($id, function ($query) use ($id) {
            return $query->where('id', $id);
        })
        ->markAsRead();

        return response()->noContent();
    }
}
