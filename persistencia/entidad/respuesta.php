<?php

namespace Persistencia\Entidad;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    protected $primaryKey = 'Respuesta_Id';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Respuesta_Id',
        'Alumno',
        'Valor'
    ];

    public function getTable()
    {
        return 'Respuesta';
    }

}