@extends('layout.default')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Enviar SMS
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row" ng-app="hermes_app" ng-controller="sms_lote_ctrl">
                <div class="col-sm-4">
                    <div class="box box-default">

                        <form role="form">

                            <div class="box box-body">

                                <div class="form-group">
                                    <label for="destinatario">Arquivo de destinatários</label>
                                    <input id="file" type="file" class="form-control" name="destinatario"
                                           placeholder="Destinatário" accept=".xls">
                                </div>

                                <div class="form-group">
                                    <label for="descricao">Descrição</label>
                                    <textarea name="descricao" class="form-control" placeholder="Descrição do Lote"
                                              rows="2"
                                              maxlength="60" ng-model="form.lote.descricao"></textarea>

                                </div>


                                <div class="form-group">
                                    <label for="texto">Texto</label>
                                    <textarea name="texto" class="form-control" placeholder="Texto do Sms"
                                              rows="3"
                                              maxlength="160" ng-model="form.lote.texto"
                                              ng-init="form.lote.texto = ''"></textarea>

                                </div>

                                <p class="pull-right">@{{ form.lote.texto.length }} / 160 caracteres
                                    (@{{ 160 - form.lote.texto.length }} restantes)</p>

                            </div> <!-- ./box-body -->

                            <div class="box-footer">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-sm btn-primary btn-flat" ng-click="loadFile()">
                                        <i class="fa fa-check"></i>
                                        Carregar
                                    </button>
                                    <button type="reset" class="btn btn-sm btn-default btn-flat" ng-click="formReset()">
                                        <i class="fa fa-eraser"></i>
                                        Limpar
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

                <div class="col-sm-8">

                    <div class="alert" data-ng-if="destinatarios.length === 0">
                        <h4><i class="icon fa fa-ban"></i> Não há dados!</h4>
                        Nenhum dado foi carregado ainda. Use o formulário ao lado para carregar o arquivo e definir a
                        mensagem a ser enviada.
                    </div>

                    <div class="box box-primary" data-ng-if="destinatarios.length > 0">

                        <div class="box-header with-border">
                            <h3 class="box-title">Dados do arquivo...</h3>

                            <div class="box-tools pull-right">
                                <div class="has-feedback">
                                    <input type="text" class="form-control input-sm" placeholder="Pesquise qualquer coisa" ng-model="form.searchValue">
                                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                </div>
                            </div>
                        </div>

                        <div class="box-body no-padding">



                            <div class="mailbox-controls">

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="tooltip" data-title="Marcar todos" ng-click="toggleCheckboxes(true)">
                                        <i class="fa fa-check-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="tooltip" data-title="Desmarcar todos" ng-click="toggleCheckboxes(false)">
                                        <i class="fa fa-square-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="tooltip" data-title="Inverter seleção" ng-click="toggleCheckboxes()">
                                        <i class="fa fa-random"></i>
                                    </button>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="tooltip" data-title="Confirmar envio" data-ng-click="confirmOperation()">
                                        <i class="fa fa-thumbs-o-up"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-flat btn-sm" data-toggle="tooltip" data-title="Cancelar" data-ng-click="cancelOperation()">
                                        <i class="fa fa-thumbs-o-down"></i>
                                    </button>
                                </div>

                                <div class="pull-right">
                                    1-50/200
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                                    </div>
                                    <!-- /.btn-group -->
                                </div>
                                <!-- /.pull-right -->
                            </div>

                            <table class="table table-bordered table-striped dataTable">
                                <thead>
                                <tr>
                                    <td>Enviar</td>
                                    <td style="width: 50%;">Nome</td>
                                    <td>CPF/CNPJ</td>
                                    <td>Telefone</td>
                                </tr>
                                </thead>
                                <tbody>

                                <tr ng-repeat="d in destinatarios | filter:form.searchValue | orderBy:'nome'" ng-class="d.block_envio ? 'text-danger' : ''">
                                    <td>
                                        <input type="checkbox" ng-model="d.enviar" ng-disabled="d.block_envio">
                                    </td>
                                    <td>@{{ d.nome }}</td>
                                    <td>@{{ d.cpfcnpj }}</td>
                                    <td>@{{ d.celular }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div> <!-- /.box-body -->

                        <div class="box-footer">

                        </div>
                    </div> <!-- /.box box-primary -->
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <script src="/js/modules/response_message_handler.js"></script>
    <script src="/js/sms_lote_angular_app.js"></script>

@endsection