<?php

namespace Controlador;


use Persistencia\Servicio\ServicioCalificaciones as Servicio;
use Persistencia\Entidad\Calificaciones as Entidad;
use Persistencia\Servicio\ServicioUsuario as ServicioU;
use Persistencia\Entidad\Usuario as EntidadU;
use Persistencia\Servicio\ServicioUsuarioPeriodo as ServicioUP;
use Persistencia\Servicio\ServicioPeriodo as ServicioP;
use PhpOffice\PhpSpreadsheet\IOfactory;

class ControladorCalificaciones
{
    private $servicio;
    private $servicioU;
    private $servicioUP;
    private $servicioP;
    private static $VISTA_CONSULTAR = 'calificaciones';
    private static $VISTA_EDITAR = 'confirmarCalificaciones';
    private static $VISTA_NUEVO = 'nuevoEvento';

    public function __construct()
    {
        $this->servicio = new Servicio();
        $this->servicioU = new ServicioU();
        $this->servicioUP = new ServicioUP();
        $this->servicioP = new ServicioP();

    }

    public function index()
    {
        require 'vistas/' . self::$VISTA_CONSULTAR . '.php';
    }

    public function subirCalificaciones(){

        if (empty($_POST)) {
            header('Location: ./');
        }
    
        $ruta = $_FILES['documento']['name'];
        $move = "controlador/".$_FILES['documento']['name'];
        move_uploaded_file($_FILES['documento']['tmp_name'], $move);

        $documento = IOFactory::load($move);
        $parcial = $_POST['parcial'];
        $matricula = array();
        $c1 = array();
        $c2 = array();
        $c3 = array();
        $c4 = array();
        $c5 = array();
        $c6 = array();
        $c7 = array();

        $hoja = $documento->getSheet(0);
        $Filas = $hoja->getHighestRow();
        for ($row = 2; $row <= $Filas; $row++){
            $matricula[] = $hoja->getCellByColumnAndRow(1,$row)->getValue();
            $c1[] = $hoja->getCellByColumnAndRow(2,$row)->getValue();
            $c2[] = $hoja->getCellByColumnAndRow(3,$row)->getValue();
            $c3[] = $hoja->getCellByColumnAndRow(4,$row)->getValue();
            $c4[] = $hoja->getCellByColumnAndRow(5,$row)->getValue();
            $c5[] = $hoja->getCellByColumnAndRow(6,$row)->getValue();
            $c6[] = $hoja->getCellByColumnAndRow(7,$row)->getValue();
            $c7[] = $hoja->getCellByColumnAndRow(8,$row)->getValue();

        }
        unlink($move);
        require 'vistas/' . self::$VISTA_EDITAR . '.php';
    }

    public function guardarCalificaciones()
    {
        if (empty($_POST)) {
            header('Location: ./');
        }
        date_default_timezone_set('UTC');
        date_default_timezone_set("America/Mexico_City");
        $var = '';
        $var = $_SESSION['Matricula'];

        $Periodo = $this->servicioP->obtenerActivo($var,1);

        $cant = $_POST['cantidad'] - 1;
        $parc = $_POST['parcial'];

        for ($i = 0; $i < $cant; $i++){
            $t = $i*8;
            $j = $t + 1;
            $k = $t + 2;
            $l = $t + 3;
            $m = $t + 4;
            $n = $t + 5;
            $o = $t + 6;
            $p = $t + 7;
            $q = $t + 8;

            $matricula = $_POST[$j];

            $alumno = $this->servicioU->obtenerPorId($matricula);

            if ($alumno != null){
                $nuevo = new Entidad();
                $nuevo->Usuario_Matricula = $alumno->Matricula;
                $nuevo->Cal1 = $_POST[$k];
                $nuevo->Cal2 = $_POST[$l];
                $nuevo->Cal3 = $_POST[$m];
                $nuevo->Cal4 = $_POST[$n];
                $nuevo->Cal5 = $_POST[$o];
                $nuevo->Cal6 = $_POST[$p];
                $nuevo->Cal7 = $_POST[$q];
                $nuevo->Parcial = $parc;
                $nuevo->Periodo = $Periodo->IdPeriodo;
                $nuevo->FechaRegistro = date("Y-m-d");
                $nuevo->save();
            }
        }

        ?>
        <script type='text/javascript'>
            alert('Calificaciones guardadas exitosamente'); 
            window.location.href ='index.php?vista=calificaciones';
        </script>";
        <?php
    }

    

    public function editar()
    {
        if (empty($_GET)) {
            header("Location: ./");
        }

        $servEvento = new Servicio();
        $eventos = $servEvento->obtenerTodos();
        $obj = $this->servicio->obtenerPorId($_GET["id"]);
        require 'vistas/' . self::$VISTA_EDITAR . '.php';
    }

    public function nuevo()
    {
        $servEvento = new Servicio();
        $eventos = $servEvento->obtenerTodos();
        require 'vistas/' . self::$VISTA_NUEVO . '.php';
    }
}

?>