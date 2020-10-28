<?php

//Este archivo cumple la función de routeador, en el cual, se acuerdo a ciertas llamadas con la función $_GET, se llaman las funciones pertinentes para realizar la acción deseada.

//También se llama al archivo bootloader que contiene la llamada a los demás archivos.
require "bootloader.php";

//Se hace uso de los archivos del módulo de Controlador
use Controlador\ControladorUsuario;
use Controlador\ControladorEvento;
use Controlador\ControladorFormato;
use Controlador\ControladorDisponibilidad;
use Controlador\ControladorCita;
use Controlador\ControladorCuestionario;
use Controlador\ControladorCalificaciones;
use Controlador\ControladorRespaldo;
use Controlador\ControladorReportes;
use Controlador\ControladorDomicilio;

//Se crean las variables para los controladores de cada requisito.
$contUsuario = new ControladorUsuario();
$contEvento = new ControladorEvento();
$contFormato = new ControladorFormato();
$contDisponibilidad = new ControladorDisponibilidad();
$contCita = new ControladorCita();
$contCuestionario = new ControladorCuestionario();
$contCalificaciones = new ControladorCalificaciones();
$contRespaldo = new ControladorRespaldo();
$contReportes = new ControladorReportes();
$contDomicilio = new ControladorDomicilio();

$vista = $_GET["vista"];

//De acuerdo a lo que se obtenga de la funcion $_GET se va a llamar cierta función.
switch ($vista) {

    case 'mail':
        $contCita->pruebaMail();
        break;
        
    case 'inicioSesion':
        $contUsuario->validarUsuario();
        break;
    case 'cerrarSesion':
        $contUsuario->cerrarSesion();
        break;
    case 'volver':
        $contUsuario->volverInicio();
        break;

    //USUARIO
    case 'consultarAdmin':
        $contUsuario->conAdmin();
        break;

    case 'consultarTutor':
        $contUsuario->conTutor();
        break;

    case 'consultarAlumno':
        $contUsuario->conAlumno();
        break; 

    case 'agregarUsuario':
        $contUsuario->agregar();
        break;

    case 'nuevoAdmin':
        $contUsuario->nuevoAdmin();
        break;

    case 'nuevoTutor':
        $contUsuario->nuevoTutor();
        break;

    case 'nuevoAlumno':
        $contUsuario->nuevoAlumno();
        break;

    case 'editarUsuario':
        $contUsuario->editar();
        break;
        
    case 'guardarUsuario':
        $contUsuario->guardar();
        break;

    case 'eliminarUsuario':
        $contUsuario->eliminar();
        break;

    //DOMICILIO

    case 'domicilio':
        $contDomicilio->index();
        break;

    case 'guardarDomicilio':
        $contDomicilio->guardar();
        break;

    //EVENTO
    case 'consultarEvento':
        $contEvento->index();
        break;

    case 'eliminarEvento':
        $contEvento->eliminar();
        break;

    case "editarEvento":
        $contEvento->editar();
        break;

    case "guardarEvento":
        $contEvento->guardar();
        break;

    case "agregarEvento":
        $contEvento->agregar();
        break;

    case "nuevoEvento":
        $contEvento->nuevo();
        break;

    //FORMATO DE TUTORÍAS

    case 'consultarFormato':
        $contFormato->index();
        break;

    case 'eliminarFormato':
        $contFormato->eliminar();
        break;

    case "editarFormato":
        $contFormato->editar();
        break;

    case "guardarFormato":
        $contFormato->guardar();
        break;

    case "agregarFormato":
        $contFormato->agregar();
        break;

    case "nuevoFormato":
        $contFormato->nuevo();
        break;
    
    //DISPONIBILIDAD DE HORARIO

    case 'consultarDisponibilidad':
        $contDisponibilidad->index();
        break;

    case 'eliminarDisponibilidad':
        $contDisponibilidad->eliminar();
        break;

    case "editarDisponibilidad":
        $contDisponibilidad->editar();
        break;

    case "guardarDisponibilidad":
        $contDisponibilidad->guardar();
        break;

    case "agregarDisponibilidad":
        $contDisponibilidad->agregar();
        break;

    case "nuevoDisponibilidad":
        $contDisponibilidad->nuevo();
        break;

    //TUTORÍAS
    case "agendar":
        $contDisponibilidad->agendar();
        break;

    case "agendarA":
        $contDisponibilidad->agendarAlumno();
        break;

    case "agendar2":
        $contDisponibilidad->agendar2();
        break;

    case "agendarA2":
        $contDisponibilidad->agendarAlumno2();
        break;

    case "confirmarCita":
        $contCita->agregar();
        break;

    case "confirmarCitaAlumno":
        $contCita->agregarAlumno();
        break;

    case "verCitas":
        $contCita->verCitas();
        break;

    case "confirmarAsistencia":
        $contCita->confirmarAsistencia();
        break;

    case "confirmarAsistenciaAlumno":
        $contCita->confirmarAsistenciaAlumno();
        break;

    case "guardarRespuestas":
        $contCita->guardarRespuestas();
        break;

    case "verRegistro":
        $contCita->verRegistro();
        break;

    //CUESTIONARIOS PROFESOR
    case "cuestionarios":
        $contCuestionario->index();
        break;

    case "nuevoCuestionario":
        $contCuestionario->nuevoCuestionario();
        break;

    case "agregarCuestionario":
        $contCuestionario->agregar();
        break;

    case "agregarPreguntas":
        $contCuestionario->agregarPreguntas();
        break;

    case "editarCuestionario":
        $contCuestionario->editar();
        break;

    case "guardarCuestionario":
        $contCuestionario->guardar();
        break;

    //CUESTIONARIOS ALUMNOS

    case "verCuestionarios":
        $contCuestionario->verCuestionarios();
        break;

    case "contestar":
        $contCuestionario->contestarCuestionario();
        break;

    case "guardarR":
        $contCuestionario->guardarRespuestas();
        break;

    //CALIFICACIONES

    case "calificaciones":
        $contCalificaciones->index();
        break;

    case "subirCalificaciones":
        $contCalificaciones->subirCalificaciones();
        break;
        
    case "guardarCalificaciones":
        $contCalificaciones->guardarCalificaciones();
        break;

    //RESPALDO BD

    case "respaldo":
        $contRespaldo->index();
        break;

    case "descarga":
        $contRespaldo->respaldo();
        break;

    //TRANSITAR CUATRIMESTRE
    case "transitar":
        $contUsuario->transitar();
        break;
    case "transitarCuatrimestre":
        $contUsuario->transitarCuatrimestre();
        break;

    //REPORTES
    case "reporteAlumno":
        $contReportes->reporteTutorias();
        break; 

    case "reporteEstados":
        $contReportes->reporteEstados();
        break; 

    case "reporteTutorias":
        $contReportes->reporteTutoriasTutor();
        break;

    case "generarReporteTutorias":
        $contReportes->generarReporteTutoriasTutor();
        break;

    case "tutoriasTotales":
        $contReportes->tutoriasTotales();
        break;
        
    case "reporteCalificaciones":
        $contReportes->reporteCalificaciones();
        break;
    case "reporteTutoriasAlumnos":
        $contReportes->reporteAlumnos();
        break;

    case "reporteCuestionario":
        $contReportes->reporteCuestionario();
        break;

    case "graficar":
        $contReportes->graficar();
        break; 
        
    default:
        $contUsuario->index();
        break;

}
?>
