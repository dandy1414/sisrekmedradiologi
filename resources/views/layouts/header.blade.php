<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo" style="position: fixed;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>S</b><b>R</b><b>M</b><b>R</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>SISRMRadiologi</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-fixed-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                @if (Auth::user()->role == 'radiografer' || Auth::user()->role == 'dokterPoli' || Auth::user()->role == 'dokterRadiologi' || Auth::user()->role == 'kasir')
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-danger" id="total-location">
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header" id="text-notifications">Tidak ada notifikasi</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    @foreach (auth()->user()->unreadNotifications as $notification)
                                    @include('notifikasi.'.Str::replaceArray('\\', ['_','_'], $notification->type))
                                    @endforeach
                                </li>
                                <!-- end message -->
                            </ul>
                        </li>
                    </ul>
                </li>
                @endif

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if (Auth::user()->avatar == null)
                        <img src="{{ asset('adminlte/dist/img/avatar1.png') }}" class="user-image" alt="User Image">
                        @else
                        <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" class="user-image" alt="User Image">
                        @endif
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            @if (Auth::user()->avatar == null)
                            <img src="{{ asset('adminlte/dist/img/avatar1.png') }}" class="img-circle" alt="User Image">
                            @else
                            <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" class="img-circle" alt="User Image">
                            @endif
                            <p>
                                {{ Auth::user()->nama }}
                                @switch(Auth::user()->role)
                                @case('admin')
                                <small><strong>NIP&nbsp;:&nbsp;</strong>{{ Auth::user()->nip }}</small>
                                    @break
                                @case('resepsionis')
                                <small><strong>NIP&nbsp;:&nbsp;</strong>{{ Auth::user()->nip }}</small>
                                    @break
                                @case('dokterPoli')
                                <small><strong>SIP&nbsp;:&nbsp;</strong>{{ Auth::user()->sip }}</small>
                                    @break
                                @case('dokterRadiologi')
                                <small><strong>SIP&nbsp;:&nbsp;</strong>{{ Auth::user()->sip }}</small>
                                    @break
                                @case('radiografer')
                                <small><strong>NIP&nbsp;:&nbsp;</strong>{{ Auth::user()->nip }}</small>
                                    @break
                                @case('kasir')
                                <small><strong>NIP&nbsp;:&nbsp;</strong>{{ Auth::user()->nip }}</small>
                                    @break
                                @default
                            @endswitch
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                @if (Auth::user()->role == 'admin')
                                <a href="{{ route('profil.show', ['id' => Auth::user()->id]) }}" class="btn btn-primary btn-flat">Profil</a>
                                @endif
                                @if (Auth::user()->role == 'resepsionis')
                                <a href="{{ route('profil.show.resepsionis', ['id' => Auth::user()->id]) }}" class="btn btn-primary btn-flat">Profil</a>
                                @endif
                                @if (Auth::user()->role == 'radiografer')
                                <a href="{{ route('profil.show.radiografer', ['id' => Auth::user()->id]) }}" class="btn btn-primary btn-flat">Profil</a>
                                @endif
                                @if (Auth::user()->role == 'dokterPoli')
                                <a href="{{ route('profil.show.dokterPoli', ['id' => Auth::user()->id]) }}" class="btn btn-primary btn-flat">Profil</a>
                                @endif
                                @if (Auth::user()->role == 'dokterRadiologi')
                                <a href="{{ route('profil.show.dokterRadiologi', ['id' => Auth::user()->id]) }}" class="btn btn-primary btn-flat">Profil</a>
                                @endif
                                @if (Auth::user()->role == 'kasir')
                                <a href="{{ route('profil.show.kasir', ['id' => Auth::user()->id]) }}" class="btn btn-primary btn-flat">Profil</a>
                                @endif
                            </div>
                            <div class="pull-right">
                                <a href="{{  route('logout')  }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="btn btn-danger btn-flat">Log
                                    out</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
