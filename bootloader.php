<?php

//Dentro de este documento se manejan la unión de todos los archivos necesarios para la ejecución del sistema, además, de la conexión a la base de datos.

require "vendor/autoload.php";
require "persistencia/entidad/usuario.php";
require "persistencia/servicio/ServicioUsuario.php";
require "controlador/ControladorUsuario.php";

require "persistencia/entidad/domicilio.php";
require "persistencia/servicio/ServicioDomicilio.php";
require "controlador/ControladorDomicilio.php";

require "persistencia/entidad/evento.php";
require "persistencia/servicio/ServicioEvento.php";
require "controlador/ControladorEvento.php";

require "persistencia/entidad/formato.php";
require "persistencia/servicio/ServicioFormato.php";
require "controlador/ControladorFormato.php";

require "persistencia/entidad/disponibilidad.php";
require "persistencia/servicio/ServicioDisponibilidad.php";
require "controlador/ControladorDisponibilidad.php";

require "persistencia/entidad/periodo.php";
require "persistencia/servicio/ServicioPeriodo.php";

require "persistencia/entidad/Usuario_periodo.php";
require "persistencia/servicio/ServicioUsuarioPeriodo.php";

require "persistencia/entidad/Formato_respuestas.php";
require "persistencia/servicio/ServicioFormatoRespuestas.php";

require "persistencia/entidad/cita.php";
require "persistencia/servicio/ServicioCita.php";
require "controlador/ControladorCita.php";

require "persistencia/entidad/cuestionario.php";
require "persistencia/servicio/ServicioCuestionario.php";
require "controlador/ControladorCuestionario.php";

require "persistencia/entidad/cuestionario_preguntas.php";
require "persistencia/servicio/ServicioCuestionarioPreguntas.php";

require "persistencia/entidad/preguntas_cuestionario.php";
require "persistencia/servicio/ServicioPreguntasCuestionario.php";

require "persistencia/entidad/respuesta.php";
require "persistencia/servicio/ServicioRespuesta.php";

require "persistencia/entidad/notificaciones.php";
require "persistencia/servicio/ServicioNotificaciones.php";

require "persistencia/entidad/calificaciones.php";
require "persistencia/servicio/ServicioCalificaciones.php";
require "controlador/ControladorCalificaciones.php";

require "controlador/ControladorRespaldo.php";
require "controlador/ControladorReportes.php";
require "persistencia/entidad/pdf.php";



use Illuminate\Database\Capsule\Manager;

$capsule = new Manager();
$capsule->addConnection([
	"driver"   => "mysql",
	"host"     => "localhost",
	"database" => "sistema_tutorias",
	"username" => "root",
	"password" => ""
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

?>