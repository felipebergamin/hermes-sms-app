<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class SmsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $loggedUser = Auth::user();

        return ($loggedUser->habilitado && $loggedUser->permissoes->enviar_sms);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (strtolower($this->method()) == 'put') {
            // regras de validação para 'update'
            return [
                'id' => 'required|integer',
                'descricao_destinatario' => 'required|string|min:5|max:60',
                'texto' => 'required|string|min:10|max:160',
                'numero_destinatario' => 'required|digits:11',
            ];
        }

        // regras de validação para 'store'
        return [
            'descricao_destinatario' => 'required|string|min:5|max:60',
            'texto' => 'required|string|min:10|max:160',
            'numero_destinatario' => 'required|digits:11'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute deve ser informado!',
            'min' => ':attribute deve ter mais que :min caracteres!',
            'max' => ':attribute deve ter, no máximo, :max caracteres!',
            'digits' => ':attribute deve ter :digits dígitos!'
        ];
    }
}
