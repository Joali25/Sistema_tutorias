<?php

namespace Persistencia\Servicio;

use Persistencia\Entidad\Usuario_periodo as Entidad;

class ServicioUsuarioPeriodo
{
    public function guardar($obj)
    {
        $nuevo = $this->obtenerPorId($obj->Periodo_IdPeriodo,$obj->Usuario_Matricula);
        if (empty($nuevo)) {
            $obj->save();
            return $obj->Periodo_IdPeriodo;
        }

        $nuevo->Periodo_IdPeriodo = $obj->Periodo_IdPeriodo;
        $nuevo->Usuario_Matricula = $obj->Usuario_Matricula;
        $nuevo->save();
        return $nuevo->Periodo_IdPeriodo;
    }


    public function eliminar($id)
    {
        $obj = $this->obtenerPorId($id);
        if (empty($obj)) {
            return false;
        }

        $obj->delete();
        return true;
    }

    public function obtenerPorId($id,$id2)
    {
        return Entidad::where('Periodo_IdPeriodo',$id)->where('Usuario_Matricula',$id2)->first();
    }

    public function obtenerTodos()
    {
        return Entidad::all();
    }

    public function obtenerAlumnos($id){
        return Entidad::find($id);
    }

    public function obtenerAlumnos2($id)
    {
        return Entidad::where('Usuario_Matricula',$id)->get();
    }

    public function obtenerPorPeriodo($id){
        return Entidad::where('Periodo_IdPeriodo',$id)->get();
    }
}

?>