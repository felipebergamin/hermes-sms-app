<?php

namespace App\Http\Controllers;

use App\LoteSms;
use App\Sms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function makeReport()
    {
        $response = [
            'totalSms' => \App\Sms::count(),
            'topUser' => 'karol',
            'sumSmsByUser' => [
                [
                    'nome' => 'felipe',
                    'sms' => 1
                ],
                [
                    'nome' => 'karol',
                    'sms' => 7
                ],
                [
                    'nome' => 'alex',
                    'sms' => 2
                ]
            ]
        ];

        $response['totalSms'] = Sms::count();
        $response['totalLotes'] = LoteSms::count();
        $response['totalSmsAvulso'] = Sms::where('lote_sms_id', null)->count();
        $response['totalSmsComLote'] = Sms::where('lote_sms_id', '<>', null)->count();
        $response['sumSmsByUser'] = $this->getSmsSumForEachUser();
        $response['topUser'] = $this->getTopUser( $response['sumSmsByUser'] );

        return new JsonResponse($response);
    }

    public function makeReportFromInterval($dataInicio, $dataFim)
    {

    }

    private function getSmsSumForEachUser()
    {
        return DB::table('sms')
            ->join('users', 'sms.usuario_id', '=', 'users.id')
            ->select(DB::raw('users.name as name,count(*) as sumSms'))
            ->groupBy('sms.usuario_id')->get();

        /*
        return Sms::select(
            DB::raw('usuario_id as nome,count(*) as sms')
        )->groupBy('usuario_id')->get();
        */
    }

    private function getTopUser($smsSumForEachUser)
    {
        $top = $smsSumForEachUser[0];

        foreach ($smsSumForEachUser as $s)
            if ($s->sumSms > $top->sumSms)
                $top = $s;

        return $top;
    }
}
