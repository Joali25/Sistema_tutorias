<?php

namespace Persistencia\Servicio;

use Persistencia\Entidad\Cita as Entidad;

class ServicioCita
{

    //Función que guarda la información que se obtiene y verifica 
    //si ya se encuentra en la base de datos 
    //Recibe: Un objeto.
    //Regresa: El campo identificador del objeto.
    public function guardar($obj)
    {
        $nuevo = $this->obtenerPorId($obj->Id_tutoria);
        if (empty($nuevo)) {
            $obj->save();
            return $obj->Id_tutoria;
        }

        $nuevo->Id_tutoria = $obj->Id_tutoria;
        $nuevo->Fecha = $obj->Fecha;
        $nuevo->Asistencia = $obj->Asistencia;
        $nuevo->Alumno = $obj->Alumno;
        $nuevo->Disponibilidad_horario_Id = $obj->Disponibilidad_horario_Id;
        $nuevo->save();
        return $nuevo->Id_tutoria;
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

    public function obtenerPorTutor($tutor){
        return Entidad::where('Disponibilidad_horario_Id',$tutor)->get();
    }

    public function obtenerPorAlumno($alumno){
        return Entidad::where('Alumno',$alumno)->get();
    }

    public function verificarCita($fecha,$id){
        return Entidad::where('Disponibilidad_horario_Id',$id)->where('Fecha',$fecha)->first();
    }

    public function obtenerPorFecha($fecha){
        return Entidad::where('Fecha',$fecha)->get();
    }
    // public function obtenerPorNombre($val)
    // {
    //     return Entidad::where('nombre', 'LIKE', '%' . $val . '%')->get();
    // }
}

?>