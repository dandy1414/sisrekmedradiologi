<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hasil Expertise Radiologi</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css') }}">

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
    @include('sweet::alert')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img src="{{ asset('storage/kop_surat/kop_surat.PNG') }}" alt="Kop Surat" class="responsive"
                    height="100%" width="80%" style="margin-left:90px">
            </div>
        </div>

        <hr>

        <h2 style="text-align: center">Hasil Expertise Radiologi</h2>

        <hr>

        <div class="row">
            <div class="col-xs-9">
                <strong> Nama Pasien</strong><br>
                {{ ucfirst($pemeriksaan->pasien->nama) }} <br>
                <strong> No. Rekam Medis</strong><br>
                {{ $pemeriksaan->pasien->no_rm }} <br>
                <strong> No. Pemeriksaan</strong><br>
                {{ $pemeriksaan->nomor_pemeriksaan }} <br>
                <strong> Jenis Kelamin / Umur</strong><br>
                {{ ucfirst($pemeriksaan->pasien->jenis_kelamin) }} / {{ $pemeriksaan->pasien->umur }} tahun <br>
                <strong> Alamat</strong><br>
                {{ ucfirst($pemeriksaan->pasien->alamat) }} <br>
            </div>
            <div class="col-xs-3">
                <strong> Jenis Pasien</strong><br>
                {{ ($pemeriksaan->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }} <br>
                <strong>Dokter Perujuk</strong><br>
                @if ($pemeriksaan->id_dokterPoli != null)
                {{ ucfirst($pemeriksaan->dokterPoli->nama) }} <br>
                @else
                <strong>-</strong><br>
                @endif
                <strong>Radiografer</strong> <br>
                {{ ucfirst($pemeriksaan->radiografer->nama) }} <br>
                <strong>Waktu Pemeriksaan</strong><br>
                {{ \Carbon\Carbon::parse($pemeriksaan->waktu_kirim)->format('d, F Y H:i') }} WIB <br>
                <strong>Asal Ruangan</strong><br>
                {{ ($pemeriksaan->pasien->jenis_pasien) != 'umum' ? ucfirst($pemeriksaan->pasien->ruangan->nama_ruangan) : "-" }}
                {{-- <strong>Poli</strong><br>
                {{ ($pemeriksaan->pasien->jenis_pasien) != 'umum' ? ucfirst($pemeriksaan->pasien->ruangan->nama_ruangan) : "-" }}
                --}}
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-xs-12">
                <strong>Kategori/layanan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong>
                {{ ucfirst($pemeriksaan->layanan->kategori->nama) }} / {{ ucfirst($pemeriksaan->layanan->nama) }}<br>
                <strong>Informasi tambahan/permintaan foto &nbsp;:</strong>
                {{ ($pemeriksaan->permintaan_tambahan) != null ? ucfirst($pemeriksaan->permintaan_tambahan) : "Tidak ada" }}<br>
                <strong>Indikasi pemeriksaan/diagnosa klinis &nbsp;&nbsp;:</strong>
                {{ ($pemeriksaan->keluhan) != null ? ucfirst($pemeriksaan->keluhan) : "Tidak ada" }}<br>
            </div>
        </div>

        <hr>

        <h3 style="text-align: center">Expertise</h3><br>

        <div class="row">
            <div class="col-xs-12">
                 <?php echo $pemeriksaan->expertise ?>
            </div>
        </div>
        <br>
        <br>
        <br>
        <div class="row">
            @if (request()->is('dokter-radiologi/*/expertise-pasien'))
            <a class="pull left btn btn-default btn" href="{{ route('dokterRadiologi.pasien.index-pemeriksaan') }}"><i class="fa fa-chevron-left"></i> Kembali</a>
            <a class="pull left btn btn-danger btn" href="{{ route('dokterRadiologi.pasien.pemeriksaan.print.hasil-expertise', ['id'=>$pemeriksaan->id]) }}" target="_blank"><i class="fa fa-print"></i> Export PDF</a>
            @else
            @endif

            @if (request()->is('dokter-radiologi/*/hasil-expertise'))
            <a class="pull left btn btn-danger btn" href="{{ route('dokterRadiologi.pasien.pemeriksaan.print.hasil-expertise', ['id'=>$pemeriksaan->id]) }}" target="_blank"><i class="fa fa-print"></i> Export PDF</a>
            @endif

            @if (request()->is('radiografer/*/pemeriksaan/hasil-expertise'))
            <a class="pull left btn btn-danger btn" href="{{ route('radiografer.pasien.pemeriksaan.print.hasil-expertise', ['id'=>$pemeriksaan->id]) }}" target="_blank"><i class="fa fa-print"></i> Export PDF</a>
            @endif

            @if (request()->is('dokter-poli/*/pemeriksaan/hasil-expertise'))
            <a class="pull left btn btn-danger btn" href="{{ route('dokterPoli.pasien.pemeriksaan.print.hasil-expertise', ['id'=>$pemeriksaan->id]) }}" target="_blank"><i class="fa fa-print"></i> Export PDF</a>
            @endif

            @if (request()->is('admin/*/pasien/hasil-expertise'))
            <a class="pull left btn btn-danger btn" href="{{ route('pasien.pemeriksaan.print.hasil-expertise', ['id'=>$pemeriksaan->id]) }}" target="_blank"><i class="fa fa-print"></i> Export PDF</a>
            @endif

        </div>
        <div class="row">
            <div class="col-xs-9">
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Petugas Radiografer <br><br><br>

                {{ ($pemeriksaan->id_radiografer != null ? ucfirst($pemeriksaan->radiografer->nama) : "-") }}
            </div>
            <div class="col-xs-3">
                Tanggal cetak &nbsp;: {{ \Carbon\Carbon::parse($pemeriksaan->waktu_selesai)->format('d, F Y H:i') }} WIB<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Salam sejawat <br>
                <br><br>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ ($pemeriksaan->id_dokterRadiologi != null ? ucfirst($pemeriksaan->dokterRadiologi->nama) : "-") }}
            </div>
        </div>
        <br>
        <br>
        <br>
    </div>

@if (Session::has('store_succeed'))
<script>
swal('Berhasil', '{!! Session::get('store_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif
</body>
</html>
