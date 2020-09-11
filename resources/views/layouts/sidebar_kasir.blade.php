<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                @if (Auth::user()->avatar == null)
                <img src="{{ asset('adminlte/dist/img/avatar1.png') }}" class="img-circle" alt="User Image">
                @else
                <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" class="img-circle" alt="User Image">
                @endif
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->nama }}</p>
                @switch(Auth::user()->role)
                @case('admin')
                <p>Admin</p>
                @break
                @case('resepsionis')
                <p>Resepsionis</p>
                @break
                @case('dokterPoli')
                <p>Dokter Poli</p>
                @break
                @case('dokterRadiologi')
                <p>Dokter Radiologi</p>
                @break
                @case('radiografer')
                <p>Radiografer</p>
                @break
                @case('kasir')
                <p>Kasir</p>
                @break
                @default
                @endswitch
            </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU</li>
            <li class="{{ (request()->is('kasir/index/tagihan')) ? 'active' : '' }}">
                <a href="{{ route('kasir.index-tagihan') }}">
                    <i class="fa fa-money"></i> <span>Tagihan</span>
                </a>
            </li>
            <li class="{{ (request()->is('kasir/pasien/index/pasien-umum')) ? 'active' : '' }}">
                <a href="{{ route('kasir.pasien.index-pasien-umum') }}">
                    <i class="fa fa-users"></i> <span>Pasien Umum</span>
                </a>
            </li>
            <li class="{{ (request()->is('kasir/pasien/index/pasien-rs')) ? 'active' : '' }}">
                <a href="{{ route('kasir.pasien.index-pasien-rs') }}">
                    <i class="fa fa-users"></i> <span>Pasien RS</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
