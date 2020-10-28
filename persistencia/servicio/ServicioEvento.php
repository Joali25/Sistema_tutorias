<?php

//Se realizan las acciones necesarias para efectuar los cambios en el crud, 
//Realiza la unión entre las vistas y la base de datos.

namespace Persistencia\Servicio;

use Persistencia\Entidad\Evento as Entidad;

class ServicioEvento
{
    //Función que guarda la información que se obtiene y verifica 
    //si ya se encuentra en la base de datos 
    //Recibe: Un objeto.
    //Regresa: El campo identificador del objeto.
    public function guardar($obj)
    {
        $nuevo = $this->obtenerPorId($obj->IdEvento);
        if (empty($nuevo)) {
            $obj->save();
            return $obj->IdEvento;
        }

        $nuevo->IdEvento = $obj->IdEvento;
        $nuevo->Nombre = $obj->Nombre;
        $nuevo->Ruta = $obj->Ruta;
        $nuevo->Url = $obj->Url;
        $nuevo->save();
        return $nuevo->IdEvento;
    }

    //Función que elimina un objeto si este se encuentra en la 
    //base de datos
    //Recibe: El identificador de un objeto.
    //Regresa: False si no se encuentra y True si se encuentra
    //y elimina.
    public function eliminar($id)
    {
        $obj = $this->obtenerPorId($id);
        if (empty($obj)) {
            return false;
        }

        $obj->delete();
        return true;
    }

    //Obtiene todos los objetos que encuentre con el identificador
    //que manda a la función find
    //Recibe: El identificador de un objeto.
    //Regresa: El objeto que se encontró con ese Id o null 
    //si no se encuentra
    public function obtenerPorId($id)
    {
        return Entidad::find($id);
    }

    //Obtiene todos los registros de la tabla Eventos.
    //Recibe: Nada.
    //Regresa: Todos los registros de la tabla, y null si 
    //la tabla está vacía.
    public function obtenerTodos()
    {
        return Entidad::all();
    }

    // public function obtenerPorNombre($val)
    // {
    //     return Entidad::where('nombre', 'LIKE', '%' . $val . '%')->get();
    // }
}

?>