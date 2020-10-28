<?php

namespace Persistencia\Servicio;

use Persistencia\Entidad\Periodo as Entidad;

class ServicioPeriodo
{
    public function guardar($obj)
    {
        $nuevo = $this->obtenerPorId($obj->IdPeriodo);
        if (empty($nuevo)) {
            $obj->save();
            return $obj->IdPeriodo;
        }

        $nuevo->IdPeriodo = $obj->IdPeriodo;
        $nuevo->Grado = $obj->Grado;
        $nuevo->Grupo = $obj->Grupo;
        $nuevo->Periodo = $obj->Periodo;
        $nuevo->AnoGrupo = $obj->AnoGrupo;
        $nuevo->Activo = $obj->Activo;
        $nuevo->TutorMatricula = $obj->TutorMatricula;
        $nuevo->save();
        return $nuevo->IdPeriodo;
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

    public function obtenerPorId($id)
    {
        return Entidad::find($id);
    }

    public function obtenerTodos()
    {
        return Entidad::all();
    }

    public function obtenerAlumnos($id){
        return Entidad::find($id);
    }

    public function obtenerActivo($tutor,$activo){
        return Entidad::where('TutorMatricula',$tutor)->where('Activo',$activo)->first();
    }

    public function obtenerActivosP($activo){
        return Entidad::where('Activo',$activo)->get();
    }

    public function obtenerPeriodo($grado,$grupo,$anio,$periodo){
        return Entidad::where('Grado',$grado)->where('Grupo',$grupo)->where('AnoGrupo',$anio)->where('Periodo',$periodo)->first();
    }

}

?>