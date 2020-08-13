@extends('layouts.global')

@section('title') List Tagihan @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List Tagihan
    </h1>
    <ol class="breadcrumb" style="margin-top: 58px">
        <li><a href="#"><i class="fa fa-money"></i>Tagihan</a></li>
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
            <button class="btn btn-warning" id="tombolSatu"><span class="fa fa-money" style="margin-right: 5px"></span>Belum</button>
        </div>
        <div class="btn-group" style="float: left; margin-left: 5px; margin-top: 20px">
            <button class="btn btn-success" id="tombolDua"><span class="fa fa-check" style="margin-right: 5px"></span>Selesai</button>
        </div>
    </div>
</div>

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
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-warning" id="tagihanBelum" style="position: relative;" >
                <div class="box-header">
                    <h3 class="box-title">Tagihan Belum Terbayar</h3>
                </div>
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Tagihan</th>
                                <th>Nama</th>
                                <th>Nomor RM</th>
                                <th>Nomor KTP</th>
                                <th>Jenis Pasien</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th>Tarif Dokter</th>
                                <th>Tarif Jasa</th>
                                <th>Total Tarif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($belum as $b)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $b->nomor_tagihan }}</td>
                                <td>{{ $b->pasien->nama }}</td>
                                <td>{{ $b->pasien->nomor_rm }}</td>
                                <td>{{ $b->pasien->nomor_ktp }}</td>
                                <td>{{ ($b->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($b->pemeriksaan->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($b->layanan->nama) }}</td>
                                <td>{{ $b->jadwal->waktu_mulai }} - {{ $b->jadwal->waktu_selesai }}</td>
                                <td>@currency($b->tarif_dokter)</td>
                                <td>@currency($b->tarif_jasa)</td>
                                <td>@currency($b->total_harga)</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('kasir.pasien.pembayaran-pasien', ['id'=>$b->id]) }}">Pembayaran</a></li>
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

            <div class="box box-success" id="tagihanSelesai" style="position: relative; display: none">
                <div class="box-header">
                    <h3 class="box-title">Tagihan Selesai Terbayar</h3>
                </div>
                <div class="box-body">
                    <table id="table2" class="table table-bordered table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Nomor Tagihan</th>
                                <th>Nama</th>
                                <th>Nomor RM</th>
                                <th>Nomor KTP</th>
                                <th>Jenis Pasien</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th>Tarif Dokter</th>
                                <th>Tarif Jasa</th>
                                <th>Kasir</th>
                                <th>Total Tarif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sudah as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->tanggal }}</td>
                                <td>{{ $s->nomor_tagihan }}</td>
                                <td>{{ $s->pasien->nama }}</td>
                                <td>{{ $s->pasien->nomor_rm }}</td>
                                <td>{{ $s->pasien->nomor_ktp }}</td>
                                <td>{{ ($s->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($s->pemeriksaan->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($s->layanan->nama) }}</td>
                                <td>{{ $s->jadwal->waktu_mulai }} - {{ $s->jadwal->waktu_selesai }}</td>
                                <td>@currency($s->tarif_dokter)</td>
                                <td>@currency($s->tarif_jasa)</td>
                                <td>@currency($s->total_harga)</td>
                                <td>{{ ucfirst($s->kasir->nama) }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('kasir.pasien.detail-tagihan', ['id'=>$s->id]) }}">Detail Pembayaran</a></li>
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
$("#tombolSatu").click(function () {
    // $(this).css("background", "#3c8dbc");
    // $(this).css("color", "white");
    // $("#button-two").css("background", "#ecf0f5")
    // $("#button-two").css("color", "black")
    // $("#button-three").css("background", "#ecf0f5")
    // $("#button-three").css("color", "black")
    $("#tagihanBelum").show(1000)
    $("#tagihanSelesai").hide(300)
})
$("#tombolDua").click(function () {
    // $(this).css("background", "#3c8dbc");
    // $(this).css("color", "white");
    // $("#button-one").css("background", "#ecf0f5")
    // $("#button-one").css("color", "black")
    // $("#button-three").css("background", "#ecf0f5")
    // $("#button-three").css("color", "black")
    $("#tagihanSelesai").show(1000)
    $("#tagihanBelum").hide(300)
})
</script>
@endpush
