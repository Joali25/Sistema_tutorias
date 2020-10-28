<?php
    # definimos los valores iniciales para nuestro calendario
    $month=date("n");
    $year=date("Y");
    $diaActual=date("j");
     
    # Obtenemos el dia de la semana del primer dia
    # Devuelve 0 para domingo, 6 para sabado
    $diaSemana=date("w",mktime(0,0,0,$month,1,$year))+7;
    # Obtenemos el ultimo dia del mes
    $ultimoDiaMes=date("d",(mktime(0,0,0,$month+1,1,$year)-1));
     
    $meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
    "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
?>
<!doctype html>
<html lang="en-US" xmlns:fb="https://www.facebook.com/2008/fbml" xmlns:addthis="https://www.addthis.com/help/api-spec"
      prefix="og: http://ogp.me/ns#" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Agendar Tutoría</title>

    <link rel="shortcut icon" href="https://demo.learncodeweb.com/favicon.ico">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>

<body>

<div class="bg-light border-bottom shadow-sm sticky-top">
    <div class="container">
        <header class="blog-header py-1">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="nav-item">
                            <a title="Tutores" href="./?vista=volver" class="nav-link">Inicio</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="nav-item">
                            <a title="Tutores" href="./?vista=agendarA" class="nav-link">Tutorías</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="nav-item">
                            <a title="Administradores" href="" class="nav-link">Cuestionarios</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="nav-item">
                            <a title="Cuenta" href="./?vista=cerrarSesion" class="nav-link">Cerrar sesión</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="nav-item">
                            <a title="Cuenta" class="nav-link" style="color:#F8F7F7;">_____________</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="nav-item">
                            <a title="Cuenta" class="nav-link" style="color:#070A5B;">MATRÍCULA: <?=$_SESSION['Matricula']?></a>
                        </li>
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Consultas
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="./?vista=informacionProduccion">Informació de producción</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./?vista=informacionVolumen">Informació de volumen</a>
                            </div>
                        </li> -->
                    </ul>
                </div>
            </nav>
        </header>
    </div> <!--/.container-->
</div>

                                <!--TABLA QUE MUESTRA LA DISPONIBILIDAD DE HORARIO-->
