@extends('layouts.global')

@section('title') List Pemeriksaan @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List Pemeriksaan
    </h1>
    <ol class="breadcrumb">
        <li class="active"><a href="#"> Pemeriksaan</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $total_pasien }}</h3>

                    <p>Pemeriksaan pasien hari ini</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
            </div>
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
                                <td>{{ str_pad($p->pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ ucfirst($p->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($p->layanan->nama) }}</td>
                                <td>{{ $p->jadwal->waktu_mulai }} WIB - {{ $p->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ $p->waktu_selesai }}</td>
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
