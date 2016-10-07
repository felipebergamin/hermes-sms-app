<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class ListaBrancaRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->habilitado;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'descricao' => 'required|string|min:4|max:40',
            'tipo' => 'required|in:CPF,CNPJ,CELULAR',
            'valor' => 'required|string|min:11|max:14'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute não informado!',
            'min' => 'O campo :attribute deve ter, no mínimo, :min caracteres!',
            'max' => 'O campo :attribute deve ter, no máximo, :max caracteres!',
            'in' => 'O campo :attribute deve ser um dos valores: :in'
        ];
    }
}
