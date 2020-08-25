<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexDokter(User $user){
        $users = User::whereIn('role', ['dokterPoli', 'dokterRadiologi'])->orderBy('created_at', 'desc')->get();

        return view('admin.user.index_dokter', ['users'=> $users]);
    }

    public function indexPegawai(User $user){
        $users = User::whereIn('role',
        ['kasir',
        'radiografer',
        'admin',
        'resepsionis',
        ])->orderBy('created_at', 'desc')->get();

        return view('admin.user.index_pegawai', ['users'=> $users]);
    }

    public function createDokter(){
        return view('admin.user.create_dokter');
    }

    public function createPegawai(){
        return view('admin.user.create_pegawai');
    }

    public function storeDokter(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required|min:5|max:100|unique:users,name",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/",
            "role" => "required",
            "spesialis" => "required",
            "nama" => "required|min:5|max:100",
            "sip" => "required|unique:users,sip",
            "jenisKelamin" => "required",
            "alamat" => "required|min:10|max:200",
            "nomorTelepon" => "required|digits_between:10,12|unique:users, nomor_telepon",
            "avatar" => 'file|image|mimes:jpeg,png,gif,webp|max:2048'
        ])->validate();

        DB::beginTransaction();

        try{
            $new_user = new User;
            $new_user->name = $request->name;
            $new_user->email = $request->email;
            $new_user->password = Hash::make($request->password);
            $new_user->role = $request->role;
            $new_user->spesialis = $request->spesialis;
            $new_user->sip = $request->sip;
            $new_user->nama = $request->nama;
            $new_user->alamat = $request->alamat;
            $new_user->jenis_kelamin = $request->jenisKelamin;
            $new_user->nomor_telepon = $request->nomorTelepon;

            if($request->hasFile('avatar')){
                $resource = $request->avatar;
                $name = Str::slug($request->name."_".time()).".".$resource->getClientOriginalExtension();
                $resource->move(\base_path() ."/public/storage/avatars", $name);
                $new_user->avatar = $name;
            }
            $new_user->save();

            DB::commit();
            return redirect()->route('dokter.index')->with(['success' => 'Dokter berhasil ditambahkan']);
        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('dokter.create')->with(['error' => 'Dokter gagal ditambahkan']);
        }

    }

    public function storePegawai(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required|min:5|max:100|unique:users,name",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/",
            "role" => "required",
             "jabatan" => "required",
            "nama" => "required|min:5|max:100",
            "nip" => "required|unique:users,nip",
            "jenisKelamin" => "required",
            "alamat" => "required|min:10|max:200",
            "nomorTelepon" => "required|digits_between:10,12|unique:users,nomor_telepon",
            "avatar" => 'file|image|mimes:jpeg,png,gif,webp|max:2048'
        ])->validate();

        DB::beginTransaction();

        try{
            $new_user = new User;
            $new_user->name = $request->name;
            $new_user->email = $request->email;
            $new_user->password = Hash::make($request->password);
            $new_user->role = $request->role;
            $new_user->jabatan = $request->jabatan;
            $new_user->nip = $request->nip;
            $new_user->nama = $request->nama;
            $new_user->alamat = $request->alamat;
            $new_user->jenis_kelamin = $request->jenisKelamin;
            $new_user->nomor_telepon = $request->nomorTelepon;

            if($request->hasFile('avatar')){
                $resource = $request->avatar;
                $name = Str::slug($request->name."_".time()).".".$resource->getClientOriginalExtension();
                $resource->move(\base_path() ."/public/storage/avatars", $name);
                $new_user->avatar = $name;
            }
            $new_user->save();

            DB::commit();
            return redirect()->route('pegawai.index')->with(['success' => 'Pegawai berhasil ditambahkan']);
        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('pegawai.create')->with(['error' => 'Pegawai gagal ditambahkan']);
        }

    }

    public function editDokter($id){
        $user = User::findOrFail($id);

        return view('admin.user.edit_dokter', ['user' => $user]);
    }

    public function editPegawai($id){
        $user = User::findOrFail($id);

        return view('admin.user.edit_pegawai', ['user' => $user]);
    }

    public function updateDokter(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "name" => "required|min:5|max:100|unique:users,name,". $id,
            "email" => "required|email|unique:users,email,". $id,
            "password" => "required|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/",
            "role" => "required",
            // "jabatan" => "required",
            "nama" => "required|min:5|max:100",
            "sip" => "required|digits_between:10,12|unique:users,sip,". $id,
            "jenisKelamin" => "required",
            "alamat" => "required|min:10|max:200",
            "nomorTelepon" => "required|digits_between:10,12|unique:users,nomor_telepon,". $id,
        ])->validate();

        DB::beginTransaction();

        try{
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->sip = $request->sip;
            $user->nama = $request->nama;
            $user->alamat = $request->alamat;
            $user->jenis_kelamin = $request->jenisKelamin;
            $user->nomor_telepon = $request->nomorTelepon;

            if($user->avatar != null && $request->hasFile('avatar') ){
                $image_path = \base_path() ."/public/storage/avatars/".$user->avatar;
                if(File::exists($image_path)){
                    File::delete($image_path);
                }
                $resource = $request->avatar;
                $name = Str::slug($request->name."_".time()).".".$resource->getClientOriginalExtension();
                $resource->move(\base_path() ."/public/storage/avatars", $name);
                $user->avatar = $name;
            }
            $user->save();

            DB::commit();
            return redirect()->route('dokter.index')->with(['success' => 'User berhasil diedit']);
        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('dokter.edit')->with(['error' => 'User gagal diedit']);
        }
    }

    public function updatePegawai(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "name" => "required|min:5|max:100|unique:users,name,". $id,
            "email" => "required|email|unique:users,email,". $id,
            "password" => "required|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/",
            "role" => "required",
            // "jabatan" => "required",
            "nama" => "required|min:5|max:100",
            "nip" => "required|digits_between:10,12|unique:users,nip,". $id,
            "jenisKelamin" => "required",
            "alamat" => "required|min:10|max:200",
            "nomorTelepon" => "required|digits_between:10,12|unique:users,nomor_telepon,". $id,
        ])->validate();

        DB::beginTransaction();

        try{
            $user = User::findOrFail($id);
            $user->name = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->nip = $request->nomorInduk;
            $user->nama = $request->nama;
            $user->alamat = $request->alamat;
            $user->jenis_kelamin = $request->jenisKelamin;
            $user->nomor_telepon = $request->nomorTelepon;

            if($user->avatar != null && $request->hasFile('avatar') ){
                $image_path = \base_path() ."/public/storage/avatars/".$user->avatar;
                if(File::exists($image_path)){
                    File::delete($image_path);
                }
                $resource = $request->avatar;
                $name = Str::slug($request->name."_".time()).".".$resource->getClientOriginalExtension();
                $resource->move(\base_path() ."/public/storage/avatars", $name);
                $user->avatar = $name;
            }
            $user->save();

            DB::commit();
            return redirect()->route('pegawai.index')->with(['success' => 'Pegawai berhasil diedit']);
        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('pegawai.edit')->with(['error' => 'Pegawai gagal diedit']);
        }
    }

    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with(['warning' => 'User berhasil dihapus']);
    }

    public function trash(){
        $users = User::onlyTrashed()->get();

        return view('admin.user.trash_user', ['users' => $users]);
    }

    public function restore($id){
        $user = User::onlyTrashed()->where('id', $id);
        $user->restore();

        return redirect()->route('user.trash')->with(['success' => 'User berhasil dikembalikan']);
    }

    public function destroy($id){
        $user = User::where('id', $id)->withTrashed()->firstOrFail();
        if($user->avatar != null){
            $image_path = \base_path() ."/public/storage/avatars/".$user->avatar;
            if(File::exists($image_path)){
                File::delete($image_path);
            }
        }
        $user->forceDelete();

        return redirect()->route('user.trash')->with(['success' => 'User berhasil dihapus permanen']);
    }
}
