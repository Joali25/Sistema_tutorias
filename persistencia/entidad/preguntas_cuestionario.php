<?php

namespace Persistencia\Entidad;

use Illuminate\Database\Eloquent\Model;

class Preguntas_cuestionario extends Model
{
    protected $primaryKey = 'Id';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'Pregunta',
        'Respuesta1',
        'Respuesta2',
        'Respuesta3',
        'Respuesta4'
    ];

    public function getTable()
    {
        return 'Preguntas_cuestionario';
    }

}