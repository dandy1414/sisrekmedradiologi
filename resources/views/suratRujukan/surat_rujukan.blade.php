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

        <h2 style="text-align: center">Surat Rujukan Pemeriksaan</h2>

        <hr>

        <div class="row">
            <div class="col-xs-9">
                <strong> Nama Pasien :</strong><br>
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
            <div class="col-xs-3">
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

        <hr>

        <div class="row">
            <div class="col-xs-12">
                <strong>Informasi tambahan/permintaan foto &nbsp;:</strong>
                {{ ($pendaftaran->pemeriksaan->permintaan_tambahan) != null ? ucfirst($pendaftaran->pemeriksaan->permintaan_tambahan) : "Tidak ada" }}<br>
                <strong>Indikasi pemeriksaan/diagnosa klinis &nbsp;&nbsp;:</strong>
                {{ ($pendaftaran->keluhan) != null ? ucfirst($pendaftaran->keluhan) : "Tidak ada" }}<br>
            </div>
        </div>

        <hr>

        <h3 style="text-align: center">Pemeriksaan</h3><br>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" width="500px">Layanan</th>
                            <th scope="col" width="500px">Kategori</th>
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
        <br>
        <div class="row">
            <div class="col-xs-9">
                @if (request()->is('resepsionis/*/pendaftaran/pasien*') && $pendaftaran->pasien->jenis_pasien == 'rs')
                <a class="btn btn-danger btn"
                    href="{{ route('resepsionis.pasien.pendaftaran.print.surat-rujukan', ['id'=>$pendaftaran->id]) }}"
                    target="_blank"><i class="fa fa-print"></i> Export PDF</a>
                <br>
                <form method="POST" action="{{ route('resepsionis.pasien.upload.surat-rujukan', ['id'=>$pendaftaran->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="suratRujukan">Surat Rujukan :</label>
                        <input id="suratRujukan" name="suratRujukan" class="form-control" type="file" id="suratRujukan" style="width: 50%">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
                @endif

                @if ($pendaftaran->jenis_pemeriksaan == 'penuh' && $pendaftaran->pasien->jenis_pasien == 'umum')
                <a class="btn btn-success btn" href="{{ route('resepsionis.pasien.index.pendaftaran') }}" style="margin-right: 5px">Kembali</a>
                <a class="btn btn-danger btn"
                    href="{{ route('resepsionis.pasien.pendaftaran.print.surat-rujukan', ['id'=>$pendaftaran->id]) }}"
                    target="_blank"><i class="fa fa-print"></i> Export PDF</a>
                @endif

                @if(request()->is('dokter-poli/*/rujuk-pasien'))
                <a class="btn btn-danger btn"
                    href="{{ route('dokterPoli.pasien.pendaftaran.print.surat-rujukan', ['id'=>$pendaftaran->id]) }}"
                    target="_blank"><i class="fa fa-print"></i> Export PDF</a>
                <br>
                <br>
                <form method="POST" action="{{ route('dokterPoli.pasien.upload.surat-rujukan', ['id'=>$pendaftaran->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="suratRujukan">Surat Rujukan :</label>
                        <input id="suratRujukan" name="suratRujukan" class="form-control" type="file" id="suratRujukan" style="width: 50%">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
                @endif


                @if (request()->is('resepsionis/*/pendaftaran/detail/surat-rujukan'))
                <a class="btn btn-danger btn"
                    href="{{ route('resepsionis.pasien.download.surat-rujukan', ['id'=>$pendaftaran->id]) }}"
                    target="_blank"><i class="fa fa-print"></i> Download Surat</a>
                @endif

                @if (request()->is('dokter-poli/*/rujuk/detail/surat-rujukan'))
                <a class="btn btn-danger btn"
                    href="{{ route('dokterPoli.pasien.download.surat-rujukan', ['id'=>$pendaftaran->id]) }}"
                    target="_blank"><i class="fa fa-print"></i> Download Surat</a>
                @endif

                @if (request()->is('dokter-radiologi/*/pemeriksaan/detail/surat-rujukan'))
                <a class="btn btn-danger btn"
                    href="{{ route('dokterRadiologi.pasien.download.surat-rujukan', ['id'=>$pendaftaran->id]) }}"
                    target="_blank"><i class="fa fa-print"></i> Download Surat</a>
                @endif

                @if (request()->is('radiografer/*/pemeriksaan/detail/surat-rujukan'))
                <a class="btn btn-danger btn"
                    href="{{ route('radiografer.pasien.download.surat-rujukan', ['id'=>$pendaftaran->id]) }}"
                    target="_blank"><i class="fa fa-print"></i> Download Surat</a>
                @endif

                @if (request()->is('admin/*/pasien/detail/surat-rujukan'))
                <a class="btn btn-danger btn"
                    href="{{ route('pasien.download.surat-rujukan', ['id'=>$pendaftaran->id]) }}" target="_blank"><i
                        class="fa fa-print"></i> Download Surat</a>
                @endif
            </div>
            <div class="col-xs-3">
                Tanggal cetak &nbsp;: {{ $pendaftaran->created_at }} WIB<br>
                @if ($pendaftaran->jenis_pemeriksaan == 'penuh' && $pendaftaran->pasien->jenis_pasien == 'rs')
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dokter
                Perujuk <br>
                <br><br>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ ($pendaftaran->id_dokterPoli != null ? ucfirst($pendaftaran->dokterPoli->nama) : "-") }}
                @endif
            </div>
        </div>
        <br>
    </div>

    <script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>

    @if (Session::has('store_succeed'))
    <script>
        swal('Berhasil', '{!! Session::get('store_succeed') !!}', 'success', {
            button: 'OK',
        });
    </script>
    @endif

    @if (Session::has('upload_failed'))
    <script>
    swal('Error', '{!! Session::get('upload_failed') !!}', 'error',{
        button:'OK',
    });
    </script>
    @endif
</body>
</html>
