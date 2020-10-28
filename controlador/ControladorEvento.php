<?php

namespace Controlador;

use Persistencia\Servicio\ServicioEvento as Servicio;
use Persistencia\Entidad\Evento as Entidad;

class ControladorEvento
{
    private $servicio;
    private static $VISTA_CONSULTAR = 'consultarEvento';
    private static $VISTA_EDITAR = 'editarEvento';
    private static $VISTA_NUEVO = 'nuevoEvento';

    public function __construct()
    {
        $this->servicio = new Servicio();
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
        $nuevo->Nombre = $_POST['nombre'];
        $nuevo->Ruta = $_FILES['imagen']['name'];
        $move = "vistas/Imagenes/".$_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], $move);
        $nuevo->Url = $_POST['url'];
        $this->servicio->guardar($nuevo);
        header('Location: ./?vista=' . self::$VISTA_CONSULTAR);
    }

    public function guardar()
    {
        if (empty($_POST)) {
            header('Location: ./');
        }

        $obj = $this->servicio->obtenerPorId($_POST["id"]);
        $obj->Nombre = $_POST['nombre'];
        $rut=$obj->Ruta;
        $rut2= $_FILES['imagen']['name'];
        $obj->Url = $_POST['url'];

        if ($rut2 != ''){
            $direc="vistas/Imagenes/".$rut;
            unlink($direc);

            $obj->Ruta = $_FILES['imagen']['name'];
            $move = "vistas/Imagenes/".$_FILES['imagen']['name'];
            move_uploaded_file($_FILES['imagen']['tmp_name'], $move);

        }else{
            $obj->Ruta = $rut;
        }
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