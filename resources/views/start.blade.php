@extends('layout.default')

@section('imports')
    <script src="/js/controller/gwsms.js"></script>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" ng-app="hermes_app" ng-controller="gwsms" ng-init="getCredits()">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Início
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Your Page Content Here -->
            <div class="row">
                <section class="col-lg-3" style="cursor: pointer" data-toggle="tooltip" title="Clique para atualizar">

                    <div class="box box-success small-box bg-green" ng-click="getCredits()">
                        <div class="inner">
                            <h3 ng-bind="credits.total"></h3>

                            <p>Créditos MobiPronto</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>

                        <!-- Efeito de carregameto -->
                        <div class="overlay" ng-if="credits.loading">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </section> <!-- left col -->

                <section class="col-lg-9 connectedSortable">
                    <div class="box box-info">

                        <div class="box-header">
                            <h3 class="box-title">Haverá algo legal aqui em breve...</h3>
                        </div><!-- /.box-header -->

                        <div class="box-body table-responsive">

                        </div><!-- /.box-body -->

                        <div class="box-footer">

                        </div>

                    </div><!-- /.box -->
                </section>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

@endsection