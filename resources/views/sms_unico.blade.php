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
        <section class="content" ng-app="hermes_app" ng-controller="sms_ctrl">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="box box-default">

                        <form ng-submit="formSubmit()">

                            <div class="box box-body">

                                <div class="form-group">
                                    <label for="numero_destinatario">Destinatário</label>
                                    <input type="text" name="numero_destinatario" class="form-control" autofocus
                                           required
                                           ng-model="form.sms.numero_destinatario" ui-mask="(99) 9 9999-9999"
                                           ui-mask-placeholder ui-masn-placeholder-char="">

                                </div>

                                <div class="form-group">
                                    <label for="descricao_destinatario">Descrição</label>
                                    <input type="text" name="descricao_destinatario" class="form-control" required
                                           ng-model="form.sms.descricao_destinatario" placeholder="Descrição"
                                           maxlength="60">
                                </div>

                                <div class="form-group">
                                    <label for="texto">Texto</label>
                                    <textarea class="form-control" name="texto" placeholder="Texto do Sms"
                                              rows="3" maxlength="160" required ng-model="form.sms.texto"></textarea>
                                </div>

                            </div> <!-- ./box-body -->

                            <div class="box-footer">
                                <div class="box-tools pull-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-envelope-o"></i>
                                        Enviar
                                    </button>
                                    <button type="reset" class="btn btn-flat">
                                        <i class="fa fa-eraser"></i>
                                        Limpar
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <script src="/js/sms_angular_app.js"></script>
@endsection