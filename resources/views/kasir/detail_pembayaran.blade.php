@extends('layouts.global')

@section('title')Pembayaran @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        Tagihan
        <small>#{{ $tagihan->nomor_tagihan }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('kasir.index-tagihan') }}"><i class="fa fa-money"></i> Tagihan</a></li>
        <li class="active">Detail Pembayaran</li>
    </ol>
</section>

<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <img src="{{ asset('storage/kop_surat/kop_surat.PNG') }}" alt="Kop Surat" class="responsive" height="100%" width="80%" style="margin-left:90px">
            <hr>
        </div>
        <!-- /.col -->
    </div>

    <h2 style="text-align: center">Tagihan</h2>
    <hr>
    <br>

    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-10 invoice-col">
            <strong> Nama Pasien</strong><br>
            {{ $tagihan->pasien->nama }} <br>
            <strong> No. Rekam Medis</strong><br>
            {{ $tagihan->pasien->no_rm }} <br>
            <strong> Alamat</strong><br>
            {{ $tagihan->pasien->alamat }} <br>
            <strong> No. telepon</strong><br>
            {{ $tagihan->pasien->nomor_telepon }} <br>
            <strong> Jenis Pasien</strong><br>
            {{ ($tagihan->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}
        </div>

        <!-- /.col -->
        <div class="col-sm-2 invoice-col">
            <strong>No. Tagihan</strong><br>
            {{ $tagihan->nomor_tagihan }}<br>
            <strong>Waktu Pembayaran</strong><br>
            {{ $tagihan->tanggal }} <br>
            <strong>Kasir</strong><br>
            {{ ucfirst($tagihan->kasir->nama) }}
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <hr>

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="300px">Layanan</th>
                        <th width="300px">Kategori</th>
                        <th>Jenis Pemeriksaan</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $tagihan->layanan->nama }}</td>
                        <td>{{ ucfirst($tagihan->layanan->kategori->nama) }}</td>
                        <td>{{ ucfirst($tagihan->pemeriksaan->jenis_pemeriksaan) }}</td>
                        <td>@currency($tarif)</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="977px">Film</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $tagihan->film->nama }}</td>
                        <td>@currency($tagihan->film->harga)</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-md-8">
            <p class="lead">Detail Total Harga</p>
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Harga Layanan:</th>
                            <td>@currency($tarif)</td>
                        </tr>
                        <tr>
                            <th>Biaya Pendaftaran:</th>
                            <td>@currency(25000)</td>
                        </tr>
                        <tr>
                            <th>Film:</th>
                            <td>@currency($tagihan->film->harga)</td>
                        </tr>
                        <tr>
                            <th>Total Harga:</th>
                            <td>@currency($tagihan->total_harga)</td>
                        </tr>
                    </table>
                </div>
            </div>


        </div>
        <!-- /.col -->
        <div class="col-md-4">
            <p class="lead">Keterangan Pembayaran</p>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Jenis Asuransi</th>
                            <td>{{ ucfirst($tagihan->pasien->jenis_asuransi) }}</td>
                        </tr>
                        @if ($tagihan->pasien->jenis_asuransi == 'bpjs')
                            <th>Nomor BPJS</th>
                            <td>{{ $tagihan->pasien->nomor_bpjs }}</td>
                        @endif
                        <tr>
                            <th style="width:50%">Metode Pembayaran:</th>
                            @if ($tagihan->metode_pembayaran == 'cash')
                            <td>Cash</td>
                            @elseif($tagihan->metode_pembayaran == 'kartu_kredit')
                            <td>Kartu Kredit</td>
                            @else
                            <td>Debit</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Bayar:</th>
                            <td>@currency($tagihan->bayar)</td>
                        </tr>
                        <tr>
                            <th>Kembalian:</th>
                            <td>@currency($tagihan->kembali)</td>
                        </tr>
                    </table>
                </div>
            </div>


        </div>
    </div>
    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">
            {{--  <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>  --}}
            <button type="button" class="btn btn-info pull-left" data-toggle="modal" data-target="#pembayaran"> Cetak PDF
            </button>
        </div>
    </div>

</section>

<div class="clearfix"></div>

@endsection

