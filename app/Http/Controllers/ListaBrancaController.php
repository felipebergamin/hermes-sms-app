<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListaBrancaRequest;
use App\ListaBranca;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListaBrancaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return new JsonResponse(ListaBranca::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lista_branca');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ListaBrancaRequest $request
     * @return JsonResponse
     */
    public function store(ListaBrancaRequest $request)
    {
        $lb = Auth::user()->listaBranca()->create($request->all());

        return new JsonResponse($lb);
    }

    /**
     * Display the specified resource.
     *
     * @param  ListaBranca  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return new JsonResponse( ListaBranca::find($id) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ListaBranca  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $obj = ListaBranca::find($id);

        if($obj)
            return new JsonResponse($obj->delete());

        return new JsonResponse(['message' => 'Registro não encontrado!'], 500);
    }

    public function consultar($valor) {
        if(isset($valor)) {
            $hasElements = count(ListaBranca::whereIn('valor', explode("|", $valor))->get()) > 0;

            return ($hasElements ? 'true' : 'false');
        }
    }
}
