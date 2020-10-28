<?php
namespace Controlador;

use Persistencia\Servicio\ServicioDisponibilidad as Servicio;
use Persistencia\Entidad\Disponibilidad as Entidad;
use Persistencia\Servicio\ServicioCita as ServicioC;
use Persistencia\Entidad\Cita as EntidadC;
use Persistencia\Servicio\ServicioUsuario as ServicioU;
use Persistencia\Entidad\Usuario as EntidadU;
use Persistencia\Servicio\ServicioUsuarioPeriodo as ServicioUP;
use Persistencia\Servicio\ServicioPeriodo as ServicioP;

class ControladorDisponibilidad
{
    private $servicio;
    private $servicioC;
    private $servicioU;
    private $servicioUP;
    private $servicioP;

    private static $VISTA_CONSULTAR = 'consultarDisponibilidad';
    private static $VISTA_EDITAR = 'editarDisponibilidad';
    private static $VISTA_NUEVO = 'nuevoDisponibilidad';

    private static $AGENDAR = 'agendarTutoria';
    private static $AGENDAR2 = 'agendarTutoria2';
    private static $AGENDAR3 = 'agendarTutoriaA';
    private static $AGENDAR4 = 'agendarTutoriaA2';

    public function __construct()
    {
        $this->servicio = new Servicio();
        $this->servicioC = new ServicioC();
        $this->servicioU = new ServicioU();
        $this->servicioUP = new ServicioUP();
        $this->servicioP = new ServicioP();
    }

    public function index()
    {
        $var = '';
        $var = $_SESSION['Matricula'];
        $objs = $this->servicio->obtenerPorMatricula($var);
        require 'vistas/' . self::$VISTA_CONSULTAR . '.php';
    }

    public function agendarAlumno(){
        $var = '';
        $var = $_SESSION['Matricula'];
        $objs = $this->servicioUP->obtenerAlumnos2($var);
        if (count($objs) > 0) {
            foreach ($objs as $obj) {
                $buscar = $this->servicioP->obtenerPorId($obj->Periodo_IdPeriodo);
                if ($buscar->Activo==1){
                    $tutor = $buscar->TutorMatricula;
                }
            }
        }

        $citas = [0,0,0,0,0];
        $reservas = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

        $objs = $this->servicio->obtenerPorMatricula($tutor);
        if (count($objs) > 0) {
            foreach ($objs as $obj) {
                $cita2 = $this->servicioC->obtenerPorTutor($obj->Id);
                $mes=date("n");
                $anio = date("Y");
                if($cita2!=null){
                    foreach($cita2 as $cit){
                        $fechaEntero = strtotime($cit->Fecha);
                        $anio2 = date("Y",$fechaEntero);
                        $mes2 = date("n",$fechaEntero);
                        $dia = date("j",$fechaEntero);
                        if($anio==$anio2 && $mes==$mes2){
                            $reservas[$dia]=$reservas[$dia]+1;
                        }
                    }
                    
                }
                
                
                switch ($obj->Dia) {
                    case '1':
                        $citas[0]=$citas[0]+1;
                        break;
                    case '2':
                        $citas[1]=$citas[1]+1;
                        break;
                    case '3':
                        $citas[2]=$citas[2]+1;
                        break;
                    case '4':
                        $citas[3]=$citas[3]+1;
                        break;
                    case '5':
                        $citas[4]=$citas[4]+1;
                        break;
                }
                 
            }
        }

        require 'vistas/' . self::$AGENDAR3 . '.php';
    }

    public function agendarAlumno2(){
        if (empty($_GET)) {

            header("Location: ./");
            
        }

        $citasDisponibles = array();
        $ids = array();

        $mes=date("m");
        $anio = date("Y");
        $dia = $_GET["id"];

        settype($mes, 'string');
        settype($anio, 'string');
        settype($dia, 'string');

        $guion = "-";

        $fecha = $anio.$guion.$mes.$guion.$dia;
        $fechaEntero = strtotime($fecha);
        $diaFecha = date("N",$fechaEntero);

        $var = '';
        $var = $_SESSION['Matricula'];
        $objs = $this->servicioUP->obtenerAlumnos2($var);
        if (count($objs) > 0) {
            foreach ($objs as $obj) {
                $buscar = $this->servicioP->obtenerPorId($obj->Periodo_IdPeriodo);
                if ($buscar->Activo==1){
                    $tutor = $buscar->TutorMatricula;
                }
            }
        }

        $objs = $this->servicio->obtenerPorDia($tutor,$diaFecha);
        if (count($objs) > 0) {
            foreach ($objs as $obj) {
                $val = $this->servicioC->verificarCita($fecha,$obj->Id);
                if($val == null){
                    $ids[] = $obj->Id;
                    $citasDisponibles[] = $obj->Horario;
                }
            }
        }

        require 'vistas/' . self::$AGENDAR4 . '.php';
    }

