<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoteSms extends Model
{
    protected $table = 'lote_sms';
    protected $dateFormat = 'U';
    protected $fillable = ['descricao'];

    public function user() {
        return $this->belongsTo('\App\User', 'usuario_id', 'id');
    }

    public function sms() {
        return $this->hasMany('\App\Sms', 'lote_sms_id', 'id');
    }
}
