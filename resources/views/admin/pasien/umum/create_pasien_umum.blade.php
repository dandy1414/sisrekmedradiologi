@extends('layouts.global')

@section('title')Tambah Pasien Baru @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        Tambah Pasien Baru
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('pasien.index-pasien-umum') }}"><i class="fa fa-users"></i> Pasien Umum</a>
        <li class="active">Tambah Pasien</li>
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
            <form method="POST" action="{{ route('pasien.store.pasien-umum') }}" enctype="multipart/form-data">
                @csrf
                <div class="box box-success" style="position: relative;">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('nomorKtp') ? "has-error": "" }}">
                                    <label>Nomor KTP :</label>
                                    <input value="{{ old('nomorKtp') }}" type="text" name="nomorKtp" class="form-control"
                                        placeholder="Nomor KTP ...">
                                    <span class="help-block">{{ $errors->first('nomorKtp') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('nama') ? "has-error": "" }}">
                                    <label>Nama :</label>
                                    <input value="{{ old('nama') }}" type="text" name="nama" class="form-control"
                                        placeholder="Nama ...">
                                    <span class="help-block">{{ $errors->first('nama') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('umur') ? "has-error": "" }}">
                                    <label>Umur :</label>
                                    <input value="{{ old('umur') }}" type="text" name="umur"
                                        class="form-control" placeholder="Umur ...">
                                    <span class="help-block">{{ $errors->first('umur') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('jenisKelamin') ? "has-error": "" }}">
                                    <label>Jenis Kelamin :</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jenisKelamin" id="Laki-laki" value="Laki-laki"
                                                {{ old('jenisKelamin') == 'Laki-laki' ? "checked" : "" }}>
                                            Laki-laki
                                        </label>
                                        <label>
                                            <input type="radio" name="jenisKelamin" id="perempuan" value="perempuan"
                                                {{ old('jenisKelamin') == 'perempuan' ? "checked" : "" }}>
                                            Perempuan
                                        </label>
                                        <span class="help-block">{{ $errors->first('jenisKelamin') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('nomorTelepon') ? "has-error": "" }}">
                                    <label>Nomor Telepon :</label>
                                    <input value="{{old('nomorTelepon')}}" type="text" name="nomorTelepon"
                                        class="form-control {{$errors->first('nomorTelepon') ? "is-invalid" : ""}}"
                                        placeholder="Nomor telepon ...">
                                    <span class="help-block">{{ $errors->first('nomorTelepon') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('alamat') ? "has-error": "" }}">
                                    <label>Alamat :</label>
                                    <textarea name="alamat" id="alamat"
                                        class="form-control {{$errors->first('alamat') ? "is-invalid" : ""}}">{{old('alamat')}}</textarea>
                                    <span class="help-block">{{ $errors->first('alamat') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('jenisAsuransi') ? "has-error": "" }}">
                                    <label>Jenis Asuransi :</label>
                                    <select onchange="yesnoSelectAsuransi()" class="form-control select2" name="jenisAsuransi" style="width: 100%;">
                                        <option selected>Silahkan pilih salah satu</option>
                                        <option id="noSelectAsuransi" value="umum"
                                            {{ old('jenisAsuransi') == 'umum' ? "selected" : "" }}>
                                            Umum</option>
                                        <option id="yesSelectAsuransi" value="bpjs"
                                            {{ old('jenisAsuransi') == 'bpjs' ? "selected" : "" }}>
                                            BPJS</option>
                                        <option id="noSelectAsuransi" value="lainnya"
                                            {{ old('jenisAsuransi') == 'lainnya' ? "selected" : "" }}>
                                            Lainnya</option>
                                        <option id="noSelectAsuransi" value="tidak ada"
                                            {{ old('jenisAsuransi') == 'tidak ada' ? "selected" : "" }}>
                                            Tidak ada</option>
                                    </select>
                                    <span class="help-block">{{ $errors->first('jenisAsuransi') }}</span>
                                </div>

                                <div id="ifYesAsuransi" class="form-group {{ $errors->first('noBpjs') ? "has-error": "" }}" style="display: none">
                                    <label>Nomor BPJS :</label>
                                    <input value="{{ old('noBpjs') }}" type="text" name="noBpjs" class="form-control"
                                        placeholder="Nomor BPJS ...">
                                    <span class="help-block">{{ $errors->first('noBpjs') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Tambah Pasien</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
<script type="text/javascript">
    function yesnoSelect() {
        if(document.getElementById("yesSelect").selected) {
            document.getElementById("ifYes1").style.display = "block";
            document.getElementById("ifYes2").style.display = "block";
        } else {
            document.getElementById("ifYes1").style.display = "none";
            document.getElementById("ifYes2").style.display = "none";
        }
    }

    function yesnoSelectAsuransi() {
        if(document.getElementById("yesSelectAsuransi").selected) {
            document.getElementById("ifYesAsuransi").style.display = "block";
        } else {
            document.getElementById("ifYesAsuransi").style.display = "none";
        }
    }
</script>
