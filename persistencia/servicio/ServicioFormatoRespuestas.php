<?php

namespace Persistencia\Servicio;

use Persistencia\Entidad\Formato_respuestas as Entidad;

class ServicioFormatoRespuestas
{
    public function guardar($obj)
    {
        $nuevo = $this->obtenerPorCita($obj->Cita_tutoria_Id_tutoria,$obj->Formato_tutorias_Id);
        if (empty($nuevo)) {
            $obj->save();
            return $obj->Periodo_IdPeriodo;
        }

        $nuevo->Cita_tutoria_Id_tutoria = $obj->Cita_tutoria_Id_tutoria;
        $nuevo->Formato_tutorias_Id = $obj->Formato_tutorias_Id;
        $nuevo->Respuesta = $obj->Respuesta;
        $nuevo->save();
        return $nuevo->Cita_tutoria_Id_tutoria;
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

    public function obtenerPorCita($cita,$id)
    {
        return Entidad::where('Cita_tutoria_Id_tutoria',$cita)->where('Formato_tutorias_Id',$id)->first();
    }

    public function obtenerPorCita2($cita)
    {
        return Entidad::where('Cita_tutoria_Id_tutoria',$cita)->get();
    }

    public function obtenerTodos()
    {
        return Entidad::all();
    }


    
}

?>