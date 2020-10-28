<?php

namespace Persistencia\Entidad;

use Illuminate\Database\Eloquent\Model;

class Disponibilidad extends Model
{
    protected $primaryKey = 'Id';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'Dia',
        'Horario',
        'Usuario_Matricula'
    ];

    public function getTable()
    {
        return 'Disponibilidad_horario';
    }

}
