@extends('layouts.global')

@section('title')Unggah Hasil Pemeriksaan Pasien @endsection

@section('csrf')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        Unggah Hasil Pemeriksaan Pasien
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('radiografer.pasien.index-pemeriksaan') }}"><i class="fa fa-stethoscope"></i>
                Pemeriksaan</a>
        <li class="active">Unggah Hasil Pemeriksaan</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info" style="position: relative;">
                <div class="box-header">
                    <h3 class="box-title">Detail Pasien</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-7">
                        <strong><i class="glyphicon glyphicon-list-alt"></i> Jenis Pasien : </strong>
                        <p class="text-muted">
                            {{ ($pemeriksaan->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}
                        </p>

                        <strong><i class="fa fa-medkit"></i> Nomor Rekam Medis :</strong>

                        <p class="text-muted">{{ str_pad($pemeriksaan->pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }}</p>

                        <strong><i class="fa fa-credit-card"></i> Nomor KTP :</strong>

                        <p class="text-muted">{{ $pemeriksaan->pasien->nomor_ktp }}</p>

                        <strong><i class="fa fa-user"></i> Nama :</strong>

                        <p class="text-muted">{{ $pemeriksaan->pasien->nama }}</p>

                        <strong><i class="fa fa-user"></i> Jenis Kelamin :</strong>

                        <p class="text-muted">{{ ucfirst($pemeriksaan->pasien->jenis_kelamin) }}</p>
                    </div>

                    <div class="col-md-5">
                        <strong><i class="fa fa-user"></i> Umur :</strong>

                        <p class="text-muted">{{ $pemeriksaan->pasien->umur }} tahun</p>


                        <strong><i class="fa fa-phone"></i> Nomor telepon :</strong>
                        <p class="text-muted">
                            {{ $pemeriksaan->pasien->nomor_telepon }}
                        </p>

                        <strong><i class="fa fa-home"></i> Alamat :</strong>
                        <p class="text-muted">
                            {{ ucfirst($pemeriksaan->pasien->alamat) }}
                        </p>

                        <strong><i class="fa fa-hospital-o"></i> Asal Ruangan / Kelas :</strong>
                        <p class="text-muted">
                            {{ ($pemeriksaan->pasien->id_ruangan) != null ? $pemeriksaan->pasien->ruangan->nama_ruangan ." / ". $pemeriksaan->pasien->ruangan->kelas : "-" }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-primary" style="position: relative;">
                <div class="box-header">
                    <h3 class="box-title">Detail Pemeriksaan</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-7">
                        <strong><i class="glyphicon glyphicon-th-list"></i> Nomor Pemeriksaan : </strong>
                        <p class="text-muted">
                            {{ ucfirst($pemeriksaan->nomor_pemeriksaan) }}
                        </p>

                        <strong><i class="fa fa-bars"></i> Jenis Pemeriksaan : </strong>
                        <p class="text-muted">
                            {{ ucfirst($pemeriksaan->jenis_pemeriksaan) }}
                        </p>

                        <strong><i class="fa fa-book"></i> Kategori / Layanan : </strong>
                        <p class="text-muted">
                            {{ ucfirst($pemeriksaan->layanan->kategori->nama) }} / {{ ($pemeriksaan->layanan->nama) }}
                        </p>

                        <strong><i class="fa fa-user-md"></i> Dokter Perujuk : </strong>
                        <p class="text-muted">
                            {{ ($pemeriksaan->id_dokterPoli) != null ? $pemeriksaan->dokterPoli->nama : "-" }}
                        </p>

                        <strong><i class="fa fa-user-md"></i> Dokter Rujukan : </strong>
                        <p class="text-muted">
                            {{ ($pemeriksaan->id_dokterRadiologi) != null ? $pemeriksaan->dokterRadiologi->nama : "-" }}
                        </p>
                    </div>

                    <div class="col-md-5">
                        <strong><i class="glyphicon glyphicon-file"></i> Permintaan Tambahan : </strong>
                        <p class="text-muted">
                            {{ ($pemeriksaan->permintaan_tambahan) != null ? $pemeriksaan->permintaan_tambahan : "Tidak ada" }}
                        </p>

                        <strong><i class="fa fa-ambulance"></i> Keluhan : </strong>
                        <p class="text-muted">
                            {{ ($pemeriksaan->keluhan) != null ? $pemeriksaan->keluhan : "Tidak ada" }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="POST"
                action="{{ route('radiografer.pasien.store.pemeriksaan-pasien', ['id' => $pemeriksaan->id]) }}"
                enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Form Pemeriksaan</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->first('hasilFoto') ? "has-error": "" }}">
                                <label for="foto"><span style="color: red">*</span> Hasil Foto</label>
                                <input id="hasilFoto" name="hasilFoto" class="form-control" type="file">
                                <p class="help-block">Silahkan unggah hasil foto</p>
                                <span class="help-block">{{ $errors->first('hasilFoto') }}</span>
                            </div>

                            <div class="form-group {{ $errors->first('film') ? "has-error": "" }}">
                                <label><span style="color: red">*</span> Film :</label>
                                <select class="form-control select2" name="film" style="width: 100%;">
                                    <option disabled selected>Silahkan pilih salah satu</option>
                                    @foreach ($film as $f)
                                    <option value="{{ $f->id }}" {{ old('film') == $f->id ? "selected" : "" }}>
                                        {{ $f->nama }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block">{{ $errors->first('film') }}</span>
                            </div>

                            <div class="form-group">
                                <label>Catatan</label>
                                <textarea name="catatan" id="catatan" cols="10" rows="2"
                                    class="form-control"></textarea>
                            </div>

                            <div class="form-group {{ $errors->first('arus') ? "has-error": "" }}">
                                <label>Arus Listrik :</label>
                                <input value="{{ old('arus') }}" type="text" name="arus" class="form-control"
                                    placeholder="Arus dan Waktu ...">
                                <span class="help-block">{{ $errors->first('arus') }}</span>
                            </div>

                            <hr>
                        <label class="text-muted"><span style="color: red">*</span> Wajib diisi</label>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group {{ $errors->first('ffd') ? "has-error": "" }}">
                                <label>FFD :</label>
                                <input value="{{ old('ffd') }}" type="text" name="ffd" class="form-control"
                                    placeholder="FFD ...">
                                <span class="help-block">{{ $errors->first('ffd') }}</span>
                            </div>

                            <div class="form-group {{ $errors->first('bsf') ? "has-error": "" }}">
                                <label>BSF :</label>
                                <input value="{{ old('bsf') }}" type="text" name="bsf" class="form-control"
                                    placeholder="BSF ...">
                                <span class="help-block">{{ $errors->first('bsf') }}</span>
                            </div>

                            <div class="form-group {{ $errors->first('jumlah') ? "has-error": "" }}">
                                <label>Jumlah Penyinaran :</label>
                                <input value="{{ old('jumlah') }}" type="text" name="jumlah" class="form-control"
                                    placeholder="Jumlah Penyinaran ...">
                                <span class="help-block">{{ $errors->first('jumlah') }}</span>
                            </div>

                            <div class="form-group {{ $errors->first('dosis') ? "has-error": "" }}">
                                <label>Dosis Radiasi :</label>
                                <input value="{{ old('dosis') }}" type="text" name="dosis" class="form-control"
                                    placeholder="Dosis Radiasi ...">
                                <span class="help-block">{{ $errors->first('dosis') }}</span>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Unggah</button>
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

@if (Session::has('store_failed'))
<script>
swal('Gagal', '{!! Session::get('store_failed') !!}', 'error',{
    button:'OK',
});
</script>
@endif
@endpush

