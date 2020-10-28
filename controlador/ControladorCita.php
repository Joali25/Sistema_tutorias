<?php

namespace Controlador;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Persistencia\Servicio\ServicioCita as Servicio;
use Persistencia\Entidad\Cita as Entidad;
use Persistencia\Servicio\ServicioDisponibilidad as ServicioD;
use Persistencia\Entidad\Disponibilidad as EntidadD;
use Persistencia\Servicio\ServicioUsuario as ServicioU;
use Persistencia\Entidad\Formato as EntidadF;
use Persistencia\Servicio\ServicioFormato as ServicioF;
use Persistencia\Entidad\Formato_respuestas as EntidadFR;
use Persistencia\Servicio\ServicioFormatoRespuestas as ServicioFR;

class ControladorCita
{
    private $servicio;
    private static $VISTA_CONSULTAR = 'agendar';
    private static $VISTA_EDITAR = 'editarEvento';
    private static $VISTA_NUEVO = 'nuevoEvento';
    private static $VISTA_CONSULTAR2 = 'agendarA';
    private static $VISTA_CONSULTAR_CITA = 'consultarCitas';
    private static $VISTA_ASISTENCIA = 'confirmacionCita';
    private static $VISTA_FORMATO = 'formatoTutoria';
    private static $VISTA_REGISTRO = 'verRegistro';

    public function __construct()
    {
        $this->servicio = new Servicio();
        $this->servicioD = new ServicioD();
        $this->servicioU = new ServicioU();
        $this->servicioF = new ServicioF();
        $this->servicioFR = new ServicioFR();
    }

    public function index()
    {
        $objs = $this->servicio->obtenerTodos();
        require 'vistas/' . self::$VISTA_CONSULTAR . '.php';
    }

    public function agregar()
    {
        if (empty($_POST)) {
            header('Location: ./');
        }

        $nuevo = new Entidad();
        $nuevo->Fecha = $_POST['fecha'];
        $nuevo->Asistencia = 0;
        $nuevo->Alumno = $_POST['alumno'];
        $nuevo->Disponibilidad_horario_Id = $_POST['horario'];
        $this->servicio->guardar($nuevo);
        header('Location: ./?vista=' . self::$VISTA_CONSULTAR);
    }

    public function agregarAlumno()
    {
        if (empty($_POST)) {
            header('Location: ./');
        }

        $nuevo = new Entidad();
        $nuevo->Fecha = $_POST['fecha'];
        $nuevo->Asistencia = 0;
        $nuevo->Alumno = $_POST['alumno'];
        $nuevo->Disponibilidad_horario_Id = $_POST['horario'];
        $this->servicio->guardar($nuevo);
        header('Location: ./?vista=' . self::$VISTA_CONSULTAR2);
    }


    public function confirmarAsistencia(){
        if (empty($_GET)) {
            header('Location: ./');
        }

        $idCita = $_GET["id"];
        require 'vistas/' . self::$VISTA_ASISTENCIA . '.php';
    }

