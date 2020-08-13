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

    public function index(User $user){
        $users = User::orderBy('created_at', 'desc')->get();;

        return view('admin.user.index_user', ['users'=> $users]);
    }

    public function create(){
        return view('admin.user.create_user');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required|min:5|max:100|unique:users",
            "email" => "required|email|unique:users",
            "password" => "required",
            "role" => "required",
            "nama" => "required|min:5|max:100",
            "nomorInduk" => "required|digits_between:10,12",
            "jenisKelamin" => "required",
            "alamat" => "required|min:10|max:200",
            "nomorTelepon" => "required|digits_between:10,12",
            "avatar" => 'file|image|mimes:jpeg,png,gif,webp|max:2048'
        ])->validate();

        DB::beginTransaction();

        try{
            $new_user = new \App\User;
            $new_user->name = $request->name;
            $new_user->email = $request->email;
            $new_user->password = Hash::make($request->password);
            $new_user->role = $request->role;

            if($request->role == 'dokterRadiologi' || $request->role == 'dokterPoli' ){
                $new_user->sip = $request->get('nomorInduk');
            } else {
                $new_user->nip = $request->get('nomorInduk');
            }

            $new_user->nama = $request->get('nama');
            $new_user->alamat = $request->get('alamat');
            $new_user->jenis_kelamin = $request->get('jenisKelamin');
            $new_user->nomor_telepon = $request->get('nomorTelepon');

            if($request->hasFile('avatar')){
                $resource = $request->avatar;
                $name = Str::slug($request->name."_".time()).".".$resource->getClientOriginalExtension();
                $resource->move(\base_path() ."/public/storage/avatars", $name);
                $new_user->avatar = $name;
            }
            $new_user->save();

            DB::commit();
            return redirect()->route('user.index')->with(['success' => 'User berhasil ditambahkan']);
        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('user.create')->with(['error' => 'User gagal ditambahkan']);
        }

    }

    public function edit($id){
        $user = User::findOrFail($id);

        return view('admin.user.edit_user', ['user' => $user]);
    }

    public function update(Request $request, $id){
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(),[
            "name" => "required|min:5|max:100",
            "email" => "required|email",
            "password" => "required",
            "role" => "required",
            "nama" => "required|min:5|max:100",
            "nomorInduk" => "required|digits_between:10,12",
            "jenisKelamin" => "required",
            "alamat" => "required|min:10|max:200",
            "nomorTelepon" => "required|digits_between:10,12",
        ])->validate();

        DB::beginTransaction();

        try{
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;

            if($request->role == 'dokterRadiologi' || $request->role == 'dokterPoli' ){
                $user->sip = $request->get('nomorInduk');
            } else {
                $user->nip = $request->get('nomorInduk');
            }

            $user->nama = $request->get('nama');
            $user->alamat = $request->get('alamat');
            $user->jenis_kelamin = $request->get('jenisKelamin');
            $user->nomor_telepon = $request->get('nomorTelepon');

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
            return redirect()->route('user.index')->with(['success' => 'User berhasil diedit']);
        } catch (QueryException $x)
        {
            DB::rollBack();
            dd($x->getMessage());
            return redirect()->route('user.edit')->with(['error' => 'User gagal diedit']);
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
