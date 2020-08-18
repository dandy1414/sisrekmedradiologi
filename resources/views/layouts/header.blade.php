<header class="main-header">
    <!-- Logo -->
    <a href="index3.html" class="logo" style="position: fixed;">
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
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="../dist/img/user2-160x160.jpg" class="img-circle"
                                                alt="User Image">
                                        </div>
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <!-- end message -->
                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
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
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{ route('logout') }}" onclick="event.preventDefault();
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