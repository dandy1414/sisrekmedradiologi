@extends('layouts.global')

@section('title') List Pemeriksaan @endsection

@section('csrf')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List Pemeriksaan
    </h1>
    <ol class="breadcrumb">
        <li class="active"><a href="#"> Pemeriksaan</a></li>
    </ol>
</section>

<div class="row">
    <div class="col-md-8">
        <div class="btn-group" style="float: left; margin-left: 15px; margin-top: 20px">
            <button class="btn btn-warning" id="tombol-one"><span class="fa fa-stethoscope" style="margin-right: 5px"></span>Pending</button>
        </div>
        <div class="btn-group" style="float: left; margin-left: 10px; margin-top: 20px">
            <button class="btn btn-success" id="tombol-two"><span class="fa fa-check" style="margin-right: 5px"></span>Selesai</button>
        </div>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-xs-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $total_pasien_pending }}</h3>

                    <p>Pemeriksaan pasien pending</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
            </div>
        </div>

        <div class="col-xs-3 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $total_pasien_selesai }}</h3>

                    <p>Pemeriksaan pasien selesai hari ini</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-warning" id="tabel-pending-pemeriksaan" style="position: relative;">
                <div class="box-header">
                    <h3 class="box-title">Pemeriksaan Pasien Pending </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th width="30%">Nomor Pemeriksaan</th>
                                <th>Nomor RM</th>
                                <th width="20%">Nama</th>
                                <th width="2%">Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th width="5%">Waktu Kirim</th>
                                <th width="15%">Dokter Rujukan</th>
                                <th>Keluhan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemeriksaan_pending as $pp)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pp->nomor_pemeriksaan }}</td>
                                <td>{{ $pp->pasien->nama }}</td>
                                <td>{{ str_pad($pp->pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ ucfirst($pp->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($pp->layanan->nama) }}</td>
                                <td>{{ $pp->jadwal->waktu_mulai }} WIB - {{ $pp->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ $pp->waktu_kirim }}</td>
                                <td>{{ ($pp->id_dokterRadiologi) != null ? $pp->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ ($pp->keluhan) != null ? ucfirst($pp->keluhan) : "Tidak ada" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('dokterPoli.pasien.detail-pemeriksaan', ['id' => $pp->id]) }}">Detail Pemeriksaan</a></li>
                                                @if ($pp->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('dokterPoli.pasien.pendaftaran.surat-rujukan', ['id'=>$pp->pendaftaran_id]) }}" target="_blank">Lihat Surat Rujukan </a></li>
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

            <div class="box box-success" id="tabel-selesai-pemeriksaan" style="position: relative; display: none;">
                <div class="box-header">
                    <h3 class="box-title">Pemeriksaan Pasien Selesai </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table2" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th width="30%">Nomor Pemeriksaan</th>
                                <th>Nomor RM</th>
                                <th width="20%">Nama</th>
                                <th width="2%">Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th width="5%">Waktu Selesai</th>
                                <th width="15%">Dokter Rujukan</th>
                                <th>Keluhan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemeriksaan_selesai as $ps)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ps->nomor_pemeriksaan }}</td>
                                <td>{{ $ps->pasien->nama }}</td>
                                <td>{{ str_pad($ps->pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ ucfirst($ps->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($ps->layanan->nama) }}</td>
                                <td>{{ $ps->jadwal->waktu_mulai }} WIB - {{ $ps->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ $ps->waktu_selesai }}</td>
                                <td>{{ ($ps->id_dokterRadiologi) != null ? $ps->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ ($ps->keluhan) != null ? ucfirst($ps->keluhan) : "Tidak ada" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('dokterPoli.pasien.detail-pemeriksaan', ['id' => $ps->id]) }}">Detail Pemeriksaan</a></li>
                                                @if ($ps->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('dokterPoli.pasien.pendaftaran.surat-rujukan', ['id'=>$ps->pendaftaran_id]) }}" target="_blank">Lihat Surat Rujukan </a></li>
                                                <li><a href="{{ route('dokterPoli.pasien.pemeriksaan.hasil-expertise', ['id'=>$ps->id]) }}" target="_blank">Lihat Hasil Expertise </a></li>
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
        <!-- /.row -->
    </div>

</section>

@endsection
@push('scripts')
<script>
$("#tombol-one").click(function () {
    $("#tabel-pending-pemeriksaan").show(1000)
    $("#tabel-selesai-pemeriksaan").hide(300)
})
$("#tombol-two").click(function () {
    $("#tabel-selesai-pemeriksaan").show(1000)
    $("#tabel-pending-pemeriksaan").hide(300)
})
</script>
@endpush
