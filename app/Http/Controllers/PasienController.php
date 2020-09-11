<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use App\Models\Tagihan;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class PasienController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexPasienUmum(){
        $pasien = Pasien::where('jenis_pasien', 'umum')->orderBy('created_at', 'desc')->get();

        return view('admin.pasien.umum.index_pasien_umum', ['pasien'=> $pasien]);
    }

    public function indexPasienRs(){
        $pasien = Pasien::where('jenis_pasien', 'rs')->orderBy('created_at', 'desc')->get();

        return view('admin.pasien.rs.index_pasien_rs', ['pasien'=> $pasien]);
    }

    public function detailPasienUmum($id){
        $pasien = Pasien::findOrFail($id);
        $pendaftaran = Pendaftaran::where('pasien_id', $id)->orderBy('created_at', 'desc')->get();
        $pemeriksaan = Pemeriksaan::where('status_pemeriksaan', 'selesai')->where('pasien_id', $id)->orderBy('created_at', 'desc')->get();
        $tagihan = Tagihan::where('status_pembayaran', 'sudah')->where('pasien_id', $id)->orderBy('created_at', 'desc')->get();

        return view('admin.pasien.umum.detail_pasien_umum', ['pasien'=> $pasien, 'pendaftaran'=>$pendaftaran, 'pemeriksaan'=>$pemeriksaan, 'tagihan'=> $tagihan]);
    }

    public function detailPasienRs($id){
        $pasien = Pasien::findOrFail($id);
        $pendaftaran = Pendaftaran::where('pasien_id', $id)->orderBy('created_at', 'desc')->get();
        $pemeriksaan = Pemeriksaan::where('status_pemeriksaan', 'selesai')->where('pasien_id', $id)->orderBy('created_at', 'desc')->get();
        $tagihan = Tagihan::where('status_pembayaran', 'sudah')->where('pasien_id', $id)->orderBy('created_at', 'desc')->get();

        return view('admin.pasien.rs.detail_pasien_rs', ['pasien'=> $pasien, 'pendaftaran'=>$pendaftaran, 'pemeriksaan'=>$pemeriksaan, 'tagihan'=> $tagihan]);
    }

    public function createPasienUmum(){
        $pasien = Pasien::all();

        if($pasien->isEmpty()){
            $nomor = str_pad(1, 6, '0', STR_PAD_LEFT);
        } else {
            $mamak = $pasien->nomor_rm + 1;
            $mamak = str_pad($mamak, 6, '0', STR_PAD_LEFT);
        }

        return view('admin.pasien.umum.create_pasien_umum', ['mamak' => $mamak, 'nomor' => $nomor]);
    }

    public function createPasienRs(){
        $nomor_rm = Pasien::latest()->first()->value('nomor_rm');
        $ruangan = Ruangan::all();

        if($nomor_rm == null){
            $nomor_rm = str_pad(1, 6, '0', STR_PAD_LEFT);
        } else {
            $nomor_rm = str_pad($nomor_rm + 1, 6, '0', STR_PAD_LEFT);
        }

        return view('admin.pasien.rs.create_pasien_rs', ['ruangan' => $ruangan]);
    }

    public function createPasienPasien(){
        $ruangan = Ruangan::all();
        return view('admin.pasien.create_pasien', ['ruangan' => $ruangan]);
    }

    public function storePasienUmum(Request $request){
        $validator = Validator::make($request->all(),[
            "nama" => "required|min:3|max:100",
            "nomorKtp" => "required|max:16|unique:trans_pasien,nomor_ktp",
            "umur" => "required|numeric",
            "jenisKelamin" => "required",
            "alamat" => "required|min:5|max:200",
            "nomorTelepon" => "required|digits_between:10,12|unique:trans_pasien,nomor_telepon",
            "jenisAsuransi" => "required",
        ])->validate();

    DB::beginTransaction();

    $pasien = Pasien::latest()->first();
        if($pasien->nomor_rm == null){
            $pasien->nomor_rm = str_pad(1, 6, '0', STR_PAD_LEFT);
        } else {
            $pasien->nomor_rm = str_pad($pasien->nomor_rm + 1, 6, '0', STR_PAD_LEFT);
        }

    try{
        $new_pasien = new \App\Models\Pasien;
        $new_pasien->nomor_ktp = $request->nomorKtp;
        $new_pasien->nomor_rm = $pasien->nomor_rm;
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

        Session::flash('store_succeed', 'Data Pasien berhasil tersimpan');
        return redirect()->route('pasien.index-pasien-umum');
    } catch (QueryException $x)
    {
        DB::rollBack();
        dd($x->getMessage());
        Session::flash('store_failed', 'Data pasien gagal tersimpan');
        return redirect()->route('pasien.create.pasien-umum');
    }
}

    public function storePasienRs(Request $request){
        $validator = Validator::make($request->all(),[
            "nomorRm" => "required|max:6|unique:trans_pasien,nomor_rm",
            "nama" => "required|min:3|max:100",
            "nomorKtp" => "required|max:16|unique:trans_pasien,nomor_ktp",
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
            Session::flash('store_succeed', 'Data Pasien berhasil tersimpan');
            return redirect()->route('pasien.index-pasien-rs');
        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            Session::flash('store_failed', 'Data pasien gagal tersimpan');
            return redirect()->route('pasien.create.pasien-rs');
        }
    }

    public function detailPemeriksaan($id){
        $pemeriksaan = Pemeriksaan::findOrFail($id);

        return view('admin.pasien.detail_pemeriksaan', ['pemeriksaan'=> $pemeriksaan]);
    }

    public function editPasienUmum($id){
        $ruangan = Ruangan::all();
        $pasien = Pasien::findOrFail($id);

        return view('admin.pasien.umum.edit_pasien_umum', ['pasien'=> $pasien, 'ruangan' => $ruangan]);
    }

    public function editPasienRs($id){
        $ruangan = Ruangan::all();
        $pas = Pasien::findOrFail($id);

        return view('admin.pasien.rs.edit_pasien_rs', ['pas'=> $pas, 'ruangan' => $ruangan]);
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
            Session::flash('update_succeed', 'Data pasien berhasil terubah');
            return redirect()->route('pasien.index-pasien-umum');

        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            Session::flash('update_failed', 'Data pasien gagal terubah');
            return redirect()->route('pasien.edit-pasien-umum');
        }
    }

    public function updatePasienRs(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "noRm" => "required|max:6|unique:trans_pasien,nomor_rm,". $id,
            "nama" => "required|min:3|max:100",
            "nomorKtp" => "required|max:6|unique:trans_pasien,nomor_ktp,". $id,
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

            Session::flash('update_succeed', 'Data pasien berhasil terubah');
            return redirect()->route('pasien.index-pasien-rs');

        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            Session::flash('update_failed', 'Data pasien gagal terubah');
            return redirect()->route('pasien.edit-pasien-rs');
        }
    }

    public function delete($id){
        $pasien = Pasien::where('id', $id)->firstOrFail();
        if($pasien->jenis_pasien == 'umum'){
            $pindah = true;
        } else {
            $pindah = false;
        }
        $pasien = Pasien::where('id', $id)->delete();

        if($pindah){
            Session::flash('delete_succeed', 'Data pasien berhasil terhapus');
            return redirect()->route('pasien.index-pasien-umum');
        }
        Session::flash('delete_succeed', 'Data pasien berhasil terhapus');
        return redirect()->route('pasien.index-pasien-rs');
    }

    public function trash(){
        $pasien = Pasien::onlyTrashed()->get();

        return view('admin.pasien.trash_pasien', ['pasien' => $pasien]);
    }

    public function restore($id){
        Pasien::onlyTrashed()->where('id', $id)->restore();

        Session::flash('restore_succeed', 'Data pasien berhasil dikembalikan');
        return redirect()->route('pasien.trash');
    }

    public function destroy($id){
        Pasien::where('id', $id)->withTrashed()->forceDelete();

        Session::flash('destroy_succeed', 'Data pasien berhasil dihapus permanen');
        return redirect()->route('pasien.trash');
    }

    public function detailSuratRujukan($id){
        $pendaftaran = Pendaftaran::findOrFail($id);

        return view('suratRujukan.surat_rujukan', compact('pendaftaran'));
    }

    public function detailHasilExpertise($id){
        $pemeriksaan = Pemeriksaan::findOrFail($id);

        return view('hasilExpertise.hasil_expertise', compact('pemeriksaan'));
    }

    public function detailTagihan($id){
        $tagihan = Tagihan::findOrFail($id);
        $tarif = $tagihan->layanan->tarif - 25000;

        return view('kasir.detail_pembayaran', ['tagihan'=>$tagihan, 'tarif'=>$tarif]);
    }
}
