@extends('layouts.global')

@section('title')Tambah Pasien Umum Baru @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        Tambah Pasien Umum Baru
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('pasien.index-pasien-umum') }}"><i class="fa fa-users"></i> Pasien Umum</a>
        <li class="active">Tambah Pasien</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <form method="POST" action="{{ route('pasien.store.pasien-umum') }}" enctype="multipart/form-data">
                @csrf
                <div class="box box-success" style="position: relative;">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('rekamMedis') ? "has-error": "" }}">
                                    <label>Nomor Rekam Medis :</label>
                                    <input value="{{ $nomor_rm }}" type="text" name="rekamMedis" class="form-control"
                                        placeholder="Nomor Rekam Medis ..." readonly>
                                    <span class="help-block">{{ $errors->first('rekamMedis') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('nomorKtp') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Nomor KTP :</label>
                                    <input value="{{ old('nomorKtp') }}" type="text" name="nomorKtp" class="form-control"
                                        placeholder="Nomor KTP ...">
                                    <span class="help-block">{{ $errors->first('nomorKtp') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('nama') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Nama :</label>
                                    <input value="{{ old('nama') }}" type="text" name="nama" class="form-control"
                                        placeholder="Nama ...">
                                    <span class="help-block">{{ $errors->first('nama') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('umur') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Umur :</label>
                                    <input value="{{ old('umur') }}" type="text" name="umur"
                                        class="form-control" placeholder="Umur ...">
                                    <span class="help-block">{{ $errors->first('umur') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('jenisKelamin') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Jenis Kelamin :</label>
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

                                <hr>
                                <label class="text-muted"><span style="color: red">*</span> Wajib diisi</label>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('nomorTelepon') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Nomor Telepon :</label>
                                    <input value="{{old('nomorTelepon')}}" type="text" name="nomorTelepon"
                                        class="form-control {{$errors->first('nomorTelepon') ? "is-invalid" : ""}}"
                                        placeholder="Nomor telepon ...">
                                    <span class="help-block">{{ $errors->first('nomorTelepon') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('alamat') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Alamat :</label>
                                    <textarea name="alamat" id="alamat"
                                        class="form-control {{$errors->first('alamat') ? "is-invalid" : ""}}">{{old('alamat')}}</textarea>
                                    <span class="help-block">{{ $errors->first('alamat') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('jenisAsuransi') ? "has-error": "" }}">
                                    <label><span style="color: red">*</span> Jenis Asuransi :</label>
                                    <select onchange="yesnoSelectAsuransi()" class="form-control select2" name="jenisAsuransi" style="width: 100%;">
                                        <option selected disabled>Silahkan pilih salah satu</option>
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
                                    <label><span style="color: red">*</span> Nomor BPJS :</label>
                                    <input value="{{ old('noBpjs') }}" type="text" name="noBpjs" class="form-control"
                                        placeholder="Nomor BPJS ...">
                                    <span class="help-block">{{ $errors->first('noBpjs') }}</span>
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

@if (Session::has('store_failed'))
<script>
swal('Gagal', '{!! Session::get('store_failed') !!}', 'error',{
    button:'OK',
});
</script>
@endif
@endpush

