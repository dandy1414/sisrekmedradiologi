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
                <strong> Nama Pasien : </strong><br>
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
            <div class="col-xs-3">
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
            <a class="pull left btn btn-danger btn" href="{{ route('dokterRadiologi.pasien.pemeriksaan.print.hasil-expertise', ['id'=>$pemeriksaan->id]) }}" target="_blank"><i class="fa fa-print"></i> Export PDF</a>
            <br>
            <br>
                <form method="POST" action="{{ route('dokterRadiologi.pasien.upload.hasil-expertise', ['id'=>$pemeriksaan->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="hasil">Hasil Expertise :</label>
                        <input id="hasil" name="hasil" class="form-control" type="file" id="hasil" style="width: 50%">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            @endif

            @if (request()->is('dokter-radiologi/*/hasil-expertise'))
            <a class="pull left btn btn-danger btn" href="{{ route('dokterRadiologi.pasien.download.hasil-expertise', ['id'=>$pemeriksaan->id]) }}" target="_blank"><i class="fa fa-print"></i> Download Expertise</a>
            @endif

            @if (request()->is('radiografer/*/pemeriksaan/hasil-expertise') && $pemeriksaan->expertise_pdf_radiografer == null)
            <a class="pull left btn btn-danger btn" href="{{ route('radiografer.pasien.download.hasil-expertise', ['id'=>$pemeriksaan->id]) }}" target="_blank"><i class="fa fa-print"></i> Download Expertise</a>
            <br>
            <br>
                <form method="POST" action="{{ route('radiografer.pasien.upload.hasil-expertise', ['id'=>$pemeriksaan->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="hasil">Hasil Expertise :</label>
                        <input id="hasil" name="hasil" class="form-control" type="file" id="hasil" style="width: 50%">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            @endif

            @if (request()->is('dokter-poli/*/pemeriksaan/hasil-expertise') && $pemeriksaan->expertise_pdf_radiografer != null)
            <a class="pull left btn btn-danger btn" href="{{ route('dokterPoli.pasien.download.hasil-expertise', ['id'=>$pemeriksaan->id]) }}" target="_blank"><i class="fa fa-print"></i> Download Expertise</a>
            @endif

            @if (request()->is('admin/*/pasien/hasil-expertise') && $pemeriksaan->expertise_pdf_radiografer != null)
            <a class="pull left btn btn-danger btn" href="{{ route('pasien.download.hasil-expertise', ['id'=>$pemeriksaan->id]) }}" target="_blank"><i class="fa fa-print"></i> Download Expertise</a>
            @endif

        </div>
        <div class="row">
            <br>
            <br>
            <div class="pull-right">
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

    <script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>

    @if (Session::has('store_succeed'))
    <script>
    swal('Berhasil', '{!! Session::get('store_succeed') !!}', 'success',{
        button:'OK',
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
