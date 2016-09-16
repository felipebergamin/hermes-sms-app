<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MobiprontoController extends Controller
{
    private $wsdl = 'http://www.mpgateway.com/v_3_00/sms/service.asmx?wsdl';
    private $url = '';
    private $credencial = 'BD8FE4C9C7AC0259150C21A1EA39EFB5FFCB9A7D'; // sua credencial
    private $token = 'aF9F85'; // o token
    private $user = '27999017915'; //o codigo principal user
    private $aux_user = ''; // auxiliar user
    private $options = [
        'soap_version' => SOAP_1_2,
        'exceptions' => true,
        'trace' => 1,
        'cache_wsdl' => WSDL_CACHE_NONE
    ];

    private function initSoapClient()
    {
        return new SoapClient($this->wsdl, $this->options);
    }

    public function getCredits()
    {
        $params = [
            'CREDENCIAL' => $this->credencial,
            'TOKEN' => $this->token,
            'STATUS' => ''
        ];

        $cli = $this->initSoapClient();

        echo $cli->MPG_Credits($params);
    }
}
