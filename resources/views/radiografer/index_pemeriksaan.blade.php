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
    <ol class="breadcrumb" style="margin-top: 58px">
        <li><a href="#"><i class="fa fa-users"></i> Pemeriksaan</a></li>
    </ol>
</section>

{{--  <div class="row">
    <div class="col-md-8">
        <div class="btn-group" style="float: left; margin-left: 15px; margin-top: 20px">
            <button class="btn btn-default" style="background-color: #3c8dbc; color: white" id="button-one"><i class="fa fa-user" style="margin-right: 5px"></i>Belum</button>
            <button class="btn btn-default" id="button-two">Pending</button>
            <button class="btn btn-default" id="button-three">Selesai</button>
        </div>
    </div>
</div>  --}}

<div class="row">
    <div class="col-md-8">
        <div class="btn-group" style="float: left; margin-left: 15px; margin-top: 20px">
            <button class="btn btn-info" id="button-one"><span class="fa fa-stethoscope" style="margin-right: 5px"></span>Belum</button>
        </div>
        <div class="btn-group" style="float: left; margin-left: 5px; margin-top: 20px">
            <button class="btn btn-warning" id="button-two"><span class="fa fa-clock-o" style="margin-right: 5px"></span>Pending</button>
        </div>
        <div class="btn-group" style="float: left; margin-left: 5px; margin-top: 20px">
            <button class="btn btn-success" id="button-three"><span class="fa fa-check" style="margin-right: 5px"></span>Selesai</button>
        </div>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h4>
                    <i class="icon fa fa-info"></i>
                    Peringatan Khusus Pasien Jenis Pemeriksaan Penuh
                </h4>
                - Pastikan anda telah memberikan tanda tangan anda pada hasil expertise pasien <br>
                - Klik "Lihat Hasil Expertise" pada tombol "Aksi" pasien yang telah selesai dilakukan expertise <br>
                - Klik tombol "Download Expertise" untuk mengunduh hasil expertise <br>
                - Berikan tanda tangan anda menggunakan tanda tangan digital pada hasil expertise tersebut <br>
                - Setelah diberi tanda tangan, unggah hasil expertise tersebut pada sistem<br>
                - Cetak hasil expertise menggunakan file pdf yang telah anda tanda tangani
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-3 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $total_belum }}</h3>

                    <p>Pasien belum diperiksa</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
            </div>
        </div>

        <div class="col-xs-3 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $total_pending }}</h3>

                    <p>Pasien pending</p>
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
                    <h3>{{ $total_selesai }}</h3>

                    <p>Pasien selesai diperiksa</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info" id="tabelbelum" style="position: relative;" >
                <div class="box-header">
                    <h3 class="box-title">Pasien Belum Diperiksa</h3>
                </div>
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th width="18%">Nomor Pemeriksaan</th>
                                <th>Nomor RM</th>
                                <th width="20%">Nama</th>
                                <th width="15%">Jenis Pasien</th>
                                <th width="2%">Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th width="5%">Jadwal</th>
                                <th width="20%">Dokter Perujuk</th>
                                <th width="20%">Dokter Rujukan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($belum as $b)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $b->nomor_pemeriksaan }}</td>
                                <td>{{ str_pad($b->pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $b->pasien->nama }}</td>
                                <td>{{ ($b->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($b->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($b->layanan->nama) }}</td>
                                <td>{{ $b->jadwal->waktu_mulai }} WIB - {{ $b->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ ($b->id_dokterPoli) != null ? $b->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($b->id_dokterRadiologi) != null ? $b->dokterRadiologi->nama : "-" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a id="modal-detail" href="#" data-toggle="modal"
                                                    data-target="#detail-pemeriksaan"
                                                    data-ktp="{{ $b->pasien->nomor_ktp }}"
                                                    data-tanggal="{{ $b->created_at }}"
                                                    data-keluhanpasien="{{ ($b->keluhan) != null ? ucfirst($b->keluhan) : "Tidak ada" }}"
                                                    data-permintaantambahan="{{ ($b->permintaan_tambahan) != null ? ucfirst($b->permintaan_tambahan) : "Tidak ada" }}">Detail</a>
                                                <li><a href="{{ route('radiografer.pasien.pemeriksaan-pasien', ['id'=>$b->id]) }}">Unggah Hasil</a></li>
                                                @if ($b->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('radiografer.pasien.pendaftaran.surat-rujukan', ['id'=>$b->pendaftaran_id]) }}" target="_blank">Lihat Surat Rujukan </a></li>
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

            <div class="box box-warning" id="tabelpending" style="position: relative; display: none">
                <div class="box-header">
                    <h3 class="box-title">Pemeriksaan Pasien Pending </h3>
                </div>
                <div class="box-body">
                    <table id="table2" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th width="40%">Nomor Pemeriksaan</th>
                                <th>Nomor RM</th>
                                <th width="20%">Nama</th>
                                <th width="15%">Jenis Pasien</th>
                                <th width="2%">Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th width="5%">Waktu Kirim</th>
                                <th width="15%">Dokter Perujuk</th>
                                <th width="15%">Dokter Rujukan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pending as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->nomor_pemeriksaan }}</td>
                                <td>{{ str_pad($p->pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $p->pasien->nama }}</td>
                                <td>{{ ($p->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($p->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($p->layanan->nama) }}</td>
                                <td>{{ $p->jadwal->waktu_mulai }} WIB - {{ $p->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ $p->waktu_kirim }}</td>
                                <td>{{ ($p->id_dokterPoli) != null ? $p->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($p->id_dokterRadiologi) != null ? $p->dokterRadiologi->nama : "-" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('radiografer.pasien.detail-pemeriksaan', ['id' => $p->id]) }}">Detail Pemeriksaan</a></li>
                                                @if ($p->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('radiografer.pasien.pendaftaran.surat-rujukan', ['id'=>$p->pendaftaran_id]) }}" target="_blank">Lihat Surat Rujukan </a></li>
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

            <div class="box box-success" id="tabelselesai" style="position: relative; display: none">
                <div class="box-header">
                    <h3 class="box-title">Pasien Selesai Diperiksa</h3>
                </div>
                <div class="box-body">
                    <table id="table5" class="table table-bordered table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th width="40%">Nomor Pemeriksaan</th>
                                <th>Nomor RM</th>
                                <th width="30%">Nama</th>
                                <th width="15%">Jenis Pasien</th>
                                <th width="2%">Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th>Waktu Selesai</th>
                                <th width="15%">Dokter Perujuk</th>
                                <th width="15%">Dokter Rujukan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($selesai as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->nomor_pemeriksaan }}</td>
                                <td>{{ str_pad($s->pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $s->pasien->nama }}</td>
                                <td>{{ ($s->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($s->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($s->layanan->nama) }}</td>
                                <td>{{ $s->jadwal->waktu_mulai }} WIB - {{ $s->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ $s->waktu_selesai }}</td>
                                <td>{{ ($s->id_dokterPoli) != null ? $s->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($s->id_dokterRadiologi) != null ? $s->dokterRadiologi->nama : "-" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('radiografer.pasien.detail-pemeriksaan', ['id' => $s->id]) }}">Detail Pemeriksaan</a></li>
                                                @if ($s->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('radiografer.pasien.pendaftaran.surat-rujukan', ['id'=>$s->pendaftaran_id]) }}" target="_blank">Lihat Surat Rujukan </a></li>
                                                <li><a href="{{ route('radiografer.pasien.pemeriksaan.hasil-expertise', ['id'=>$s->id]) }}" target="_blank">Lihat Hasil Expertise </a></li>
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

    <div class="modal fade" id="detail-pemeriksaan">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="text-align: center">Detail Pemeriksaan</h4>
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
                                        <th>Keluhan</th>
                                        <td><span id="keluhan-pasien"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Permintaan Tambahan</th>
                                        <td><span id="permintaan-tambahan"></span></td>
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
            var keluhan_pasien = $(this).data('keluhanpasien');
            var permintaan_tambahan = $(this).data('permintaantambahan');
            $('#tanggal').text(tanggal);
            $('#nomor-ktp').text(ktp_pasien);
            $('#keluhan-pasien').text(keluhan_pasien);
            $('#permintaan-tambahan').text(permintaan_tambahan);
        })
    })

$("#button-one").click(function () {
    // $(this).css("background", "#3c8dbc");
    // $(this).css("color", "white");
    // $("#button-two").css("background", "#ecf0f5")
    // $("#button-two").css("color", "black")
    // $("#button-three").css("background", "#ecf0f5")
    // $("#button-three").css("color", "black")
    $("#tabelbelum").show(1000)
    $("#tabelpending").hide(300)
    $("#tabelselesai").hide(300)
})
$("#button-two").click(function () {
    // $(this).css("background", "#3c8dbc");
    // $(this).css("color", "white");
    // $("#button-one").css("background", "#ecf0f5")
    // $("#button-one").css("color", "black")
    // $("#button-three").css("background", "#ecf0f5")
    // $("#button-three").css("color", "black")
    $("#tabelpending").show(1000)
    $("#tabelbelum").hide(300)
    $("#tabelselesai").hide(300)
})
$("#button-three").click(function () {
    // $(this).css("background", "#3c8dbc");
    // $(this).css("color", "white");
    // $("#button-one").css("background", "#ecf0f5")
    // $("#button-one").css("color", "black")
    // $("#button-two").css("background", "#ecf0f5")
    // $("#button-two").css("color", "black")
    $("#tabelselesai").show(1000)
    $("#tabelbelum").hide(300)
    $("#tabelpending").hide(300)
})
</script>

@if (Session::has('store_succeed'))
<script>
swal('Berhasil', '{!! Session::get('store_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif

@if (Session::has('upload_succeed'))
<script>
swal('Berhasil', '{!! Session::get('upload_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif

@if (Session::has('login_succeed'))
<script>
swal('Login Berhasil', '{!! Session::get('login_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif
@endpush
