@extends('layouts.global')

@section('title')Tambah User Baru @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        Tambah User Baru
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('user.index') }}"><i class="fa fa-users"></i> Data User</a></li>
        <li class="active">Tambah User</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h4>
                    <i class="icon fa fa-check"></i>
                    Gagal
                </h4>
                    {{ $message }}
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="box box-success" style="position: relative;">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('name') ? "has-error": "" }}">
                                    <label>Username :</label>
                                    <input value="{{ old('name') }}" type="text" name="name" class="form-control"
                                        placeholder="Username ...">
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('email') ? "has-error": "" }}">
                                    <label>Email :</label>
                                    <input value="{{ old('email') }}" type="email" name="email" class="form-control"
                                        placeholder="Email ...">
                                    <span class="help-block">{{ $errors->first('email') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('password') ? "has-error": "" }}">
                                    <label>Password :</label>
                                    <input value="{{ old('password') }}" type="password" name="password"
                                        class="form-control" placeholder="password">
                                    <span class="help-block">{{ $errors->first('password') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('role') ? "has-error": "" }}">
                                    <label>Role :</label>
                                    <select class="form-control select2" name="role" style="width: 100%;">
                                        <option selected="selected">Silahkan pilih salah satu role</option>
                                        <option value="resepsionis"
                                            {{ old('role') == 'resepsionis' ? "selected" : "" }}>
                                            Resepsionis</option>
                                        <option value="radiografer"
                                            {{ old('role') == 'radiografer' ? "selected" : "" }}>
                                            Radiografer</option>
                                        <option value="dokterPoli" {{ old('role') == 'dokterPoli' ? "selected" : "" }}>
                                            Dokter Poli</option>
                                        <option value="dokterRadiologi"
                                            {{ old('role') == 'dokterRadiologi' ? "selected" : "" }}>Dokter Radiologi
                                        </option>
                                        <option value="kasir" {{ old('role') == 'kasir' ? "selected" : "" }}>Kasir
                                        </option>
                                    </select>
                                    <span class="help-block">{{ $errors->first('role') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('nama') ? "has-error": "" }}">
                                    <label>Nama :</label>
                                    <input value="{{ old('nama') }}" type="text" name="nama"
                                        class="form-control {{$errors->first('nama') ? "is-invalid" : ""}}"
                                        placeholder="Nama ...">
                                    <span class="help-block">{{ $errors->first('nama') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('nomorInduk') ? "has-error": "" }}">
                                    <label>SIP/NIP :</label>
                                    <input value="{{ old('nomorInduk') }}" type="text" name="nomorInduk"
                                        class="form-control {{$errors->first('nomorInduk') ? "is-invalid" : ""}}"
                                        placeholder="SIP/NIP ...">
                                    <span class="help-block">{{ $errors->first('nomorInduk') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('jenisKelamin') ? "has-error": "" }}">
                                    <label>Jenis Kelamin :</label>
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
                                    <label>Alamat :</label>
                                    <textarea name="alamat" id="alamat"
                                        class="form-control {{$errors->first('alamat') ? "is-invalid" : ""}}">{{old('alamat')}}</textarea>
                                    <span class="help-block">{{ $errors->first('alamat') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('nomorTelepon') ? "has-error": "" }}">
                                    <label>Nomor Telepon :</label>
                                    <input value="{{old('nomorTelepon')}}" type="text" name="nomorTelepon"
                                        class="form-control {{$errors->first('nomorTelepon') ? "is-invalid" : ""}}"
                                        placeholder="Nomor telepon ...">
                                    <span class="help-block">{{ $errors->first('nomorTelepon') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('avatar') ? "has-error": "" }}">
                                    <label for="foto">Avatar</label>
                                    <input id="avatar" name="avatar" class="form-control" type="file" id="foto">
                                    <span class="help-block">{{ $errors->first('avatar') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Tambah User</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
<script>
    $('.select2').select2()
</script>
