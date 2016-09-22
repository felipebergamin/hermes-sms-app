<?php

namespace App\Http\Controllers;

use App\Sms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests\SmsRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SmsController extends Controller
{

    /**
     * Retorna uma listagem de Sms
     *
     * @return JsonResponse
     */
    public function index(Request $request) {
        if($request->has('withRelationships'))
            return new JsonResponse(Sms::with('user')->with('loteSms')->get());

        return new JsonResponse(Sms::all(), 200);
    }

    /**
     * Mostra o formulário para criar um novo Sms
     *
     * @return Response
     */
    public function create() {
        return view('sms_unico');
    }

    /**
     * Salva um sms no banco de dados
     *
     * @param SmsRequest $request
     * @return JsonResponse
     */
    public function store(SmsRequest $request, MobiprontoController $mb) {
        $sms = new Sms($request->all());

        if ($mb && $sms) {
            if($mb->sendSms($sms));
                Auth::user()->sms()->save($sms);

            return new JsonResponse($sms);
        }

        /*
        if (Auth::user()->sms()->create($request->all())) {
            return new JsonResponse(['message' => 'Sms salvo com sucesso!']);
        } else {
            return new JsonResponse(['message' => 'Impossível salvar o Sms'], 500);
        }
        */
    }

    /**
     * Lista o Sms especificado
     *
     * @param Sms $id
     * @return JsonResponse
     */
    public function show(Sms $id) {
        return new JsonResponse(Sms::where('id', '=', $id->getAttribute('id'))->with('user')->first());
    }

    public function send(Sms $id) {

    }

    public function searchDateInterval(Request $request) {
        if($request->has(['start', 'end']))
            return new JsonResponse(Sms::with('user')->with('loteSms')->whereBetween('created_at', [$request->only('start'), $request->only('end')])->get());

        return new JsonResponse(['message' => 'Intervalo de busca não definido!'], 400);
    }

    // public function edit() { }

    // public function update() { }

    // public function destroy() { }
}
