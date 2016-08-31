@extends('layout.default')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php
                $h = date("H");

                if($h >= 0 && $h < 12)
                    echo "Bom dia";
                else
                    echo "Boa tarde";
                ?>
                <small>Inicio</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Your Page Content Here -->
            <div class="row">
                <section class="col-lg-3" style="cursor: pointer" data-toggle="tooltip" title="Clique para atualizar">

                    <div class="box box-success small-box bg-green">
                        <div class="inner">
                            <h3>53</h3>

                            <p>Créditos MobiPronto</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>

                        <!-- Efeito de carregameto -->
                        <div class="overlay" hidden>
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>

                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Últimos logins</h3>
                        </div>

                        <div class="box-body table-responsive no-padding">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Últimos logins</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>hehe</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section> <!-- left col -->

                <section class="col-lg-9 connectedSortable">
                    <div class="box box-info">

                        <div class="box-header">
                            <h3 class="box-title">Últimos SMS enviados</h3>
                            <div class="box-tools pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"
                                                                                            data-toggle="tooltip"
                                                                                            title="Atualizar"></i>
                                    </button>
                                </div>
                            </div>
                        </div><!-- /.box-header -->

                        <div class="box-body table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Enviado por</th>
                                    <th>Destinatário</th>
                                    <th>Mensagem</th>
                                </tr>
                                </thead>
                                <tbody>

                                @for($i = 0; $i < 20; $i++)
                                    <tr>
                                        <td>felipe</td>
                                        <td><a href="#">16999999999</a></td>
                                        <td>texto do sms {{$i}}</td>
                                    <tr>
                                @endfor

                                </tbody>
                            </table>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <div class="box-tools pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh" data-toggle="tooltip" title="Atualizar"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Efeito de carregameto -->
                        <div class="overlay" hidden>
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div><!-- /.box -->
                </section>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

@endsection