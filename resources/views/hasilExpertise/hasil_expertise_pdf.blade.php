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
    {{-- <link rel="stylesheet" href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}"> --}}
    <!-- Theme style -->
    {{-- <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css') }}"> --}}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    {{-- <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> --}}
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3 style="text-align: center">PT. Patroman Medical Center</h3>
                <h1 style="text-align: center">RSU Banjar Patroman</h1>
            </div>
        </div>

        <hr style="border: 1px solid black">

        <h3 style="text-align: center">Hasil Expertise Radiologi</h3>

        <hr style="border: 1px solid black">

        <div class="row">
            <div class="col-xs-8">
                <strong> Nama Pasien :</strong><br>
                {{ ucfirst($pemeriksaan->pasien->nama) }} <br>
                <strong> No. Rekam Medis :</strong><br>
                {{ str_pad($pemeriksaan->pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }} <br>
                <strong> No. Pemeriksaan :</strong><br>
                {{ $pemeriksaan->nomor_pemeriksaan }} <br>
                <strong> Jenis Kelamin / Umur :</strong><br>
                {{ ucfirst($pemeriksaan->pasien->jenis_kelamin) }} / {{ $pemeriksaan->pasien->umur }} tahun <br>
                <strong> Alamat :</strong><br>
                {{ ucfirst($pemeriksaan->pasien->alamat) }} <br>
            </div>
            <div class="col-xs-4">
                <strong> Jenis Pasien :</strong><br>
                {{ ($pemeriksaan->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }} <br>
                <strong>Dokter Perujuk :</strong><br>
                @if ($pemeriksaan->id_dokterPoli != null)
                {{ ucfirst($pemeriksaan->dokterPoli->nama) }} <br>
                @else
                <strong>-</strong><br>
                @endif
                <strong>Radiografer :</strong> <br>
                {{ ucfirst($pemeriksaan->radiografer->nama) }} <br>
                <strong>Waktu Pemeriksaan :</strong><br>
                {{ \Carbon\Carbon::parse($pemeriksaan->waktu_kirim)->format('d, F Y H:i') }} WIB <br>
                <strong>Asal Ruangan :</strong><br>
                {{ ($pemeriksaan->pasien->jenis_pasien) != 'umum' ? ucfirst($pemeriksaan->pasien->ruangan->nama_ruangan) : "-" }}
                {{-- <strong>Poli</strong><br>
                {{ ($pemeriksaan->pasien->jenis_pasien) != 'umum' ? ucfirst($pemeriksaan->pasien->ruangan->nama_ruangan) : "-" }}
                --}}
            </div>
        </div>

        <hr style="border: 1px solid black">

        <div class="row">
            <div class="col-xs-12">
                <strong>Kategori/layanan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong>
                {{ ucfirst($pemeriksaan->layanan->kategori->nama) }} / {{ ucfirst($pemeriksaan->layanan->nama) }}<br>
                <strong>Informasi tambahan/permintaan foto &nbsp;&nbsp;&nbsp;:</strong>
                {{ ($pemeriksaan->permintaan_tambahan) != null ? ucfirst($pemeriksaan->permintaan_tambahan) : "Tidak ada" }}<br>
                <strong>Indikasi pemeriksaan/diagnosa klinis &nbsp;&nbsp;:</strong>
                {{ ($pemeriksaan->keluhan) != null ? ucfirst($pemeriksaan->keluhan) : "Tidak ada" }}<br>
            </div>
        </div>
        <hr style="border: 1px solid black">
        <h4 style="text-align: center">Expertise</h4>

        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-12">
                    <?php echo $pemeriksaan->expertise ?>
               </div>
            </div>
        </div>

        <br>
        <br>
        <br>

        <div class="row">
            <div class="pull-right" style="margin-right: 40px">
                Tanggal cetak : {{ \Carbon\Carbon::parse($pemeriksaan->waktu_selesai)->format('d, F Y H:i') }} WIB<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Salam sejawat <br>
                <br><br>

                &nbsp;&nbsp;&nbsp;&nbsp;{{ ($pemeriksaan->id_dokterRadiologi != null ? ucfirst($pemeriksaan->dokterRadiologi->nama) : "-") }}
            </div>
        </div>
    </div>
</body>

</html>
