@extends('layout.default')

@section('imports')
    <script src="/dist/angular/app.min.js"></script>
    <script src="/dist/angular/services/relatoriosAPI.min.js"></script>
    <script src="/dist/angular/controller/relatorios_ctrl.min.js"></script>
@endsection


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Relatórios
            </h1>
            <!--
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol>
            -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- row tiles -->
            <div class="row" ng-controller="relatorios_ctrl">

                <section class="col-lg-3">
                    <div class="box box-info">
                        <div class="box-header">
                            <h1 class="box-title">Gerar relatório deste período:</h1>
                        </div>

                        <form ng-submit="gerarRelatorio()">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="dataInicio">
                                        Data início
                                    </label>
                                    <input class="form-control" type="date" name="dataInicio"
                                           data-ng-model="form.dataInicio">

                                    <label for="dataFim">
                                        Data fim
                                    </label>
                                    <input class="form-control" type="date" name="dataFim" data-ng-model="form.dataFim">
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-flat btn-default">Atualizar</button>
                            </div>
                        </form>

                    </div><!-- /.box-->
                </section>

                <section class="col-lg-9 connectedSortable">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Relatório</h3>

                        </div><!-- /.box-header -->
                        <div class="box-body">

                            <dl class="dl-horizontal">

                                <dt>Total de SMS</dt>
                                <dd>Total de @{{ report.totalSms }} enviados</dd>

                                <dt>Usuário mais ativo</dt>
                                <dd>@{{ report.topUser.name }} é o usuário que mais enviou SMS's
                                    (@{{ report.topUser.sumSms }}).
                                </dd>

                                <dt>Lote SMS</dt>
                                <dd>
                                    @{{ report.totalLotes }} lote(s) totalizando @{{ report.totalSmsComLote }} SMS's
                                </dd>

                                <dt>SMS's avulsos</dt>
                                <dd>
                                    @{{ report.totalSmsAvulso }} SMS's avulsos enviados
                                </dd>

                                <dt>Total de SMS / usuário</dt>
                                <dd ng-repeat="u in report.sumSmsByUser">
                                    @{{ u.name }} enviou @{{ u.sumSms }} SMS's.
                                </dd>

                            </dl>

                        </div><!-- /.box-body -->

                        <!-- TODO: Acrescentar um botão "Ver relação dos destinatários"
                            Este botão fará uma listagem de quem recebeu SMS no período,
                            assim como quantos SMS foram enviados para este número.
                            A tabela deve ser ordenada pela quantidade de SMS enviados, em ordem decrescente.
                         -->
                        <div class="box-footer">
                            <button class="btn btn-primary">Ver relação de destinatários</button>
                        </div>
                    </div>
                </section>


            </div><!-- /.row -->

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection