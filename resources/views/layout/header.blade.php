    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="/home" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><i class="fa fa-send-o"></i></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
                <i class="fa fa-send-o"></i>
                <strong>Hermes</strong>
                <small>0.9.6
                    <small>Beta</small>
                </small>
            </span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">


                    @if(env('APP_TESTING', false))
                        <li>

                            <a href="#">
                                <i class="fa fa-warning"></i>
                                <!--
                                <span class="label label-danger">!</span>
                                -->
                            </a>

                        </li>
                    @endif

                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="/dist/img/logo_acetech.jpg" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="/dist/img/logo_acetech.jpg" class="img-circle" alt="User Image" />
                                <p>
                                    {{ \Illuminate\Support\Facades\Auth::user()->name }}
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">
                                        <i class="fa fa-sign-out"></i>
                                        Sair
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>