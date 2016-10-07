<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class SmsLoteRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $loggedUser = Auth::user();

        return ($loggedUser->permissoes->enviar_lote_sms && $loggedUser->habilitado);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'texto' => 'required|string|min:10|max:160',
            'descricao' => 'required|string|max:50',
            'destinatarios' => 'required|array',
            'destinatarios.*.descricao_destinatario' => 'required_with:destinatarios|string|max:60',
            'destinatarios.*.numero_destinatario' => 'required_with:destinatarios|string|size:11'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute deve ser informado!',
            'min' => 'O :attribute deve ser, pelo menos, :min caracteres!',
            'max' => ':attribute deve ter, no máximo, :max caracteres',
            'size' => ':attribute deve ter :size caracteres!',

            'destinatarios.required' => 'Nenhum destinatário foi definido!'
        ];
    }
}
