<?php

namespace Persistencia\Servicio;

use Persistencia\Entidad\Preguntas_cuestionario as Entidad;

class ServicioPreguntasCuestionario
{

    //Función que guarda la información que se obtiene y verifica 
    //si ya se encuentra en la base de datos 
    //Recibe: Un objeto.
    //Regresa: El campo identificador del objeto.
    public function guardar($obj)
    {
        $nuevo = $this->obtenerPorId($obj->Id);
        if (empty($nuevo)) {
            $obj->save();
            return $obj->Id;
        }

        $nuevo->Id = $obj->Id;
        $nuevo->Pregunta = $obj->Pregunta;
        $nuevo->Respuesta1 = $obj->Respuesta1;
        $nuevo->Respuesta2 = $obj->Respuesta2;
        $nuevo->Respuesta3 = $obj->Respuesta3;
        $nuevo->Respuesta4 = $obj->Respuesta4;
        $nuevo->save();
        return $nuevo->Id;
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

    //Obtiene todos los registros de la tabla Formato_tutorias.
    //Recibe: Nada.
    //Regresa: Todos los registros de la tabla, y null si 
    //la tabla está vacía.
    public function obtenerTodos()
    {
        return Entidad::all();
    }

}

?>