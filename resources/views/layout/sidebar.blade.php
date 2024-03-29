    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{url('/dist/img/logo_acetech.jpg')}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ \Illuminate\Support\Facades\Auth::user()->name }}</p>
                    <a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> Sair</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header">Menu</li>
                <!-- Optionally, you can add icons to the links -->

                <li>
                    <a href="{{url('/')}}">
                        <i class="fa fa-home"></i>
                        <span>Início</span>
                    </a>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-send"></i>
                        <span>Enviar SMS</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{url('/enviarSms')}}">
                                <i class="fa fa-user"></i>
                                Unitário
                            </a>
                        </li>
                    </ul>
                    <ul class="treeview-menu">
                        <li id="li_configuracoes">
                            <a href="{{url('/enviarLote')}}">
                                <i class="fa fa-users"></i>
                                Em lote
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-archive"></i>
                        <span>Consultar</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{url('/consultarSms')}}">
                                <i class="fa fa-file-o"></i>
                                SMS enviados
                            </a>
                        </li>
                    </ul>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{url('/consultarLote')}}">
                                <i class="fa fa-files-o"></i>
                                Lotes enviados
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gears"></i>
                        <span>Configurações</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="li_configuracoes">
                            <a href="{{url('/usuarios')}}">
                                <i class="fa fa-users"></i>
                                    Usuários
                            </a>
                        </li>
                    </ul>
                    <ul class="treeview-menu">
                        <li id="li_configuracoes">
                            <a href="{{url('/listaBranca')}}">
                                <i class="fa fa-angellist"></i>
                                Lista branca
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{url('/relatorio')}}">
                        <i class="fa fa-info"></i>
                        <span>Relatórios</span>
                    </a>
                </li>

                <li>
                    <a href="{{'/sobre'}}">
                        <i class="fa fa-code-fork"></i>
                        <span>Sobre</span>
                    </a>
                </li>
            </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>