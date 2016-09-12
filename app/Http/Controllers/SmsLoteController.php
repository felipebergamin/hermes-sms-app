<?php

namespace App\Http\Controllers;

use App\Http\Requests\SmsLoteRequest;
use App\LoteSms;
use App\Sms;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

// SmsLoteController
class SmsLoteController extends Controller
{

    public function index() {
        return new JsonResponse(LoteSms::all());
    }

    public function show(LoteSms $id) {
        return new JsonResponse($id);
    }

    public function create() {
        return view('smsLote');
    }

    public function store(SmsLoteRequest $request) {
        $count = ['ok' => 0, 'fail' => 0];
        $lote = Auth::user()->loteSms()->create($request->only(['descricao']));

        if($lote) {
            $destinatarios = $request->input('destinatarios');

            foreach ($destinatarios as $dest) {
                //return new JsonResponse($dest, 418);

                $sms = new Sms([
                    'texto' => $request->input('texto'),
                    'descricao_destinatario' => $dest['nome'],
                    'numero_destinatario' => $dest['celular']
                ]);
                $sms->setAttribute('usuario_id', Auth::user()->getAttribute('id'));
                $sms->setAttribute('lote_sms_id', $lote->getAttribute('id'));

                //$lote->sms()->save($sms)
                if ($sms->save())
                    $count['ok']++;
                else
                    $count['fail']++;
            }
        } else {
            return new JsonResponse(['message' => 'Houve um erro inesperado no servidor!'], 500);
        }

        return new JsonResponse(['message' => "{$count['ok']} mensagens enviadas. {$count['fail']} com falha!"]);
    }
}
