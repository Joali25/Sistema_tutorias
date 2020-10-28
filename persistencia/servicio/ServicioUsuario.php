<?php

namespace Persistencia\Servicio;

use Persistencia\Entidad\Usuario as Entidad;
use Persistencia\Entidad\Usuario_periodo as EntidadAux;
use Persistencia\Entidad\Periodo as EntidadPeriodo;

class ServicioUsuario
{
    public function guardar($obj)
    {
        $nuevo = $this->obtenerPorId($obj->id);
        if (empty($nuevo)) {
            $obj->save();
            return $obj->id;
        }

        $nuevo->id = $obj->id;
        $nuevo->nombre = $obj->nombre;
        $nuevo->save();
        return $nuevo->id;
    }

    public function verificar($obj)
    {
        $nuevo = $this->obtenerUsuario($obj);
        if (empty($nuevo)) {
            return null;
        }
        return $nuevo;
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

    public function obtenerUsuario($obj)
    {
        return Entidad::where('Matricula',$obj->Matricula)->where('Contrasena',$obj->Contrasena)->first();
    }

    public function obtenerAdmins($tipo)
    {
        return Entidad::where('TipoUsuario',$tipo)->get();
    }

    public function obtenerTutores($tipo)
    {
        return Entidad::where('TipoUsuario',$tipo)->get();
    }

    public function obtenerAlum($Mat)
    {
        return Entidad::where('Matricula',$Mat)->first();
    }

    public function obtenerActivo(){
        $tutor=$_SESSION['Matricula'];
        $act = 1;
        return EntidadPeriodo::where('TutorMatricula',$tutor)->where('Activo',$act)->first();    
    }
    
    public function obtenerAlumnos()
    {
        $tutor=$_SESSION['Matricula'];
        $act = 1;
        $idP = EntidadPeriodo::where('TutorMatricula',$tutor)->where('Activo',$act)->first();
        return EntidadAux::where('Periodo_IdPeriodo',$idP->IdPeriodo)->get();
    }


}

?>