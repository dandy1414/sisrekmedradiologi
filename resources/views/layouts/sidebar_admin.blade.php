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
            {{-- <li class="{{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li> --}}
            <li class="{{ (request()->is('admin/user/*')) ? 'active' : '' }} treeview">
                <a href="#">
                  <i class="fa fa-users"></i> <span>User</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ (request()->is('admin/user/index/dokter')) ? 'active' : '' }}"><a href="{{ route('dokter.index') }}"><i class="fa fa-user-md"></i> Dokter</a></li>
                  <li class="{{ (request()->is('admin/user/index/pegawai')) ? 'active' : '' }}"><a href="{{ route('pegawai.index') }}"><i class="fa fa-users"></i> Pegawai</a></li>
                </ul>
              </li>
            <li class="{{ (request()->is('admin/pelayanan/*')) ? 'active' : '' }}">
                <a href="{{ route('pelayanan.index') }}">
                    <i class="fa fa-list-ul"></i> <span>Pelayanan</span>
                </a>
            </li>
            <li>
            <li class="{{ (request()->is('admin/pasien/index/pasien-umum')) ? 'active' : '' }}">
                <a href="{{ route('pasien.index-pasien-umum') }}">
                    <i class="fa fa-users"></i> <span>Pasien Umum</span>
                </a>
            </li>
            <li class="{{ (request()->is('admin/pasien/index/pasien-rs')) ? 'active' : '' }}">
                <a href="{{ route('pasien.index-pasien-rs') }}">
                    <i class="fa fa-users"></i> <span>Pasien RS</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
