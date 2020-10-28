<?php

namespace Controlador;
session_start();
use Persistencia\Servicio\ServicioUsuario as Servicio;
use Persistencia\Entidad\Usuario as Entidad;
use Persistencia\Servicio\ServicioEvento as ServicioE;
use Persistencia\Entidad\Evento as EntidadE;
use Persistencia\Servicio\ServicioPeriodo as ServicioP;
use Persistencia\Entidad\Periodo as EntidadP;
use Persistencia\Servicio\ServicioUsuarioPeriodo as ServicioUP;
use Persistencia\Entidad\Usuario_periodo as EntidadUP;
use Persistencia\Servicio\ServicioDisponibilidad as ServicioD;
use Persistencia\Servicio\ServicioCita as ServicioC;
use Persistencia\Servicio\ServicioNotificaciones as ServicioN;
use Persistencia\Entidad\Notificaciones as EntidadN;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class ControladorUsuario
{
    private $servicio;
    private $servicioE;
    private $servicioP;
    private $servicioUP;
    private $servicioC;
    private $servicioD;
    private $servicioN;
    
    private static $VISTA_INICIO = 'inicioSesion';
    private static $VISTA_PRINCIPAL = 'paginaPrincipalAdmin';
    private static $VISTA_PRINCIPAL2 = 'paginaPrincipalTutor';
    private static $VISTA_PRINCIPAL3 = 'paginaPrincipalAlumno';

    private static $VISTA_ADMIN = 'consultarAdministradores';
    private static $VISTA_ADMIN2 = 'consultarAdmin';
    private static $VISTA_TUTOR = 'consultarTutores';
    private static $VISTA_TUTOR2 = 'consultarTutor';
    private static $VISTA_ALUMNO = 'consultarAlumnos';
    private static $VISTA_ALUMNO2 = 'consultarAlumno';

    private static $VISTA_NUEVO_ADMIN = 'nuevoAdministrador';
    private static $VISTA_NUEVO_TUTOR = 'nuevoTutor';
    private static $VISTA_NUEVO_ALUMNO = 'nuevoAlumno';

    private static $VISTA_EDITAR_ADMIN = 'editarAdministrador';
    private static $VISTA_EDITAR_TUTOR = 'editarTutor';
    private static $VISTA_EDITAR_ALUMNO = 'editarAlumno';

    private static $VISTA_TRANSITAR = 'transitar';

    public function __construct()
    {
        $this->servicio = new Servicio();
        $this->servicioE = new ServicioE();
        $this->servicioP = new ServicioP();
        $this->servicioUP = new ServicioUP();
        $this->servicioC = new ServicioC();
        $this->servicioD = new ServicioD();
        $this->servicioN = new ServicioN();
    }

    public function index()
    {
        
        require 'vistas/' . self::$VISTA_INICIO . '.php';
    }


    public function conAdmin(){
        $tipo=1;
        $objs = $this->servicio->obtenerAdmins($tipo);
        require 'vistas/' . self::$VISTA_ADMIN . '.php';
    }

    public function conTutor(){
        $tipo=2;
        $objs = $this->servicio->obtenerTutores($tipo);
        require 'vistas/' . self::$VISTA_TUTOR . '.php';
    }

    
    public function conAlumno(){
        $mat = array();
        $nombre = array();
        $AP = array();
        $AM = array();
        $objetos = $this->servicio->obtenerAlumnos();
        if (count($objetos) > 0) {
            foreach ($objetos as $obj) {
                $alum = $this->servicio->obtenerPorId($obj->Usuario_Matricula);
                $mat[]=$alum->Matricula;
                $nombre[] = $alum->Nombre;
                $AP[] = $alum->ApellidoP;
                $AM[] = $alum->ApellidoM;
            }
        }
        
        require 'vistas/' . self::$VISTA_ALUMNO . '.php';
    }

    public function volverInicio(){
        $nuevo = new Entidad();
        $nuevo = $this->servicio->obtenerPorId($_SESSION['Matricula']);
        $objs = $this->servicioE->obtenerTodos();
        switch ($nuevo->TipoUsuario) {
        case '1':
            require 'vistas/' . self::$VISTA_PRINCIPAL . '.php';
            break;
        case '2':
            require 'vistas/' . self::$VISTA_PRINCIPAL2 . '.php';
            break;
        case '3':
            require 'vistas/' . self::$VISTA_PRINCIPAL3 . '.php';
            break;
                
        }
    }

    public function validarUsuario()
    {

        if (empty($_POST)) {
            header('Location: ./');
        }

        $nuevo = new Entidad();
        $nuevo->Matricula = $_POST['matricula'];
        $nuevo->Contrasena = $_POST['contra'];
        $nuevo2 = $this->servicio->verificar($nuevo);

        if(empty($nuevo2))
        {
            $message = "No se tiene registro del usuario y/o contraseña";
            session_destroy();
            echo "<script type='text/javascript'>alert('$message');</script>";
            require 'vistas/' . self::$VISTA_INICIO . '.php';
        }else{
            $objs = $this->servicioE->obtenerTodos();
            
            $_SESSION['Matricula'] = $nuevo2->Matricula;
            //echo "<script type='text/javascript'>alert('$var');</script>";
            switch ($nuevo2->TipoUsuario) {
                case '1':
                    require 'vistas/' . self::$VISTA_PRINCIPAL . '.php';
                    break;
                case '2':
                    $this->mandarNotificaciones();
                    require 'vistas/' . self::$VISTA_PRINCIPAL2 . '.php';
                    break;
                case '3':
                    require 'vistas/' . self::$VISTA_PRINCIPAL3 . '.php';
                    break;
                
            }
            
        }
        
    }

    public function mandarNotificaciones(){

        date_default_timezone_set('UTC');
        date_default_timezone_set("America/Mexico_City");
        $fechaHoy = date("Y-m-d");
        $fechaActual = strtotime($fechaHoy);
        $var = $_SESSION['Matricula'];
        $verificar = $this->servicioN->obtenerPorId($var,$fechaHoy);
        if(empty($verificar)){
            $notif = new EntidadN();
            $notif->Matricula_tutor = $var;
            $notif->Fecha = $fechaHoy;
            $this->servicioN->guardar($notif);
            $correos = array();
            $disponibilidad = $this->servicioD->obtenerPorMatricula($var);
            foreach ($disponibilidad as $disp) {
                $citas = $this->servicioC->obtenerPorTutor($disp->Id);
                foreach ($citas as $cita) {
                    $fechaDada = strtotime($cita->Fecha);
                    $dias = ($fechaDada-$fechaActual)/86400;
                    if($dias > 0){
                        $dias = floor($dias);
                        if($dias == 1){
                            $correos[] = $cita->Alumno;
                        }
                    }
                }

            }

            if(count($correos) > 0){
                $extension = "@upemor.edu.mx";
                
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
                    foreach ($correos as $correo) {
                        $Alumno = strtolower($correo);
                        $correoAlumno = $Alumno.$extension;
                        $mail->addAddress($correoAlumno); 
                    }

                    $tutor = strtolower($var);
                    $correoTutor = $tutor.$extension;
                    $mail->addAddress($correoTutor);

                    $mail->isHTML(true);                                  
                    $mail->Subject = 'Recordatorio Cita Tutoría';
                    $mail->Body    = 'Recuerda que tienes una(s) cita(s) para tutorías el día de mañana';
                    
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
            }     
        }  
    }

    public function agregar()
    {
        if (empty($_POST)) {
            header('Location: ./');
        }

        $nuevo = new Entidad();
        
        $nuevo->Matricula = $_POST['matricula'];
        $nuevo->Nombre = $_POST['nombre'];
        $nuevo->ApellidoP = $_POST['apellidoP'];
        $nuevo->ApellidoM = $_POST['apellidoM'];
        $nuevo->FechaN = $_POST['fechaN'];
        $nuevo->TipoUsuario = $_POST['tipo'];
        $nuevo->Contrasena = md5($_POST['matricula']);
        $nuevo->PrimerInicio = 1;

        $nuevo2 = $this->servicio->obtenerPorId($nuevo->Matricula);

        if(empty($nuevo2))
        {
            $this->servicio->guardar($nuevo);
            switch ($nuevo->TipoUsuario) {
                case '1':
                     header('Location: ./?vista=' . self::$VISTA_ADMIN2);
                     break;
                case '2':
                     header('Location: ./?vista=' . self::$VISTA_TUTOR2);
                     break;
                case '3':
                     $nuevoP = $this->servicio->obtenerActivo();
                     $alumno = new EntidadUP();
                     $alumno->Periodo_IdPeriodo = $nuevoP->IdPeriodo;
                     $alumno->Usuario_Matricula = $nuevo->Matricula;
                     $nuevoUP = $this->servicioUP->guardar($alumno);
                     header('Location: ./?vista=' . self::$VISTA_ALUMNO2);
                     break;

             } 
             
        }else{
            switch ($nuevo->TipoUsuario) {
                case '1':
                    ?>
                    <script type='text/javascript'>
                    alert('La matrícula está siendo utilizada por un Administrador actualmente'); 
                    window.location.href ='index.php?vista=consultarAdmin';
                    </script>";
                    <?php
                    break;

                case '2':
                    ?>
                    <script type='text/javascript'>
                    alert('La matrícula está siendo utilizada por un Tutor actualmente'); 
                    window.location.href ='index.php?vista=consultarTutor';
                    </script>";
                    <?php
                    break;

                case '3':
                    ?>
                    <script type='text/javascript'>
                    alert('La matrícula está siendo utilizada por un alumno actualmente'); 
                    window.location.href ='index.php?vista=consultarAlumno';
                    </script>";
                    <?php
                    break;
            }
        }   
    }

    public function guardar()
    {
        if (empty($_POST)) {
            header('Location: ./');
        }

        $obj = $this->servicio->obtenerPorId($_POST["matricula"]);

        $obj->Nombre = $_POST['nombre'];
        $obj->ApellidoP = $_POST['apellidoP'];
        $obj->ApellidoM = $_POST['apellidoM'];
        $obj->FechaN = $_POST['fechaN'];

        switch ($obj->TipoUsuario) {
        case '1':
            $obj->save();
            ?>
            <script type='text/javascript'>
            alert('Administrador editado correctamente'); 
            window.location.href ='index.php?vista=consultarAdmin';
            </script>";
            <?php
            break;
        case '2':
            $obj->PrimerInicio = $_POST['estatus'];
            $obj->save();
            ?>
            <script type='text/javascript'>
            alert('Tutor editado correctamente'); 
            window.location.href ='index.php?vista=consultarTutor';
            </script>";
            <?php
            break;
        case '3':
            $obj->save();
            ?>
            <script type='text/javascript'>
            alert('Alumno editado correctamente'); 
            window.location.href ='index.php?vista=consultarAlumno';
            </script>";
            <?php
            break;
                
        }

    }

    public function eliminar()
    {
        if (empty($_GET)) {
            header("Location: ./");
        }

        $id = $_GET["id"];
        $this->servicio->eliminar($id);
        header('Location: ./?vista=' . self::$VISTA_ADMIN2);
    }

    public function editar()
    {
        if (empty($_GET)) {
            header("Location: ./");
        }

        $obj = $this->servicio->obtenerPorId($_GET["id"]);

        switch ($obj->TipoUsuario) {
        case '1':
            require 'vistas/' . self::$VISTA_EDITAR_ADMIN . '.php';
            break;
        case '2':
            require 'vistas/' . self::$VISTA_EDITAR_TUTOR . '.php';
            break;
        case '3':
            require 'vistas/' . self::$VISTA_EDITAR_ALUMNO . '.php';
            break;
                
        }
    }

    public function nuevoAdmin()
    {
        require 'vistas/' . self::$VISTA_NUEVO_ADMIN . '.php';
    }

    public function nuevoTutor()
    {
        require 'vistas/' . self::$VISTA_NUEVO_TUTOR . '.php';
    }

    public function nuevoAlumno()
    {
        require 'vistas/' . self::$VISTA_NUEVO_ALUMNO . '.php';
    }

    public function cerrarSesion(){
        session_destroy();
        require 'vistas/' . self::$VISTA_INICIO . '.php';
    }

    public function transitar(){
        $Periodos = $this->servicioP->obtenerActivosP(1);
        $Tutores = $this->servicio->obtenerTutores(2);
        require 'vistas/' . self::$VISTA_TRANSITAR . '.php';
    }

    public function transitarCuatrimestre(){
        $Periodos = $this->servicioP->obtenerActivosP(1);
        $NumPeriodos = count($Periodos);
        foreach ($Periodos as $Periodo) {
            $estacion = $Periodo->Periodo;
            break;
        }

        switch ($estacion) {
            case 'Otoño':
                $nuevoPeriodo = "Invierno";
                break;
            case 'Invierno':
                $nuevoPeriodo = "Primavera";
                break;
            case 'Primavera':
                $nuevoPeriodo = "Otoño";
                break;
        }

        $anio=date("Y");
        $i = 0;

        //Creación de nuevos grupos a partir de los existentes
        foreach ($Periodos as $Periodo) {
            $j = $i*2;
            $k = $j + 1;
            $l = $j + 2;
            $i = $i + 1;
            $Alumnos = $this->servicioUP->obtenerPorPeriodo($Periodo->IdPeriodo);
            $obj = $this->servicioP->obtenerPorId($Periodo->IdPeriodo);
            $obj->Activo = 0;
            $obj->save();

            $buscarPeriodo = $this->servicioP->obtenerPeriodo($_POST[$k],$_POST[$l],$anio,$nuevoPeriodo);
            if(empty($buscarPeriodo)){
                $nuevoP = new EntidadP();
                $nuevoP->Grado = $_POST[$k];
                $nuevoP->Grupo = $_POST[$l];
                $nuevoP->Periodo = $nuevoPeriodo;
                $nuevoP->AnoGrupo = $anio;
                $nuevoP->Activo = 1;
                $nuevoP->TutorMatricula = "N";

                $nuevo = $this->servicioP->guardar($nuevoP);

                foreach ($Alumnos as $Alumno) {
                    $union = new EntidadUP();
                    $union->Usuario_Matricula = $Alumno->Usuario_Matricula;
                    $union->Periodo_IdPeriodo = $nuevo;
                    $union->save();
                }
            }else{
                foreach ($Alumnos as $Alumno) {
                    $union = new EntidadUP();
                    $union->Usuario_Matricula = $Alumno->Usuario_Matricula;
                    $union->Periodo_IdPeriodo = $buscarPeriodo->IdPeriodo;
                    $union->save();
                }
            }
        }

        //Ajuste de tutores
        $Tutores = $this->servicio->obtenerTutores(2);
        foreach ($Tutores as $Tutor) {
            $j=$i*2;
            $k=$j+1;
            $l=$j+2;
            $i=$i+1;

            if($_POST[$k]!=null && $_POST[$l]!=null){
                $buscarPeriodo = $this->servicioP->obtenerPeriodo($_POST[$k],$_POST[$l],$anio,$nuevoPeriodo);
                if(empty($buscarPeriodo)){
                    $nuevoP = new EntidadP();
                    $nuevoP->Grado = $_POST[$k];
                    $nuevoP->Grupo = $_POST[$l];
                    $nuevoP->Periodo = $nuevoPeriodo;
                    $nuevoP->AnoGrupo = $anio;
                    $nuevoP->Activo = 1;
                    $nuevoP->TutorMatricula = $Tutor->Matricula;

                    $nuevo = $this->servicioP->guardar($nuevoP);

                }else{
                    $buscarPeriodo->TutorMatricula = $Tutor->Matricula;
                    $buscarPeriodo->save();
                }
            }
        }

        ?>
        <script type='text/javascript'>
            alert('Se transitó al siguiente cuatrimestre exitosamente'); 
            window.location.href ='index.php?vista=volver';
        </script>";
        <?php

    }
}

?>