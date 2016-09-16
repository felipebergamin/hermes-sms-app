<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;

class MobiprontoController extends Controller
{
    private $wsdl = 'http://www.mpgateway.com/v_3_00/sms/service.asmx?wsdl';
    private $credencial = 'BD8FE4C9C7AC0259150C21A1EA39EFB5FFCB9A7D';
    private $token = 'aF9F85'; // o token
    private $user = '27999017915'; //o codigo principal user
    private $aux_user = ''; // auxiliar user

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
        try {
            $params = [
                'Credencial' => $this->credencial,
                'Token' => $this->token
            ];

            $cli = $this->initSoapClient();

            $result = $cli->$call($params);

            if ($this->hasError($call, $result))
                return new JsonResponse([
                    'status' => $result->v_st_Status,
                    'message' => $this->errors[$result->v_st_Status]
                ], 500);
            else
                return new JsonResponse(['result' => $result->MPG_CreditsResult]);

        } catch (Exception $e) {
            echo($e->getMessage());
        }
    }

    public function hasError($call, $response)
    {
        $v = "{$call}Result";

        return (
            intval($response->$v) == -1
        );
    }
}
