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
        $mensagens = [];

        // se o lote foi salvo no BD com sucesso
        if ($lote) {
            // pega a lista de destinatários do $request
            $destinatarios = $request->input('destinatarios');

            // itera a lista de destinatários montando a estrutura do objeto Sms, enviando e salvando no BD
            foreach ($destinatarios as $dest) {

                // cria um novo objeto Sms de acordo com os dados recebidos do Front
                $sms = new Sms([
                    'texto' => $request->input('texto'),
                    'descricao_destinatario' => $dest['descricao_destinatario'],
                    'numero_destinatario' => $dest['numero_destinatario']
                ]);
                // seta os id para as foreign keys do banco
                $sms->setAttribute('usuario_id', Auth::user()->getAttribute('id'));
                $sms->setAttribute('lote_sms_id', $lote->getAttribute('id'));

                // se o sms não deve ser enviado
                if (boolval($dest['enviar']) === false) {
                    // define que o sms não foi enviado
                    $sms->setAttribute('enviado', false);

                    // a mensagem de status tem a intenção de informar o porquê do sms não ter sido enviado
                    // se há uma mensagem de status no SMS
                    if (array_key_exists('msg_status', $dest))
                        // seta o atributo no objeto com a mensagem de status
                        $sms->setAttribute('msg_status', $dest['msg_status']);
                    else // se não há msg de status
                        $sms->setAttribute('msg_status', 'Não informado');

                    // salva o objeto no banco de dados
                    // Auth::user()->sms()->save($sms);
                } else { // se não (se o objeto pode ser enviado)
                    $mb->sendSms($sms);
                    // Auth::user()->sms()->save($sms);
                }

                // salva o objeto no banco de dados
                Auth::user()->sms()->save($sms);
                array_push($mensagens, $sms);
            }
        } else {
            return new JsonResponse(['message' => 'Não foi possível registrar o lote de mensagens!'], 500);
        }

        return new JsonResponse($mensagens);
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