    public function confirmarAsistenciaAlumno(){
        if (empty($_POST)) {
            header('Location: ./');
        }
        $obj = $this->servicio->obtenerPorId($_POST["id"]);
        if ($_POST["estatus"]==1){
            $obj->Asistencia = 1;
            $obj->save();
            $activo = 1;
            $campos = $this->servicioF->obtenerActivos($activo);
            require 'vistas/' . self::$VISTA_FORMATO . '.php';

        }else{
            $extension = "@upemor.edu.mx";
            $Alumno = strtolower($obj->Alumno);
            $correo = $Alumno.$extension;
            $mail = new PHPMailer(true);

            try {
                $mail->SMTPDebug = 0;                      
                $mail->isSMTP();                                            
                $mail->Host       = 'smtp.gmail.com';                    
                $mail->SMTPAuth   = true;                                   
                $mail->Username   = 'sistema.tutorias.upemor@gmail.com';                  
                $mail->Password   = 'sistema123';                               
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;                                    

                //Recipients
                $mail->setFrom('sistema.tutorias.upemor@gmail.com', 'Sistema Tutorías');
                $mail->addAddress($correo);     
                $mail->isHTML(true);                                  
                $mail->Subject = 'Prueba';
                $mail->Body    = 'Se ha colocado la inasistencia a tu cita de tutoría';
                
                $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
                );
                $mail->send();
                ?>
                <script type='text/javascript'>
                    alert('Se ha notificado al alumno de su inasistencia'); 
                    window.location.href ='index.php?vista=volver';
                </script>";
            <?php
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }

    public function envioMail($obj){

        
    }

    public function guardarRespuestas(){
        if (empty($_POST)) {
            header('Location: ./');
        }
        $activo=1;
        $campos = $this->servicioF->obtenerActivos($activo);
        $cantidad = 1;
        foreach ($campos as $campo) {
            $nuevo = new EntidadFR();
            $nuevo->Cita_tutoria_Id_tutoria = $_POST["id"];
            $nuevo->Formato_tutorias_Id = $campo->Id;
            $nuevo->Respuesta = $_POST[$cantidad];
            $this->servicioFR->guardar($nuevo);
            $cantidad = $cantidad+1;
        }
        ?>
        <script type='text/javascript'>
            alert('Respuestas registradas correctamente'); 
            window.location.href ='index.php?vista=verCitas';
        </script>";
        <?php

    }

    public function verRegistro(){

        if (empty($_GET)) {
            header('Location: ./');
        }

        $idCita = $_GET["id"];
        $cita = $this->servicio->obtenerPorId($idCita);
        $hora = $this->servicioD->obtenerPorId($cita->Disponibilidad_horario_Id);
        $alum = $this->servicioU->obtenerPorId($cita->Alumno);
        $esp = " ";
        $name = $alum->Nombre.$esp.$alum->ApellidoP.$esp.$alum->ApellidoM;
        $preguntas = array();
        $respuestas = array();
        $registros = $this->servicioFR->obtenerPorCita2($cita->Id_tutoria);
        if(count($registros)>0){
            foreach ($registros as $registro) {
                $respuestas[] = $registro->Respuesta;
                $question = $this->servicioF->obtenerPorId($registro->Formato_tutorias_Id);
                $preguntas[] = $question->Campo;
            }
        }
        require 'vistas/' . self::$VISTA_REGISTRO . '.php';
    }

    public function verCitas(){
        $ids1 = array();
        $previas = array();
        $horarios1 = array();
        $nombres1 = array();

        $ids2 = array();
        $hoy = array();
        $horarios2 = array();
        $nombres2 = array();
        $contestados = array();

        $ids3 = array();
        $futuras = array();
        $horarios3 = array();
        $nombres3 = array();
        date_default_timezone_set('UTC');
        date_default_timezone_set("America/Mexico_City");
        $fechaActual = strtotime(date("Y-m-d"));
        $var = '';
        $var = $_SESSION['Matricula'];
        $objs = $this->servicioD->obtenerPorMatricula($var);

        if (count($objs) > 0) {
            foreach ($objs as $obj) {
                $citas = $this->servicio->obtenerPorTutor($obj->Id);
                if (count($citas) > 0) {
                    foreach ($citas as $cita) {
                        $fechaCita = strtotime($cita->Fecha);
                        if($fechaActual==$fechaCita){
                            $ids2[] = $cita->Id_tutoria;
                            $hoy[]= $cita->Fecha;
                            $horarios2[] = $obj->Horario;
                            $contestados[] = $cita->Asistencia;
                            $alum = $this->servicioU->obtenerPorId($cita->Alumno);
                            $esp = " ";
                            $name = $alum->Nombre.$esp.$alum->ApellidoP.$esp.$alum->ApellidoM;
                            $nombres2[] = $name;

                        }
                        if($fechaCita<$fechaActual){
                            $ids1[] = $cita->Id_tutoria;
                            $previas[]= $cita->Fecha;
                            $horarios1[] = $obj->Horario;
                            $alum = $this->servicioU->obtenerPorId($cita->Alumno);
                            $esp = " ";
                            $name = $alum->Nombre.$esp.$alum->ApellidoP.$esp.$alum->ApellidoM;
                            $nombres1[] = $name;
                        }
                        
                        if($fechaCita>$fechaActual){
                            $ids3[] = $cita->Id_tutoria;
                            $futuras[]= $cita->Fecha;
                            $horarios3[] = $obj->Horario;
                            $alum = $this->servicioU->obtenerPorId($cita->Alumno);
                            $esp = " ";
                            $name = $alum->Nombre.$esp.$alum->ApellidoP.$esp.$alum->ApellidoM;
                            $nombres3[] = $name;

                        }

                    }
                }
            }
        }
        require 'vistas/' . self::$VISTA_CONSULTAR_CITA . '.php';

    }
}

?>