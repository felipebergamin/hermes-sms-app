<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SmsLoteRequest;
use App\LoteSms;
use App\Sms;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

// SmsLoteController
class SmsLoteController extends Controller
{

    public function index()
    {
        return new JsonResponse(LoteSms::all());
    }

    public function show(LoteSms $id)
    {
        return new JsonResponse($id);
    }

    public function create()
    {
        return view('smsLote');
    }

    public function store(SmsLoteRequest $request, MobiprontoController $mb)
    {
        // contador para saber quantas mensagens foram enviadas com sucesso, e quantas não foram
        $count = ['ok' => 0, 'fail' => 0];
        // cria o lote Sms no banco de dados
        $lote = Auth::user()->loteSms()->create($request->only(['descricao']));

        // se o lote foi salvo no BD com sucesso
        if ($lote) {
            // pega a lista de destinatários do $request
            $destinatarios = $request->input('destinatarios');

            // itera a lista de destinatários montando a estrutura do objeto Sms, enviando e salvando no BD
            foreach ($destinatarios as $dest) {

                // cria um novo objeto Sms de acordo com os dados recebidos do Front
                $sms = new Sms([
                    'texto' => $request->input('texto'),
                    'descricao_destinatario' => $dest['nome'],
                    'numero_destinatario' => $dest['celular']
                ]);
                // seta os id para as foreign keys do banco
                $sms->setAttribute('usuario_id', Auth::user()->getAttribute('id'));
                $sms->setAttribute('lote_sms_id', $lote->getAttribute('id'));

                /*
                    TODO: Implementar o envio de cada Sms
                    Ter cuidado para não enviar os Sms que vierem marcados com [enviar = false]
                    Estes devem apenas ser salvos no banco, junto com o motivo de não serem enviados
                */

                if (!boolval($dest['enviar'])) {
                    $sms->setAttribute('enviado', false);

                    if (array_key_exists('msg_status', $dest))
                        $sms->setAttribute('msg_status', $dest['msg_status']);
                    else
                        $sms->setAttribute('msg_status', 'Não informado');

                    Auth::user()->sms()->save($sms);
                } else {
                    $mb->sendSms($sms);
                    Auth::user()->sms()->save($sms);
                }

                // se o objeto for salvo com sucesso no banco de dados
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

    public function searchDateInterval(Request $request)
    {
        // return new JsonResponse(['message' => 'hehehe']);

        if ($request->has(['start', 'end'])) {
            $result = LoteSms::with('user')->whereBetween('created_at', [$request->only('start'), $request->only('end')])->get();

            foreach ($result as $lote) {
                $lote->sms_count = Sms::where('lote_sms_id', $lote->id)->count();
            }

            return new JsonResponse($result);
        }

        return new JsonResponse(['message' => 'Intervalo de pesquisa não definido!'], 400);
    }
}
