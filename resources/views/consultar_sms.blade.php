@extends('layout.default')

@section('imports')
    <script src="/js/modules/response_message_handler.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/filters/startFrom.js"></script>
    <script src="/js/controller/visualizar_sms.js"></script>
@endsection


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Visualizar
                <small>SMS</small>
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
            <div class="row" ng-app="hermes_app" ng-controller="visualizar_sms">

                <section class="col-lg-3">
                    <div class="box box-info">
                        <div class="box-header">
                            <h1 class="box-title">Pesquisar...</h1>
                        </div>

                        <div class="box-body">
                            <form>
                                <div class="form-group">
                                    <label for="dataInicio">
                                        Data início
                                    </label>
                                    <input class="form-control" type="date" name="dataInicio" data-ng-model="search.startDate">

                                    <label for="dataFim">
                                        Data fim
                                    </label>
                                    <input class="form-control" type="date" name="dataFim" data-ng-model="search.endDate">
                                </div>
                            </form>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="button" class="btn btn-flat btn-default" ng-click="doSearch()">Atualizar</button>
                        </div>

                    </div><!-- /.box-->

                    <div class="box box-info">
                        <div class="box-header">
                            <h1 class="box-title">Filtros</h1>
                        </div>

                        <div class="box-body">
                            <form>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
                                    <input class="form-control" placeholder="Filtrar por qualquer coisa" type="text"
                                        ng-model="filters.$">
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
                                    <input class="form-control" placeholder="Filtrar por texto" type="text"
                                        ng-model="filters.texto">
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input class="form-control" placeholder="Filtrar por número do destinatário"
                                        ng-model="filters.numero_destinatario">
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input class="form-control" placeholder="Filtrar por descrição do SMS"
                                        ng-model="filters.descricao_destinatario">
                                </div>
                                <br>

                                <div class="form-group">
                                    <label>Registros por página</label>
                                    <select class="form-control" ng-model="pagination.page_length">
                                        <option value="5">5 registros</option>
                                        <option value="10">10 registros</option>
                                        <option value="15">15 registros</option>
                                        <option value="20" selected>20 registros</option>
                                    </select>
                                </div>
                            </form>
                        </div><!-- /.box-body -->

                    </div><!-- /.box-->
                </section>

                <section class="col-lg-9 connectedSortable">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Resultados da pesquisa</h3>

                            <div class="pull-right" ng-if="true">

                                Página @{{ pagination.current_page + 1 }} de @{{ pagination.totalPages() }}

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm" ng-click="pagination.previousPage()">
                                        <i class="fa fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm" ng-click="pagination.nextPage()">
                                        <i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>
                                <!-- /.btn-group -->
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Descrição</th>
                                        <th>Texto</th>
                                        <th>Remetente</th>
                                        <th>Data/Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="sms in lista_sms | startFrom:pagination.current_page*pagination.page_length | limitTo:pagination.page_length | filter:filters">
                                        <td>@{{ sms.numero_destinatario }}</td>
                                        <td>@{{ sms.descricao_destinatario }}</td>
                                        <td>@{{ sms.texto }}</td>
                                        <td>@{{ sms.user.name }}</td>
                                        <td>@{{ sms.created_at*1000 | date:'dd/MM/yyyy - HH:mm' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div>
                </section>


            </div><!-- /.row -->

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection