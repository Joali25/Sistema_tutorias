<?php

namespace Controlador;

use Persistencia\Servicio\ServicioUsuario as ServicioU;
use Persistencia\Entidad\Usuario as EntidadU;

use Persistencia\Servicio\ServicioDomicilio as ServicioD;
use Persistencia\Entidad\Domicilio as EntidadD;

use Persistencia\Servicio\ServicioDisponibilidad as ServicioDi;
use Persistencia\Entidad\Disponibilidad as EntidadDi;

use Persistencia\Servicio\ServicioPeriodo as ServicioP;
use Persistencia\Entidad\Periodo as EntidadP;

use Persistencia\Servicio\ServicioUsuarioPeriodo as ServicioUP;
use Persistencia\Entidad\Usuario_Periodo as EntidadUP;

use Persistencia\Servicio\ServicioCalificaciones as ServicioCa;
use Persistencia\Entidad\Calificaciones as EntidadCa;

use Persistencia\Servicio\ServicioCuestionario as ServicioCu;
use Persistencia\Servicio\ServicioCuestionarioPreguntas as ServicioCP;
use Persistencia\Servicio\ServicioRespuesta as ServicioR;

use Persistencia\Servicio\ServicioCita as ServicioC;
use Persistencia\Entidad\Cita as EntidadC;
use Persistencia\Entidad\PDF as pdf;

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

class ControladorReportes 
{
    private $servicioC;
    private $servicioCa;
    private $servicioU;
    private $servicioD;
    private $servicioDi;
    private $servicioP;
    private $servicioUP;
    private $servicioCu;
    private $servicioCP;
    private $servicioR;
    private static $VISTA_CONSULTAR = 'volver';
    private static $VISTA_TUTOR = 'reporteTutorias';
    private static $VISTA_NUEVO = 'reporteCuestionarios';

    public function __construct()
    {
        $this->servicioC = new ServicioC();
        $this->servicioCa = new ServicioCa();
        $this->servicioU = new ServicioU();
        $this->servicioD = new ServicioD();
        $this->servicioDi = new ServicioDi();
        $this->servicioP = new ServicioP();
        $this->servicioUP = new ServicioUP();
        $this->servicioCu = new ServicioCu();
        $this->servicioCP = new ServicioCP();
        $this->servicioR = new ServicioR();

    }

    public function index()
    {
        require 'vistas/' . self::$VISTA_CONSULTAR . '.php';
    }

    public function reporteTutoriasTutor()
    {
        $tutores = $this->servicioU->obtenerTutores(2);
        require 'vistas/' . self::$VISTA_TUTOR . '.php';
    }

    public function reporteCuestionario()
    {
        $var = $_SESSION['Matricula'];
        $cuestionarios = $this->servicioCu->obtenerPorTutor($var);
        require 'vistas/' . self::$VISTA_NUEVO . '.php';
    }

    public function generarReporteTutoriasTutor()
    {
        if (empty($_POST)) {
            header('Location: ./');
        }
        $rangoInferior = strtotime($_POST['fechaInicio']);
        $rangoFinal = strtotime($_POST['fechaFin']);

        $citas = $this->servicioC->obtenerTodos();

        switch ($_POST['tipo']) {
            case '1':
                $titulo = "Reporte de tutorias por dia del tutor ".$_POST['tutor'] ;
                $pdf = new pdf($titulo);
                $pdf->AliasNbPages();
                $pdf->AddPage();
                $cantidad = 0;
                $pdf->SetFillColor(232,232,232);
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(6,2,'FECHA',1,0,'C',1);
                $pdf->Cell(6,2,'CANTIDAD DE TUTORIAS',1,1,'C',1);
                $fechasRango = array();
                for($i=$rangoInferior; $i<=$rangoFinal; $i+=86400){
                    $fechaTitulo = date("Y-m-d", $i);
                    $fechasRango[] = $fechaTitulo;
                    $cantidad = $cantidad + 1;
                }

                $cantidadTutorias = array();
                for ($i=0; $i < $cantidad; $i++) { 
                    $cantidadTutorias[] = 0;
                }

                for ($i=0; $i < $cantidad; $i++) { 
                    $objs = $this->servicioC->obtenerPorFecha($fechasRango[$i]);

                    if(count($objs)>0){
                        foreach ($objs as $obj) {
                            $citaBuscada = $this->servicioDi->encontrar($_POST['tutor'],$obj->Disponibilidad_horario_Id);
                            if($citaBuscada != null){
                                $cantidadTutorias[$i] = $cantidadTutorias[$i] + 1; 
                            }
                        }
                    }
                }

                for ($i=0; $i < $cantidad; $i++) { 
                    $pdf->Cell(6,1,$fechasRango[$i],1,0,'C');
                    $pdf->Cell(6,1,$cantidadTutorias[$i],1,1,'C');
                }

                $pdf->Output('D','ReporteTutoriasPorDia.pdf');
                break;

            case '2':
                $titulo = "Reporte de tutorias por semana del tutor ".$_POST['tutor'] ;
                $pdf = new pdf($titulo);
                $pdf->AliasNbPages();
                $pdf->AddPage();
                $cantidad = 0;
                $pdf->SetFillColor(232,232,232);
                $pdf->SetFont('Arial','B',12);
                $pdf->Cell(6,2,'SEMANA',1,0,'C',1);
                $pdf->Cell(6,2,'CANTIDAD DE TUTORIAS',1,1,'C',1);

                $fechasRango = array();
                for($i=$rangoInferior; $i<=$rangoFinal; $i+=86400){
                    $fechaTitulo = date("Y-m-d", $i);
                    $fechasRango[] = $fechaTitulo;
                    $cantidad = $cantidad + 1;
                }

                $fechasSemana = array();
                $semanas = ceil($cantidad/7);

                for($i=0; $i<$semanas; $i++){
                    if($i==0){
                        $fechasSemana[]= date("Y-m-d", $rangoInferior);
                    }else{
                        $j=($i*2)-1;
                        $nuevaFecha = strtotime($fechasSemana[$j])+86400;
                        $fechasSemana[] = date("Y-m-d", $nuevaFecha);
                    }
                    $t = $i*2;
                    $fechaNueva = strtotime($fechasSemana[$t])+518400;
                    $fechasSemana[] = date("Y-m-d", $fechaNueva);
                }

                $citasSemana = array();
                for($i=0; $i<$semanas; $i++){
                    $citasSemana[] = 0;
                }

                for($i=0; $i<$semanas; $i++){
                    $t=$i*2;
                    $j=$t+1;
                    $Fecha1= strtotime($fechasSemana[$t]);
                    $Fecha2= strtotime($fechasSemana[$j]);

                    foreach ($citas as $cita) {
                        $Fecha3 = strtotime($cita->Fecha);
                        if($Fecha3>=$Fecha1 && $Fecha3<=$Fecha2){
                            $citaBuscada = $this->servicioDi->encontrar($_POST['tutor'],$cita->Disponibilidad_horario_Id);
                            if($citaBuscada != null){
                                $citasSemana[$i] = $citasSemana[$i] + 1; 
                            }
                        }
                    }
                }

                for($i=0; $i<$semanas; $i++){
                    $j = $i*2;
                    $t = $j+1;
                    $rango =  $fechasSemana[$j]." / ".$fechasSemana[$t];
                    $pdf->Cell(6,1,$rango,1,0,'C');
                    $pdf->Cell(6,1,$citasSemana[$i],1,1,'C');
                }

                $pdf->Output('D','ReporteTutoriasPorSemana.pdf');
                break;

            case '3':
                $titulo = "Reporte de tutorias por mes del tutor ".$_POST['tutor'] ;
                $pdf = new pdf($titulo);
                $pdf->AliasNbPages();
                $pdf->AddPage();
                $cantidad = 0;
                $pdf->SetFillColor(232,232,232);
                $pdf->SetFont('Arial','B',12);
                $pdf->Cell(6,2,'MES',1,0,'C',1);
                $pdf->Cell(6,2,'CANTIDAD DE TUTORIAS',1,1,'C',1);

                $meses = [0,0,0,0,0,0,0,0,0,0,0,0,0];

                $fechasRango = array();
                for($i=$rangoInferior; $i<=$rangoFinal; $i+=86400){
                    $fechaTitulo = date("Y-m-d", $i);
                    $fechasRango[] = $fechaTitulo;
                    $cantidad = $cantidad + 1;
                    $mes = date("n",$i);
                    settype($mes, 'int');
                    $meses[$mes] = 1;
                }

                $citasPorMes = [0,0,0,0,0,0,0,0,0,0,0,0,0];

                foreach ($citas as $cita) {
                    $Fecha3 = strtotime($cita->Fecha);
                    if($Fecha3>=$rangoInferior && $Fecha3<=$rangoFinal){
                        $citaBuscada = $this->servicioDi->encontrar($_POST['tutor'],$cita->Disponibilidad_horario_Id);
                        if($citaBuscada != null){
                            $mesCita =  date("n",strtotime($cita->Fecha));
                            $citasPorMes[$mesCita] = $citasPorMes[$mesCita] + 1;
                        }
                    }
                }

                $mesesNombre=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

                for($i=1; $i<=12; $i++){
                    if($meses[$i] == 1){
                        $pdf->Cell(6,1,$mesesNombre[$i],1,0,'C');
                        $pdf->Cell(6,1,$citasPorMes[$i],1,1,'C');
                    }
                }

                $pdf->Output('D','ReporteTutoriasPorMes.pdf');
                break;
        }
    }


    public function reporteTutorias(){


        $var = $_SESSION['Matricula'];

        $citas = $this->servicioC->obtenerPorAlumno($var);
        $des = "Reporte de tutorias para el alumno ";
        $titulo = $des.$var;
        $pdf = new pdf($titulo);
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $pdf->SetFillColor(232,232,232);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(5,2,'ID',1,0,'C',1);
        $pdf->Cell(5,2,'FECHA',1,0,'C',1);
        $pdf->Cell(7,2,'ASISTENCIA',1,1,'C',1);
        
        $pdf->SetFont('Arial','',10);
        
        foreach ($citas as $cita) {
            $pdf->Cell(5,2,$cita->Id_tutoria,1,0,'C');
            $pdf->Cell(5,2,$cita->Fecha,1,0,'C');
            if($cita->Asistencia == 1){
                $pdf->Cell(7,2,'Asistencia',1,1,'C');
            }else{
                $pdf->Cell(7,2,'Falta',1,1,'C');
            }
            
        }
        
        $pdf->Output('D','ReporteTutorias.pdf');
    }

    public function reporteEstados(){
        $Domicilios = $this->servicioD->obtenerTodos();
        $registros = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $Estados = array();
        $Estados[] = "Aguascalientes";
        $Estados[] = "Baja California Norte";
        $Estados[] = "Baja California Sur";
        $Estados[] = "Campeche";
        $Estados[] = "CDMX";
        $Estados[] = "Chiapas";
        $Estados[] = "Chihuahua";
        $Estados[] = "Coahuila";
        $Estados[] = "Colima";
        $Estados[] = "Durango";
        $Estados[] = "Estado de México";
        $Estados[] = "Guanajuato";
        $Estados[] = "Guerrero";
        $Estados[] = "Hidalgo";
        $Estados[] = "Jalisco";
        $Estados[] = "Michoacan";
        $Estados[] = "Morelos";
        $Estados[] = "Nayarit";
        $Estados[] = "Nuevo León";
        $Estados[] = "Oaxaca";
        $Estados[] = "Puebla";
        $Estados[] = "Queretaro";
        $Estados[] = "Quintana Roo";
        $Estados[] = "San Luis Potosí";
        $Estados[] = "Sinaloa";
        $Estados[] = "Sonora";
        $Estados[] = "Tabasco";
        $Estados[] = "Tamaulipas";
        $Estados[] = "Tlaxcala";
        $Estados[] = "Veracruz";
        $Estados[] = "Yucatán";
        $Estados[] = "Zacatecas";

        foreach ($Domicilios as $Domicilio) {
            $indice = $Domicilio->Estado;
            settype($indice, 'int'); 
            $registros[$indice] = $registros[$indice] + 1;
        }

        $titulo = "Reporte de estudiantes provenientes de cada entidad";
        $pdf = new pdf($titulo);
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $pdf->SetFillColor(232,232,232);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(5,2,'ESTADO',1,0,'C',1);
        $pdf->Cell(8,2,'CANTIDAD DE ESTUDIANTES',1,1,'C',1);
        
        $pdf->SetFont('Arial','',10);
        
        for ($i=0; $i < 32 ; $i++) {
            $j = $i+1; 
            $pdf->Cell(5,2,$Estados[$i],1,0,'C');
            $pdf->Cell(8,2,$registros[$j],1,1,'C');
        }
        
        $pdf->Output('D','ReporteEstudiantesPorEntidad.pdf');

    }

    public function tutoriasTotales(){
        $titulo = "Tutorias totales por cada Tutor";
        $pdf = new pdf($titulo);
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $pdf->SetFillColor(232,232,232);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(4,2,'MATRICULA',1,0,'C',1);
        $pdf->Cell(6,2,'NOMBRE',1,0,'C',1);
        $pdf->Cell(7,2,'CANTIDAD DE TUTORÍAS',1,1,'C',1);
        $pdf->SetFont('Arial','',10);

        $tutores = $this->servicioU->obtenerTutores(2);

        foreach ($tutores as $tutor) {
            $pdf->Cell(4,2,$tutor->Matricula,1,0,'C');
            $nombre = $tutor->Nombre." ".$tutor->ApellidoP." ".$tutor->ApellidoM;
            $pdf->Cell(6,2,$nombre,1,0,'C');
            $citas = $this->servicioC->obtenerTodos();
            $cantidad = 0;
            foreach ($citas as $cita) {
                $citaBuscada = $this->servicioDi->encontrar($tutor->Matricula,$cita->Disponibilidad_horario_Id);
                if($citaBuscada != null){
                    $cantidad = $cantidad + 1;
                }
            }
            $pdf->Cell(7,2,$cantidad,1,1,'C');
        }
        $pdf->Output('D','ReporteTutoriasTotales.pdf');
    }

