<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissoes extends Model
{
    protected $table = 'permissoes';
    protected $dateFormat = 'U';
    protected $fillable = ['enviar_sms', 'visualizar_envios', 'visualizar_relatorios', 'manter_usuarios', 'enviar_lote_sms'];

    public function user() {
        return $this->belongsTo('\App\User', 'usuario_id', 'id');
    }
}
