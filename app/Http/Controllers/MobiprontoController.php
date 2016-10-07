<?php

namespace App\Http\Controllers;

use Log;
use App\Sms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\Exception;
use Psy\Util\Json;

class MobiprontoController extends Controller
{
    private $wsdl = 'http://www.mpgateway.com/v_3_00/sms/service.asmx?wsdl';
    private $credencial = 'BD8FE4C9C7AC0259150C21A1EA39EFB5FFCB9A7';
    private $token = 'aF9F85'; // o token
    private $user = '27999017915'; //o codigo principal user
    private $aux_user = ''; // auxiliar user
    private $client = null;

    public function __construct()
    {
        if (!env('APP_TESTING', false))
            try {
                $this->client = $this->initSoapClient();
            } catch (Exception $e) {
                return new JsonResponse(['message' => $e->getMessage()], 500);
            }
    }

    public $errors = array(
        '000' => 'Sucesso-Mensagem enviada com sucesso',
        '001' => 'Credencial inválida',
        '005' => 'MOBILE com formato inválido',
        '008' => 'MESSAGE ou MESSAGE + NOME_PROJETO com mais de 160 posições. SMS concatenado com mais de 15300 posições',
        '009' => 'Créditos insuficientes em conta',
        '010' => 'Gateway SMS da conta bloqueado',
        '012' => 'MOBILE correto, porém com crítica',
        '013' => 'Conteúdo da mensagem inválido ou vazio',
        '015' => 'País sem cobertura ou não aceita mensagens concatenadas (SMS Longo)',
        '016' => 'MOBILE com código de área inválido',
        '017' => 'Operadora não autorizada para esta credencial',
        '018' => 'MOBILE se encontra em lista negra',
        '019' => 'Token inválido',
        '900' => 'Erro de autenticação ou limite de segurança excedido'
    );

    private $options = [
        'soap_version' => SOAP_1_2,
        'exceptions' => true,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    ];

    private function initSoapClient()
    {
        return new \SoapClient($this->wsdl, $this->options);
    }

    public function getCredits()
    {
        $call = "MPG_Credits";

        if(env('APP_TESTING', false)) {
            return new JsonResponse(['result' => -1]);
        }

        try {
            $params = [
                'Credencial' => $this->credencial,
                'Token' => $this->token
            ];

            $result = $this->client->$call($params);

            if ($this->hasError($call, $result))
                return new JsonResponse([
                    'status' => $result->v_st_Status,
                    'message' => $this->errors[$result->v_st_Status]
                ], 500);
            else
                return new JsonResponse(['result' => $result->MPG_CreditsResult]);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function sendSms(Sms $sms)
    {
        $call = "MPG_Send_LMS";

        if (env('APP_TESTING', false)) {
            $sms->setAttribute('enviado', true);
            $sms->setAttribute('id_gateway', "TEST_" . str_random(10));

            return true;
        }
        if ($this->client) {
            try {
                $params = [
                    'Credencial' => $this->credencial,
                    'Token' => $this->token,
                    'Principal_User' => "",
                    'Aux_User' => Auth::user()->name,
                    'Mobile' => preg_replace("/^(\d{2})(\d{9})/", "+55($1)$2$3$4", $sms->getAttribute('numero_destinatario')),
                    'Message' => $sms->getAttribute("texto")
                ];


                $result = $this->client->$call($params)->MPG_Send_LMSResult;

                // verifica se o código de retorno começa com '000:'
                // se começar, significa que o envio ao MobiPronto foi bem sucedido
                if (preg_match("/^000:/i", $result)) {
                    $sms->setAttribute('enviado', true);
                    $sms->setAttribute('id_gateway', explode(":", $result)[1]);

                    return true;
                } else { // se o código de retorno é diferente, então houve um erro
                    $sms->setAttribute('enviado', false);
                    $sms->setAttribute('msg_status', $this->translateErrorCode($result));

                    return false;
                }

                /*
                    object(stdClass)#4 (1) {
                       ["MPG_Send_LMSResult"]=>
                        string(19) "000:MPG000236180474"
                    }
                 */
            } catch (Exception $e) {
                $sms->setAttribute('enviado', false);
                $sms->setAttribute('msg_status', $e->getMessage());
            }
        }

        return false;
    }

    public function translateErrorCode($code)
    {
        if (array_key_exists($code, $this->errors))
            return "$code - {$this->errors[$code]}";

        return $code;
    }

    public function hasError($call, $response)
    {
        $v = "{$call}Result";

        return (
            intval($response->$v) == -1
        );
    }
}