    public function reporteCalificaciones(){

        $var = $_SESSION['Matricula'];
        $periodo = $this->servicioP->obtenerActivo($var,1);
        $cuatri1=array("MATRÍCULA","QUÍMICA BÁSICA","ÁLGEBRA LINEAL","  INTRODUCCIÓN A LA PROGRAMACIÓN"," INTRODUCCIÓN A LAS TICS"," HERRAMIENTAS OFIMÁTICAS","EXPRESIÓN ORAL Y ESCRITA","INGLÉS I");
        $cuatri2=array("DESARROLLO HUMANO Y VALORES","FUNCIONES MATEMÁTICAS","FÍSICA", "ELECTRICIDAD Y MAGNETISMO","MATEMÁTICAS BÁSICAS PARA COMPUTACIÓN","ARQUITECTURA DE COMPUTADORAS","INGLÉS");
        $cuatri3=array("INTELIGENCIA EMOCIONAL","CÁLCULO DIFERENCIAL", "PROBABILIDAD Y ESTADÍSTICA","PROGRAMACIÓN","INTRODUCCIÓN A LAS REDES","MANTO A EQUIPO DE CÓMPUTO","INGLÉS III");
        $cuatri4=array("HABILIDADES COGNITIVAS Y CREATIVIDAD","CÁLCULO INTEGRAL","INGENIERÍA DE SOFTWARE","ESTRUCTURA DE DATOS","RUTEO Y CONMUTACIÓN","ESTANCIA I","INGLÉS IV");
        $cuatri5=array("ÉTICA PROFESIONAL","MATEMÁTICAS PARA INGENIERÍA I",   "FÍSICA PARA INGENIERÍA","FUNDAMENTOS POO","ESCALAMIENTO DE REDES","BASE DE DATOS","INGLÉS V");
        $cuatri6=array("HABILIDADES GERENCIALES",'MATEMÁTICAS PARA INGENIERÍA II',"SISTEMAS OPERATIVOS","POO","INTERCONEXIÓN DE REDES","ADMINISTRACIÓN DE BASE DE DATOS","INGLÉS VI");
        $cuatri7=array("LIDERAZGO DE EQUIPOS DE ALTO DESEMPEÑO","FORMULACIÓN DE PROYECTOS DE TICS","LENGUAJE Y AUTÓMATAS","PROGRAMACIÓN WEB ",   "INGENIERÍA DE REQUISITOS","ESTANCIA II","INGLÉS VII");
        $cuatri8=array("TECNOLOGÍAS DE VIRTUALIZACIÓN","ADMON DE PROYECTOS DE TICS","TECNOLOGÍAS Y APLICACIONES EN INTERNET", "DISEÑO DE INTERFACES","SISTEMAS INTELIGENTES","GESTIÓN DE DESARROLLO DE SOFTWARE","INGLÉS VIII");
        $cuatri9=array("INTELIGENCIA DE NEGOCIOS", "DESARROLLO DE NEGOCIOS PARA TICS","SISTEMAS EMBÉBIDOS","PROGRAMACIÓN MÓVIL","SEGURIDAD INFORMÁTICA","EXPRESIÓN ORAL Y ESCRITA II", "INGLÉS IX");
        if(empty($periodo)){
            ?>
            <script type='text/javascript'>
                alert('NO TIENES UN GRUPO ASIGNADO PARA GENERAR REPORTE DE CALIFICACIONES'); 
                window.location.href ='index.php?vista=domicilio';
            </script>";
            <?php
        }else{

            $titulo = "CALIFICACIONES DEL GRUPO ".$periodo->Grado."° ".$periodo->Grupo;
            $pdf = new pdf($titulo);
            $pdf->AliasNbPages();
            $pdf->AddPage('L','Legal');

            $pdf->SetFillColor(232,232,232);
            $pdf->SetFont('Arial','B',5);
            $pdf->Cell(3,2,'MATERIA',1,0,'C',1);
            switch ($periodo->Grado) {
                case '1':
                    for ($i=0; $i < 7; $i++) { 
                        if($i==6){
                            $pdf->Cell(3,2,$cuatri1[$i],1,1,'C',1);
                        }else{
                            $pdf->Cell(3,2,$cuatri1[$i],1,0,'C',1);
                        }

                    }
                    break;
                case '2':
                    for ($i=0; $i < 7; $i++) { 
                        if($i==6){
                            $pdf->Cell(3,2,$cuatri2[$i],1,1,'C',1);
                        }else{
                            $pdf->Cell(3,2,$cuatri2[$i],1,0,'C',1);
                        }

                    }
                    break;
                case '3':
                    for ($i=0; $i < 7; $i++) { 
                        if($i==6){
                            $pdf->Cell(3,2,$cuatri3[$i],1,1,'C',1);
                        }else{
                            $pdf->Cell(3,2,$cuatri3[$i],1,0,'C',1);
                        }

                    }
                    break;
                case '4':
                    for ($i=0; $i < 7; $i++) { 
                        if($i==6){
                            $pdf->Cell(3,2,$cuatri4[$i],1,1,'C',1);
                        }else{
                            $pdf->Cell(3,2,$cuatri4[$i],1,0,'C',1);
                        }

                    }
                    break;
                case '5':
                    for ($i=0; $i < 7; $i++) { 
                        if($i==6){
                            $pdf->Cell(3,2,$cuatri5[$i],1,1,'C',1);
                        }else{
                            $pdf->Cell(3,2,$cuatri5[$i],1,0,'C',1);
                        }

                    }
                    break;
                case '6':
                    for ($i=0; $i < 7; $i++) { 
                        if($i==6){
                            $pdf->Cell(3,2,$cuatri6[$i],1,1,'C',1);
                        }else{
                            $pdf->Cell(3,2,$cuatri6[$i],1,0,'C',1);
                        }

                    }
                    break;
                case '7':
                    for ($i=0; $i < 7; $i++) { 
                        if($i==6){
                            $pdf->Cell(3,2,$cuatri7[$i],1,1,'C',1);
                        }else{
                            $pdf->Cell(3,2,$cuatri7[$i],1,0,'C',1);
                        }

                    }
                    break;
                case '8':
                    for ($i=0; $i < 7; $i++) { 
                        if($i==6){
                            $pdf->Cell(3,2,$cuatri8[$i],1,1,'C',1);
                        }else{
                            $pdf->Cell(3,2,$cuatri8[$i],1,0,'C',1);
                        }

                    }
                    break;
                case '9':
                    for ($i=0; $i < 7; $i++) { 
                        if($i==6){
                            $pdf->Cell(3,2,$cuatri9[$i],1,1,'C',1);
                        }else{
                            $pdf->Cell(3,2,$cuatri9[$i],1,0,'C',1);
                        }

                    }
                    break;
            }

            $pdf->Cell(3,2,'PARCIAL',1,0,'C',1);
            for ($i=0; $i < 7; $i++) { 
                $pdf->Cell(1,2,'1',1,0,'C',1);
                $pdf->Cell(1,2,'2',1,0,'C',1);
                if($i==6){
                    $pdf->Cell(1,2,'Final',1,1,'C',1);
                }else{
                    $pdf->Cell(1,2,'Final',1,0,'C',1);
                }
                
            }
            $alumnos = $this->servicioUP->obtenerPorPeriodo($periodo->IdPeriodo);
            $cantidadAlumnos= count($alumnos);

            $promedioP1 = 0;
            $promedioP2 = 0;
            $promedioP3 = 0;
            foreach ($alumnos as $alumno) {
                $pdf->Cell(3,2,$alumno->Usuario_Matricula,1,0,'C');
                $parcial1 = $this->servicioCa->obtenerPorPeriodoParcial($alumno->Usuario_Matricula,$periodo->IdPeriodo,1);
                $parcial2 = $this->servicioCa->obtenerPorPeriodoParcial($alumno->Usuario_Matricula,$periodo->IdPeriodo,2);
                $parcial3 = $this->servicioCa->obtenerPorPeriodoParcial($alumno->Usuario_Matricula,$periodo->IdPeriodo,3);
                $AlumnoP1 = 0;
                $AlumnoP2 = 0;
                $AlumnoP3 = 0;
                if(empty($parcial1)){
                    $parcial1 = new EntidadCa();
                }else{
                    $AlumnoP1 = (((int)$parcial1->Cal1)+((int)$parcial1->Cal2)+((int)$parcial1->Cal3)+((int)$parcial1->Cal4)+((int)$parcial1->Cal5)+((int)$parcial1->Cal6)+((int)$parcial1->Cal7))/7;
                }

                if(empty($parcial2)){
                    $parcial2 = new EntidadCa();
                }else{
                    $AlumnoP2 = (((int)$parcial2->Cal1)+((int)$parcial2->Cal2)+((int)$parcial2->Cal3)+((int)$parcial2->Cal4)+((int)$parcial2->Cal5)+((int)$parcial2->Cal6)+((int)$parcial2->Cal7))/7;
                }

                if(empty($parcial3)){
                    $parcial3 = new EntidadCa();
                }else{
                    $AlumnoP3 = (((int)$parcial3->Cal1)+((int)$parcial3->Cal2)+((int)$parcial3->Cal3)+((int)$parcial3->Cal4)+((int)$parcial3->Cal5)+((int)$parcial3->Cal6)+((int)$parcial3->Cal7))/7;
                }

                $pdf->Cell(1,2,$parcial1->Cal1,1,0,'C');
                $pdf->Cell(1,2,$parcial2->Cal1,1,0,'C');
                $pdf->Cell(1,2,$parcial3->Cal1,1,0,'C');

                $pdf->Cell(1,2,$parcial1->Cal2,1,0,'C');
                $pdf->Cell(1,2,$parcial2->Cal2,1,0,'C');
                $pdf->Cell(1,2,$parcial3->Cal2,1,0,'C');

                $pdf->Cell(1,2,$parcial1->Cal3,1,0,'C');
                $pdf->Cell(1,2,$parcial2->Cal3,1,0,'C');
                $pdf->Cell(1,2,$parcial3->Cal3,1,0,'C');

                $pdf->Cell(1,2,$parcial1->Cal4,1,0,'C');
                $pdf->Cell(1,2,$parcial2->Cal4,1,0,'C');
                $pdf->Cell(1,2,$parcial3->Cal4,1,0,'C');

                $pdf->Cell(1,2,$parcial1->Cal5,1,0,'C');
                $pdf->Cell(1,2,$parcial2->Cal5,1,0,'C');
                $pdf->Cell(1,2,$parcial3->Cal5,1,0,'C');

                $pdf->Cell(1,2,$parcial1->Cal6,1,0,'C');
                $pdf->Cell(1,2,$parcial2->Cal6,1,0,'C');
                $pdf->Cell(1,2,$parcial3->Cal6,1,0,'C');

                $pdf->Cell(1,2,$parcial1->Cal7,1,0,'C');
                $pdf->Cell(1,2,$parcial2->Cal7,1,0,'C');
                $pdf->Cell(1,2,$parcial3->Cal7,1,1,'C');

                $promedioP1 = $promedioP1 + $AlumnoP1;
                $promedioP2 = $promedioP2 + $AlumnoP2;
                $promedioP3 = $promedioP3 + $AlumnoP3;
            }

            $promedioP1 = $promedioP1/$cantidadAlumnos;
            $promedioP2 = $promedioP2/$cantidadAlumnos;
            $promedioP3 = $promedioP3/$cantidadAlumnos;

            $pdf->Cell(4,2,'Promedio Grupal Parcial 1',1,0,'C');
            $pdf->Cell(4,2,$promedioP1,1,0,'C');
            $pdf->Cell(4,2,"Promedio Grupal Parcial 2",1,0,'C');
            $pdf->Cell(4,2,$promedioP2,1,0,'C');
            $pdf->Cell(4,2,"Promedio Grupal Final",1,0,'C');
            $pdf->Cell(4,2,$promedioP3,1,1,'C');
            $TituloDoc = "Calificaciones ".$periodo->Grado." ".$periodo->Grupo.".pdf";
            $pdf->Output('D',$TituloDoc);

        }
        

    }

