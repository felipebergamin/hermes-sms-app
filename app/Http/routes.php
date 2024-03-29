<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::group(['middleware' => ['web', 'auth', 'enabled']], function () {
    Route::get('/', function () {
        return view('start');
    });

    Route::get('/relatorio', function () {
        return view('relatorio');
    });

    Route::get('/enviarSms', 'SmsController@create');

    Route::get('/consultarSms', function () {
        return view('consultar_sms');
    });

    Route::get('/consultarLote', function () {
        return view('consultar_lote');
    });

    Route::get('/enviarLote', 'SmsLoteController@create');

    Route::get('/listaBranca', 'ListaBrancaController@create');

    Route::get('/sobre', function () {
        return view('sobre');
    });

    Route::get('/usuarios', 'UserController@create');

    Route::group(['prefix' => 'api'], function () {

        //
        //   _   _ ___  ___ _ __
        //  | | | / __|/ _ \ '__|
        //  | |_| \__ \  __/ |
        //   \__,_|___/\___|_|
        //
        Route::group(['prefix' => 'user'], function () {

            /**
             * Obter lista de usuários
             */
            Route::get('', 'UserController@index');

            /**
             * Obter um usuário específico
             */
            Route::get('{id}', 'UserController@show');

            /**
             * Criar novo usuário com base nos dados recebidos
             */
            Route::post('', 'UserController@store');

            /**
             * Atualiza as informações de um usuário com base nos dados recebidos
             */
            Route::put('{id}', 'UserController@update');

            /**
             * Requisição delete, não implementada no Controller, pois não é permitido deletar usuários
             */
            Route::delete('{id}', 'UserController@destroy');
        });

        //
        //   ___ _ __ ___  ___
        //  / __| '_ ` _ \/ __|
        //  \__ \ | | | | \__ \
        //  |___/_| |_| |_|___/
        //
        Route::group(['prefix' => 'sms'], function () {
            Route::get('', 'SmsController@index');

            Route::get('{id}', 'SmsController@show');

            Route::post('', 'SmsController@store');

            //                           _
            //   ___  ___  __ _ _ __ ___| |__
            //  / __|/ _ \/ _` | '__/ __| '_ \
            //  \__ \  __/ (_| | | | (__| | | |
            //  |___/\___|\__,_|_|  \___|_| |_|
            //
            Route::group(['prefix' => 'search'], function () {
                Route::get('dateinterval', 'SmsController@searchDateInterval');
            });
        });


        //                       _       _
        //   ___ _ __ ___  ___  | | ___ | |_ ___
        //  / __| '_ ` _ \/ __| | |/ _ \| __/ _ \
        //  \__ \ | | | | \__ \ | | (_) | |_  __/
        //  |___/_| |_| |_|___/ |_|\___/ \__\___|
        //
        Route::group(['prefix' => 'smslote'], function () {
            Route::get('', 'SmsLoteController@index');

            Route::get('{id}', 'SmsLoteController@show');

            Route::post('', 'SmsLoteController@store');

            Route::group(['prefix' => 'search'], function () {
                Route::get('dateinterval', 'SmsLoteController@searchDateInterval');
            });
        });

        //   _ _     _          _
        //  | (_)___| |_ __ _  | |__  _ __ __ _ _ __   ___ __ _
        //  | | / __| __/ _` | | '_ \| '__/ _` | '_ \ / __/ _` |
        //  | | \__ \ |_ (_| | | |_) | | | (_| | | | | (__ (_| |
        //  |_|_|___/\__\__,_| |_.__/|_|  \__,_|_| |_|\___\__,_|
        //
        Route::group(['prefix' => 'listabranca'], function () {
            Route::get('', 'ListaBrancaController@index');

            Route::get('{id}', 'ListaBrancaController@show');

            Route::post('', 'ListaBrancaController@store');

            Route::delete('{id}', 'ListaBrancaController@destroy');

            // verifica se {valor} está na lista branca
            Route::get('consultar/{valor}', 'ListaBrancaController@consultar');
        });

        //               _
        //    __ _  __ _| |_ _____      ____ _ _   _   ___ _ __ ___  ___
        //   / _` |/ _` | __/ _ \ \ /\ / / _` | | | | / __| '_ ` _ \/ __|
        //  | (_| | (_| | |_  __/\ V  V / (_| | |_| | \__ \ | | | | \__ \
        //   \__, |\__,_|\__\___| \_/\_/ \__,_|\__, | |___/_| |_| |_|___/
        //   |___/                             |___/
        Route::group(['prefix' => 'gwsms'], function () {
            Route::get('credits', 'MobiprontoController@getCredits');
        });


        //            _       _             _
        //   _ __ ___| | __ _| |_ ___  _ __(_) ___  ___
        //  | '__/ _ \ |/ _` | __/ _ \| '__| |/ _ \/ __|
        //  | | |  __/ | (_| | |_ (_) | |  | | (_) \__ \
        //  |_|  \___|_|\__,_|\__\___/|_|  |_|\___/|___/
        //
        Route::group(['prefix' => 'relatorio'], function () {

            Route::get('{dataInicio}/{dataFim}', 'ReportController@makeReportFromInterval');

            Route::get('', 'ReportController@makeReport');
        });
    });
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/disabled', function () {
    return view('errors.user_disabled');
});

Route::get('/register', function () {
    return redirect('/login');
});