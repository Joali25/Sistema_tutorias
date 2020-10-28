<?php

namespace Controlador;

use Persistencia\Servicio\ServicioDomicilio as ServicioD;
use Persistencia\Entidad\Domicilio as EntidadD;
use Persistencia\Servicio\ServicioUsuario as ServicioU;
use Persistencia\Entidad\Usuario as EntidadU;

class ControladorDomicilio
{
    private $servicioD;
    private $servicioU;
    private static $VISTA_CONSULTAR = 'domicilio';
    private static $VISTA_EDITAR = 'editarEvento';
    private static $VISTA_NUEVO = 'nuevoEvento';

    public function __construct()
    {
        $this->servicioD = new ServicioD();
        $this->servicioU = new ServicioU();
    }

    public function index()
    {
        $var = $_SESSION['Matricula'];
        $obj = $this->servicioD->obtenerPorId($var);
        if(empty($obj)){
            $obj = new EntidadD();
        }
        require 'vistas/' . self::$VISTA_CONSULTAR . '.php';
    }


    public function guardar()
    {
        if (empty($_POST)) {
            header('Location: ./');
        }
        $var = $_SESSION['Matricula'];
        $obj = $this->servicioD->obtenerPorId($var);
        if(empty($obj)){
            $obj = new EntidadD();
        }
        $obj->Calle = $_POST['calle'];
        $obj->NumE = $_POST['numE'];
        $obj->NumI = $_POST['numI'];
        $obj->Colonia = $_POST['colonia'];
        $obj->Municipio = $_POST['municipio'];
        $obj->Estado = $_POST['estado'];
        $obj->CodigoP = $_POST['cp'];
        $obj->Usuario_Matricula = $var;

        $this->servicioD->guardar($obj);
        ?>
        <script type='text/javascript'>
            alert('La información de tu domicilio ha sido guardada'); 
            window.location.href ='index.php?vista=domicilio';
        </script>";
        <?php
    }

    
}

?>