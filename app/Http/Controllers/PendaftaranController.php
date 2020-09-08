<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Jadwal;
use App\Models\Layanan;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use App\User;
use Alert;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use PDF;

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
        return view('resepsionis.umum.create_pasien_umum');
    }

    public function createPasienRs(){
        $ruangan = Ruangan::all();
        return view('resepsionis.rs.create_pasien_rs', ['ruangan' => $ruangan]);
    }

    public function storePasienUmum(Request $request){
            $validator = Validator::make($request->all(),[
                "nomorRm" => "required|max:6|unique:trans_pasien,nomor_rm",
                "nama" => "required|min:3|max:100",
                "nomorKtp" => "required|max:16|unique:trans_pasien,nomor_ktp",
                "umur" => "required|numeric",
                "jenisKelamin" => "required",
                "alamat" => "required|min:5|max:200",
                "nomorTelepon" => "required|digits_between:10,12|unique:trans_pasien,nomor_telepon",
                "jenisAsuransi" => "required",
            ])->validate();

        DB::beginTransaction();

        try{
            $new_pasien = new \App\Models\Pasien;
            $new_pasien->nomor_rm = $request->nomorRm;
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
            return redirect()->route('resepsionis.pasien.index-pasien-umum')->with(['success' => 'Pasien berhasil ditambahkan']);
        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('resepsionis.pasien.create.pasien-umum')->with(['error' => 'Pasien gagal ditambahkan']);
        }
    }

    public function storePasienRs(Request $request){
        $validator = Validator::make($request->all(),[
            "nomorRm" => "required|max:6|unique:trans_pasien,nomor_rm",
            "nama" => "required|min:3|max:100",
            "nomorKtp" => "required|max:16|unique:trans_pasien,nomor_ktp",
            "umur" => "required|numeric",
            "jenisKelamin" => "required",
            "alamat" => "required|min:5|max:200",
            "nomorTelepon" => "required|digits_between:10,12|unique:trans_pasien,nomor_telepon",
            "jenisAsuransi" => "required",
        ])->validate();

        DB::beginTransaction();

        try{
            $new_pasien = new \App\Models\Pasien;
            $new_pasien->nomor_rm = $request->nomorRm;
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
            return redirect()->route('resepsionis.pasien.index-pasien-rs')->with(['success' => 'Pasien berhasil ditambahkan']);
        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('resepsionis.pasien.create.pasien-rs')->with(['error' => 'Pasien gagal ditambahkan']);
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
            "noRm" => "required|max:6|unique:trans_pasien,nomor_rm,". $id,
            "nama" => "required|min:3|max:100",
            "nomorKtp" => "required|max:16|unique:trans_pasien,nomor_ktp,". $id,
            "umur" => "required|numeric",
            "jenisKelamin" => "required",
            "alamat" => "required|min:5|max:200",
            "nomorTelepon" => "required|digits_between:10,12|unique:trans_pasien,nomor_telepon,". $id,
            "jenisAsuransi" => "required"
        ])->validate();

        DB::beginTransaction();

        try{

            Pasien::where('id', $id)->update([
                'nomor_rm' => $request->noRm,
                'nomor_ktp' => $request->nomorKtp,
                'nama' => $request->nama,
                'jenis_pasien' => $request->jenisPasien,
                'umur' => $request->umur,
                'id_ruangan' => $request->asalRuangan,
                'jenis_kelamin' => $request->jenisKelamin,
                'alamat' => $request->alamat,
                'nomor_telepon' => $request->nomorTelepon,
                'jenis_asuransi' => $request->jenisAsuransi,
                'nomor_bpjs' => $request->noBpjs,
            ]);

            DB::commit();
            return redirect()->route('resepsionis.pasien.index-pasien-umum')->with(['success' => 'Pasien berhasil diedit']);

        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('resepsionis.pasien.edit-pasien-umum')->with(['error' => 'Pasien gagal diedit']);
        }
    }

    public function updatePasienRs(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "noRm" => "required|max:6|unique:trans_pasien,nomor_rm,". $id,
            "nama" => "required|min:3|max:100",
            "nomorKtp" => "required|max:16|unique:trans_pasien,nomor_ktp,". $id,
            "umur" => "required|numeric",
            "jenisKelamin" => "required",
            "alamat" => "required|min:5|max:200",
            "nomorTelepon" => "required|digits_between:10,12|unique:trans_pasien,nomor_telepon,". $id,
            "jenisAsuransi" => "required"
        ])->validate();

        DB::beginTransaction();

        try{

            Pasien::where('id', $id)->update([
                'nomor_rm' => $request->noRm,
                'nomor_ktp' => $request->nomorKtp,
                'nama' => $request->nama,
                'umur' => $request->umur,
                'id_ruangan' => $request->asalRuangan,
                'jenis_kelamin' => $request->jenisKelamin,
                'id_ruangan' => $request->asalRuangan,
                'alamat' => $request->alamat,
                'nomor_telepon' => $request->nomorTelepon,
                'jenis_asuransi' => $request->jenisAsuransi,
                'nomor_bpjs' => $request->noBpjs,
            ]);

            DB::commit();
            return redirect()->route('resepsionis.pasien.index-pasien-rs')->with(['success' => 'Pasien berhasil diedit']);

        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('resepsionis.pasien.edit-pasien-rs')->with(['error' => 'Pasien gagal diedit']);
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
        $layanan_rontgen = Layanan::where('id', '2')->get();
        $layanan_usg = Layanan::where('id', '1')->get();
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

                DB::commit();

                return redirect()->route('resepsionis.pasien.index-pasien-umum')->with(['success' => 'Pendaftaran pemeriksaan berhasil']);
            }catch (QueryException $x){
                DB::rollBack();
                dd($x->getMessage());
                return redirect()->route('resepsionis.pasien.pendaftaran.pasien-umum')->with(['error' => 'Pendaftaran pemeriksaan gagal']);
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

                DB::commit();

                $pendaftaran = Pendaftaran::findOrFail($id_pendaftaran);

                return view('suratRujukan.surat_rujukan', compact('pendaftaran'));
            }catch (QueryException $x){
                DB::rollBack();
                dd($x->getMessage());
                return redirect()->route('resepsionis.pasien.pendaftaran.pasien-umum')->with(['error' => 'Pendaftaran pemeriksaan gagal']);
            }
        }
    }

    public function storePendaftaranPasienRs(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "jenisPemeriksaan" => "required",
            "layanan" => "required",
            "jadwal" => "required",
        ])->validate();

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
                $pemeriksaan->id_pendaftaran = $id_pendaftaran;
                $pemeriksaan->jenis_pemeriksaan = $request->jenisPemeriksaan;
                $pemeriksaan->cito = $request->cito;
                $pemeriksaan->pasien_id = $id;
                $pemeriksaan->id_jadwal = $request->jadwal;
                $pemeriksaan->id_layanan = $request->layanan;
                $pemeriksaan->id_dokterRadiologi = $request->dokterRujukan;
                $pemeriksaan->keluhan = $request->keluhan;
                $pemeriksaan->total_tarif = $tarif;
                $pemeriksaan->save();

                DB::commit();

                return redirect()->route('resepsionis.pasien.index-pasien-umum')->with(['success' => 'Pendaftaran pemeriksaan berhasil']);
            }catch (QueryException $x){
                DB::rollBack();
                dd($x->getMessage());
                return redirect()->route('resepsionis.pasien.pendaftaran.pasien-umum')->with(['error' => 'Pendaftaran pemeriksaan gagal']);
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

                DB::commit();

                $pendaftaran = Pendaftaran::findOrFail($id_pendaftaran);

                return view('suratRujukan.surat_rujukan', compact('pendaftaran'));
            }catch (QueryException $x){
                DB::rollBack();
                dd($x->getMessage());
                return redirect()->route('resepsionis.pasien.pendaftaran.pasien-umum')->with(['error' => 'Pendaftaran pemeriksaan gagal']);
            }
        }
    }

    public function detailSuratRujukan($id){
        $pendaftaran = Pendaftaran::findOrFail($id);

        return view('suratRujukan.surat_rujukan', compact('pendaftaran'));
    }

    public function suratRujukan($id){
        $pendaftaran = Pendaftaran::findOrFail($id);

        $pdf = PDF::loadview('suratRujukan.surat_rujukan_pdf', compact('pendaftaran'))->setPaper('A4', 'potrait');
        return $pdf->stream('surat-rujukan-'.$pendaftaran->nomor_pendaftaran.'.pdf');
    }
}