    public function reporteAlumnos(){

        $var = $_SESSION['Matricula'];

        $periodo = $this->servicioP->obtenerActivo($var,1);

        $alumnos = $this->servicioUP->obtenerPorPeriodo($periodo->IdPeriodo);

        $titulo = "TUTORIAS POR ALUMNO";
        $pdf = new pdf($titulo);
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $pdf->SetFillColor(232,232,232);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(4,2,'MATRICULA',1,0,'C',1);
        $pdf->Cell(4,2,'NOMBRE',1,0,'C',1);
        $pdf->Cell(3,2,'FALTAS',1,0,'C',1);
        $pdf->Cell(3,2,'ASISTENCIAS',1,0,'C',1);
        $pdf->Cell(4,2,'FUTURAS CITAS',1,1,'C',1);
        $pdf->SetFont('Arial','',10);

        foreach ($alumnos as $alumno) {
            $InfAlumno = $this->servicioU->obtenerPorId($alumno->Usuario_Matricula);
            $pdf->Cell(4,2,$InfAlumno->Matricula,1,0,'C',1);
            $nombre = $InfAlumno->Nombre." ".$InfAlumno->ApellidoP." ".$InfAlumno->ApellidoM;
            $pdf->Cell(4,2,$nombre,1,0,'C',1);
            $faltas = 0;
            $asistidas = 0;
            $futuras = 0;

            $citas = $this->servicioC->obtenerPorAlumno($InfAlumno->Matricula);
            $hoy = strtotime(date("Y-m-d"));
            foreach ($citas as $cita) {
                $buscarCita = $this->servicioDi->encontrar($var,$cita->Disponibilidad_horario_Id);
                if($buscarCita != null){
                    $fechaComparacion = strtotime($cita->Fecha);
                    if($fechaComparacion<=$hoy){
                        if($cita->Asistencia==1){
                            $asistidas = $asistidas + 1;
                        }else{
                            $faltas = $faltas + 1;
                        }

                    }else{
                        $futuras = $futuras+1;
                    }
                }
            }
            $pdf->Cell(3,2,$faltas,1,0,'C',1);
            $pdf->Cell(3,2,$asistidas,1,0,'C',1);
            $pdf->Cell(4,2,$futuras,1,1,'C',1);
        }

        $pdf->Output('D','TutoriasAlumnos.pdf');
    }

