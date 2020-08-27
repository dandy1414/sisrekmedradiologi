@extends('layouts.global')

@section('title')Expertise Pasien @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        Expertise Pasien
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dokterRadiologi.pasien.index-pemeriksaan') }}"><i class="fa fa-users"></i>
                Pemeriksaan</a>
        <li class="active">Expertise Pasien</li>
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
        <div class="col-md-4">
            <div class="box box-warning" style="position: relative; height:598px">
                <div class="box-header">
                    <h3 class="box-title">Hasil Foto</h3>
                </div>
                <div class="box-body">
                    <img src="{{ asset('storage/hasil_foto/'. $pemeriksaan->hasil_foto) }}" alt="Hasil Foto"
                        class="responsive" height="100%" width="100%">
                    <hr>

                    <div class="col-md-6">
                        <strong> Arus Listrik : </strong>
                        <p class="text-muted">
                            {{ ($pemeriksaan->arus_listrik) != null ? $pemeriksaan->arus_listrik : "-"  }}
                        </p>

                        <strong> FFD : </strong>
                        <p class="text-muted">
                            {{ ($pemeriksaan->ffd) != null ? $pemeriksaan->ffd : "-" }}
                        </p>

                        <strong> BSF : </strong>
                        <p class="text-muted">
                            {{ ($pemeriksaan->bsf) != null ? $pemeriksaan->bsf : "-" }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <strong> Jumlah Penyinaran : </strong>
                        <p class="text-muted">
                            {{ ($pemeriksaan->jumlah_penyinaran) != null ? $pemeriksaan->jumlah_penyinaran : "-"  }}
                        </p>

                        <strong> Dosis Penyinaran : </strong>
                        <p class="text-muted">
                            {{ ($pemeriksaan->dosis_penyinaran) != null ? $pemeriksaan->dosis_penyinaran : "-" }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
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

                        <p class="text-muted">{{ $pemeriksaan->pasien->nomor_rm }}</p>

                        <strong><i class="fa fa-credit-card"></i> Nomor KTP :</strong>

                        <p class="text-muted">{{ $pemeriksaan->pasien->nomor_ktp }}</p>

                        <strong><i class="fa fa-user"></i> Nama :</strong>

                        <p class="text-muted">{{ $pemeriksaan->pasien->nama }}</p>

                        <strong><i class="fa fa-user"></i> Jenis Kelamin :</strong>

                        <p class="text-muted">{{ ucfirst($pemeriksaan->pasien->jenis_kelamin) }}</p>
                        <strong><i class="fa fa-user"></i> Umur :</strong>

                        <p class="text-muted">{{ $pemeriksaan->pasien->umur }} tahun</p>
                    </div>

                    <div class="col-md-5">


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
                    </div>

                    <div class="col-md-5">
                        <strong><i class="fa fa-user-md"></i> Dokter Perujuk : </strong>
                        <p class="text-muted">
                            {{ ($pemeriksaan->id_dokterPoli) != null ? $pemeriksaan->dokterPoli->nama : "-" }}
                        </p>

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
                action="{{ route('dokterRadiologi.pasien.store.expertise-pasien', ['id' => $pemeriksaan->id]) }}"
                enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Form Expertise</h3>
                    </div>
                    <div class="box-body">
                        <textarea id="expertisePasien" class="form-control" name="expertise" rows="10"
                            cols="50"></textarea>
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
<!-- CKeditor -->
<script src="{{ asset('adminlte/bower_components/ckeditor/ckeditor.js') }}"></script>
<script>
    $(function () {
        // var expertise = document.getElementById("expertise");
        CKEDITOR.replace('expertisePasien', {
            language: 'en-gb',
        });
        CKEDITOR.config.allowedContent = true;
    })

</script>
@endpush
