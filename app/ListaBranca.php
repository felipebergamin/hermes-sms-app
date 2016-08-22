<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaBranca extends Model
{
    protected $table = 'lista_branca';
    protected $dateFormat = 'U';
    protected $fillable = ['descricao', 'tipo', 'valor'];

    protected function user() {
        return $this->belongsTo('\App\User', 'usuario_id', 'id');
    }
}
