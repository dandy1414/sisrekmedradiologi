@extends('layouts.global')

@section('title')Edit Dokter @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        Edit Dokter
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dokter.index') }}"><i class="fa fa-user-md"></i> Dokter</a>
        <li class="active">Edit User</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h4>
                    <i class="icon fa fa-info"></i>
                    Aturan
                </h4>
                - Username harus kombinasi angka dan huruf <br>
                - Password harus berisi 6 karakter <br>
                - Password harus kombinasi angka dan huruf <br>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <form method="POST" action="{{ route('dokter.update', ['id' => $user->id]) }}" enctype="multipart/form-data">
                @csrf

                {{ method_field('PUT') }}
                <div class="box box-success" style="position: relative;">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('name') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Username :</label>
                                    <input value="{{ $user->name }}" type="text" name="name" class="form-control"
                                        placeholder="Username ...">
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('email') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Email :</label>
                                    <input value="{{ $user->email }}" type="email" name="email" class="form-control"
                                        placeholder="Email ...">
                                    <span class="help-block">{{ $errors->first('email') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('role') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Role :</label>
                                    <select class="form-control select2" name="role" style="width: 100%;">
                                        <option value="dokterPoli" {{ $user->role == 'dokterPoli' ? "selected" : "" }}>Dokter Poli</option>
                                        <option value="dokterRadiologi" {{ $user->role == 'dokterRadiologi' ? "selected" : "" }}>Dokter Radiologi
                                        </option>
                                    </select>
                                    <span class="help-block">{{ $errors->first('role') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('spesialis') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Spesialis :</label>
                                    <select class="form-control select2" name="spesialis" style="width: 100%;">
                                        <option selected disabled>Silahkan pilih salah satu</option>
                                        <option value="umum"
                                            {{ $user->spesialis == 'umum' ? "selected" : "" }}>
                                            Dokter Umum</option>
                                        <option value="obgyn"
                                            {{ $user->spesialis == 'obgyn' ? "selected" : "" }}>
                                            Spesialis Obgyn</option>
                                        <option value="syaraf" {{ $user->spesialis == 'syaraf' ? "selected" : "" }}>
                                            Spesialis Syaraf</option>
                                        <option value="jiwa"
                                            {{ $user->spesialis == 'jiwa' ? "selected" : "" }}>Spesialis Jiwa
                                        </option>
                                        <option value="gigi" {{ $user->spesialis == 'gigi' ? "selected" : "" }}>Dokter Gigi
                                        </option>
                                        <option value="penyakit_dalam" {{ $user->spesialis == 'penyakit_dalam' ? "selected" : "" }}>Spesialis Penyakit Dalam
                                        </option>
                                        <option value="bedah" {{ $user->spesialis == 'bedah' ? "selected" : "" }}>Spesialis Bedah
                                        </option>
                                        <option value="penyakit_mulut" {{ $user->spesialis == 'penyakit_mulut' ? "selected" : "" }}>Spesialis Penyakit Mulut
                                        </option>
                                        <option value="anak" {{ $user->spesialis == 'anak' ? "selected" : "" }}>Spesialis Anak
                                        </option>
                                        <option value="mata" {{ $user->spesialis == 'mata' ? "selected" : "" }}>Spesialis Mata
                                        </option>
                                        <option value="anasthesi" {{ $user->spesialis == 'anasthesi' ? "selected" : "" }}>Spesialis Anasthesi
                                        </option>
                                        <option value="radiologi" {{ $user->spesialis == 'radiologi' ? "selected" : "" }}>Dokter Radiologi
                                        </option>
                                    </select>
                                    <span class="help-block">{{ $errors->first('spesialis') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('sip') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> SIP :</label>
                                    <input value="{{ $user->sip }}" type="text" name="sip"
                                        class="form-control {{$errors->first('sip') ? "is-invalid" : ""}}"
                                        placeholder="SIP ...">
                                    <span class="help-block">{{ $errors->first('sip') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('nama') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Nama :</label>
                                    <input value="{{ $user->nama }}" type="text" name="nama"
                                        class="form-control {{$errors->first('nama') ? "is-invalid" : ""}}"
                                        placeholder="Nama ...">
                                    <span class="help-block">{{ $errors->first('nama') }}</span>
                                </div>

                                <hr>
                                <label class="text-muted"><span style="color: red">*</span> Wajib diisi</label>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('jenisKelamin') ? "has-error": "" }}">
                                    <label>Jenis Kelamin :</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jenisKelamin" id="pria" value="pria"
                                                {{ $user->jenis_kelamin == 'pria' ? "checked" : "" }}>
                                            Pria
                                        </label>
                                        <label>
                                            <input type="radio" name="jenisKelamin" id="wanita" value="wanita"
                                                {{ $user->jenis_kelamin == 'wanita' ? "checked" : "" }}>
                                            Wanita
                                        </label>
                                        <span class="help-block">{{ $errors->first('jenisKelamin') }}</span>
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->first('alamat') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Alamat :</label>
                                    <textarea name="alamat" id="alamat"
                                        class="form-control {{$errors->first('alamat') ? "is-invalid" : ""}}">{{ $user->alamat }}</textarea>
                                    <span class="help-block">{{ $errors->first('alamat') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('nomorTelepon') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> No. Telepon :</label>
                                    <input value="{{$user->nomor_telepon}}" type="text" name="nomorTelepon"
                                        class="form-control {{$errors->first('nomorTelepon') ? "is-invalid" : ""}}"
                                        placeholder="Nomor telepon ...">
                                    <span class="help-block">{{ $errors->first('nomorTelepon') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('avatar') ? "has-error": "" }}">
                                    <label for="foto">Avatar</label>
                                    <input id="avatar" class="form-control {{$errors->first('avatar') ? "is-invalid" : ""}}" name="avatar" type="file" id="foto">
                                    <span class="help-block">{{ $errors->first('avatar') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@push('scripts')
@if (Session::has('update_failed'))
<script>
swal('Berhasil', '{!! Session::get('update_failed') !!}', 'error',{
    button:'OK',
});
</script>
@endif
@endpush
