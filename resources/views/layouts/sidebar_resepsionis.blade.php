<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ url('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
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
        <li class="{{ (request()->is('resepsionis/pasien/index/pasien-umum')) ? 'active' : '' }}">
          <a href="{{ route('resepsionis.pasien.index-pasien-umum') }}">
            <i class="fa fa-users"></i> <span>Pasien Umum</span>
          </a>
        </li>
        <li class="{{ (request()->is('resepsionis/pasien/index/pasien-rs')) ? 'active' : '' }}">
          <a href="{{ route('resepsionis.pasien.index-pasien-rs') }}">
            <i class="fa fa-users"></i> <span>Pasien RS</span>
          </a>
        </li>
        <li class="{{ (request()->is('resepsionis/pendaftaran/index')) ? 'active' : '' }}">
            <a href="{{ route('resepsionis.pasien.index.pendaftaran') }}">
              <i class="fa fa-list"></i> <span>List Pendaftaran</span>
            </a>
          </li>
        <li>
          <a href="pages/Jadwal.html">
            <i class="fa fa-calendar-times-o"></i> <span>Jadwal</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
