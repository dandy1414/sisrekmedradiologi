<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Jadwal;
use App\Models\Layanan;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use App\Models\Film;
use App\User;
use App\Models\Ruangan;
use Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use PDF;

class ExpertiseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexPasienUmum(){
        $pasien = Pasien::where('jenis_pasien', 'umum')->orderBy('created_at', 'desc')->get();

        return view('dokterRadiologi.umum.index_pasien_umum', ['pasien'=> $pasien]);
    }

    public function indexPasienRs(){
        $pasien = Pasien::where('jenis_pasien', 'rs')->orderBy('created_at', 'desc')->get();

        return view('dokterRadiologi.rs.index_pasien_rs', ['pasien'=> $pasien]);
    }

    public function detailPasienUmum($id){
        $pasien = Pasien::findOrFail($id);
        $pemeriksaan = Pemeriksaan::where('pasien_id', $id)->where('status_pemeriksaan', 'selesai')->orderBy('created_at', 'desc')->get();

        return view('dokterRadiologi.umum.detail_pasien_umum', ['pasien'=> $pasien, 'pemeriksaan'=> $pemeriksaan]);
    }

    public function detailPasienRs($id){
        $pasien = Pasien::findOrFail($id);
        $pemeriksaan = Pemeriksaan::where('pasien_id', $id)->where('status_pemeriksaan', 'selesai')->orderBy('created_at', 'desc')->get();

        return view('dokterRadiologi.rs.detail_pasien_rs', ['pasien'=> $pasien, 'pemeriksaan'=> $pemeriksaan]);
    }

    public function indexPemeriksaan(){
        $tgl_hari_ini = date('Y-m-d').'%';
        $total_belum = Pemeriksaan::where('status_pemeriksaan', 'pending')->where('updated_at', 'like', $tgl_hari_ini)->count();
        $total_selesai = Pemeriksaan::where('status_pemeriksaan', 'selesai')->where('updated_at', 'like', $tgl_hari_ini)->count();

        $id_dokterRadiologi = Auth::user()->id;
        $belum = Pemeriksaan::where('status_pemeriksaan', 'pending')->where('id_dokterRadiologi', $id_dokterRadiologi)->orderBy('created_at', 'desc')->get();
        $selesai = Pemeriksaan::where('status_pemeriksaan', 'selesai')->where('id_dokterRadiologi', $id_dokterRadiologi)->orderBy('created_at', 'desc')->get();

        return view('dokterRadiologi.index_pemeriksaan', ['belum'=> $belum, 'selesai'=>$selesai, 'total_belum'=>$total_belum, 'total_selesai'=>$total_selesai]);
    }

    public function detailPemeriksaan($id){
        $pemeriksaan = Pemeriksaan::findOrFail($id);

        return view('dokterRadiologi.detail_pemeriksaan', ['pemeriksaan'=> $pemeriksaan]);
    }

    public function expertisePasien($id){
        $pemeriksaan = Pemeriksaan::where('id', $id)->firstOrFail();

        return view('dokterRadiologi.expertise_pasien', ['pemeriksaan'=>$pemeriksaan]);
    }

    public function storeExpertisePasien(Request $request, $id){
        $waktu_kirim = Pemeriksaan::where('id', $id)->value('waktu_kirim');
        DB::beginTransaction();
        try{
            $timestamp = date('Y-m-d H:i:s');
            $mulai = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $waktu_kirim);
            $selesai = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestamp);
            $selisih = $selesai->diffInSeconds($mulai);
            $durasi = gmdate('H:i:s', $selisih);
            $expertise = Pemeriksaan::findOrFail($id);
            $expertise->expertise = $request->expertise;
            $expertise->waktu_selesai = $timestamp;
            $expertise->durasi = $durasi;
            $expertise->status_pemeriksaan = "selesai";
            $expertise->save();

            DB::commit();

            $pemeriksaan = Pemeriksaan::findOrFail($id);

            return view('hasilExpertise.hasil_expertise', compact('pemeriksaan'));
        }
        catch(QueryException $x){
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('dokterRadiologi.pasien.expertise-pasien')->with(['error' => 'Expertise gagal dikirim']);
        }
    }

    public function detailSuratRujukan($id){
        $pendaftaran = Pendaftaran::findOrFail($id);

        return view('suratRujukan.surat_rujukan', compact('pendaftaran'));
    }

    public function detailHasilExpertise($id){
        $pemeriksaan = Pemeriksaan::findOrFail($id);

        return view('hasilExpertise.hasil_expertise', compact('pemeriksaan'));
    }

    public function hasilExpertise($id){
        $pemeriksaan = Pemeriksaan::findOrFail($id);

        $pdf = PDF::loadview('hasilExpertise.hasil_expertise_pdf', ['pemeriksaan'=>$pemeriksaan])->setPaper('A4', 'potrait');
        return $pdf->stream('hasil-expertise'.$pemeriksaan->nomor_pemeriksaan.'.pdf');
    }
}