    public function agendar()
    {
        $citas = [0,0,0,0,0];
        $reservas = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $var = '';
        $var = $_SESSION['Matricula'];
        $objs = $this->servicio->obtenerPorMatricula($var);
        if (count($objs) > 0) {
            foreach ($objs as $obj) {
                $cita2 = $this->servicioC->obtenerPorTutor($obj->Id);
                $mes=date("n");
                $anio = date("Y");
                if($cita2!=null){
                    foreach($cita2 as $cit){
                        $fechaEntero = strtotime($cit->Fecha);
                        $anio2 = date("Y",$fechaEntero);
                        $mes2 = date("n",$fechaEntero);
                        $dia = date("j",$fechaEntero);
                        if($anio==$anio2 && $mes==$mes2){
                            $reservas[$dia]=$reservas[$dia]+1;
                        }
                    }
                    
                }
                
                
                switch ($obj->Dia) {
                    case '1':
                        $citas[0]=$citas[0]+1;
                        break;
                    case '2':
                        $citas[1]=$citas[1]+1;
                        break;
                    case '3':
                        $citas[2]=$citas[2]+1;
                        break;
                    case '4':
                        $citas[3]=$citas[3]+1;
                        break;
                    case '5':
                        $citas[4]=$citas[4]+1;
                        break;
                }
                 
            }
        }
        require 'vistas/' . self::$AGENDAR . '.php';
    }

    public function agendar2(){
        if (empty($_GET)) {

            header("Location: ./");
            
        }

        $citasDisponibles = array();
        $ids = array();

        $mes=date("m");
        $anio = date("Y");
        $dia = $_GET["id"];

        settype($mes, 'string');
        settype($anio, 'string');
        settype($dia, 'string');

        $guion = "-";

        $fecha = $anio.$guion.$mes.$guion.$dia;
        $fechaEntero = strtotime($fecha);
        $diaFecha = date("N",$fechaEntero);
        $var = '';
        $var = $_SESSION['Matricula'];
        $objs = $this->servicio->obtenerPorDia($var,$diaFecha);
        if (count($objs) > 0) {
            foreach ($objs as $obj) {
                $val = $this->servicioC->verificarCita($fecha,$obj->Id);
                if($val == null){
                    $ids[] = $obj->Id;
                    $citasDisponibles[] = $obj->Horario;
                }
            }
        }

        $mat = array();
        $nombre = array();

        $objetos = $this->servicioU->obtenerAlumnos();
        if (count($objetos) > 0) {
            foreach ($objetos as $obj) {
                $alum = $this->servicioU->obtenerPorId($obj->Usuario_Matricula);
                $mat[]=$alum->Matricula;
                $esp = " ";
                $name = $alum->Nombre.$esp.$alum->ApellidoP.$esp.$alum->ApellidoM;
                $nombre[] = $name;
            }
        }

        require 'vistas/' . self::$AGENDAR2 . '.php';
    }

    public function agregar()
    {
        if (empty($_POST)) {
            header('Location: ./');
        }

        $nuevo = new Entidad();
        $nuevo->Dia = $_POST['dias'];
        $nuevo->Horario = $_POST['hora'];
        $var = '';
        $var = $_SESSION['Matricula'];
        $nuevo->Usuario_Matricula = $var;
        $this->servicio->guardar($nuevo);
        header('Location: ./?vista=' . self::$VISTA_CONSULTAR);
    }

    public function guardar()
    {
        if (empty($_POST)) {
            header('Location: ./');
        }

        $obj = $this->servicio->obtenerPorId($_POST["id"]);
        $obj->Dia = $_POST['dias'];
        $obj->Horario = $_POST['hora'];
        $var = '';
        $var = $_SESSION['Matricula'];
        $obj->Usuario_Matricula = $var;
        $obj->save();
        header('Location: ./?vista=' . self::$VISTA_CONSULTAR);
    }

    public function eliminar()
    {
        if (empty($_GET)) {
            header("Location: ./");
        }

        $id = $_GET["id"];
        $obj = $this->servicio->obtenerPorId($id);
        $direc="vistas/Imagenes/".$obj->Ruta;
        unlink($direc);
        $this->servicio->eliminar($id);
        header('Location: ./?vista=' . self::$VISTA_CONSULTAR);
    }

    public function editar()
    {
        if (empty($_GET)) {
            header("Location: ./");
        }

        $servDisp = new Servicio();
        $Disp = $servDisp->obtenerTodos();
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