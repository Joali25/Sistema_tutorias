<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Proyecto Integrador</title>
</head>
<body>
<h4>Proyecto Integrador</h4>
<?php
require "bootloader.php";

use Controlador\ControladorCiclo;
use Controlador\ControladorCultivo;
use Controlador\ControladorDistrito;
use Controlador\ControladorEstado;
use Controlador\ControladorFuente;
use Controlador\ControladorGrupo;
use Controlador\ControladorModalidad;
use Controlador\ControladorOrganismo;
use Controlador\ControladorProduccionAgricola;
use Controlador\ControladorTenencia;
use Controlador\ControladorVolumenDistribuido;

$contCiclo = new ControladorCiclo();
$contCultivo = new ControladorCultivo();
$contDistrito = new ControladorDistrito();
$contEstado = new ControladorEstado();
$contFuente = new ControladorFuente();
$contGrupo = new ControladorGrupo();
$contModalidad = new ControladorModalidad();
$contOrganismo = new ControladorOrganismo();
$contProduccionAgricola = new ControladorProduccionAgricola();
$contTenencia = new ControladorTenencia();
$contVolumenDistribuido = new ControladorVolumenDistribuido();

$vista = $_GET["vista"];
switch ($vista) {
    // Ciclo
    case 'consultarCiclo':
        echo "Hola amigos";
        $contCiclo->index();
        break;

    case 'eliminarCiclo':
        $contCiclo->eliminar();
        break;

    case "editarCiclo":
        $contCiclo->editar();
        break;

    case "guardarCiclo":
        $contCiclo->guardar();
        break;

    case "agregarCiclo":
        $contCiclo->agregar();
        break;

    case "nuevoCiclo":
        $contCiclo->nuevo();
        break;

    // Cultivo
    case 'consultarCultivo':
        $contCultivo->index();
        break;

    case 'eliminarCultivo':
        $contCultivo->eliminar();
        break;

    case "editarCultivo":
        $contCultivo->editar();
        break;

    case "guardarCultivo":
        $contCultivo->guardar();
        break;

    case "agregarCultivo":
        $contCultivo->agregar();
        break;

    case "nuevoCultivo":
        $contCultivo->nuevo();
        break;

    // Distrito
    case 'consultarDistrito':
        $contDistrito->index();
        break;

    case 'eliminarDistrito':
        $contDistrito->eliminar();
        break;

    case "editarDistrito":
        $contDistrito->editar();
        break;

    case "guardarDistrito":
        $contDistrito->guardar();
        break;

    case "agregarDistrito":
        $contDistrito->agregar();
        break;

    case "nuevoDistrito":
        $contDistrito->nuevo();
        break;

    // Estado
    case 'consultarEstado':
        $contEstado->index();
        break;

    case 'eliminarEstado':
        $contEstado->eliminar();
        break;

    case "editarEstado":
        $contEstado->editar();
        break;

    case "guardarEstado":
        $contEstado->guardar();
        break;

    case "agregarEstado":
        $contEstado->agregar();
        break;

    case "nuevoEstado":
        $contEstado->nuevo();
        break;

    // Fuente
    case 'consultarFuente':
        $contFuente->index();
        break;

    case 'eliminarFuente':
        $contFuente->eliminar();
        break;

    case "editarFuente":
        $contFuente->editar();
        break;

    case "guardarFuente":
        $contFuente->guardar();
        break;

    case "agregarFuente":
        $contFuente->agregar();
        break;

    case "nuevoFuente":
        $contFuente->nuevo();
        break;

    // Grupo
    case 'consultarGrupo':
        $contGrupo->index();
        break;

    case 'eliminarGrupo':
        $contGrupo->eliminar();
        break;

    case "editarGrupo":
        $contGrupo->editar();
        break;

    case "guardarGrupo":
        $contGrupo->guardar();
        break;

    case "agregarGrupo":
        $contGrupo->agregar();
        break;

    case "nuevoGrupo":
        $contGrupo->nuevo();
        break;

    // Modalidad
    case 'consultarModalidad':
        $contModalidad->index();
        break;

    case 'eliminarModalidad':
        $contModalidad->eliminar();
        break;

    case "editarModalidad":
        $contModalidad->editar();
        break;

    case "guardarModalidad":
        $contModalidad->guardar();
        break;

    case "agregarModalidad":
        $contModalidad->agregar();
        break;

    case "nuevoModalidad":
        $contModalidad->nuevo();
        break;

    // Organismo
    case 'consultarOrganismo':
        $contOrganismo->index();
        break;

    case 'eliminarOrganismo':
        $contOrganismo->eliminar();
        break;

    case "editarOrganismo":
        $contOrganismo->editar();
        break;

    case "guardarOrganismo":
        $contOrganismo->guardar();
        break;

    case "agregarOrganismo":
        $contOrganismo->agregar();
        break;

    case "nuevoOrganismo":
        $contOrganismo->nuevo();
        break;

    // ProduccionAgricola
    case 'consultarProduccionAgricola':
        $contProduccionAgricola->index();
        break;

    case 'eliminarProduccionAgricola':
        $contProduccionAgricola->eliminar();
        break;

    case "editarProduccionAgricola":
        $contProduccionAgricola->editar();
        break;

    case "guardarProduccionAgricola":
        $contProduccionAgricola->guardar();
        break;

    case "agregarProduccionAgricola":
        $contProduccionAgricola->agregar();
        break;

    case "nuevoProduccionAgricola":
        $contProduccionAgricola->nuevo();
        break;

    // Tenencia
    case 'consultarTenencia':
        $contTenencia->index();
        break;

    case 'eliminarTenencia':
        $contTenencia->eliminar();
        break;

    case "editarTenencia":
        $contTenencia->editar();
        break;

    case "guardarTenencia":
        $contTenencia->guardar();
        break;

    case "agregarTenencia":
        $contTenencia->agregar();
        break;

    case "nuevoTenencia":
        $contTenencia->nuevo();
        break;

    // VolumenDistribuido
    case 'consultarVolumenDistribuido':
        $contVolumenDistribuido->index();
        break;

    case 'eliminarVolumenDistribuido':
        $contVolumenDistribuido->eliminar();
        break;

    case "editarVolumenDistribuido":
        $contVolumenDistribuido->editar();
        break;

    case "guardarVolumenDistribuido":
        $contVolumenDistribuido->guardar();
        break;

    case "agregarVolumenDistribuido":
        $contVolumenDistribuido->agregar();
        break;

    case "nuevoVolumenDistribuido":
        $contVolumenDistribuido->nuevo();
        break;

    default:
        break;

//		case "consultarAutos":
//            $controladorAuto->index();
//			break;
//
//		case "eliminarAuto":
//            $controladorAuto->eliminar();
//			break;
//
//		case "editarAuto":
//            $controladorAuto->editar();
//			break;
//
//		case "guardarAuto":
//            $controladorAuto->guardar();
//			break;
//
//		case "agregarAuto":
//            $controladorAuto->agregar();
//			break;
//
//        case "nuevoAuto":
//            $controladorAuto->nuevo();
//            break;
//
//		default:
//			# code...
//			break;
}
?>
</body>
</html>