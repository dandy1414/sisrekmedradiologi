<?php

namespace App\Http\Controllers;

use PDF;
use Session;
use App\Models\Pasien;
use App\Models\Jadwal;
use App\Models\Layanan;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use App\User;
use App\Models\Ruangan;
use App\Notifications\PendaftaranNotifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;


class PendaftaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexPasienUmum(){
        $pasien = Pasien::where('jenis_pasien', 'umum')->orderBy('created_at', 'desc')->get();

        return view('resepsionis.umum.index_pasien_umum', ['pasien'=> $pasien]);
    }

    public function indexPasienRs(){
        $pasien = Pasien::where('jenis_pasien', 'rs')->orderBy('created_at', 'desc')->get();

        return view('resepsionis.rs.index_pasien_rs', ['pasien'=> $pasien]);
    }

    public function detailPasienUmum($id){
        $pasien = Pasien::findOrFail($id);
        $pendaftaran = Pendaftaran::where('pasien_id', $id)->orderBy('created_at', 'desc')->get();

        return view('resepsionis.umum.detail_pasien_umum', ['pasien'=> $pasien, 'pendaftaran'=> $pendaftaran]);
    }

    public function detailPasienRs($id){
        $pasien = Pasien::findOrFail($id);
        $pendaftaran = Pendaftaran::where('pasien_id', $id)->orderBy('created_at', 'desc')->get();

        return view('resepsionis.rs.detail_pasien_rs', ['pasien'=> $pasien, 'pendaftaran'=> $pendaftaran]);
    }

    public function createPasienUmum(){
        $last_nomor_rm = Pasien::max('nomor_rm');
        if($last_nomor_rm == null){
            $nomor_rm = 1;
        }else{
            $nomor_rm = $last_nomor_rm + 1;
        }

        $nomor_rm = str_pad($nomor_rm, 6, '0', STR_PAD_LEFT);
        return view('resepsionis.umum.create_pasien_umum', ['nomor_rm' => $nomor_rm]);
    }

    public function createPasienRs(){
        $ruangan = Ruangan::all();
        $last_nomor_rm = Pasien::max('nomor_rm');
        if($last_nomor_rm == null){
            $nomor_rm = 1;
        }else{
            $nomor_rm = $last_nomor_rm + 1;
        }

        $nomor_rm = str_pad($nomor_rm, 6, '0', STR_PAD_LEFT);

        return view('resepsionis.rs.create_pasien_rs', ['ruangan' => $ruangan, 'nomor_rm' => $nomor_rm]);
    }

    public function storePasienUmum(Request $request){
        $validator = Validator::make($request->all(),[
            "nama" => "required|min:3|max:100",
            "nomorKtp" => "required|size:16|string|unique:trans_pasien,nomor_ktp",
            "umur" => "required|numeric",
            "jenisKelamin" => "required",
            "alamat" => "required|min:5|max:200",
            "nomorTelepon" => "required|numeric|digits_between:10,12|unique:trans_pasien,nomor_telepon",
            "jenisAsuransi" => "required",
        ])->validate();

        DB::beginTransaction();

        try{
            $new_pasien = new \App\Models\Pasien;
            $new_pasien->nomor_rm = $request->rekamMedis;
            $new_pasien->nomor_ktp = $request->nomorKtp;
            $new_pasien->nama = $request->nama;
            $new_pasien->jenis_pasien = "umum";
            $new_pasien->umur = $request->umur;
            $new_pasien->jenis_kelamin = $request->jenisKelamin;
            $new_pasien->alamat = $request->alamat;
            $new_pasien->nomor_telepon = $request->nomorTelepon;
            $new_pasien->jenis_asuransi = $request->jenisAsuransi;
            $new_pasien->nomor_bpjs = $request->noBpjs;

            $new_pasien->save();

            DB::commit();

            Session::flash('store_succeed', 'Data pasien berhasil tersimpan');
            return redirect()->route('resepsionis.pasien.index-pasien-umum');
        } catch (QueryException $x)
        {
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('store_failed', 'Data pasien gagal tersimpan');
            return redirect()->route('resepsionis.pasien.create.pasien-umum');
        }
    }

    public function storePasienRs(Request $request){
        $validator = Validator::make($request->all(),[
            "nama" => "required|min:3|max:100",
            "nomorKtp" => "required|size:16|string|unique:trans_pasien,nomor_ktp",
            "umur" => "required|numeric",
            "jenisKelamin" => "required",
            "asalRuangan" => "required",
            "alamat" => "required|min:5|max:200",
            "nomorTelepon" => "required|numeric|digits_between:10,12|unique:trans_pasien,nomor_telepon",
            "jenisAsuransi" => "required",
        ])->validate();

        DB::beginTransaction();

        try{
            $new_pasien = new \App\Models\Pasien;
            $new_pasien->nomor_rm = $request->rekamMedis;
            $new_pasien->nomor_ktp = $request->nomorKtp;
            $new_pasien->nama = $request->nama;
            $new_pasien->jenis_pasien = "rs";
            $new_pasien->umur = $request->umur;
            $new_pasien->id_ruangan = $request->asalRuangan;
            $new_pasien->jenis_kelamin = $request->jenisKelamin;
            $new_pasien->alamat = $request->alamat;
            $new_pasien->nomor_telepon = $request->nomorTelepon;
            $new_pasien->jenis_asuransi = $request->jenisAsuransi;
            $new_pasien->nomor_bpjs = $request->noBpjs;

            $new_pasien->save();

            DB::commit();
            Session::flash('store_succeed', 'Data pasien berhasil tersimpan');
            return redirect()->route('resepsionis.pasien.index-pasien-rs');
        } catch (QueryException $x)
        {
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('store_failed', 'Data pasien gagal tersimpan');
            return redirect()->route('resepsionis.pasien.create.pasien-rs');
        }
    }

    public function editPasienUmum($id){
        $ruangan = Ruangan::all();
        $pasien = Pasien::where('id', $id)->first();

        return view('resepsionis.umum.edit_pasien_umum', ['pasien'=> $pasien, 'ruangan' => $ruangan]);
    }

    public function editPasienRs($id){
        $ruangan = Ruangan::all();
        $pasien = Pasien::where('id', $id)->first();

        return view('resepsionis.rs.edit_pasien_rs', ['pasien'=> $pasien, 'ruangan' => $ruangan]);
    }

    public function updatePasienUmum(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "nama" => "required|min:3|max:100",
            "nomorKtp" => "required|size:16|string|unique:trans_pasien,nomor_ktp,". $id,
            "umur" => "required|numeric",
            "jenisKelamin" => "required",
            "alamat" => "required|min:5|max:200",
            "nomorTelepon" => "required|numeric|digits_between:10,12|unique:trans_pasien,nomor_telepon,". $id,
            "jenisAsuransi" => "required"
        ])->validate();

        DB::beginTransaction();

        try{

            $pasien = Pasien::where('id', $id)->first();
            $pasien->nomor_ktp = $request->nomorKtp;
            $pasien->nama = $request->nama;
            $pasien->jenis_pasien = $request->jenisPasien;
            $pasien->umur = $request->umur;
            $pasien->id_ruangan = $request->asalRuangan;
            $pasien->jenis_kelamin = $request->jenisKelamin;
            $pasien->id_ruangan = $request->asalRuangan;
            $pasien->alamat = $request->alamat;
            $pasien->nomor_telepon = $request->nomorTelepon;
            $pasien->jenis_asuransi = $request->jenisAsuransi;
            $pasien->nomor_bpjs = $request->noBpjs;
            $pasien->save();

            DB::commit();

            if($pasien->wasChanged() == true){
                Session::flash('update_succeed', 'Data pasien berhasil terubah');
            }

            return redirect()->route('resepsionis.pasien.index-pasien-umum');

        } catch (QueryException $x)
        {
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('update_failed', 'Data pasien gagal terubah');
            return redirect()->route('resepsionis.pasien.edit-pasien-umum');
        }
    }

    public function updatePasienRs(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "nama" => "required|min:3|max:100",
            "nomorKtp" => "required|size:16|string|unique:trans_pasien,nomor_ktp,". $id,
            "umur" => "required|numeric",
            "asalRuangan" => "required",
            "jenisKelamin" => "required",
            "alamat" => "required|min:5|max:200",
            "nomorTelepon" => "required|numeric|digits_between:10,12|unique:trans_pasien,nomor_telepon,". $id,
            "jenisAsuransi" => "required",
        ])->validate();

        DB::beginTransaction();

        try{
            $pasien = Pasien::where('id', $id)->first();
            $pasien->nomor_ktp = $request->nomorKtp;
            $pasien->nama = $request->nama;
            $pasien->umur = $request->umur;
            $pasien->id_ruangan = $request->asalRuangan;
            $pasien->jenis_kelamin = $request->jenisKelamin;
            $pasien->id_ruangan = $request->asalRuangan;
            $pasien->alamat = $request->alamat;
            $pasien->nomor_telepon = $request->nomorTelepon;
            $pasien->jenis_asuransi = $request->jenisAsuransi;
            $pasien->nomor_bpjs = $request->noBpjs;
            $pasien->save();

            DB::commit();

            if($pasien->wasChanged() == true){
                Session::flash('update_succeed', 'Data pasien berhasil terubah');
            }
            return redirect()->route('resepsionis.pasien.index-pasien-rs');

        } catch (QueryException $x)
        {
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('update_failed', 'Data pasien gagal terubah');
            return redirect()->route('resepsionis.pasien.edit-pasien-rs');
        }
    }

    public function indexPendaftaran(){
        $pendaftaran = Pendaftaran::orderBy('created_at', 'desc')->get();
        $tgl_hari_ini = date('Y-m-d').'%';
        $total_pasien = Pendaftaran::where('created_at', 'like', $tgl_hari_ini)->count();

        return view('resepsionis.index_pendaftaran', ['pendaftaran'=> $pendaftaran, 'total_pasien' => $total_pasien]);
    }

    public function pendaftaranPasienUmum($id){
        $pasien = Pasien::where('id', $id)->firstOrFail();
        $layanan_rontgen = Layanan::where('id_kategori', '2')->get();
        $layanan_usg = Layanan::where('id_kategori', '1')->get();
        $dokter = User::where('role', 'dokterRadiologi')->get();

        $tgl_hari_ini = date('Y-m-d').'%';
        $jadwal_has_used = Pendaftaran::where('created_at', 'like', $tgl_hari_ini)->distinct()->pluck('id_jadwal')->toArray();
        $jadwal = Jadwal::whereNotIn('id', $jadwal_has_used)->get();

        return view('resepsionis.umum.pendaftaran_pasien_umum', ['dokter' => $dokter,'pasien' => $pasien, 'layanan_rontgen' => $layanan_rontgen, 'layanan_usg' => $layanan_usg, 'jadwal' => $jadwal]);
    }

    public function pendaftaranPasienRs($id){
        $pasien = Pasien::where('id', $id)->firstOrFail();
        $layanan_rontgen = Layanan::where('id_kategori', '2')->get();
        $layanan_usg = Layanan::where('id_kategori', '1')->get();
        $dokter_poli = User::where('role', 'dokterPoli')->get();
        $dokter_radiologi = User::where('role', 'dokterRadiologi')->get();

        $tgl_hari_ini = date('Y-m-d').'%';
        $jadwal_has_used = Pendaftaran::where('created_at', 'like', $tgl_hari_ini)->distinct()->pluck('id_jadwal')->toArray();
        $jadwal = Jadwal::whereNotIn('id', $jadwal_has_used)->get();

        return view('resepsionis.rs.pendaftaran_pasien_rs', ['dokter_poli' => $dokter_poli, 'dokter_radiologi' => $dokter_radiologi, 'pasien' => $pasien, 'layanan_rontgen' => $layanan_rontgen, 'layanan_usg' => $layanan_usg, 'jadwal' => $jadwal]);
    }

    public function storePendaftaranPasienUmum(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "jenisPemeriksaan" => "required",
            "layanan" => "required",
            "jadwal" => "required",
        ])->validate();

        $penerima_radiografer = User::where('role', 'radiografer')->get();

        if($request->jenisPemeriksaan == 'biasa'){
            $new_pendaftaran = new Pendaftaran();
            $new_pendaftaran->jenis_pemeriksaan = $request->jenisPemeriksaan;
            $new_pendaftaran->pasien_id = $id;
            $new_pendaftaran->id_jadwal = $request->jadwal;
            $new_pendaftaran->id_layanan = $request->layanan;
            $new_pendaftaran->id_resepsionis = Auth::user()->id;
            $new_pendaftaran->id_dokterRadiologi = $request->dokterRujukan;
            $new_pendaftaran->keluhan = $request->keluhan;
            $new_pendaftaran->save();

            $id_pendaftaran = $new_pendaftaran->id;

            DB::beginTransaction();
            try{
                $tarif = Layanan::where('id', $request->layanan)->value('tarif');
                $pemeriksaan = new Pemeriksaan;
                $pemeriksaan->pendaftaran_id = $id_pendaftaran;
                $pemeriksaan->jenis_pemeriksaan = $request->jenisPemeriksaan;
                $pemeriksaan->pasien_id = $id;
                $pemeriksaan->id_jadwal = $request->jadwal;
                $pemeriksaan->id_layanan = $request->layanan;
                $pemeriksaan->id_dokterRadiologi = $request->dokterRujukan;
                $pemeriksaan->keluhan = $request->keluhan;
                $pemeriksaan->total_tarif = $tarif;
                $pemeriksaan->save();

                $nama_pasien = $pemeriksaan->pasien->nama;

                Notification::send($penerima_radiografer, new PendaftaranNotifikasi($pemeriksaan, $nama_pasien));

                DB::commit();

                Session::flash('store_succeed', 'Pendaftaran berhasil tersimpan');
                return redirect()->route('resepsionis.pasien.index.pendaftaran');
            }catch (QueryException $x){
                DB::rollBack();
                // dd($x->getMessage());
                Session::flash('store_failed', 'Pendaftaran gagal tersimpan');
                return redirect()->route('resepsionis.pasien.pendaftaran.pasien-umum');
            }
        } else {
            $new_pendaftaran = new Pendaftaran();
            $new_pendaftaran->jenis_pemeriksaan = $request->jenisPemeriksaan;
            $new_pendaftaran->pasien_id = $id;
            $new_pendaftaran->id_jadwal = $request->jadwal;
            $new_pendaftaran->id_layanan = $request->layanan;
            $new_pendaftaran->id_resepsionis = Auth::user()->id;
            $new_pendaftaran->id_dokterPoli = $request->dokterPerujuk;
            $new_pendaftaran->id_dokterRadiologi = $request->dokterRujukan;
            $new_pendaftaran->keluhan = $request->keluhan;
            $new_pendaftaran->save();

            $id_pendaftaran = $new_pendaftaran->id;

            DB::beginTransaction();
            try{
                $tarif = Layanan::where('id', $request->layanan)->value('tarif');
                $pemeriksaan = new Pemeriksaan;
                $pemeriksaan->pendaftaran_id = $id_pendaftaran;
                $pemeriksaan->jenis_pemeriksaan = $request->jenisPemeriksaan;
                $pemeriksaan->pasien_id = $id;
                $pemeriksaan->id_jadwal = $request->jadwal;
                $pemeriksaan->id_layanan = $request->layanan;
                $pemeriksaan->id_dokterPoli = $request->dokterPerujuk;
                $pemeriksaan->id_dokterRadiologi = $request->dokterRujukan;
                $pemeriksaan->keluhan = $request->keluhan;
                $pemeriksaan->permintaan_tambahan = $request->permintaan;
                $pemeriksaan->total_tarif = $tarif;
                $pemeriksaan->save();

                $nama_pasien = $pemeriksaan->pasien->nama;

                Notification::send($penerima_radiografer, new PendaftaranNotifikasi($pemeriksaan, $nama_pasien));

                DB::commit();

                $pendaftaran = Pendaftaran::findOrFail($id_pendaftaran);

                Session::flash('store_succeed', 'Pendaftaran berhasil tersimpan');
                return view('suratRujukan.surat_rujukan', compact('pendaftaran'));
            }catch (QueryException $x){
                DB::rollBack();
                // dd($x->getMessage());
                Session::flash('store_failed', 'Pendaftaran gagal tersimpan');
                return redirect()->route('resepsionis.pasien.pendaftaran.pasien-umum');
            }
        }
    }

    public function storePendaftaranPasienRs(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "jenisPemeriksaan" => "required",
            "layanan" => "required",
            "jadwal" => "required",
        ])->validate();

        $penerima_radiografer = User::where('role', 'radiografer')->get();

        if($request->jenisPemeriksaan == 'biasa'){
            $new_pendaftaran = new Pendaftaran();
            $new_pendaftaran->jenis_pemeriksaan = $request->jenisPemeriksaan;
            $new_pendaftaran->pasien_id = $id;
            $new_pendaftaran->id_jadwal = $request->jadwal;
            $new_pendaftaran->id_layanan = $request->layanan;
            $new_pendaftaran->id_resepsionis = Auth::user()->id;
            $new_pendaftaran->id_dokterPoli = $request->dokterPerujuk;
            $new_pendaftaran->id_dokterRadiologi = $request->dokterRujukan;
            $new_pendaftaran->keluhan = $request->keluhan;
            $new_pendaftaran->save();

            $id_pendaftaran = $new_pendaftaran->id;

            DB::beginTransaction();
            try{
                $tarif = Layanan::where('id', $request->layanan)->value('tarif');
                $pemeriksaan = new Pemeriksaan;
                $pemeriksaan->pendaftaran_id = $id_pendaftaran;
                $pemeriksaan->jenis_pemeriksaan = $request->jenisPemeriksaan;
                $pemeriksaan->cito = $request->cito;
                $pemeriksaan->pasien_id = $id;
                $pemeriksaan->id_jadwal = $request->jadwal;
                $pemeriksaan->id_layanan = $request->layanan;
                $pemeriksaan->id_dokterRadiologi = $request->dokterRujukan;
                $pemeriksaan->keluhan = $request->keluhan;
                $pemeriksaan->total_tarif = $tarif;
                $pemeriksaan->save();

                $nama_pasien = $pemeriksaan->pasien->nama;

                Notification::send($penerima_radiografer, new PendaftaranNotifikasi($pemeriksaan, $nama_pasien));

                DB::commit();

                Session::flash('store_succeed', 'Pendaftaran berhasil tersimpan');
                return redirect()->route('resepsionis.pasien.index.pendaftaran');
            }catch (QueryException $x){
                DB::rollBack();
                // dd($x->getMessage());
                Session::flash('store_failed', 'Pendaftaran gagal tersimpan');
                return redirect()->route('resepsionis.pasien.pendaftaran.pasien-umum');
            }
        }else{
            $new_pendaftaran = new Pendaftaran();
            $new_pendaftaran->jenis_pemeriksaan = $request->jenisPemeriksaan;
            $new_pendaftaran->pasien_id = $id;
            $new_pendaftaran->id_jadwal = $request->jadwal;
            $new_pendaftaran->id_layanan = $request->layanan;
            $new_pendaftaran->id_resepsionis = Auth::user()->id;
            $new_pendaftaran->id_dokterRadiologi = $request->dokterRujukan;
            $new_pendaftaran->id_dokterPoli = $request->dokterPerujuk;
            $new_pendaftaran->keluhan = $request->keluhan;
            $new_pendaftaran->save();

            $id_pendaftaran = $new_pendaftaran->id;

            DB::beginTransaction();
            try{
                $tarif = Layanan::where('id', $request->layanan)->value('tarif');
                $pemeriksaan = new Pemeriksaan;
                $pemeriksaan->pendaftaran_id = $id_pendaftaran;
                $pemeriksaan->jenis_pemeriksaan = $request->jenisPemeriksaan;
                $pemeriksaan->cito = $request->cito;
                $pemeriksaan->pasien_id = $id;
                $pemeriksaan->id_jadwal = $request->jadwal;
                $pemeriksaan->id_layanan = $request->layanan;
                $pemeriksaan->id_dokterRadiologi = $request->dokterRujukan;
                $pemeriksaan->id_dokterPoli = $request->dokterPerujuk;
                $pemeriksaan->keluhan = $request->keluhan;
                $pemeriksaan->permintaan_tambahan = $request->permintaan;
                $pemeriksaan->total_tarif = $tarif;
                $pemeriksaan->save();

                $nama_pasien = $pemeriksaan->pasien->nama;

                Notification::send($penerima_radiografer, new PendaftaranNotifikasi($pemeriksaan, $nama_pasien));

                DB::commit();

                $pendaftaran = Pendaftaran::findOrFail($id_pendaftaran);

                Session::flash('store_succeed', 'Pendaftaran berhasil tersimpan, silahkan unduh surat rujukan terlebih dahulu');
                return view('suratRujukan.surat_rujukan', compact('pendaftaran'));
            }catch (QueryException $x){
                DB::rollBack();
                // dd($x->getMessage());
                Session::flash('store_failed', 'Pendaftaran gagal tersimpan');
                return redirect()->route('resepsionis.pasien.pendaftaran.pasien-umum');
            }
        }
    }

    public function uploadSuratRujukan(Request $request, $id){
        $upload_surat = Pendaftaran::findOrFail($id);
        DB::beginTransaction();
        try{
            if($upload_surat->surat_rujukan_pdf == null){
                if($request->hasFile('suratRujukan')){
                    $resource = $request->suratRujukan;
                    $name = Str::slug($upload_surat->pasien->nama."_".time()).".".$resource->getClientOriginalExtension();
                    $resource->move(\base_path() ."/public/storage/surat_rujukan", $name);
                    $upload_surat->surat_rujukan_pdf = $name;
                }
            }
            $upload_surat->save();

            DB::commit();
            Session::flash('upload_succeed', 'Upload surat berhasil');
            return redirect()->route('resepsionis.pasien.index.pendaftaran');
        }catch (QueryException $x){
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('upload_failed', 'Upload surat gagal');
            return view('suratRujukan.surat_rujukan', compact('pendaftaran'));
        }
    }

    public function downloadSuratRujukan($id){
        $pendaftaran = Pendaftaran::findOrFail($id);
        $nama_file = $pendaftaran->surat_rujukan_pdf;

        return Storage::disk('local')->download('public/surat_rujukan/'.$nama_file);
    }

    public function detailSuratRujukan($id){
        $pendaftaran = Pendaftaran::findOrFail($id);

        return view('suratRujukan.surat_rujukan', compact('pendaftaran'));
    }

    public function suratRujukan($id){
        $pendaftaran = Pendaftaran::findOrFail($id);

        $pdf = PDF::loadview('suratRujukan.surat_rujukan_pdf', ['pendaftaran' => $pendaftaran])
        ->setPaper('A4', 'potrait');
        return $pdf->stream('surat-rujukan-'.$pendaftaran->nomor_pendaftaran.'.pdf', array('Attachment' => false));
    }

}
