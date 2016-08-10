@extends('layout.default')

@section('content')

    <!-- TODO: Fazer a página "Sobre" -->

    <div class="content-wrapper">

        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-send-o"></i> Hermes - Ace Tech <i class="fa fa-copyright"></i>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info text-center">
                <div class="col-sm-6 invoice-col">
                    <h1>Laravel</h1>
                    <p>PHP Framework</p>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                    <h1>AngularJS</h1>
                    <p>MVW Javascript Framework</p>
                </div>
            </div>
            <!-- /.row -->
        </section>

    </div>

@endsection