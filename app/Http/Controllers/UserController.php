<?php

namespace App\Http\Controllers;

use App\Permissoes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests;
use Illuminate\Http\Response;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return new JsonResponse(User::with('permissoes')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuarios');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Database\Eloquent\Collection|JsonResponse|static[]
     */
    public function store(UserRequest $request)
    {
        $params = $request->all();
        $params['password'] = bcrypt($params['password']);

        // cria o usuário na base de dados
        $user = User::create($params);

        // se o usuário foi criado corretamente
        if ( $user ) {
            // cria as permissoes
            $permissoes = $user->permissoes()->create($request->only('permissoes')['permissoes']);

            // se as permissões foram criadas corretamente
            if ( $permissoes ) {

                // retorna o objeto user criado com as permissoes
                return new JsonResponse(User::where(['id' => $user->id])->with('permissoes')->first());
            }
            else { // se as permissoes não foram criadas no banco de dados
                // deleta o usuário já armazenado
                $user->delete();
                // retorna um http status 500 com uma mensagem de erro
                return new JsonResponse(['Impossível processar as permissoes do usuário!'], 500);
            }
        }
        else { // se não foi possível salvar o usuário
            return new JsonResponse(['message' => 'Impossível salvar o usuário na base de dados!'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $id)
    {
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return action('UserController@create');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $id)
    {
        $id->fill($request->all());
        if( $request->has('password') ) {
            $id->password = bcrypt( $request->get('password') );
        }

        if ( $id->save() ) {
            return new JsonResponse(['message' => 'Usuário atualizado com sucesso!'], 200);
        }
        else {
            return new JsonResponse(['message' => 'Erro ao atualizar o usuário no banco de dados!'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $id)
    {
        // Exclusão de usuários não é permitida
    }
}
