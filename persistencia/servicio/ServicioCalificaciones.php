<?php

namespace Persistencia\Servicio;

use Persistencia\Entidad\Calificaciones as Entidad;

class ServicioCalificaciones
{

    //Función que guarda la información que se obtiene y verifica 
    //si ya se encuentra en la base de datos 
    //Recibe: Un objeto.
    //Regresa: El campo identificador del objeto.
    public function guardar($obj)
    {
        $nuevo = $this->obtenerPorId($obj->Usuario_Matricula);
        if (empty($nuevo)) {
            $obj->save();
            return $obj->Id;
        }

        $nuevo->Usuario_Matricula = $obj->Usuario_Matricula;
        $nuevo->Cal1 = $obj->Cal1;
        $nuevo->Cal2 = $obj->Cal2;
        $nuevo->Cal3 = $obj->Cal3;
        $nuevo->Cal4 = $obj->Cal4;
        $nuevo->Cal5 = $obj->Cal5;
        $nuevo->Cal6 = $obj->Cal6;
        $nuevo->Cal7 = $obj->Cal7;
        $nuevo->Parcial = $obj->Parcial;
        $nuevo->Periodo = $obj->Periodo;
        $nuevo->FechaRegistro = $obj->FechaRegistro;
        $nuevo->save();
        return $nuevo->Usuario_Matricula;
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
        return Entidad::where('Usuario_Matricula',$id)->get();    }

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

    public function obtenerPorPeriodoParcial($id,$periodo,$parcial){
        return Entidad::where('Periodo',$periodo)->where('Usuario_Matricula',$id)->where('Parcial',$parcial)->first();
    }

    public function obtenerPorTutor($tutor){
        return Entidad::where('Usuario_Matricula',$tutor)->get();
    }

}

?>