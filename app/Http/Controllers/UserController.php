<?php

namespace App\Http\Controllers;

use Session;
use App\User;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function markAsReadNotification(Request $request){
        auth()->user()
        ->unreadNotifications
        ->when($request->input('id'), function ($query) use ($request) {
            return $query->where('id', $request->input('id'));
        })
        ->markAsRead();

        $total = count(auth()->user()->unreadNotifications);

        return response()->json([
            'total' => $total
        ]);
    }

    public function totalNotifications(){
        $total = count(auth()->user()->unreadNotifications);

        return response()->json([
            'total_notifications' => $total
        ]);
    }

    public function profil($id){
        $user = User::findOrFail($id);

        switch ($user->role) {
            case 'admin':
                return view('admin.profil', ['user'=> $user]);
                break;
            case 'resepsionis':
                $pendaftaran = Pendaftaran::where('id_resepsionis', $id)->get();
                return view('resepsionis.profil', ['user'=> $user, 'pendaftaran' => $pendaftaran]);
                break;
            case 'dokterPoli':
                $rujukan = Pendaftaran::where('id_dokterPoli', $id)->get();
                return view('dokterPoli.profil', ['user'=> $user, 'rujukan' => $rujukan]);
                break;
            case 'radiografer':
                $pemeriksaan = Pemeriksaan::where('id_radiografer', $id)->get();
                return view('radiografer.profil', ['user'=> $user, 'pemeriksaan' => $pemeriksaan]);
                break;
            case 'dokterRadiologi':
                $pemeriksaan = Pemeriksaan::where('id_dokterRadiologi', $id)->get();
                return view('dokterRadiologi.profil', ['user'=> $user, 'pemeriksaan' => $pemeriksaan]);
                break;
            case 'kasir':
                $tagihan = Tagihan::where('id_kasir', $id)->get();
                return view('kasir.profil', ['user'=> $user, 'tagihan' => $tagihan]);
                break;
            default:
                break;
        }
    }

    public function updateProfilPegawai(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "name" => "required|min:5|max:100|unique:users,name,". $id,
            "email" => "required|email|unique:users,email,". $id,
            "password" => "required|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/",
            "nama" => "required|min:5|max:100",
            "nip" => "required|digits_between:8,9|unique:users,nip,". $id,
            "alamat" => "required|min:10|max:200",
            "nomorTelepon" => "required|digits_between:10,12|unique:users,nomor_telepon,". $id,
        ])->validate();

        DB::beginTransaction();

        try{
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->nip = $request->nip;
            $user->password = Hash::make($request->password);
            $user->nama = $request->nama;
            $user->alamat = $request->alamat;
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
            switch ($user->role) {
                case 'admin':
                    if($user->hasChanged() == true){
                        Session::flash('store_succeed', 'Profil berhasil terubah');
                    }
                    return redirect()->route('profil.show', ['id' => $id]);
                    break;
                case 'resepsionis':
                    if($user->hasChanged() == true){
                        Session::flash('store_succeed', 'Profil berhasil terubah');
                    }
                    return redirect()->route('profil.show.resepsionis', ['id' => $id]);
                    break;
                case 'radiografer':
                    if($user->hasChanged() == true){
                        Session::flash('store_succeed', 'Profil berhasil terubah');
                    }
                    return redirect()->route('profil.show.radiografer', ['id' => $id]);
                    break;
                case 'kasir':
                    if($user->hasChanged() == true){
                        Session::flash('store_succeed', 'Profil berhasil terubah');
                    }
                    return redirect()->route('profil.show.kasir', ['id' => $id]);
                    break;
                default:
                    break;
            }
        } catch (QueryException $x)
        {
            DB::rollBack();
            // dd($x->getMessage());
            switch ($user->role) {
                case 'admin':
                    Session::flash('store_failed', 'Profil gagal terubah');
                    return redirect()->route('profil.show', ['id' => $id]);
                    break;
                case 'resepsionis':
                    Session::flash('store_failed', 'Profil gagal terubah');
                    return redirect()->route('profil.show.resepsionis', ['id' => $id]);
                    break;
                case 'radiografer':
                    Session::flash('store_failed', 'Profil gagal terubah');
                    return redirect()->route('profil.show.radiografer', ['id' => $id]);
                    break;
                case 'kasir':
                    Session::flash('store_failed', 'Profil gagal terubah');
                    return redirect()->route('profil.show.kasir', ['id' => $id]);
                    break;
                default:
                    break;
            }
        }
    }

    public function updateProfilDokter(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "name" => "required|min:5|max:100|unique:users,name,". $id,
            "email" => "required|email|unique:users,email,". $id,
            "password" => "required|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/",
            "nama" => "required|min:5|max:100",
            "sip" => "required|max:50|unique:users,sip,". $id,
            "alamat" => "required|min:10|max:200",
            "nomorTelepon" => "required|digits_between:10,12|unique:users,nomor_telepon,". $id,
        ])->validate();


        DB::beginTransaction();

        try{
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->sip = $request->sip;
            $user->nama = $request->nama;
            $user->alamat = $request->alamat;
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
            switch ($user->role) {
                case 'dokterPoli':
                    if($user->hasChanged() == true){
                        Session::flash('store_succeed', 'Profil berhasil terubah');
                    }
                    return redirect()->route('profil.show.dokterPoli', ['id' => $id]);
                    break;
                case 'dokterRadiologi':
                    if($user->hasChanged() == true){
                        Session::flash('store_succeed', 'Profil berhasil terubah');
                    }
                    return redirect()->route('profil.show.dokterRadiologi', ['id' => $id]);
                    break;
                default:
                    break;
            }
        } catch (QueryException $x)
        {
            DB::rollBack();
            // dd($x->getMessage());
            switch ($user->role) {
                case 'dokterPoli':
                    Session::flash('store_failed', 'Profil gagal terubah');
                    return redirect()->route('profil.show.dokterPoli', ['id' => $id]);
                    break;
                case 'dokterRadiologi':
                    Session::flash('store_failed', 'Profil gagal terubah');
                    return redirect()->route('profil.show.dokterRadiologi', ['id' => $id]);
                    break;
                default:
                    break;
            }
        }
    }

    public function indexDokter(User $user){
        $users = User::whereIn('role', ['dokterPoli', 'dokterRadiologi'])->orderBy('created_at', 'desc')->get();

        return view('admin.user.index_dokter', ['users'=> $users]);
    }

    public function indexPegawai(User $user){
        $users = User::whereIn('role',
        ['kasir',
        'radiografer',
        'resepsionis',
        ])->orderBy('created_at', 'desc')->get();

        return view('admin.user.index_pegawai', ['users'=> $users]);
    }

    public function detailUser($id){
        $user = User::findOrFail($id);
        $pendaftaran = Pendaftaran::where('id_resepsionis', $id)->get();
        $rujukan = Pendaftaran::where('id_dokterPoli', $id)->get();
        $pemeriksaan_dokter = Pemeriksaan::where('id_dokterRadiologi', $id)->get();
        $pemeriksaan_radiografer = Pemeriksaan::where('id_radiografer', $id)->get();
        $tagihan = Tagihan::where('id_kasir', $id)->get();

        return view('admin.user.detail_user', ['user'=> $user, 'pendaftaran' => $pendaftaran, 'rujukan' => $rujukan, 'pemeriksaan_dokter'  => $pemeriksaan_dokter, 'pemerikasan_radiografer' => $pemeriksaan_radiografer , 'tagihan' => $tagihan]);
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
            "sip" => "required|max:50|unique:users,sip",
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
            Session::flash('store_succeed', 'Data dokter berhasil tersimpan');
            return redirect()->route('dokter.index');
        } catch (QueryException $x)
        {
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('store_failed', 'Data dokter gagal tersimpan');
            return redirect()->route('dokter.create');
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
            "nip" => "required|unique:users,nip|digits_between:8,9",
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
            Session::flash('store_succeed', 'Data pegawai berhasil tersimpan');
            return redirect()->route('pegawai.index');
        } catch (QueryException $x)
        {
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('store_failed', 'Data pegawai gagal tersimpan');
            return redirect()->route('pegawai.create');
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
            "role" => "required",
            "spesialis" => "required",
            "nama" => "required|min:5|max:100",
            "sip" => "required|max:50|unique:users,sip,". $id,
            "jenisKelamin" => "required",
            "alamat" => "required|min:10|max:200",
            "nomorTelepon" => "required|digits_between:10,12|unique:users,nomor_telepon,". $id,
        ])->validate();

        DB::beginTransaction();

        try{
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->spesialis = $request->spesialis;
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
            if($user->wasChanged() == true){
                Session::flash('update_succeed', 'Data dokter berhasil terubah');
            }
            return redirect()->route('dokter.index');
        } catch (QueryException $x)
        {
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('update_failed', 'Data dokter gagal terubah');
            return redirect()->route('dokter.edit');
        }
    }

    public function updatePegawai(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "name" => "required|min:5|max:100|unique:users,name,". $id,
            "email" => "required|email|unique:users,email,". $id,
            "role" => "required",
            "jabatan" => "required",
            "nama" => "required|min:5|max:100",
            "nip" => "required|digits_between:8,9|unique:users,nip,". $id,
            "jenisKelamin" => "required",
            "alamat" => "required|min:10|max:200",
            "nomorTelepon" => "required|digits_between:10,12|unique:users,nomor_telepon,". $id,
        ])->validate();

        DB::beginTransaction();

        try{
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->nip = $request->nip;
            $user->nama = $request->nama;
            $user->jabatan = $request->jabatan;
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
            if($user->wasChanged() == true){
                Session::flash('update_succeed', 'Data pegawai berhasil terubah');
            }
            return redirect()->route('pegawai.index');
        } catch (QueryException $x)
        {
            DB::rollBack();
            // dd($x->getMessage());
            Session::flash('update_failed', 'Data pegawai gagal terubah');
            return redirect()->route('pegawai.edit');
        }
    }

    public function delete($id){
        $user = User::findOrFail($id);
        if($user->role == 'dokterPoli' || $user->role == 'dokterRadiologi'){
            $pindah = true;
        } else {
            $pindah = false;
        }

        $user->delete();

        if($pindah){
            Session::flash('delete_succeed', 'Data dokter berhasil terhapus');
            return redirect()->route('dokter.index');
        }
        Session::flash('delete_succeed', 'Data pegawai berhasil terhapus');
        return redirect()->route('pegawai.index');
    }

    public function trash(){
        $users = User::onlyTrashed()->get();

        return view('admin.user.trash_user', ['users' => $users]);
    }

    public function restore($id){
        $user = User::onlyTrashed()->where('id', $id);
        $user->restore();

        Session::flash('restore_succeed', 'Data user berhasil dikembalikan');
        return redirect()->route('user.trash');
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

        Session::flash('destroy_succeed', 'Data user berhasil dihapus permanen');
        return redirect()->route('user.trash');
    }
}
