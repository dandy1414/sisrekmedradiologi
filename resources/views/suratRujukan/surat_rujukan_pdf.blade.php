<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Surat Rujukan</title>
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

        <h3 style="text-align: center">Surat Rujukan Pemeriksaan</h3>

        <hr style="border: 1px solid black">

        <div class="row">
            <div class="col-xs-8">
                <strong> Nama Pasien : </strong><br>
                {{ ucfirst($pendaftaran->pasien->nama) }} <br>
                <strong> No. Rekam Medis :</strong><br>
                {{ str_pad($pendaftaran->pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }} <br>
                <strong> No. Rujukan :</strong><br>
                {{ $pendaftaran->nomor_pendaftaran }}<br>
                <strong> Jenis Kelamin / Umur :</strong><br>
                {{ ucfirst($pendaftaran->pasien->jenis_kelamin) }} / {{ $pendaftaran->pasien->umur }} tahun <br>
                <strong> Alamat :</strong><br>
                {{ ucfirst($pendaftaran->pasien->alamat) }} <br>
            </div>
            <div class="col-xs-4">
                <strong> Jenis Pasien :</strong><br>
                {{ ($pendaftaran->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }} <br>
                <strong>Dokter Perujuk :</strong><br>
                @if ($pendaftaran->id_dokterPoli != null)
                {{ ucfirst($pendaftaran->dokterPoli->nama) }} <br>
                @else
                <strong>-</strong><br>
                @endif
                <strong>Dokter Rujukan :</strong><br>
                {{ ucfirst($pendaftaran->dokterRadiologi->nama) }} <br>
                <strong>Waktu Rujukan :</strong><br>
                {{ $pendaftaran->created_at }} WIB <br>
                <strong>Asal Ruangan :</strong><br>
                {{ ($pendaftaran->pasien->jenis_pasien) != 'umum' ? ucfirst($pendaftaran->pasien->ruangan->nama_ruangan) : "-" }}
            </div>
        </div>

        <hr style="border: 1px solid black">

        <div class="row">
            <div class="col-xs-12">
                <strong>Informasi tambahan/permintaan foto &nbsp;:</strong>
                {{ ($pendaftaran->pemeriksaan->permintaan_tambahan) != null ? ucfirst($pendaftaran->pemeriksaan->permintaan_tambahan) : "Tidak ada" }}<br>
                <strong>Indikasi pemeriksaan/diagnosa klinis &nbsp;:</strong>
                {{ ($pendaftaran->keluhan) != null ? ucfirst($pendaftaran->keluhan) : "Tidak ada" }}<br>
            </div>
        </div>
        <hr style="border: 1px solid black">
        <h4 style="text-align: center">Pemeriksaan</h4>

        <div class="row">
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Layanan</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Jadwal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>{{ ucfirst($pendaftaran->layanan->nama) }}</th>
                            <td>{{ ucfirst($pendaftaran->layanan->kategori->nama) }}</td>
                            <td>{{ $pendaftaran->jadwal->waktu_mulai }} s/d {{ $pendaftaran->jadwal->waktu_selesai }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br>
        <br>

        <div class="row">
            <div style="margin-left: 400px">
                Tanggal cetak &nbsp;: {{ $pendaftaran->created_at }} WIB<br>
                @if ($pendaftaran->jenis_pemeriksaan == 'penuh' && $pendaftaran->pasien->jenis_pasien == 'rs')
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dokter Perujuk <br>
                <br><br>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ ($pendaftaran->id_dokterPoli != null ? ucfirst($pendaftaran->dokterPoli->nama) : "-") }}
                @endif
            </div>
        </div>
    </div>
</body>

</html>
