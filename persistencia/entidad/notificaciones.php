<?php

namespace Persistencia\Entidad;

use Illuminate\Database\Eloquent\Model;

class Notificaciones extends Model
{
    protected $primaryKey = 'Matricula_tutor';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Matricula_tutor',
        'fecha'
    ];

    public function getTable()
    {
        return 'Notificaciones';
    }

}