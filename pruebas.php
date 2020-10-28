<?php
require "bootloader.php";

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Capsule\Manager as Capsule;
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

use Persistencia\Entidad\ProduccionAgricola;

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

//$stmt = '
//select
//    ?,
//    SUM(sembrada) as sumSembrada,
//    SUM(cosechada) as sumCosechada,
//    SUM(produccion) as sumProduccion,
//    SUM(valor) as sumValor
//from produccionAgricola
//where
//    anio = ? and
//    modalidad = ?
//group by distrito
//';

//$stmt =
//'select
//    CONCAT(agrupador.id, agrupador.nombre) as attrAgrupacion,
//    SUM(sembrada) as sumSembrada,
//    SUM(cosechada) as sumCosechada,
//    SUM(produccion) as sumProduccion,
//    SUM(valor) as sumValor
//from
//    produccionAgricola,
//    %s agrupador
//where
//    anio = ? and
//    modalidad = ?
//group by %s';
//
//$stmt = sprintf($stmt, 'distrito', 'distrito');
//
//echo $stmt;
//
//$objs = Capsule::select($stmt, [2000, 3]);

//$stmt = '
//            select
//                CONCAT(grup.id, grup.nombre) as attrAgrupacion,
//                SUM(sembrada) as sumSembrada,
//                SUM(cosechada) as sumCosechada,
//                SUM(produccion) as sumProduccion,
//                SUM(valor) as sumValor
//            from
//                produccionAgricola,
//                cultivo cul,
//                grupo grup
//            where
//                anio = ? and
//                modalidad = ?
//            group by grup.nombre';
//$objs = Capsule::select($stmt, [2000, 3]);
//return $objs;

//$objs = ProduccionAgricola::where([
//        ['anio', '=', 2000],
//        ['modalidad', '=', 3],
//    ])
//    ->groupBy('distrito')
//    ->sum('sembrada')
//    ->sum('cosechada')
//    ->sum('produccion')
//    ->sum('valor')
//    ->get();

//$objs = ProduccionAgricola::where('anio', '>', 1999)->get();

$stmt = '
    select
        CONCAT(agrup.id, " - ", agrup.nombre) as attrAgrupacion,
        SUM(regada1) as sumRegada1,
        SUM(distribuido1) as sumDistribuido1,
        SUM(usuario1) as sumUsuario1,
        SUM(regada2) as sumRegada2,
        SUM(distribuido2) as sumDistribuido2,
        SUM(usuario2) as sumUsuario2,
        SUM(regada3) as sumRegada3,
        SUM(distribuido3) as sumDistribuido3,
        SUM(usuario3) as sumUsuario3
    from
        volumenDistribuido,
        %s agrup
    where
        anio = ? and
        tenencia = ?
    group by agrup.nombre';

$stmt = sprintf($stmt, 'organismo');

//echo $stmt;

$anio = 2016;
$tenencia = 'tenenciab';
$objs = Capsule::select($stmt, [$anio, $tenencia]);

foreach ($objs as $obj) {
    echo $obj->attrAgrupacion . "\n";
    echo $obj->sumRegada1 . "\n";
    echo $obj->sumDistribuido1 . "\n";
    echo $obj->sumUsuario1 . "\n";
    echo $obj->sumRegada2 . "\n";
    echo $obj->sumDistribuido2 . "\n";
    echo $obj->sumUsuario2 . "\n";
    echo $obj->sumRegada3 . "\n";
    echo $obj->sumDistribuido3 . "\n";
    echo $obj->sumUsuario3 . "\n";
    echo "-----\n";
}


