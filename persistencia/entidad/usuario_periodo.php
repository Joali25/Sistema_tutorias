<?php

namespace Persistencia\Entidad;

use Illuminate\Database\Eloquent\Model;

class Usuario_periodo extends Model
{
    protected $primaryKey = 'Usuario_Matricula';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Periodo_IdPeriodo',
        'Usuario_Matricula',
    ];

    public function getTable()
    {
        return 'Usuario_periodo';
    }

}
