<!doctype html>
<html lang="en-US" xmlns:fb="https://www.facebook.com/2008/fbml" xmlns:addthis="https://www.addthis.com/help/api-spec"
      prefix="og: http://ogp.me/ns#" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Editar Cuestionario</title>

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
                            <a title="FormatoT" href="" class="nav-link">Cuestionarios</a>
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
            <i class="fa fa-fw fa-plus-circle"></i>
            <strong>Editar Cuestionario</strong>
            <a href="./?vista=cuestionarios" class="float-right btn btn-dark btn-sm"><i class="fa fa-fw fa-arrow-left"></i>Consultar Cuestionarios</a>
        </div>

        <div class="card-body">
            <h5 class="card-title">¡Los campos con <span class="text-danger">*</span> son obligatorios! Debes poner mínimo dos opciones de respuesta por pregunta</h5>
            <form method="post" enctype="multipart/form-data" action="./?vista=guardarCuestionario">
                <div class="form-group">
                    <input type="hidden" name="idC" id="idC" value="<?=$obj->Id?>">
                    <input type="hidden" name="cant" id="cant" value="<?=$cantidad?>">
                    <label>NOMBRE DEL CUESTIONARIO: <span class="text-danger">*</span></label>
                    <input type="text" name="nombre" id="nombre" value="<?=$obj->Nombre?>" class="form-control" placeholder="Ingresa el nombre del usuario" required>
                </div>
                <div class="form-group">
                    <label>PREGUNTAS DEL CUESTIONARIO: <span class="text-danger">*</span></label>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr class="bg-primary text-white">
                            <th class="text-center">No.</th>
                            <th class="text-center">Pregunta*</th>
                            <th class="text-center">Respuesta 1*</th>
                            <th class="text-center">Respuesta 2*</th>
                            <th class="text-center">Respuesta 3</th>
                            <th class="text-center">Respuesta 4</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i =0;
                        foreach ($preguntas as $pregunta) {
                            $t = $i*6;
                            $j = $t + 1;
                            $k = $t + 2;
                            $l = $t + 3;
                            $m = $t + 4;
                            $n = $t + 5;
                            $o = $t + 6;
                            $i=$i+1;
                            ?>
                            <tr>
                                <td align="center"><input type="hidden" name="<?=$j?>" id="<?=$j?>" class="form-control" value="<?=$pregunta->Id?>"><?=$i?></td>
                                <td align="center"><input type="text" name="<?=$k?>" id="<?=$k?>" class="form-control" value="<?=$pregunta->Pregunta?>" required></td>
                                <td align="center"><input type="text" name="<?=$l?>" id="<?=$l?>" class="form-control" value="<?=$pregunta->Respuesta1?>" required></td>
                                <td align="center"><input type="text" name="<?=$m?>" id="<?=$m?>" class="form-control" value="<?=$pregunta->Respuesta2?>" required></td>
                                <td align="center"><input type="text" name="<?=$n?>" id="<?=$n?>" class="form-control" value="<?=$pregunta->Respuesta3?>" ></td> 
                                <td align="center"><input type="text" name="<?=$o?>" id="<?=$o?>" class="form-control" value="<?=$pregunta->Respuesta4?>" ></td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                    
                <div class="form-group">
                    <button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary">
                    <i class="fa fa-fw fa-plus-circle"></i> Guardar cambios
                    </button>
                </div>
            </form>
        
        </div>
    </div>
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
