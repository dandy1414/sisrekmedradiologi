@extends('layouts.global')

@section('title') Detail Pasien Rumah Sakit @endsection

@section('content')

<section class="content-header" style="margin-top: 50px;">
    <h1>
        Detail Pasien Rumah Sakit
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('resepsionis.pasien.index-pasien-rs') }}"><i class="fa fa-users"></i> Pasien RS</a></li>
        <li class="active">Detail Pasien RS</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title" style="text-align: center">Detail Pasien</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-7">
                            <strong><i class="fa fa-calendar"></i> Tanggal Pendaftaran :</strong>

                            <p class="text-muted">{{ $pasien->created_at }}</p>

                            <strong><i class="fa fa-medkit"></i> Nomor Rekam Medis :</strong>

                            <p class="text-muted">{{ str_pad($pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }}</p>

                            <strong><i class="fa fa-credit-card"></i> Nomor KTP :</strong>

                            <p class="text-muted">{{ $pasien->nomor_ktp }}</p>

                            <strong><i class="fa fa-user"></i> Nama :</strong>

                            <p class="text-muted">{{ $pasien->nama }}</p>

                            <strong><i class="fa fa-user"></i> Jenis Kelamin :</strong>

                            <p class="text-muted">{{ ucfirst($pasien->jenis_kelamin) }}</p>

                            <strong><i class="fa fa-user"></i> Umur :</strong>

                            <p class="text-muted">{{ $pasien->umur }} tahun</p>
                        </div>

                        <div class="col-md-5">
                            <strong><i class="fa fa-home"></i> Alamat :</strong>

                            <p class="text-muted">{{ ucfirst($pasien->alamat) }}</p>

                            <strong><i class="fa fa-phone"></i> Nomor telepon :</strong>

                            <p class="text-muted">{{ $pasien->nomor_telepon }}</p>

                            <strong><i class="fa fa-hospital-o"></i> Asal Ruangan / Kelas :</strong>

                            <p class="text-muted">{{ $pasien->ruangan->nama_ruangan }} / {{ $pasien->ruangan->kelas }}</p>

                            <strong><i class="fa fa-institution"></i> Jenis Asuransi :</strong>

                            <p class="text-muted">{{ ucfirst($pasien->jenis_asuransi) }}</p>

                            <strong><i class="fa fa-bars"></i> Nomor BPJS :</strong>

                            <p class="text-muted">
                                {{ ($pasien->nomor_bpjs) != null ? $pasien->nomor_bpjs : "-" }}</p>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title" style="text-align: center">Riwayat Pendaftaran</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Pendaftaran</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th>Dokter Rujukan</th>
                                <th width="30%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftaran as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->nomor_pendaftaran }}</td>
                                <td>{{ ucfirst($p->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($p->layanan->nama) }}</td>
                                <td>{{ $p->jadwal->waktu_mulai }} WIB - {{ $p->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ ($p->id_dokterRadiologi) != null ? $p->dokterRadiologi->nama : "-" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a id="modal-detail" href="#" data-toggle="modal"
                                                        data-target="#detail-pendaftaran"
                                                        data-ktp="{{ $p->pasien->nomor_ktp }}"
                                                        data-tanggal="{{ $p->created_at }}"
                                                        data-perujuk="{{ ($p->id_dokterPoli) != null ? $p->dokterPoli->nama : "Tidak ada" }}"
                                                        data-resepsionis="{{ ($p->id_resepsionis) != null ? $p->resepsionis->nama : "Tidak ada" }}"
                                                        data-keluhanpasien="{{ ($p->keluhan) != null ? ucfirst($p->keluhan) : "Tidak ada" }}">Detail</a>
                                                </li>
                                                @if ($p->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('resepsionis.pasien.pendaftaran.surat-rujukan', ['id'=>$p->id]) }}"
                                                        target="_blank">Lihat Surat Rujukan </a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detail-pendaftaran">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="text-align: center">Detail Pendaftaran</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Tanggal Pendaftaran</th>
                                        <td><span id="tanggal"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Nomor KTP</th>
                                        <td><span id="nomor-ktp"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Dokter Perujuk</th>
                                        <td><span id="dokter-perujuk"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Resepsionis</th>
                                        <td><span id="resepsionis"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Keluhan</th>
                                        <td><span id="keluhan-pasien"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Kembali</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</section>

@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $(document).on('click', '#modal-detail', function() {
            var tanggal = $(this).data('tanggal');
            var ktp_pasien = $(this).data('ktp');
            var dokter_perujuk = $(this).data('perujuk');
            var resepsionis = $(this).data('resepsionis');
            var keluhan_pasien = $(this).data('keluhanpasien');
            $('#tanggal').text(tanggal);
            $('#nomor-ktp').text(ktp_pasien);
            $('#dokter-perujuk').text(dokter_perujuk);
            $('#resepsionis').text(resepsionis);
            $('#keluhan-pasien').text(keluhan_pasien);
        })
    })

</script>
@endpush
