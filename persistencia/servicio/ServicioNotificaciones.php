<?php

namespace Persistencia\Servicio;

use Persistencia\Entidad\Notificaciones as Entidad;

class ServicioNotificaciones
{

    //Función que guarda la información que se obtiene y verifica 
    //si ya se encuentra en la base de datos 
    //Recibe: Un objeto.
    //Regresa: El campo identificador del objeto.
    public function guardar($obj)
    {
        $nuevo = $this->obtenerPorId($obj->Matricula_tutor,$obj->Fecha);
        if (empty($nuevo)) {
            $obj->save();
            return $obj->Id;
        }

        $nuevo->Matricula_tutor = $obj->Matricula_tutor;
        $nuevo->Fecha = $obj->Fecha;

        $nuevo->save();
        return $nuevo->Matricula_tutor;
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
    public function obtenerPorId($id,$fecha)
    {
        return Entidad::where('Matricula_tutor',$id)->where('Fecha',$fecha)->first();
    }

    //Obtiene todos los registros de la tabla Formato_tutorias.
    //Recibe: Nada.
    //Regresa: Todos los registros de la tabla, y null si 
    //la tabla está vacía.
    public function obtenerTodos()
    {
        return Entidad::all();
    }

    public function obtenerPorPeriodo($periodo){
        return Entidad::where('Periodo',$periodo)->get();
    }

    public function obtenerPorTutor($tutor){
        return Entidad::where('Usuario_Matricula',$tutor)->get();
    }

}

?>