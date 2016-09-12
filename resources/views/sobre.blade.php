@extends('layout.default')

@section('content')

    <div class="content-wrapper">

        <section class="invoice">
            <!-- title row -->
            <div class="row text-center">
                <div class="col-xs-12">
                    <h1 class="page-header">
                        <i class="fa fa-send-o"></i> Sistema Hermes para envio de SMS
                    </h1>
                </div>
                <!-- /.col -->
            </div>

            <div class="row invoice-info text-center">
                <div class="col-sm-12 invoice-col">
                    <img src="/img/acetech_logo.png">
                    <h1>Ace Tech</h1>
                    <p>Sistema de envio de SMS</p>
                </div>
            </div>

            <!-- info row -->
            <div class="row invoice-info text-center">
                <div class="col-sm-6 invoice-col">
                    <img src="/img/laravel_logo.png">
                    <h1>Laravel</h1>
                    <p>PHP Framework</p>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                    <img src="/img/angular_logo.png">
                    <h1>AngularJS</h1>
                    <p>MVW Javascript Framework</p>
                </div>
            </div>
            <!-- /.row -->
        </section>

    </div>

@endsection