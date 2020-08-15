<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Jadwal;
use App\Models\Layanan;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use App\User;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class RujukanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexPasienRs(){
        $pasien = Pasien::where('jenis_pasien', 'rs')->orderBy('created_at', 'desc')->get();

        return view('dokterPoli.index_pasien', ['pasien'=> $pasien]);
    }

    public function detailPasien($id){
        $pasien = Pasien::findOrFail($id);
        $pemeriksaan = Pasien::whereHas('pemeriksaan', function($query){
            $query->where('status_pemeriksaan', 'selesai');
        })->where('id', $id)->orderBy('created_at', 'desc')->get();

        return view('dokterPoli.detail_pasien', ['pasien'=> $pasien, 'pemeriksaan'=>$pemeriksaan ]);
    }

    public function createPasien(){
        $ruangan = Ruangan::all();
        return view('dokterPoli.create_pasien', ['ruangan' => $ruangan]);
    }

    public function storePasien(Request $request){
        $validator = Validator::make($request->all(),[
            "noRm" => "required|unique:trans_pasien,nomor_rm",
            "nama" => "required|min:3|max:100",
            "nomorKtp" => "required|digits_between:10,12|unique:trans_pasien,nomor_ktp",
            "umur" => "required|numeric",
            "asalRuangan" => "required",
            "jenisKelamin" => "required",
            "alamat" => "required|min:5|max:200",
            "nomorTelepon" => "required|digits_between:10,12|unique:trans_pasien,nomor_telepon",
            "jenisAsuransi" => "required"
        ])->validate();

        DB::beginTransaction();

        try{
            $new_pasien = new \App\Models\Pasien;
            $new_pasien->nomor_rm = $request->noRm;
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
            return redirect()->route('dokterPoli.pasien.index-pasien')->with(['success' => 'Pasien berhasil ditambahkan']);
        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('dokterPoli.pasien.create-pasien')->with(['error' => 'Pasien gagal ditambahkan']);
        }
    }

    public function editPasien($id){
        $ruangan = Ruangan::all();
        $pasien = Pasien::where('id', $id)->first();

        return view('dokterPoli.edit_pasien', ['pasien'=> $pasien, 'ruangan' => $ruangan]);
    }

    public function updatePasien(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "nama" => "required|min:3|max:100",
            "nomorKtp" => "required|digits_between:10,12",
            "umur" => "required|numeric",
            "jenisKelamin" => "required",
            "alamat" => "required|min:5|max:200",
            "nomorTelepon" => "required|digits_between:10,12",
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
                'alamat' => $request->alamat,
                'nomor_telepon' => $request->nomorTelepon,
                'jenis_asuransi' => $request->jenisAsuransi,
                'nomor_bpjs' => $request->noBpjs,
            ]);

            DB::commit();
            return redirect()->route('dokterPoli.pasien.index-pasien')->with(['success' => 'Pasien berhasil diedit']);

        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('dokterPoli.pasien.edit-pasien')->with(['error' => 'Pasien gagal diedit']);
        }
    }

    public function indexRujuk(){
        $id_dokter = Auth::user()->id;
        $rujuk = Pendaftaran::where('id_dokterPoli', $id_dokter)->orderBy('created_at', 'desc')->get();

        return view('dokterPoli.index_rujuk', ['rujuk'=> $rujuk]);
    }

    public function indexPemeriksaan(){
        $id_dokter = Auth::user()->id;
        $pemeriksaan = Pemeriksaan::where('id_dokterPoli', $id_dokter)->where('status_pemeriksaan', 'selesai')->orderBy('created_at', 'desc')->get();

        return view('dokterPoli.index_pemeriksaan', ['pemeriksaan'=> $pemeriksaan]);
    }

    public function rujukPasien($id){
        $pasien = Pasien::where('id', $id)->firstOrFail();
        $layanan_rontgen = Layanan::where('id', '2')->get();
        $layanan_usg = Layanan::where('id', '1')->get();
        $dokter_radiologi = User::where('role', 'dokterRadiologi')->get();

        $tgl_hari_ini = date('Y-m-d').'%';
        $jadwal_has_used = Pendaftaran::where('created_at', 'like', $tgl_hari_ini)->distinct()->pluck('id_jadwal')->toArray();
        $jadwal = Jadwal::whereNotIn('id', $jadwal_has_used)->get();

        return view('dokterPoli.rujuk_pasien', ['dokter_radiologi' => $dokter_radiologi, 'pasien' => $pasien, 'layanan_rontgen' => $layanan_rontgen, 'layanan_usg' => $layanan_usg, 'jadwal' => $jadwal]);
    }

    public function storeRujukPasien(Request $request, $id){
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
            $new_pendaftaran->id_dokterPoli = Auth::user()->id;
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
                $pemeriksaan->id_dokterPoli = Auth::user()->id;
                $pemeriksaan->id_dokterRadiologi = $request->dokterRujukan;
                $pemeriksaan->keluhan = $request->keluhan;
                $pemeriksaan->total_tarif = $tarif;
                $pemeriksaan->save();

                DB::commit();

                return redirect()->route('dokterPoli.pasien.index-pasien')->with(['success' => 'Rujuk pemeriksaan berhasil']);
            }catch (QueryException $x){
                DB::rollBack();
                dd($x->getMessage());
                return redirect()->route('dokterPoli.pasien.rujuk-pasien')->with(['error' => 'Rujuk pemeriksaan gagal']);
            }
        }else{
            $new_pendaftaran = new Pendaftaran();
            $new_pendaftaran->jenis_pemeriksaan = $request->jenisPemeriksaan;
            $new_pendaftaran->pasien_id = $id;
            $new_pendaftaran->id_jadwal = $request->jadwal;
            $new_pendaftaran->id_layanan = $request->layanan;
            $new_pendaftaran->id_dokterPoli = Auth::user()->id;
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
                $pemeriksaan->id_dokterPoli = Auth::user()->id;
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
                return redirect()->route('dokterPoli.pasien.rujuk-pasien')->with(['error' => 'Rujuk pemeriksaan gagal']);
            }
        }
    }

    public function detailSuratRujukan($id){
        $pendaftaran = Pendaftaran::findOrFail($id);

        return view('suratRujukan.surat_rujukan_dokterPoli', compact('pendaftaran'));
    }
}
