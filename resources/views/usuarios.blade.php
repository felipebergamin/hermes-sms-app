@extends('layout.default')

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
            <div class="row">

                <section class="col-lg-4">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Add novo usuário...</h3>
                        </div>
                        <form id="form-usuarios">
                            <input type="hidden" name="ativo" value="true">

                            <div class="box-body">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input class="form-control" placeholder="Nome" type="text" name="name">
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-at"></i></span>
                                    <input class="form-control" placeholder="E-mail" type="email" name="email">
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input class="form-control" placeholder="Senha" type="password" name="password">
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input class="form-control" placeholder="Confirme a senha" type="password" name="confirm_password">
                                </div>

                                <br>

                                <h4>Permissões</h4>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label data-toggle="tooltip" title="O usuário pode enviar SMS's únicos?">
                                            <input type="checkbox" checked="yes" name="envia_sms">
                                            Enviar SMS
                                        </label>
                                    </div>

                                    <div class="checkbox">
                                        <label data-toggle="tooltip" title="O usuário pode enviar lotes de SMS?">
                                            <input type="checkbox" name="ver_logs">
                                            Enviar lote de Sms
                                        </label>
                                    </div>

                                    <div class="checkbox">
                                        <label data-toggle="tooltip" title="O usuário pode visualizar os SMS's já enviados?">
                                            <input type="checkbox" name="controle_usuarios">
                                            Visualizar SMS enviados
                                        </label>
                                    </div>

                                    <div class="checkbox">
                                        <label data-toggle="tooltip" title="O usuário pode cadastrar e alterar outros usuários?">
                                            <input type="checkbox" name="controle_usuarios">
                                            Manter usuários
                                        </label>
                                    </div>

                                    <div class="checkbox">
                                        <label data-toggle="tooltip" title="O usuário pode visualizar relatórios de uso do sistema?">
                                            <input type="checkbox" name="controle_usuarios">
                                            Visualizar relatórios
                                        </label>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-primary" data-toggle="tooltip" title="Inserir usuário">Inserir</button>
                                <button type="reset" class="btn btn-danger" data-toggle="tooltip" title="Limpar formulário">Limpar</button>
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

                                <tr id="id_usu">
                                    <td>
                                        <div class="btn-group">

                                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Desativar usuário"><i class="fa fa-remove"></i>
                                            </button>

                                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Ativar usuário"><i class="fa fa-check"></i>
                                            </button>

                                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Editar usuário"><i class="fa fa-pencil"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>id_usu</td>
                                    <td>nome_usu</td>
                                    <td>
                                        <span class="label label-danger">
                                            desativado
                                        </span>

                                        <span class="label label-success">
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