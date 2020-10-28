<?php

namespace Persistencia\Entidad;

use Illuminate\Database\Eloquent\Model;

class Calificaciones extends Model
{
    protected $primaryKey = 'Usuario_Matricula';
    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Parcial',
        'Cal1',
        'Cal2',
        'Cal3',
        'Cal4',
        'Cal5',
        'Cal6',
        'Cal7',
        'FechaRegistro',
        'Periodo',
        'Usuario_Matricula'
    ];

    public function getTable()
    {
        return 'Calificaciones';
    }

}