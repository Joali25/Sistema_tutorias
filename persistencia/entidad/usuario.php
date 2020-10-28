<?php

namespace Persistencia\Entidad;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $primaryKey = 'Matricula';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Matricula',
        'Nombre',
        'ApellidoP',
        'ApellidoM',
        'FechaN',
        'TipoUsuario',
        'Contrasena',
        'PrimerInicio'
    ];

    public function getTable()
    {
        return 'Usuario';
    }

    public function periodos(){

        return $this->belongsToMany('Persistencia\Entidad\Periodo','Usuario_Periodo','Usuario_Matricula','Periodo_IdPeriodo')->withTimestamps();
    }
    // public function getProduccionesAgricolas()
    // {
    //     return $this->hasMany("Persistencia\Entidad\ProduccionAgricola", "distrito")->get();
    // }

    // public function getVolumenesDistribuidos()
    // {
    //     return $this->hasMany("Persistencia\Entidad\VolumenDistribuido", "distrito")->get();
    // }

}
