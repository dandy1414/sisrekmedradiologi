<?php

namespace App\Http\Controllers;

use PDF;
use Session;
use App\Models\Pasien;
use App\User;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ExpertiseNotifikasi;
use App\Notifications\ExpertisePoliNotifikasi;

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
        $total_belum = Pemeriksaan::where('status_pemeriksaan', 'pending')->count();
        $total_selesai = Pemeriksaan::where('expertise_pdf', '>', '0')->where('updated_at', 'like', $tgl_hari_ini)->count();

        $id_dokterRadiologi = Auth::user()->id;
        $belum = Pemeriksaan::where('status_pemeriksaan', 'pending')->where('id_dokterRadiologi', $id_dokterRadiologi)->orderBy('created_at', 'desc')->get();
        $selesai = Pemeriksaan::where('status_pemeriksaan', 'selesai')->where('id_dokterRadiologi', $id_dokterRadiologi)->orderBy('created_at', 'desc')->get();

        return view('dokterRadiologi.index_pemeriksaan', ['belum'=> $belum, 'selesai'=>$selesai, 'total_belum'=>$total_belum, 'total_selesai'=>$total_selesai]);
    }

    public function detailPemeriksaan($id){
        $pemeriksaan = Pemeriksaan::findOrFail($id);
        $this->markAsReadNotification($id);

        return view('dokterRadiologi.detail_pemeriksaan', ['pemeriksaan'=> $pemeriksaan]);
    }

    public function expertisePasien($id){
        $pemeriksaan = Pemeriksaan::where('id', $id)->firstOrFail();
        $id = DB::table('notifications')->where('data', 'like', '%"id":'.$id.'%')->value('id');
        $this->markAsReadNotification($id);

        return view('dokterRadiologi.expertise_pasien', ['pemeriksaan'=>$pemeriksaan]);
    }

    public function storeExpertisePasien(Request $request, $id){
        $pemeriksaan = Pemeriksaan::where('id', $id)->firstOrFail();
        $waktu_kirim = $pemeriksaan->waktu_kirim;
        $penerima_radiografer = User::where('id', $pemeriksaan->id_radiografer)->get();
        $penerima_dokterPoli = User::where('id', $pemeriksaan->id_dokterPoli)->get();

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

            $nama_pasien = $pemeriksaan->pasien->nama;

            Notification::send($penerima_radiografer, new ExpertiseNotifikasi($expertise, $nama_pasien));
            Notification::send($penerima_dokterPoli, new ExpertisePoliNotifikasi($expertise, $nama_pasien));

            DB::commit();

            Session::flash('store_succeed', 'Expertise berhasil tersimpan, silahkan export pdf hasil expertise terlebih dahulu untuk di tanda tangani');
            return view('dokterRadiologi.hasil_expertise', ['pemeriksaan' => $expertise]);
        }
        catch(QueryException $x){
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('store_failed', 'Expertise gagal tersimpan');
            return redirect()->route('dokterRadiologi.pasien.expertise-pasien');
        }
    }

    public function uploadHasilExpertise(Request $request, $id){
        $upload_expertise = Pemeriksaan::findOrFail($id);
        DB::beginTransaction();
        try{
            if($upload_expertise->expertise_pdf == null){
                if($request->hasFile('hasil')){
                    $resource = $request->hasil;
                    $name = Str::slug($upload_expertise->pasien->nama."_".time()).".".$resource->getClientOriginalExtension();
                    $resource->move(\base_path() ."/public/storage/hasil_expertise", $name);
                    $upload_expertise->expertise_pdf = $name;
                }
            }
            $upload_expertise->save();

            DB::commit();
            Session::flash('upload_succeed', 'Upload hasil expertise berhasil');
            return redirect()->route('dokterRadiologi.pasien.index-pemeriksaan');
        }catch (QueryException $x){
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('upload_failed', 'Upload hasil expertise gagal');
            return view('hasilExpertise.hasil_expertise', compact('upload_expertise'));
        }
    }

    public function downloadHasilExpertise($id){
        $pemeriksaan = Pemeriksaan::findOrFail($id);

        if($pemeriksaan->expertise_pdf_radiografer == null){
            $nama_file = $pemeriksaan->expertise_pdf;
            return Storage::disk('local')->download('public/hasil_expertise/'.$nama_file);
        }else{
            $nama_file = $pemeriksaan->expertise_pdf_radiografer;
            return Storage::disk('local')->download('public/hasil_expertise/'.$nama_file);
        }
    }

    public function detailSuratRujukan($id){
        $pendaftaran = Pendaftaran::findOrFail($id);

        return view('suratRujukan.surat_rujukan', compact('pendaftaran'));
    }

    public function detailHasilExpertise($id){
        $pemeriksaan = Pemeriksaan::findOrFail($id);
        $this->markAsReadNotification($id);

        return view('hasilExpertise.hasil_expertise', compact('pemeriksaan'));
    }

    public function hasilExpertise($id){
        $pemeriksaan = Pemeriksaan::findOrFail($id);

        $pdf = PDF::loadview('hasilExpertise.hasil_expertise_pdf', ['pemeriksaan'=>$pemeriksaan])->setPaper('A4', 'potrait');
        return $pdf->stream('hasil-expertise-'.$pemeriksaan->nomor_pemeriksaan.'.pdf');
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
