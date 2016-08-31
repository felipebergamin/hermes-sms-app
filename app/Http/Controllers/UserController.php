<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;


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
     * @param  \App\User  $id
     * @return JsonResponse
     */
    public function show(User $id)
    {
        return new JsonResponse(200, $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return action('UserController@create');
    }

    /**
     * @param UserRequest $request
     * @param User $id
     * @return JsonResponse
     */
    public function update(UserRequest $request, User $id)
    {
        $id->fill($request->all());
        if( $request->has('password') ) {
            $id->setAttribute('password', bcrypt($request->get('password')));
        }

        // se o usuário for salvo com sucesso
        if ( $id->save() ) {
            // se o usuário sendo alterado não é o usuário logado
            // ou seja, se o usuário NÃO está alterando seu próprio cadastro
            if($id->getAttribute('id') != Auth::user()->id) {
                // altera as permissões do usuário e salva no banco de dados
                // isso porque um usuário não pode alterar suas próprias permissões
                $id->permissoes->fill($request->only('permissoes')['permissoes']);

                // salva no banco de dados
                if(!$id->permissoes->save()) {
                    return new JsonResponse(['message'=>'Os dados do usuário foram alterados! Mas ocorreu um erro ao alterar a permissoes!'], 500);
                };
            }

            // se chegar aqui, os dados do usuário foram alterados,
            // mas ele está tentando alterar suas próprias permissões
            return new JsonResponse(['message' => 'Usuário atualizado com sucesso!'], 200);
        }
        else {
            // aqui, houve erro ao alterar o usuário no banco de dados
            return new JsonResponse(['message' => 'Erro ao atualizar o usuário no banco de dados!'], 500);
        }
    }

    /**
     * @return JsonResponse
     */
    public function destroy()
    {
        return new JsonResponse(['message'=>'Não é permitido remover usuários!'], 501);
    }
}
