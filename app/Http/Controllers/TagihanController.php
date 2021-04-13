<?php

namespace App\Http\Controllers;

use PDF;
use Session;
use App\Models\Pasien;
use App\Models\Tagihan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexPasienUmum(){
        $pasien = Pasien::where('jenis_pasien', 'umum')->orderBy('created_at', 'desc')->get();

        return view('kasir.umum.index_pasien_umum', ['pasien'=> $pasien]);
    }

    public function indexPasienRs(){
        $pasien = Pasien::where('jenis_pasien', 'rs')->orderBy('created_at', 'desc')->get();

        return view('kasir.rs.index_pasien_rs', ['pasien'=> $pasien]);
    }

    public function detailPasienUmum($id){
        $pasien = Pasien::findOrFail($id);
        $tagihan = Tagihan::where('pasien_id', $id)->where('status_pembayaran', 'sudah')->orderBy('created_at', 'desc')->get();

        return view('kasir.umum.detail_pasien_umum', ['pasien'=> $pasien, 'tagihan'=> $tagihan]);
    }

    public function detailPasienRs($id){
        $pasien = Pasien::findOrFail($id);
        $tagihan = Tagihan::where('pasien_id', $id)->where('status_pembayaran', 'sudah')->orderBy('created_at', 'desc')->get();

        return view('kasir.rs.detail_pasien_rs', ['pasien'=> $pasien, 'tagihan'=> $tagihan]);
    }

    public function indexTagihan(){
        $tgl_hari_ini = date('Y-m-d').'%';
        $total_belum = Tagihan::where('status_pembayaran', 'belum')->count();
        $total_sudah = Tagihan::where('status_pembayaran', 'sudah')->where('updated_at', 'like', $tgl_hari_ini)->count();

        $belum = Tagihan::where('status_pembayaran', 'belum')->orderBy('created_at', 'desc')->get();
        $sudah = Tagihan::where('status_pembayaran', 'sudah')->orderBy('created_at', 'desc')->get();

        return view('kasir.index_tagihan', ['belum'=> $belum, 'sudah'=>$sudah, 'total_belum'=>$total_belum, 'total_sudah'=> $total_sudah]);
    }

    public function pembayaranPasien($id){
        $tagihan = Tagihan::where('id', $id)->firstOrFail();
        $id = DB::table('notifications')->where('data', 'like', '%"id":'.$id.'%')->value('id');
        $this->markAsReadNotification($id);
        $tarif = $tagihan->layanan->tarif - 25000;

        return view('kasir.pembayaran_pasien', ['tagihan'=>$tagihan, 'tarif'=>$tarif]);
    }

    public function storePembayaranPasien(Request $request, $id){
        $total_harga = Tagihan::where('id', $id)->firstOrFail();
        try{
            $bayar = Tagihan::findOrFail($id);
            $bayar->id_kasir = Auth::user()->id;
            $bayar->metode_pembayaran = $request->metode;
            $bayar->bayar = $request->bayar;
            $bayar->kembali = $request->bayar - $total_harga->total_harga;
            $bayar->tanggal = date('Y-m-d H:i:s');
            $bayar->status_pembayaran = "sudah";
            $bayar->save();

            DB::commit();

            $tagihan = Tagihan::findOrFail($id);
            $tarif = $tagihan->layanan->tarif - 25000;

            Session::flash('store_succeed', 'Pembayaran berhasil tersimpan, silahkan unduh struk pembayaran');
            return view('kasir.detail_pembayaran', ['tagihan'=>$tagihan, 'tarif'=>$tarif]);
        } catch(QueryException $x) {
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('store_failed', 'Pembayaran gagal tersimpan');
            return redirect()->route('kasir.pasien.pembayaran-pasien');
        }
    }

    public function detailTagihan($id){
        $tagihan = Tagihan::findOrFail($id);
        $tarif = $tagihan->layanan->tarif - 25000;

        return view('kasir.detail_pembayaran', ['tagihan'=>$tagihan, 'tarif'=>$tarif]);
    }

    public function strukPembayaran($id){
        $tagihan = Tagihan::findOrFail($id);
        $tarif = $tagihan->layanan->tarif - 25000;

        $pdf = PDF::loadview('strukPembayaran.struk_pembayaran_pdf', ['tagihan'=>$tagihan, 'tarif'=>$tarif])->setPaper('A4', 'potrait');
        return $pdf->stream('struk-pembayaran'.$tagihan->nomor_tagihan.'.pdf');
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
