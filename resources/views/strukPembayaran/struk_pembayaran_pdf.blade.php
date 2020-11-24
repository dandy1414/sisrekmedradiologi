<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Struk Pembayaran</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    {{-- <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css') }}"> --}}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body>
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h3 style="text-align: center">PT. Patroman Medical Center</h3>
                <h1 style="text-align: center">RSU Banjar Patroman</h1>
            </div>
            <!-- /.col -->
        </div>

        <hr style="border: 1px solid black">

        <h3 style="text-align: center">Struk Pembayaran</h3>

        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-xs-8 invoice-col">
                <strong> Nama Pasien</strong><br>
                {{ $tagihan->pasien->nama }} <br>
                <strong> No. Rekam Medis</strong><br>
                {{ str_pad($tagihan->pasien->no_rm, 6, '0', STR_PAD_LEFT) }} <br>
                <strong> Alamat</strong><br>
                {{ $tagihan->pasien->alamat }} <br>
                <strong> No. telepon</strong><br>
                {{ $tagihan->pasien->nomor_telepon }} <br>
                <strong> Jenis Pasien</strong><br>
                {{ ($tagihan->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}
            </div>

            <!-- /.col -->
            <div class="col-xs-4 invoice-col">
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

        <hr style="border: 1px solid black">

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th>Kategori</th>
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
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="535px">Film</th>
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
            <div class="col-xs-8">
                <p class="lead">Detail Total Harga</p>
                <strong>Harga Layanan:</strong><br>
                @currency($tarif) <br>
                <strong>Biaya Pendaftaran:</strong><br>
                @currency(25000) <br>
                <strong>Film:</strong><br>
                @currency($tagihan->film->harga) <br>
                <strong>Total Harga:</strong><br>
                @currency($tagihan->total_harga)
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <p class="lead">Keterangan Pembayaran</p>
                <strong>Jenis Asuransi:</strong><br>
                {{ ucfirst($tagihan->pasien->jenis_asuransi) }} <br>
                @if ($tagihan->pasien->jenis_asuransi != 'bpjs')

                @else
                <strong>Nomor BPJS:</strong><br>
                {{ $tagihan->pasien->nomor_bpjs }} <br>
                @endif
                <strong>Metode Pembayaran:</strong><br>
                @if ($tagihan->metode_pembayaran == 'cash')
                Cash <br>
                @elseif($tagihan->metode_pembayaran == 'kartu_kredit')
                Kartu Kredit <br>
                @else
                Debit <br>
                @endif
                <strong>Bayar:</strong><br>
                @currency($tagihan->bayar) <br>
                <strong>Kembali:</strong><br>
                @currency($tagihan->kembali) <br>
                <strong>Status Pembayaran:</strong><br>
                LUNAS <br>
            </div>
        </div>
        <!-- /.row -->
    </section>
</body>

</html>
