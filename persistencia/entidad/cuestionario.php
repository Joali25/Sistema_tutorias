<?php

namespace Persistencia\Entidad;

use Illuminate\Database\Eloquent\Model;

class Cuestionario extends Model
{
    protected $primaryKey = 'Id';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'Nombre',
        'Fecha',
        'Periodo',
        'Usuario_Matricula'
    ];

    public function getTable()
    {
        return 'Cuestionario';
    }

}