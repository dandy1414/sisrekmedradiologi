@extends('layouts.global')

@section('title')Pendaftaran Pemeriksaan Pasien Umum @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        Pendaftaran Pemeriksaan Pasien Umum
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('resepsionis.pasien.index-pasien-umum') }}"><i class="fa fa-users"></i> Pasien Umum</a>
        <li><a href="#"><i class="fa fa-users"></i> Pendaftaran Pemeriksaan Pasien Umum</a>
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
        <div class="col-md-6">
            <div class="box box-info" style="position: relative;">
                <div class="box-header">
                    <h3 class="box-title">Data Pasien</h3>
                </div>
                <div class="box-body">
                    <strong><i class="fa fa-book margin-r-5"></i> Nomor Rekam Medis : </strong>
                    <p class="text-muted">
                        {{ $pasien->nomor_rm }}
                    </p>

                    <strong><i class="fa fa-book margin-r-5"></i> Nama : </strong>
                    <p class="text-muted">
                        {{ $pasien->nama }}
                    </p>

                    <strong><i class="fa fa-book margin-r-5"></i> Nomor KTP : </strong>
                    <p class="text-muted">
                        {{ $pasien->nomor_ktp }}
                    </p>

                    <strong><i class="fa fa-book margin-r-5"></i> Umur : </strong>
                    <p class="text-muted">
                        {{ $pasien->umur }} Tahun
                    </p>

                    <strong><i class="fa fa-book margin-r-5"></i> Jenis Kelamin : </strong>
                    <p class="text-muted">
                        {{ $pasien->jenis_kelamin }}
                    </p>

                    <strong><i class="fa fa-book margin-r-5"></i> Alamat : </strong>
                    <p class="text-muted">
                        {{ ucfirst($pasien->alamat) }}
                    </p>

                    <strong><i class="fa fa-book margin-r-5"></i> Nomor Telepon : </strong>
                    <p class="text-muted">
                        {{ $pasien->jenis_kelamin }}
                    </p>

                    <strong><i class="fa fa-book margin-r-5"></i> Jenis Asuransi : </strong>
                    <p class="text-muted">
                        {{ ucfirst($pasien->jenis_asuransi) }}
                    </p>

                    <strong><i class="fa fa-book margin-r-5"></i> Nomor BPJS : </strong>
                    <p class="text-muted">
                        {{ ($pasien->jenis_asuransi) != 'bpjs' ? "-" : ucfirst($pasien->nomor_bpjs) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <form method="POST" action="{{ route('resepsionis.pasien.store.pendaftaran.pasien-umum', ['id' => $pasien->id]) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="box box-success" style="position: relative;">
                    <div class="box-header">
                        <h3 class="box-title">Form Pendaftaran Pemeriksaan</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group {{ $errors->first('jenisPemeriksaan') ? "has-error": "" }}">
                            <label>Jenis Pemeriksaan :</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="jenisPemeriksaan" id="biasa" value="biasa"
                                        {{ old('jenisPemeriksaan') == 'biasa' ? "checked" : "" }}>
                                    Biasa
                                </label>
                                <label>
                                    <input type="radio" name="jenisPemeriksaan" id="penuh" value="penuh"
                                        {{ old('jenisPemeriksaan') == 'penuh' ? "checked" : "" }}>
                                    Penuh
                                </label>
                                <span class="help-block">{{ $errors->first('jenisPemeriksaan') }}</span>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('layanan') ? "has-error": "" }}">
                            <label>Layanan Kategori Rontgen :</label>
                            <select class="form-control select2" name="layanan" style="width: 100%;">
                                <option selected disabled>Silahkan pilih salah satu</option>
                                @foreach ($layanan_rontgen as $lr)
                                <option value="{{ $lr->id }}" {{ old('layanan') == $lr->id ? "selected" : "" }}>
                                    {{ $lr->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('layanan') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('layanan') ? "has-error": "" }}">
                            <label>Layanan Kategori USG :</label>
                            <select class="form-control select2" name="layanan" style="width: 100%;">
                                <option selected disabled>Silahkan pilih salah satu</option>
                                @foreach ($layanan_usg as $lu)
                                <option value="{{ $lu->id }}" {{ old('layanan') == $lu->id ? "selected" : "" }}>
                                    {{ $lu->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('layanan') }}</span>
                        </div>

                        <div class="form-group {{ $errors->first('jadwal') ? "has-error": "" }}">
                            <label>Jadwal :</label>
                            <select class="form-control select2" name="jadwal" style="width: 100%;">
                                <option selected disabled>Silahkan pilih salah satu</option>
                                @foreach ($jadwal as $j)
                                <option value="{{ $j->id }}" {{ old('jadwal') == $j->id ? "selected" : "" }}>
                                    {{ $j->waktu_mulai }} - {{ $j->waktu_selesai }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('jadwal') }}</span>
                        </div>

                        <div class="form-group {{ $errors->first('dokterRujukan') ? "has-error": "" }}">
                            <label>Dokter Rujukan :</label>
                            <select class="form-control select2" name="dokterRujukan" style="width: 100%;">
                                <option selected disabled>Silahkan pilih salah satu</option>
                                @foreach ($dokter as $d)
                                <option value="{{ $d->id }}" {{ old('dokterRujukan') == $d->id ? "selected" : "" }}>
                                    {{ $d->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('dokterRujukan') }}</span>
                        </div>

                        <div class="form-group {{ $errors->first('keluhan') ? "has-error": "" }}">
                            <label>Keluhan :</label>
                            <input value="{{ old('nama') }}" type="text" name="keluhan" class="form-control"
                                placeholder="Keluhan ...">
                            <span class="help-block">{{ $errors->first('keluhan') }}</span>
                        </div>

                        <div class="form-group {{ $errors->first('permintaan') ? "has-error": "" }}">
                            <label>Informasi Tambahan/Permintaan Tambahan :</label>
                            <input value="{{ old('permintaan') }}" type="text" name="permintaan" class="form-control"
                                placeholder="Informasi tambahan  ...">
                            <span class="help-block">{{ $errors->first('permintaan') }}</span>
                        </div>

                        {{--  <div class="form-group {{ $errors->first('suratRujukan') ? "has-error": "" }}">
                            <label for="foto">Surat Rujukan</label>
                            <input id="avatar" name="suratRujukan" class="form-control" type="file" id="suratRujukan">
                            <span class="help-block">{{ $errors->first('suratRujukan') }}</span>
                        </div>  --}}
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Daftarkan Pasien</button>
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
        if (document.getElementById("yesSelect").selected) {
            document.getElementById("ifYes1").style.display = "block";
            document.getElementById("ifYes2").style.display = "block";
        } else {
            document.getElementById("ifYes1").style.display = "none";
            document.getElementById("ifYes2").style.display = "none";
        }
    }

    function yesnoSelectAsuransi() {
        if (document.getElementById("yesSelectAsuransi").selected) {
            document.getElementById("ifYesAsuransi").style.display = "block";
        } else {
            document.getElementById("ifYesAsuransi").style.display = "none";
        }
    }

</script>
@endpush