<div class="container">
    <br>
    <div class="card">
        <div class="card-header">
            <i class="fa fa-fw fa-globe"></i>
            <strong>Agendar tutoría</strong>
            
        </div>
    </div>
    <hr>

    <div>
        <table id="calendar" class="table table-striped table-bordered">
            <thead>
                <th colspan="7" ><?php echo $meses[$month]." ".$year?></th>
            </thead>
            
            <tr>
                <th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th>
                <th>Vie</th><th>Sab</th><th>Dom</th>
            </tr>
            <tr bgcolor="silver">
                <?php
                $last_cell=$diaSemana+$ultimoDiaMes;
                // hacemos un bucle hasta 42, que es el máximo de valores que puede
                // haber... 6 filas de 7 columnas(dias)
                for($i=1;$i<=42;$i++)
                {
                    if($i==$diaSemana)
                    {
                        // determinamos en que dia empieza
                        $day=1;
                    }
                    if($i<$diaSemana || $i>=$last_cell)
                    {
                        // celda vacía
                        echo "<td>&nbsp;</td>";
                    }else{
                        // mostramos el dia
                        if($day<=$diaActual || $i%7==0 || ($i+1)%7==0){
                            echo "<td class='hoy'>$day</td>";
                        }
                        else{
                            if(($i+6)%7==0){
                                if($citas[0]==0){
                                    echo "<td class='hoy'>$day</td>";
                                }else{
                                    //Se pinta verde
                                    if($reservas[$day]==0){
                                        echo "<td style='background-color: #78FA56'><a href='./?vista=agendarA2&id=$day' class='text-primary'>$day</a></td>";
                                    }
                                    if($citas[0]>$reservas[$day] && $reservas[$day]>0){
                                        echo "<td style='background-color: #FDF159'><a href='./?vista=agendarA2&id=$day' class='text-primary'>$day</a></td>";
                                    }
                                    if($citas[0]==$reservas[$day]){
                                        echo "<td style='background-color: #FE1B08'>$day</td>";
                                    }
                                }
                            }
                            if(($i+5)%7==0){
                                if($citas[1]==0){
                                    echo "<td class='hoy'>$day</td>";
                                }else{
                                    //Se pinta verde
                                    if($reservas[$day]==0){
                                        echo "<td style='background-color: #78FA56'><a href='./?vista=agendarA2&id=$day' class='text-primary'>$day</a></td>";
                                    }
                                    if($citas[1]>$reservas[$day] && $reservas[$day]>0){
                                        echo "<td style='background-color: #FDF159'><a href='./?vista=agendarA2&id=$day' class='text-primary'>$day</a></td>";
                                    }
                                    if($citas[1]==$reservas[$day]){
                                        echo "<td style='background-color: #FE1B08'>$day</td>";
                                    }
                                }
                            }
                            if(($i+4)%7==0){
                                if($citas[2]==0){
                                    echo "<td class='hoy'>$day</td>";
                                }else{
                                    //Se pinta verde
                                    if($reservas[$day]==0){
                                        echo "<td style='background-color: #78FA56'><a href='./?vista=agendarA2&id=$day' class='text-primary'>$day</a></td>";
                                    }
                                    if($citas[2]>$reservas[$day] && $reservas[$day]>0){
                                        echo "<td style='background-color: #FDF159'><a href='./?vista=agendarA2&id=$day' class='text-primary'>$day</a></td>";
                                    }
                                    if($citas[2]==$reservas[$day]){
                                        echo "<td style='background-color: #FE1B08'>$day</td>";
                                    }
                                }
                            }
                            if(($i+3)%7==0){
                                if($citas[3]==0){
                                    echo "<td class='hoy'>$day</td>";
                                }else{
                                    //Se pinta verde
                                    if($reservas[$day]==0){
                                        echo "<td style='background-color: #78FA56'><a href='./?vista=agendarA2&id=$day' class='text-primary'>$day</a></td>";
                                    }
                                    if($citas[3]>$reservas[$day] && $reservas[$day]>0){
                                        echo "<td style='background-color: #FDF159'><a href='./?vista=agendarA2&id=$day' class='text-primary'>$day</a></td>";
                                    }
                                    if($citas[3]==$reservas[$day]){
                                        echo "<td style='background-color: #FE1B08'>$day</td>";
                                    }
                                }
                            }
                            if(($i+2)%7==0){
                                if($citas[4]==0){
                                    echo "<td class='hoy'>$day</td>";
                                }else{
                                    //Se pinta verde
                                    if($reservas[$day]==0){
                                        echo "<td style='background-color: #78FA56'><a href='./?vista=agendarA2&id=$day' class='text-primary'>$day</a></td>";
                                    }
                                    if($citas[4]>$reservas[$day] && $reservas[$day]>0){
                                        echo "<td style='background-color: #FDF159'><a href='./?vista=agendarA2&id=$day' class='text-primary'>$day</a></td>";
                                    }
                                    if($citas[4]==$reservas[$day]){
                                        echo "<td style='background-color: #FE1B08'>$day</td>";
                                    }
                                }
                            }
                            
                        }
                        $day++;
                    }
                    // cuando llega al final de la semana, iniciamos una columna nueva
                    if($i%7==0)
                    {
                        echo "</tr><tr>\n";
                    }
                }
            ?>
            </tr>
        </table>
    </div> <!--/.col-sm-12-->

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/jquery.caret/0.1/jquery.caret.js"></script>
<script src="https://www.solodev.com/_/assets/phone/jquery.mobilePhoneNumber.js"></script>
<script
    src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
    integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
    crossorigin="anonymous"></script>
</body>
</html>
