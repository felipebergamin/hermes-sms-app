<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $dateFormat ='U';
    protected $casts = [
        'habilitado' => 'boolean'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'habilitado',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sms() {
        return $this->hasMany('\App\Sms', 'usuario_id', 'id');
    }

    public function loteSms() {
        return $this->hasMany('\App\LoteSms', 'usuario_id', 'id');
    }

    public function listaBranca() {
        return $this->hasMany('\App\ListaBranca', 'usuario_id', 'id');
    }

    public function permissoes() {
        return $this->hasOne('\App\Permissoes', 'usuario_id', 'id');
    }
}
