@extends('layouts.global')

@section('title')Pembayaran @endsection

@section('csrf')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        Tagihan
        <small>#{{ $tagihan->nomor_tagihan }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('kasir.index-tagihan') }}"><i class="fa fa-money"></i> Tagihan</a></li>
        <li class="active">Pembayaran</li>
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
        <div class="col-sm-8 invoice-col">
            <strong> Nama Pasien</strong><br>
            {{ $tagihan->pasien->nama }} <br>
            <strong> No. Rekam Medis</strong><br>
            {{ str_pad($tagihan->pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }} <br>
            <strong> Alamat</strong><br>
            {{ $tagihan->pasien->alamat }} <br>
            <strong> No. telepon</strong><br>
            {{ $tagihan->pasien->nomor_telepon }} <br>
            <strong> Jenis Pasien</strong><br>
            {{ ($tagihan->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}
        </div>

        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <strong>No. Tagihan</strong><br>
            {{ $tagihan->nomor_tagihan }}<br>
            <strong>Tanggal</strong><br>
            {{ date('Y-m-d') }} <br>
            <strong>Kasir</strong><br>
            {{ Auth::user()->nama }}
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
        <div class="col-md-6">
            <p class="lead">Detail Total Harga</p>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Harga Layanan:</th>
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
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">
            {{--  <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>  --}}
            <button type="button" class="btn btn-success pull-left" data-toggle="modal" data-target="#pembayaran"> Bayar
            </button>
        </div>
    </div>

    <div class="modal fade" id="pembayaran">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form method="POST" action="{{ route('kasir.pasien.store.pembayaran-pasien', ['id'=>$tagihan->id]) }}">
                    @csrf
                    {{ method_field('PUT') }}

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="text-align: center">Pembayaran</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Metode Pembayaran :</label>
                                    <select class="form-control select2" name="metode" style="width: 100%;" required>
                                        <option selected disabled>Silahkan pilih salah satu</option>
                                        <option value="cash">Cash</option>
                                        <option value="kartu_kredit">Kartu Kredit</option>
                                        <option value="debit">Debit</option>
                                    </select>
                                    <br>

                                    <label>Bayar :</label>
                                    <input id="bayar" type="text" name="bayar" class="form-control" placeholder="Bayar ..." required>
                                    <br>

                                    <label>Kembalian :</label>
                                    <input type="text" id="kembalian" class="form-control" placeholder="Kembalian" readonly="">
                                    {{-- <p class="text-muted"></p> --}}
                                    <br>

                                    <input id="tarif" type="hidden" display="none" value="{{ $tagihan->total_harga }}">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left"
                                data-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-success">Bayar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </form>
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>

</section>

<div class="clearfix"></div>

@endsection
@push('scripts')
<script>
$(document).ready(function() {
    $("#tarif, #bayar").keyup(function(){
        var bayar = $('#bayar').val();
        var tarif = $('#tarif').val();
        var kembalian = parseInt(bayar) - parseInt(tarif);

        var	number_string = kembalian.toString(),
	    sisa 	= number_string.length % 3,
	    rupiah 	= number_string.substr(0, sisa),
	    ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        var rp = 'Rp, ';
        var gabung = rp.concat(rupiah);
        if(bayar > 0 && kembalian > 0){
            $("#kembalian").val(gabung);
        } else {
            var kembalian = 0;
            var gabung_kosong = rp.concat(kembalian);
            $("#kembalian").val(gabung_kosong);
        }
    });
});
</script>

@if (Session::has('store_failed'))
<script>
swal('Gagal', '{!! Session::get('store_failed') !!}', 'error',{
    button:'OK',
});
</script>
@endif
@endpush
