<?php

namespace Persistencia\Entidad;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $primaryKey = 'Id_tutoria';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Id_tutoria',
        'Fecha',
        'Asistencia',
        'Alumno',
        'Disponibilidad_horario_Id'
    ];

    public function getTable()
    {
        return 'Cita_tutoria';
    }

}
