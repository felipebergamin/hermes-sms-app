<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $table = 'sms';
    protected $dateFormat = 'U';
    protected $fillable = ['descricao_destinatario', 'texto', 'numero_destinatario'];

    public function user() {
        return $this->belongsTo('\App\User', 'usuario_id', 'id');
    }

    public function loteSms() {
        return $this->belongsTo('\App\LoteSms', 'lote_sms_id', 'id');
    }
}
