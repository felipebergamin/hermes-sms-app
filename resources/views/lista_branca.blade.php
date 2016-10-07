@extends('layout.default')

@section('imports')
    <script src="/js/modules/response_message_handler.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/controller/lista_branca.js"></script>
@endsection

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Configurações
                <small>Lista Branca</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content" ng-app="hermes_app" ng-controller="lista_branca_ctrl">

            <!-- row tiles -->
            <div class="row">

                <section class="col-lg-4">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Inserir</h3>
                        </div>
                        <form>
                            <div class="box-body">

                                <div class="form-group">
                                    <label>Tipo</label>
                                    <select class="form-control" ng-model="form.model.tipo" ng-change="form.model.valor = ''">
                                        <option value="">--- Selecione ---</option>
                                        <option ng-repeat="option in form.tipos" value="@{{ option }}">@{{ option }}</option>
                                    </select>
                                </div>

                                <br>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-info"></i></span>
                                    <input class="form-control" placeholder="Descrição..." type="text" name="descricao" maxlength="40" ng-model="form.model.descricao">
                                </div>

                                <br>

                                <div class="input-group" ng-if="form.model.tipo">
                                    <span class="input-group-addon"><i class="fa fa-star-o"></i></span>

                                    <input class="form-control" placeholder="CPF" type="text" name="cpf"
                                           ng-if="form.model.tipo === 'CPF'" ui-mask="999.999.999-99" ng-model="form.model.valor" ui-mask-placeholder>

                                    <input class="form-control" placeholder="CNPJ" type="text" name="cpf"
                                           ng-if="form.model.tipo === 'CNPJ'" ui-mask="99.999.999/9999-99" ng-model="form.model.valor" ui-mask-placeholder>

                                    <input class="form-control" placeholder="DDD + Número" type="text" name="cpf"
                                           ng-if="form.model.tipo === 'CELULAR'" ui-mask="(99) 9 9999-9999" ng-model="form.model.valor" ui-mask-placeholder>
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <div class="box-tools btn-group pull-right">
                                    <button type="button" class="btn btn-flat btn-sm btn-default" data-toggle="tooltip" title="Inserir CPF"
                                            ng-click="store()">
                                        <i class="fa fa-plus"></i>
                                        Inserir
                                    </button>
                                    <button type="reset" class="btn btn-flat btn-sm btn-default" data-toggle="tooltip" title="Limpar formulário">
                                        <i class="fa fa-eraser"></i>
                                        Limpar
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div><!-- /.box-->
                </section>

                <section class="col-lg-8 connectedSortable">

                    <div class="box" ng-if="registros.length === 0">
                        <div class="box-body">
                            <div class="callout">
                                <h4>
                                    <i class="fa fa-fw fa-info-circle"></i>
                                    Não há registros salvos na lista branca!
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="box" ng-if="registros.length > 0">
                        <div class="box-header">
                            <h3 class="box-title">Listagem</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Ação</th>
                                    <th>Tipo</th>
                                    <th>Valor</th>
                                    <th>Descrição</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr ng-repeat="reg in registros">
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Remover CPF" ng-click="delete(reg.id)">
                                                <i class="fa fa-remove"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>@{{ reg.tipo }}</td>
                                    <td>@{{ reg.valor }}</td>
                                    <td>@{{ reg.descricao }}</td>
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