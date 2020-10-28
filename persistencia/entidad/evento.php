<?php
//Se establecen los campos para la entidad Evento y que tabla 
//se toma para este de la base de datos
namespace Persistencia\Entidad;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $primaryKey = 'IdEvento';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'IdEvento',
        'Nombre',
        'Ruta',
        'Url'
    ];

    public function getTable()
    {
        return 'Eventos';
    }

}
