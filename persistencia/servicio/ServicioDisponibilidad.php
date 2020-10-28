<?php
 
namespace Persistencia\Servicio;

use Persistencia\Entidad\Disponibilidad as Entidad;

class ServicioDisponibilidad
{
    public function guardar($obj)
    {
        $nuevo = $this->obtenerPorId($obj->Id);
        if (empty($nuevo)) {
            $obj->save();
            return $obj->IdEvento;
        }

        $nuevo->Id = $obj->Id;
        $nuevo->Dia = $obj->Dia;
        $nuevo->Horario = $obj->Horario;
        $nuevo->Usuario_Matricula = $obj->Usuario_Matricula;
        $nuevo->save();
        return $nuevo->Id;
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

    public function obtenerPorMatricula($val)
    {
       return Entidad::where('Usuario_Matricula', 'LIKE', '%' . $val . '%')->get();
    }

    public function obtenerPorDia($matricula,$dia){
        return Entidad::where('Usuario_Matricula',$matricula)->where('Dia',$dia)->get();
    }

    public function encontrar($matricula,$id){
        return Entidad::where('Usuario_Matricula',$matricula)->where('Id',$id)->first();
    }
}

?>