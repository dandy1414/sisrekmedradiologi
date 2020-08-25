@extends('layouts.global')

@section('title') Dashboard @endsection

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

            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h4>
                    <i class="icon fa fa-check"></i>
                    Gagal
                </h4>
                {{ $message }}
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-xs-6" style="margin-left: 80px">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>150</h3>

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
                    <h3>20</h3>

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
                    <h3>65</h3>

                    <p>Kunjungan pasien tahun ini</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
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
                    <div class="chart">
                        <!-- Sales Chart Canvas -->
                        <canvas id="kunjunganPasien" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        10 Besar Layanan
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="col-md-8">
                        <div class="chart-responsive">
                            <canvas id="grafikLayanan" height="150"></canvas>
                        </div>
                        <!-- ./chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <ul class="chart-legend clearfix">
                            <li><i class="fa fa-circle-o text-red"></i> Thorax</li>
                            <li><i class="fa fa-circle-o text-green"></i> IE</li>
                            <li><i class="fa fa-circle-o text-yellow"></i> FireFox</li>
                            <li><i class="fa fa-circle-o text-aqua"></i> Safari</li>
                            <li><i class="fa fa-circle-o text-light-blue"></i> Opera</li>
                            <li><i class="fa fa-circle-o text-gray"></i> Navigator</li>
                        </ul>
                    </div>
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
<script src="{{ asset('adminlte/dist/js/pages/grafik.js') }}"></script>
<!-- page script -->
@endpush
