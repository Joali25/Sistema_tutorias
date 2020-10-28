<?php

namespace Controlador;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Persistencia\Servicio\ServicioCuestionario as Servicio;
use Persistencia\Entidad\Cuestionario as Entidad;

use Persistencia\Servicio\ServicioCuestionarioPreguntas as ServicioCP;
use Persistencia\Entidad\Cuestionario_preguntas as EntidadCP;

use Persistencia\Servicio\ServicioPreguntasCuestionario as ServicioPC;
use Persistencia\Entidad\Preguntas_cuestionario as EntidadPC;

use Persistencia\Servicio\ServicioRespuesta as ServicioR;
use Persistencia\Entidad\Respuesta as EntidadR;

use Persistencia\Servicio\ServicioPeriodo as ServicioP;
use Persistencia\Entidad\Periodo as EntidadP;
use Persistencia\Servicio\ServicioUsuarioPeriodo as ServicioUP;

class ControladorCuestionario
{
    private $servicio;
    private $servicioCP;
    private $servicioPC;
    private $servicioP;
    private $servicioUP;
    private $servicioR;
    private static $VISTA_CONSULTAR = 'consultarCuestionarios';
    private static $VISTA_EDITAR = 'editarCuestionario';
    private static $VISTA_NUEVO = 'nuevoCuestionario';
    private static $VISTA_PREGUNTAS = 'agregarPreguntas';
    private static $VISTA_CUESTIONARIOS = 'cuestionarios';
    private static $VISTA_CUESTIONARIOS_A = 'cuestionariosAlumno';
    private static $VISTA_CUESTIONARIO_CONTESTAR = 'contestarCuestionario';

    public function __construct()
    {
        $this->servicio = new Servicio();
        $this->servicioCP = new ServicioCP();
        $this->servicioPC = new ServicioPC();
        $this->servicioP = new ServicioP();
        $this->servicioUP = new ServicioUP();
        $this->servicioR = new ServicioR();
    }

    public function index()
    {
        $var = '';
        $var = $_SESSION['Matricula'];
        $objs = $this->servicio->obtenerPorTutor($var);
        require 'vistas/' . self::$VISTA_CONSULTAR . '.php';
    }

    public function verCuestionarios(){

        $activo = 1;
        $objs = $this->servicioP->obtenerActivosP($activo);

        $var = '';
        $var = $_SESSION['Matricula'];

        foreach ($objs as $obj) {
            
            $periodo = $this->servicioUP->obtenerPorId($obj->IdPeriodo,$var);
            if($periodo != null){
                break;
            }
        }
        $contestado = array();
        $cuestionarios = $this->servicio->obtenerPorPeriodo($periodo->Periodo_IdPeriodo);
        $i=0;
        foreach ($cuestionarios as $cuestionario) {
            $union = $this->servicioCP->obtenerPreguntas($cuestionario->Id);
            $contestado[] = 0;
            foreach ($union as $uni) {
                $verificar = $this->servicioR->buscarRespuesta($var,$uni->Preguntas_cuestionario_Id);
                if($verificar != null){
                    $contestado[$i] = 1;
                    break;
                }
            }
            $i=$i+1;
        }

        require 'vistas/' . self::$VISTA_CUESTIONARIOS_A . '.php';

    }

    public function contestarCuestionario(){
        if (empty($_GET)) {
            header("Location: ./");
        }

        $id = $_GET["id"];
        $cuest = $this->servicio->obtenerPorId($id);
        $uniones = $this->servicioCP->obtenerPreguntas($id);
        $cantidad = count($uniones);
        $reactivos = array();
        foreach ($uniones as $union) {
            $obj = $this->servicioPC->obtenerPorId($union->Preguntas_cuestionario_Id);
            $reactivos[] = $obj;
        }

        require 'vistas/' . self::$VISTA_CUESTIONARIO_CONTESTAR . '.php';
    }

    public function guardarRespuestas(){
        if (empty($_POST)) {
            header('Location: ./');
        }
        $var = '';
        $var = $_SESSION['Matricula'];
        $cant = $_POST['cant'];
        for($i=0; $i<$cant;$i++){
            $t = $i*2;
            $j = $t + 1;
            $k = $t + 2;

            $nuevaR = new EntidadR();
            $nuevaR->Respuesta_Id = $_POST[$j];
            $nuevaR->Alumno = $var;
            $nuevaR->Valor = $_POST[$k];
            $nuevaR->save();

        }
        ?>
        <script type='text/javascript'>
            alert('Respuestas guardadas correctamente'); 
            window.location.href ='index.php?vista=verCuestionarios';
        </script>";
        <?php
    }

    public function nuevoCuestionario(){
        require 'vistas/' . self::$VISTA_NUEVO . '.php';
    }

