<?php

namespace Persistencia\Entidad;

use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
    protected $primaryKey = 'Usuario_Matricula';
    protected $keyType = 'varchar';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Calle',
        'NumE',
        'NumI',
        'Colonia',
        'Municipio',
        'Estado',
        'CodigoP',
        'Usuario_Matricula'
    ];

    public function getTable()
    {
        return 'Domicilio';
    }

}
?>