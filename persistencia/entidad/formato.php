<?php

//Se establecen los campos para la entidad Formato_tutorias y que tabla 
//se toma para este de la base de datos
namespace Persistencia\Entidad;

use Illuminate\Database\Eloquent\Model;

class Formato extends Model
{
    protected $primaryKey = 'Id';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'Campo',
        'Activo'
    ];

    public function getTable()
    {
        return 'Formato_tutorias';
    }

    // public function getGrupo()
    // {
    //     return $this->belongsTo("Persistencia\Entidad\Grupo", "grupo", "id")->first();
    // }

    // public function getProduccionesAgricolas()
    // {
    //     return $this->hasMany("Persistencia\Entidad\ProduccionAgricola", "cultivo")->get();
    // }


}
