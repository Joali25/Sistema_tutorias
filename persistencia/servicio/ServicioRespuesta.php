<?php

namespace Persistencia\Servicio;

use Persistencia\Entidad\Respuesta as Entidad;

class ServicioRespuesta
{

    //Función que guarda la información que se obtiene y verifica 
    //si ya se encuentra en la base de datos 
    //Recibe: Un objeto.
    //Regresa: El campo identificador del objeto.
    public function guardar($obj)
    {
        $nuevo = $this->obtenerPorId($obj->Respuesta_Id);
        if (empty($nuevo)) {
            $obj->save();
            return $obj->Respuesta_Id;
        }

        $nuevo->Respuesta_Id = $obj->Respuesta_Id;
        $nuevo->Alumno = $obj->Alumno;
        $nuevo->Valor = $obj->Valor;
        $nuevo->save();
        return $nuevo->Respuesta_Id;
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

    public function obtenerRespuestas($id){
        return Entidad::where('Respuesta_Id',$id)->get();
    }

    public function buscarRespuesta($matricula,$id){
        return Entidad::where('Alumno',$matricula)->where('Respuesta_Id',$id)->first();
    }

}

?>