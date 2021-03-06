<!doctype html>
<html lang="en-US" xmlns:fb="https://www.facebook.com/2008/fbml" xmlns:addthis="https://www.addthis.com/help/api-spec"
      prefix="og: http://ogp.me/ns#" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Calificaciones</title>

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
                            <a title="Tutores" href="" class="nav-link">Alumnos</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="nav-item">
                            <a title="Administradores" href="" class="nav-link">Calificaciones</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="active nav-item">
                            <a title="Eventos" href="./?vista=consultarDisponibilidad" class="nav-link">Disponibilidad de horario</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="nav-item">
                            <a title="FormatoT" href="./?vista=calificaciones" class="nav-link">Cuestionarios</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="nav-item">
                            <a title="Transitar" href="" class="nav-link">Tutorías</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="nav-item">
                            <a title="Reportes" href="" class="nav-link">Reportes</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="nav-item">
                            <a title="Cuenta" href="" class="nav-link">Mi cuenta</a>
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
            <strong>Información extraída del Excel</strong>
            <a href="./?vista=calificaciones" class="float-right btn btn-dark btn-sm">
                <i class="fa fa-fw fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
    <hr>

    <div>
        <h5 >Se ha extraído la siguiente información del Excel. Puede realizar modificaciones a los campos antes de Confirmar la subida de los datos al sistema.</h5>
        <form method="post" enctype="multipart/form-data" action="./?vista=guardarCalificaciones">
            <input type="hidden" name="parcial" id="parcial" value="<?=$parcial?>">
            <input type="hidden" name="cantidad" id="cantidad" value="<?=$Filas?>">
            <div class="form-group">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr class="bg-primary text-white">
                        <th class="text-center">Matrícula</th>
                        <th class="text-center">Calif. 1</th>
                        <th class="text-center">Calif. 2</th>
                        <th class="text-center">Calif. 3</th>
                        <th class="text-center">Calif. 4</th>
                        <th class="text-center">Calif. 5</th>
                        <th class="text-center">Calif. 6</th>
                        <th class="text-center">Calif. 7</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $cant=$Filas-1;
                    if ( $cant > 0) {
                        for($i=0; $i<$cant;$i++) {
                            $t = $i*8;
                            $j = $t + 1;
                            $k = $t + 2;
                            $l = $t + 3;
                            $m = $t + 4;
                            $n = $t + 5;
                            $o = $t + 6;
                            $p = $t + 7;
                            $q = $t + 8;
                            $numero = $i+1;
                            ?>
                            <tr>
                                <td align="center"><input type="text" name="<?=$j?>" id="<?=$j?>" value="<?=$matricula[$i]?>" class="form-control" required></td>
                                <td align="center"><input type="text" name="<?=$k?>" id="<?=$k?>" value="<?=$c1[$i]?>" class="form-control" required></td>
                                <td align="center"><input type="text" name="<?=$l?>" id="<?=$l?>" value="<?=$c2[$i]?>" class="form-control" required></td>
                                <td align="center"><input type="text" name="<?=$m?>" id="<?=$m?>" value="<?=$c3[$i]?>" class="form-control" required></td>
                                <td align="center"><input type="text" name="<?=$n?>" id="<?=$n?>" value="<?=$c4[$i]?>" class="form-control" required></td>
                                <td align="center"><input type="text" name="<?=$o?>" id="<?=$o?>" value="<?=$c5[$i]?>" class="form-control" required></td>
                                <td align="center"><input type="text" name="<?=$p?>" id="<?=$p?>" value="<?=$c6[$i]?>" class="form-control" required></td>
                                <td align="center"><input type="text" name="<?=$q?>" id="<?=$q?>" value="<?=$c7[$i]?>" class="form-control" required></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr><td colspan="5" align="center">No hay nada registrado en el Excel</td></tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                <button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary">
                <i class="fa fa-fw fa-plus-circle"></i> Confirmar datos
                </button>
            </div>
        </form>
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
