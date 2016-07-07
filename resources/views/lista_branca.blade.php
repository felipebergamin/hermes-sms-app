@extends('layout.default')

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
        <section class="content">

            <!-- row tiles -->
            <div class="row">

                <section class="col-lg-4">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Adicionar novo CPF...</h3>
                        </div>
                        <form>
                            <div class="box-body">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-info"></i></span>
                                    <input class="form-control" placeholder="Descrição..." type="text" name="descricao" maxlength="40">
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-star-o"></i></span>
                                    <input class="form-control" placeholder="CPF..." type="text" name="cpf" maxlength="11">
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <div class="box-tools btn-group pull-right">
                                    <button type="button" class="btn btn-primary" data-toggle="tooltip" title="Inserir CPF">
                                        <i class="fa fa-plus"></i>
                                        Inserir
                                    </button>
                                    <button type="reset" class="btn btn-danger" data-toggle="tooltip" title="Limpar formulário">
                                        <i class="fa fa-eraser"></i>
                                        Limpar
                                    </button>
                                </div>

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
                                    <th>CPF</th>
                                    <th>Descrição</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Remover CPF"><i class="fa fa-remove"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>cpf</td>
                                    <td>descricao</td>
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