    public function agregar()
    {
        if (empty($_POST)) {
            header('Location: ./');
        }
        $var = '';
        $var = $_SESSION['Matricula'];

        $nuevo = new Entidad();
        $nuevo->Nombre = $_POST['nombre'];
        $nuevo->Fecha = date("Y-m-d");
        $act = 1;
        $per = $this->servicioP->obtenerActivo($var,$act);
        $nuevo->Periodo = $per->IdPeriodo;
        $nuevo->Usuario_Matricula = $var;
        $cantidad = $_POST['num'];
        $idCuestionario = $this->servicio->guardar($nuevo);
        require 'vistas/' . self::$VISTA_PREGUNTAS . '.php';
    }

    public function agregarPreguntas(){
        if (empty($_POST)) {
            header('Location: ./');
        }

        $cant = $_POST['cantidad2'];
        $idCuestionario = $_POST['idC'];
        for($i=0; $i<$cant;$i++){
            $t = $i*5;
            $j = $t + 1;
            $k = $t + 2;
            $l = $t + 3;
            $m = $t + 4;
            $n = $t + 5;
            $nuevaPregunta = new EntidadPC();
            $union = new EntidadCP();
            
            $nuevaPregunta->Pregunta = $_POST[$j];
            $nuevaPregunta->Respuesta1 = $_POST[$k];
            $nuevaPregunta->Respuesta2 = $_POST[$l];
            $nuevaPregunta->Respuesta3 = $_POST[$m];
            $nuevaPregunta->Respuesta4 = $_POST[$n];
            $New1 = $this->servicioPC->guardar($nuevaPregunta);

            $union->Cuestionario_Id = $idCuestionario;
            $union->Preguntas_cuestionario_Id = $New1;

            $this->servicioCP->guardar($union);
        }

        //SE ENVÍA CORREO A LOS ALUMNOS PARA NOTIFICAR QUE HAY UN CUESTIONARIO
        
        $mail = new PHPMailer(true);

        try {
                //Configuraciones del servidor
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->SMTPDebug = 0;                      
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.gmail.com';                    
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'sistema.tutorias.upemor@gmail.com';              
            $mail->Password   = 'sistema123';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;                                    

            $mail->setFrom('sistema.tutorias.upemor@gmail.com', 'Sistema Tutorías');

            //SE AÑADEN LOS CORREO DE LOS ALUMNOS
            $var = $_SESSION['Matricula'];
            $extension = "@upemor.edu.mx";
            $periodo = $this->servicioP->obtenerActivo($var,1);

            $Alumnos = $this->servicioUP->obtenerPorPeriodo($periodo->IdPeriodo);

            foreach ($Alumnos as $Alumno) {
                $matricula = strtolower($Alumno->Usuario_Matricula);
                $correo = $matricula.$extension;
                $mail->addAddress($correo);
            }
            
            $mail->isHTML(true);                                  
            $mail->Subject = 'NUEVO CUESTIONARIO';
            $mail->Body    = 'Tu tutor ha asignado un nuevo cuestionario.
            Resuelvelo lo antes posible.
            Para ver los cuestionarios por realizar ingresa al sistema de tutorías y selecciona la opción "Cuestionarios" del menú de opciones.';
            $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
            );
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        header('Location: ./?vista=' . self::$VISTA_CUESTIONARIOS);
    }

    public function guardar()
    {
        if (empty($_POST)) {
            header('Location: ./');
        }

        //GUARDA LOS CAMBIOS EN EL NOMBRE DEL CUESTIONARIO
        $obj = $this->servicio->obtenerPorId($_POST["idC"]);
        $obj->Nombre = $_POST['nombre'];
        $obj->save();

        $num = $_POST['cant'];
        
        for($i=0; $i<$num;$i++){
            $t = $i*6;
            $j = $t + 1;
            $k = $t + 2;
            $l = $t + 3;
            $m = $t + 4;
            $n = $t + 5;
            $o = $t + 6;

            $idPregunta = $_POST[$j];
            $objP = $this->servicioPC->obtenerPorId($idPregunta);
            $objP->Pregunta = $_POST[$k];
            $objP->Respuesta1 = $_POST[$l];
            $objP->Respuesta2 = $_POST[$m];
            $objP->Respuesta3 = $_POST[$n];
            $objP->Respuesta4 = $_POST[$o];
            $objP->save();
        }

        ?>
        <script type='text/javascript'>
            alert('Cuestionario editado correctamente'); 
            window.location.href ='index.php?vista=cuestionarios';
        </script>";
        <?php
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
        $preguntas = array();
        $obj = $this->servicio->obtenerPorId($_GET["id"]);
        $uniones =  $this->servicioCP->obtenerPreguntas($obj->Id);
        $cantidad = 0;
        foreach ($uniones as $union) {
            $quest = $this->servicioPC->obtenerPorId($union->Preguntas_cuestionario_Id);
            $preguntas[] = $quest;
            $cantidad = $cantidad+1;
        }

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