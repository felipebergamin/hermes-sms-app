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
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="box box-default">

                        <form role="form" enctype="multipart/form-data">

                            <div class="box box-body">

                                <div class="form-group">
                                    <label for="destinatario">Arquivo de destinatários</label>
                                    <input type="file" class="form-control" name="destinatario"
                                           placeholder="Destinatário" maxlength="11">
                                </div>

                                <div class="form-group">
                                    <label for="texto">Texto</label>
                                    <textarea name="texto" class="form-control" placeholder="Texto do Sms" rows="3"
                                              maxlength="160"></textarea>
                                </div>

                            </div> <!-- ./box-body -->

                            <div class="box-footer">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-flat btn-primary"><i class="fa fa-check"></i>
                                        Continuar
                                    </button>
                                    <button type="reset" class="btn btn-flat btn-default"><i class="fa fa-eraser"></i>
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
@endsection