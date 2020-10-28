<?php

//Se establecen los campos para la entidad Formato_tutorias y que tabla 
//se toma para este de la base de datos
namespace Persistencia\Entidad;

use Illuminate\Database\Eloquent\Model;

class Formato_respuestas extends Model
{
    protected $primaryKey = 'Formato_tutorias_Id';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Respuesta',
        'Formato_tutorias_Id',
        'Cita_tutoria_Id_tutoria'
    ];

    public function getTable()
    {
        return 'FormatoTutorias_respuestas';
    }



}