    public function graficar(){
        if (empty($_GET)) {
            header("Location: ./");
        }

        $id = $_GET["id"];
        $cuestionario= $this->servicioCu->obtenerPorId($id);

        $titulo = "REPORTE DEL CUESTIONARIO ";
        $preguntas = $this->servicioCP->obtenerPreguntas($id);
        $R1 =array();
        $R2 =array();
        $R3 =array();
        $R4 =array();

        $cantidad = count($preguntas);
        for ($i=0; $i < $cantidad; $i++) { 
            $R1[] = 0;
            $R2[] = 0;
            $R3[] = 0;
            $R4[] = 0;
        }

        $j=0;
        foreach ($preguntas as $pregunta) {
            $respuestas = $this->servicioR->obtenerRespuestas($pregunta->Preguntas_cuestionario_Id);
            if(count($respuestas)>0){
                foreach ($respuestas as $respuesta) {
                    switch ($respuesta->Valor) {
                        case '1':
                            $R1[$j] = $R1[$j] + 1;
                            break;
                        case '2':
                            $R2[$j] = $R2[$j] + 1;
                            break;
                        case '3':
                            $R3[$j] = $R3[$j] + 1;
                            break;
                        case '4':
                            $R4[$j] = $R4[$j] + 1;
                            break;

                    }
                }
            }
            $j=$j+1;
        }
        $pdf = new pdf($titulo);
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $graph = new Graph\Graph(350,250);
        $graph->SetScale('textlin');
        $graph->SetMarginColor('white');

        $b1plot = new Plot\BarPlot($R1);
        $b1plot->SetFillColor("orange");
        $b2plot = new Plot\BarPlot($R2);
        $b2plot->SetFillColor("blue");
        $b3plot = new Plot\BarPlot($R3);
        $b3plot->SetFillColor("green");
        $b4plot = new Plot\BarPlot($R4);
        $b4plot->SetFillColor("yellow");

        $accbplot = new Plot\AccBarPlot(array($b1plot,$b2plot,$b3plot,$b4plot));
        $graph->Add($accbplot);

        $graph->title->Set($cuestionario->Nombre);
        $graph->xaxis->title->Set("PREGUNTAS");
        $graph->yaxis->title->Set("CANTIDAD DE RESPUESTAS");
         
        $graph->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
        unlink("ejemplo12.png");
        $graph->Stroke("ejemplo12.png");
        $x = 3;
        $y = 6; 
        $ancho = 10;  
        $altura = 10;
       
        $pdf->Image("ejemplo12.png",$x,$y,$ancho,$altura);
        $pdf->Output('D','EjemploGrafica.pdf');
    }
}

?>