<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        #return true;
        return (boolval(Auth::user()->permissoes->manter_usuarios) && boolval(Auth::user()->habilitado));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // se o método da requisição é PUT
        // ou seja, se a solicitação é para atualizar um usuário
        if( strtolower($this->method()) === 'put' ) {
            return [
                'id' => 'required|integer',
                'name' => 'max:255',
                'email' => 'email|max:255',
                'password' => 'min:6|confirmed',
                'habilitado' => 'boolean',

                'permissoes.enviar_sms' => 'boolean',
                'permissoes.visualizar_envios' => 'boolean',
                'permissoes.visualizar_relatorios' => 'boolean',
                'permissoes.manter_usuarios' => 'boolean',
                'permissoes.enviar_lote_sms' => 'boolean',
            ];
        }

        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'habilitado' => 'required|boolean',

            'permissoes.enviar_sms' => 'required|boolean',
            'permissoes.visualizar_envios' => 'required|boolean',
            'permissoes.visualizar_relatorios' => 'required|boolean',
            'permissoes.manter_usuarios' => 'required|boolean',
            'permissoes.enviar_lote_sms' => 'required|boolean',
        ];

    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute não pode ser deixado em branco!',
            'max' => 'O :attribute não pode ser maior que :max caracteres!',
            'password.confirmed' => 'As senhas não conferem!',
            'password.min' => 'A senha deve ter, no mínimo, 6 caracteres!',
            'boolean' => 'O atributo :attribute não corresponde ao esperado!'
        ];
    }
}
