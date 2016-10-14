@extends('layout.default')

@section('imports')
    <script src="/dist/angular/services/notify.min.js"></script>
    <script src="/dist/angular/services/usersAPI.min.js"></script>
    <script src="/dist/angular/controller/users_ctrl.min.js"></script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Configurações
                <small>Usuários</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- row tiles -->
            <div class="row" ng-controller="users_ctrl" ng-init="init()">

                <section class="col-lg-4">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title" data-ng-if="form.function == 'create'">Add novo usuário...</h3>
                            <h3 class="box-title" data-ng-if="form.function == 'update'">Alterar usuário...</h3>
                        </div>
                        <form ng-submit="formSubmit()">
                            <input type="hidden" value="1" ng-model="form.user.habilitado">

                            <div class="box-body">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input class="form-control" placeholder="Nome" type="text" ng-model="form.user.name">
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-at"></i></span>
                                    <input class="form-control" placeholder="E-mail" type="email" ng-model="form.user.email">
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input class="form-control" placeholder="Senha" type="password" ng-model="form.user.password">
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input class="form-control" placeholder="Confirme a senha" type="password" ng-model="form.user.password_confirmation">
                                </div>

                                <br>

                                <!--
                                //                             _
                                //   _ __   ___ _ __ _ __ ___ (_)___ ___  ___   ___ ___
                                //  | '_ \ / _ \ '__| '_ ` _ \| / __/ __|/ _ \ / _ \ __|
                                //  | |_) |  __/ |  | | | | | | \__ \__ \ (_) |  __\__ \
                                //  | .__/ \___|_|  |_| |_| |_|_|___/___/\___/ \___|___/
                                //  |_|
                                -->
                                <h4>Permissões</h4>
                                <!-- ['enviar_sms', 'visualizar_envios', 'visualizar_relatorios', 'manter_usuarios', 'enviar_lote_sms'] -->

                                <div class="form-group">

                                    <div class="checkbox">
                                        <label data-toggle="tooltip" title="O usuário pode enviar SMS's únicos?">
                                            <input type="checkbox" checked="yes" ng-model="form.user.permissoes.enviar_sms">
                                            Enviar SMS
                                        </label>
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" ng-model="form.user.permissoes.enviar_lote_sms"
                                                   data-toggle="tooltip" title="O usuário pode enviar lotes de SMS">
                                            Enviar lote de SMS
                                        </label>
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" ng-model="form.user.permissoes.visualizar_envios"
                                                   data-toggle="tooltip" title="O usuário pode visualizar SMS enviados anteriormente?">
                                            Visualizar registro de envios
                                        </label>
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" ng-model="form.user.permissoes.visualizar_relatorios"
                                                   data-toggle="tooltip" title="O usuário pode visualizar os relatórios do sistema?">
                                            Visualizar relatórios
                                        </label>
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" ng-model="form.user.permissoes.manter_usuarios"
                                                   data-toggle="tooltip" title="O usuário pode cadastrar e alterar outros usuários?">
                                            Manter usuários
                                        </label>
                                    </div>

                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">
                                    @{{ form.function == 'create' ? 'Adicionar' : 'Atualizar' }}
                                </button>
                                <button type="reset" class="btn btn-danger" ng-click="form.reset()">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div><!-- /.box-->
                </section>

                <section class="col-lg-8 connectedSortable">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Usuários cadastrados</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Ação</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr ng-repeat="user in users">
                                    <td>
                                        <div class="btn-group">

                                            <button type="button" ng-if="user.habilitado" data-ng-click="disableUser(user)"
                                                    class="btn btn-default btn-sm" data-toggle="tooltip" title="Desativar usuário">
                                                <i class="fa fa-remove"></i>
                                            </button>

                                            <button type="button" ng-if="! user.habilitado" data-ng-click="enableUser(user)"
                                                    class="btn btn-default btn-sm" data-toggle="tooltip" title="Ativar usuário">
                                                <i class="fa fa-check"></i>
                                            </button>

                                            <button type="button" class="btn btn-default btn-sm" ng-click="editUser(user, $index)"
                                                    data-toggle="tooltip" title="Editar usuário"><i class="fa fa-pencil"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>@{{ user.name }}</td>
                                    <td>@{{ user.email }}</td>
                                    <td>
                                        <span ng-if="! user.habilitado" class="label label-danger" data-toggle="tooltip" title="Usuário desativado no sistema">
                                            desativado
                                        </span>

                                        <span ng-if="user.habilitado" class="label label-success" data-toggle="tooltip" title="Usuário ativado no sistema">
                                            ativado
                                        </span>
                                    </td>
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