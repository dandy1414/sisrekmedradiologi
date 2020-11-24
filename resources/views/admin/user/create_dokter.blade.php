@extends('layouts.global')

@section('title')Tambah Dokter Baru @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        Tambah Dokter Baru
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dokter.index') }}"><i class="fa fa-user-md"></i> Dokter</a>
        <li class="active">Tambah Dokter</li>
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
                    - Password harus berisi 6 karakter & kombinasi angka dan huruf <br>
                </div>
            </div>
        </div>

    <div class="row">
        <div class="col-xs-12">
            <form method="POST" action="{{ route('dokter.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="box box-success" style="position: relative;">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('name') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Username :</label>
                                    <input value="{{ old('name') }}" type="text" name="name" class="form-control"
                                        placeholder="Username ...">
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('email') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Email :</label>
                                    <input value="{{ old('email') }}" type="email" name="email" class="form-control"
                                        placeholder="Email ...">
                                    <span class="help-block">{{ $errors->first('email') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('password') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Password :</label>
                                    <input value="{{ old('password') }}" type="password" name="password"
                                        class="form-control" placeholder="Password ...">
                                    <span class="help-block">{{ $errors->first('password') }}</>
                                </div>

                                <div class="form-group {{ $errors->first('role') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Role :</label>
                                    <select class="form-control select2" name="role" style="width: 100%;">
                                        <option selected disabled>Silahkan pilih salah satu</option>
                                        <option value="dokterPoli" {{ old('role') == 'dokterPoli' ? "selected" : "" }}>
                                            Dokter Poli</option>
                                        <option value="dokterRadiologi"
                                            {{ old('role') == 'dokterRadiologi' ? "selected" : "" }}>Dokter Radiologi
                                        </option>
                                    </select>
                                    <span class="help-block">{{ $errors->first('role') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('spesialis') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Spesialis :</label>
                                    <select class="form-control select2" name="spesialis" style="width: 100%;">
                                        <option selected disabled>Silahkan pilih salah satu</option>
                                        <option value="umum"
                                            {{ old('spesialis') == 'umum' ? "selected" : "" }}>
                                            Dokter Umum</option>
                                        <option value="obgyn"
                                            {{ old('spesialis') == 'obgyn' ? "selected" : "" }}>
                                            Spesialis Obgyn</option>
                                        <option value="syaraf" {{ old('spesialis') == 'syaraf' ? "selected" : "" }}>
                                            Spesialis Syaraf</option>
                                        <option value="jiwa"
                                            {{ old('spesialis') == 'jiwa' ? "selected" : "" }}>Spesialis Jiwa
                                        </option>
                                        <option value="gigi" {{ old('spesialis') == 'gigi' ? "selected" : "" }}>Dokter Gigi
                                        </option>
                                        <option value="penyakit_dalam" {{ old('spesialis') == 'penyakit_dalam' ? "selected" : "" }}>Spesialis Penyakit Dalam
                                        </option>
                                        <option value="bedah" {{ old('spesialis') == 'bedah' ? "selected" : "" }}>Spesialis Bedah
                                        </option>
                                        <option value="penyakit_mulut" {{ old('spesialis') == 'penyakit_mulut' ? "selected" : "" }}>Spesialis Penyakit Mulut
                                        </option>
                                        <option value="anak" {{ old('spesialis') == 'anak' ? "selected" : "" }}>Spesialis Anak
                                        </option>
                                        <option value="mata" {{ old('spesialis') == 'mata' ? "selected" : "" }}>Spesialis Mata
                                        </option>
                                        <option value="anasthesi" {{ old('spesialis') == 'anasthesi' ? "selected" : "" }}>Spesialis Anasthesi
                                        </option>
                                        <option value="radiologi" {{ old('spesialis') == 'radiologi' ? "selected" : "" }}>Dokter Radiologi
                                        </option>
                                    </select>
                                    <span class="help-block">{{ $errors->first('spesialis') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('sip') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> SIP :</label>
                                    <input value="{{ old('sip') }}" type="text" name="sip"
                                        class="form-control {{$errors->first('sip') ? "is-invalid" : ""}}"
                                        placeholder="SIP ...">
                                    <span class="help-block">{{ $errors->first('sip') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('nama') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Nama :</label>
                                    <input value="{{ old('nama') }}" type="text" name="nama"
                                        class="form-control {{$errors->first('nama') ? "is-invalid" : ""}}"
                                        placeholder="Nama ...">
                                    <span class="help-block">{{ $errors->first('nama') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('jenisKelamin') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Jenis Kelamin :</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jenisKelamin" id="pria" value="pria"
                                                {{ old('jenisKelamin') == 'pria' ? "checked" : "" }}>
                                            Pria
                                        </label>
                                        <label>
                                            <input type="radio" name="jenisKelamin" id="wanita" value="wanita"
                                                {{ old('jenisKelamin') == 'wanita' ? "checked" : "" }}>
                                            Wanita
                                        </label>
                                        <span class="help-block">{{ $errors->first('jenisKelamin') }}</span>
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->first('alamat') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Alamat :</label>
                                    <textarea name="alamat" id="alamat"
                                        class="form-control {{$errors->first('alamat') ? "is-invalid" : ""}}">{{old('alamat')}}</textarea>
                                    <span class="help-block">{{ $errors->first('alamat') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('nomorTelepon') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Nomor Telepon :</label>
                                    <input value="{{old('nomorTelepon')}}" type="text" name="nomorTelepon"
                                        class="form-control {{$errors->first('nomorTelepon') ? "is-invalid" : ""}}"
                                        placeholder="Nomor telepon ...">
                                    <span class="help-block">{{ $errors->first('nomorTelepon') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('avatar') ? "has-error": "" }}">
                                    <label for="foto">Avatar :</label>
                                    <input id="avatar" name="avatar" class="form-control" type="file" id="foto">
                                    <span class="help-block">{{ $errors->first('avatar') }}</span>
                                </div>

                                <hr>
                                <label class="text-muted"><span style="color: red">*</span> Wajib diisi</label>
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
@if (Session::has('store_failed'))
<script>
swal('Berhasil', '{!! Session::get('store_failed') !!}', 'error',{
    button:'OK',
});
</script>
@endif
@endpush
