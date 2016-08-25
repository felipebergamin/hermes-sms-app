<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissoes extends Model
{
    protected $table = 'permissoes';
    protected $dateFormat = 'U';
    protected $fillable = [
        'enviar_sms', 'visualizar_envios', 'visualizar_relatorios', 'manter_usuarios', 'enviar_lote_sms'
    ];
    protected $casts = [
        'enviar_sms' => 'boolean',
        'visualizar_envios' => 'boolean',
        'visualizar_relatorios' => 'boolean',
        'manter_usuarios' => 'boolean',
        'enviar_lote_sms' => 'boolean'
    ];

    public function user() {
        return $this->belongsTo('\App\User', 'usuario_id', 'id');
    }
}
