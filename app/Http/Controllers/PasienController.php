<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
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
        $pasien = Pasien::findOrFail($id)->first();
        $pendaftaran = Pendaftaran::where('pasien_id', $id)->orderBy('created_at', 'desc')->get();
        $pemeriksaan = Pemeriksaan::where('pasien_id', $id)->orderBy('created_at', 'desc')->get();
        $tagihan = Tagihan::where('pasien_id', $id)->orderBy('created_at', 'desc')->get();

        return view('admin.pasien.umum.detail_pasien_umum', ['pasien'=> $pasien]);
    }

    public function createPasienUmum(){
        return view('admin.pasien.umum.create_pasien_umum');
    }

    public function createPasienRs(){
        $ruangan = Ruangan::all();

        return view('admin.pasien.rs.create_pasien_rs', ['ruangan' => $ruangan]);
    }

    public function createPasienPasien(){
        $ruangan = Ruangan::all();
        return view('admin.pasien.create_pasien', ['ruangan' => $ruangan]);
    }

    public function storePasienUmum(Request $request){
        $validator = Validator::make($request->all(),[
            "nama" => "required|min:3|max:100",
            "nomorKtp" => "required|digits_between:10,12|unique:trans_pasien,nomor_ktp",
            "umur" => "required|numeric",
            "jenisKelamin" => "required",
            "alamat" => "required|min:5|max:200",
            "nomorTelepon" => "required|digits_between:10,12|unique:trans_pasien,nomor_telepon",
            "jenisAsuransi" => "required"
        ])->validate();

    DB::beginTransaction();

    try{
        $new_pasien = new \App\Models\Pasien;
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
        return redirect()->route('pasien.index-pasien-umum')->with(['success' => 'Pasien berhasil ditambahkan']);
    } catch (QueryException $x)
    {
        DB::rollBack();
        dd($x->getMessage());
        return redirect()->route('pasien.create.pasien-umum')->with(['error' => 'Pasien gagal ditambahkan']);
    }
}

    public function storePasienRs(Request $request){
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
            return redirect()->route('pasien.index-pasien-rs')->with(['success' => 'Pasien berhasil ditambahkan']);
        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('pasien.create.pasien-rs')->with(['error' => 'Pasien gagal ditambahkan']);
        }
    }

    public function editPasienUmum($id){
        $ruangan = Ruangan::all();
        $pasien = Pasien::findOrFail($id)->first();

        return view('admin.pasien.umum.edit_pasien_umum', ['pasien'=> $pasien, 'ruangan' => $ruangan]);
    }

    public function editPasienRs($id){
        $ruangan = Ruangan::all();
        $pasien = Pasien::findOrFail($id)->first();

        return view('admin.pasien.rs.edit_pasien_rs', ['pasien'=> $pasien, 'ruangan' => $ruangan]);
    }

    public function updatePasienUmum(Request $request, $id){
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
            return redirect()->route('pasien.index-pasien-umum')->with(['success' => 'Pasien berhasil diedit']);

        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('pasien.edit-pasien-umum')->with(['error' => 'Pasien gagal diedit']);
        }
    }

    public function updatePasienRs(Request $request, $id){
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
            return redirect()->route('pasien.index-pasien-rs')->with(['success' => 'Pasien berhasil diedit']);

        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('pasien.edit-pasien-rs')->with(['error' => 'Pasien gagal diedit']);
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
            return redirect()->route('pasien.index-pasien-umum')->with(['warning' => 'Pasien berhasil dihapus']);
        }
        return redirect()->route('pasien.index-pasien-rs')->with(['warning' => 'Pasien berhasil dihapus']);
    }

    public function trash(){
        $pasien = Pasien::onlyTrashed()->get();

        return view('admin.pasien.trash_pasien', ['pasien' => $pasien]);
    }

    public function restore($id){
        Pasien::onlyTrashed()->where('id', $id)->restore();

        return redirect()->route('pasien.trash')->with(['success' => 'User berhasil dikembalikan']);
    }

    public function destroy($id){
        Pasien::where('id', $id)->withTrashed()->forceDelete();

        return redirect()->route('user.trash')->with(['success' => 'User berhasil dihapus permanen']);
    }

}
