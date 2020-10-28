<?php

namespace Controlador;

use Persistencia\Servicio\ServicioFormato as Servicio;
use Persistencia\Entidad\Formato as Entidad;

class ControladorFormato
{

    private $servicio;
    private static $VISTA_CONSULTAR = 'consultarFormato';
    private static $VISTA_EDITAR = 'editarFormato';
    private static $VISTA_NUEVO = 'nuevoFormato';

    //Se crea el constructor para el servicio de la entidad
    public function __construct()
    {
        $this->servicio = new Servicio();
    }

    //Obtiene todos los registros para el formato de tutorías
    //Manda a llamar la vista correspondiente.
    //Recibe: Nada.
    //Devuelve: Nada.
    public function index()
    {
        $objs = $this->servicio->obtenerTodos();
        require 'vistas/' . self::$VISTA_CONSULTAR . '.php';
    }

    //Permite obtener la información del formulario por medio
    //del método POST y manda a llamar el método guardar del
    //servicio para esta entidad. 
    //Llama a la vista correspondiente.
    //Recibe: Nada.
    //Devuelve: Nada.
    public function agregar()
    {
        if (empty($_POST)) {
            header('Location: ./');
        }

        $nuevo = new Entidad();
        $nuevo->Campo = $_POST['campo'];
        $nuevo->Activo = $_POST['estatus'];
        $this->servicio->guardar($nuevo);
        header('Location: ./?vista=' . self::$VISTA_CONSULTAR);
    }

    //Guarda las modificaciones realizadas a una entidad
    //y que son obtenidas por medio del método POST.
    //Llama a la vista correspondiente.
    //Recibe: Nada.
    //Devuelve: Nada.
    public function guardar()
    {
        if (empty($_POST)) {
            header('Location: ./');
        }

        $obj = $this->servicio->obtenerPorId($_POST["id"]);
        $obj->Campo = $_POST['campo'];
        $obj->Activo = $_POST['estatus'];
        $obj->save();
        header('Location: ./?vista=' . self::$VISTA_CONSULTAR);
    }

    //Elimina un objeto, del cual se obtuvo el identificador
    //por medio del método GET.
    //Llama a la vista correspondiente.
    //Recibe: Nada.
    //Devuelve: Nada.
    public function eliminar()
    {
        if (empty($_GET)) {
            header("Location: ./");
        }

        $id = $_GET["id"];
        $obj = $this->servicio->obtenerPorId($id);
        $this->servicio->eliminar($id);
        header('Location: ./?vista=' . self::$VISTA_CONSULTAR);
    }

    //Obtiene todos los datos de un objeto por medio de su 
    //identificador, para posteriormente mandarlo a la 
    //vista del formulario para su modificación.
    //Llama a la vista correspondiente.
    //Recibe: Nada.
    //Devuelve: Nada.
    public function editar()
    {
        if (empty($_GET)) {
            header("Location: ./");
        }

        $servFormato = new Servicio();
        $eventos = $servFormato->obtenerTodos();
        $obj = $this->servicio->obtenerPorId($_GET["id"]);
        require 'vistas/' . self::$VISTA_EDITAR . '.php';
    }

    //Llama al formulario correspondiente para poder 
    //ingresar la información para un nuevo objeto.
    public function nuevo()
    {
        $servFormato = new Servicio();
        $formatos = $servFormato->obtenerTodos();
        require 'vistas/' . self::$VISTA_NUEVO . '.php';
    }
}

?>