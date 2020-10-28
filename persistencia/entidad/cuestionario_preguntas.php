<?php

namespace Persistencia\Entidad;

use Illuminate\Database\Eloquent\Model;

class Cuestionario_preguntas extends Model
{
    protected $primaryKey = 'Cuestionario_Id';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Cuestionario_Id',
        'Preguntas_cuestionario_Id'
    ];

    public function getTable()
    {
        return 'Cuestionario_preguntas';
    }

}