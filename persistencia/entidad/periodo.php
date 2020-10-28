<?php

namespace Persistencia\Entidad;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $primaryKey = 'IdPeriodo';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'IdPeriodo',
        'Grado',
        'Grupo',
        'Periodo',
        'AnoGrupo',
        'Activo',
        'TutorMatricula',
    ];

    public function getTable()
    {
        return 'Periodo';
    }

    
}
