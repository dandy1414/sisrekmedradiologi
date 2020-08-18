<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Jadwal;
use App\Models\Layanan;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use App\Models\Film;
use App\Models\Tagihan;
use App\User;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PDF;

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
        $belum = Tagihan::where('status_pembayaran', 'belum')->orderBy('created_at', 'desc')->get();
        $sudah = Tagihan::where('status_pembayaran', 'sudah')->orderBy('created_at', 'desc')->get();

        return view('kasir.index_tagihan', ['belum'=> $belum, 'sudah'=>$sudah]);
    }

    public function pembayaranPasien($id){
        $tagihan = Tagihan::where('id', $id)->firstOrFail();
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

            return view('kasir.detail_pembayaran', ['tagihan'=>$tagihan, 'tarif'=>$tarif]);
        } catch(QueryException $x) {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('kasir.pasien.pembayaran-pasien')->with(['error' => 'Pembayaran gagal']);
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
}
