@extends('layouts.global')

@section('title') List Rujuk Pemeriksaan @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List Rujuk Pemeriksaan
    </h1>
    <ol class="breadcrumb">
        <li class="active"><a href="#"> Pemeriksaan</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h4>
                    <i class="icon fa fa-check"></i>
                    Berhasil
                </h4>
                    {{ $message }}
            </div>
            @endif

            @if ($message = Session::get('warning'))
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h4>
                    <i class="icon fa fa-check"></i>
                    Berhasil
                </h4>
                    {{ $message }}
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info" id="tabelsemuapasien1" style="position: relative;">
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th width="30%">Nomor Pemeriksaan</th>
                                <th>Nomor RM</th>
                                <th width="20%">Nama</th>
                                <th width="15%">Jenis Pasien</th>
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
                            @foreach ($pemeriksaan as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->nomor_pemeriksaan }}</td>
                                <td>{{ $p->pasien->nama }}</td>
                                <td>{{ $p->pasien->nomor_rm }}</td>
                                <td>{{ ucfirst($p->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($p->layanan->nama) }}</td>
                                <td>{{ $p->jadwal->waktu_mulai }} WIB - {{ $p->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ $s->waktu_selesai }}</td>
                                <td>{{ ($p->id_dokterRadiologi) != null ? $p->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ ($p->keluhan) != null ? ucfirst($p->keluhan) : "Tidak ada" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('dokterPoli.pasien.detail-pemeriksaan', ['id' => $p->id]) }}">Detail Pemeriksaan</a></li>
                                                @if ($p->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('dokterPoli.pasien.pendaftaran.surat-rujukan', ['id'=>$p->pendaftaran_id]) }}" target="_blank">Lihat Surat Rujukan </a></li>
                                                <li><a href="{{ route('dokterPoli.pasien.pemeriksaan.hasil-expertise', ['id'=>$p->id]) }}" target="_blank">Lihat Hasil Expertise </a></li>
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
