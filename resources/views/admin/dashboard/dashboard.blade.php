@extends('layouts.global')

@section('title') Dashboard @endsection

@section('csrf')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        Dashboard
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-3 col-xs-6" style="margin-left: 80px">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $total_today }}</h3></h3>

                    <p> Kunjungan pasien hari ini</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6" style="margin-left: 80px">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $total_this_month }}</h3>

                    <p>Kunjungan pasien bulan ini</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
            </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-3 col-xs-6" style="margin-left: 80px">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $total_this_year }}</h3>

                    <p>Kunjungan pasien tahun ini</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Grafik Kunjungan Pasien
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form class="form-horizontal">
                                <div class="box-body">
                                  <div class="form-group">
                                    <label for="input-year" class="col-sm-4 control-label">Tahun : </label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="tahun" id="tahun-kunjungan" style="width: 50%">
                                            <option selected disabled>Pilih tahun</option>
                                            @foreach ($year_used_kunjungan as $y)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <form class="form-horizontal">
                                <div class="box-body">
                                  <div class="form-group">
                                    <label for="input-year" class="col-sm-4 control-label">Bulan : </label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="bulan" id="bulan-kunjungan" style="width: 50%">
                                            <option selected disabled>Pilih bulan</option>
                                            <option value="all">Semua</option>
                                            @foreach ($bulan as $bul)
                                            <option value="{{ $bul->value }}">{{ $bul->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="chart">
                        <!-- Sales Chart Canvas -->
                        <canvas id="kunjunganPasien" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Grafik Layanan Terbanyak
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form class="form-horizontal">
                                <div class="box-body">
                                  <div class="form-group">
                                    <label for="input-year" class="col-sm-4 control-label">Tahun : </label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="tahun" id="tahun-layanan" style="width: 50%">
                                            <option selected disabled>Pilih tahun</option>
                                            @foreach ($year_used_layanan as $y)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <form class="form-horizontal">
                                <div class="box-body">
                                  <div class="form-group">
                                    <label for="input-year" class="col-sm-4 control-label">Bulan : </label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="bulan" id="bulan-layanan" style="width: 50%">
                                            <option selected disabled>Pilih bulan</option>
                                            <option value="all">Semua</option>
                                            @foreach ($bulan as $bul)
                                            <option value="{{ $bul->value }}">{{ $bul->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="chart">
                        <!-- Sales Chart Canvas -->
                        <canvas id="layanan" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Grafik Pendapatan
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form class="form-horizontal">
                                <div class="box-body">
                                  <div class="form-group">
                                    <label for="input-year" class="col-sm-4 control-label">Tahun : </label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="tahun" id="tahun-pendapatan" style="width: 50%">
                                            <option selected disabled>Pilih tahun</option>
                                            @foreach ($year_used_tagihan as $y)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <form class="form-horizontal">
                                <div class="box-body">
                                  <div class="form-group">
                                    <label for="input-year" class="col-sm-4 control-label">Bulan : </label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="bulan" id="bulan-pendapatan" style="width: 50%">
                                            <option selected disabled>Pilih bulan</option>
                                            <option value="all">Semua</option>
                                            @foreach ($bulan as $bul)
                                            <option value="{{ $bul->value }}">{{ $bul->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="chart">
                        <!-- Sales Chart Canvas -->
                        <canvas id="pendapatan" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Grafik Penggunaan Asuransi Terbanyak
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form class="form-horizontal">
                                <div class="box-body">
                                  <div class="form-group">
                                    <label for="input-year" class="col-sm-4 control-label">Tahun : </label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="tahun" id="tahun-asuransi" style="width: 50%">
                                            <option selected disabled>Pilih tahun</option>
                                            @foreach ($year_used_pasien as $y)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <form class="form-horizontal">
                                <div class="box-body">
                                  <div class="form-group">
                                    <label for="input-year" class="col-sm-4 control-label">Bulan : </label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="bulan" id="bulan-asuransi" style="width: 50%">
                                            <option selected disabled>Pilih bulan</option>
                                            <option value="all">Semua</option>
                                            @foreach ($bulan as $bul)
                                            <option value="{{ $bul->value }}">{{ $bul->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="chart">
                        <!-- Sales Chart Canvas -->
                        <canvas id="asuransi" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Grafik Durasi Pemeriksaan Tercepat
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form class="form-horizontal">
                                <div class="box-body">
                                  <div class="form-group">
                                    <label for="input-year" class="col-sm-4 control-label">Tahun : </label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="tahun" id="tahun-durasi" style="width: 50%">
                                            <option selected disabled>Pilih tahun</option>
                                            @foreach ($year_used_durasi as $y)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <form class="form-horizontal">
                                <div class="box-body">
                                  <div class="form-group">
                                    <label for="input-year" class="col-sm-4 control-label">Bulan : </label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="bulan" id="bulan-durasi" style="width: 50%">
                                            <option selected disabled>Pilih bulan</option>
                                            <option value="all">Semua</option>
                                            @foreach ($bulan as $bul)
                                            <option value="{{ $bul->value }}">{{ $bul->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="chart">
                        <!-- Sales Chart Canvas -->
                        <canvas id="durasi" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
@push('scripts')
<!--chartJS-->
<script src="{{ asset('adminlte/bower_components/chart.js/Chart.js') }}"></script>
<!--Dashboard-->
<script src="{{ asset('adminlte/dist/js/pages/grafik_kunjungan_pasien.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/pages/grafik_layanan.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/pages/grafik_pendapatan.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/pages/grafik_jenis_asuransi.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/pages/grafik_durasi.js') }}"></script>
<!-- page script -->

@if (Session::has('login_succeed'))
<script>
    swal('Login Berhasil', '{!! Session::get('login_succeed') !!}', 'success', {
            button: 'OK',
        });
</script>
@endif
@endpush
