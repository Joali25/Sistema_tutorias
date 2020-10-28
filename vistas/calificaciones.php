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
            <strong>Calificaciones</strong>
            
        </div>
    </div>
    <hr>

    <div class="card-body">
        <h5 class="card-title">Ingresa el documento donde se tengan las calificaciones de los estudiantes e indica el parcial al que pertenecen. Puedes descargar la plantilla de calificaciones de acuerdo al cuatrimestre de tu grupo tutorado</h5>
        <form method="post" enctype="multipart/form-data" action="./?vista=subirCalificaciones">
            <div class="form-group" align="center">
                <label>SUBIR PLANTILLA: <span class="text-danger">*</span></label>
                <input type="file" id="documento" name="documento" accept="xlsx" required>
            </div>
            <div class="form-group" align="center">
                <label>Parcial: <span class="text-danger">*</span></label>
                <select name="parcial" id="parcial" required>
                    <option value="1">Primer parcial</option>
                    <option value="2">Segundo parcial</option>
                    <option value="3">Final</option>
                </select>
            </div>
            <div class="form-group" align="center">
                <button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary">
                <i class="fa fa-fw fa-arrow-up"></i> Subir calificaciones
            </div>    
        </form>

        <table class="table table-striped table-bordered">
            <thead>
            <tr class="bg-primary text-white">
                <th class="text-center">Plantilla</th>
                <th class="text-center">Descargar</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="center">Plantilla para Calificaciones Primer Cuatrimestre</td>
                    <td align="center">
                        <a href="vistas/Plantillas/Primer.xlsx" class="float btn btn-dark btn-sm" download="Plantilla Calificaciones Primer Cuatrimestre"><i class="fa fa-fw fa-arrow-down"></i> Descargar</a>
                    </td>
                </tr>
                <tr>
                    <td align="center">Plantilla para Calificaciones Segundo Cuatrimestre</td>
                    <td align="center">
                        <a href="vistas/Plantillas/Segundo.xlsx" class="float btn btn-dark btn-sm" download="Plantilla Calificaciones Segundo Cuatrimestre"><i class="fa fa-fw fa-arrow-down"></i> Descargar</a>
                    </td>
                </tr>
                <tr>
                    <td align="center">Plantilla para Calificaciones Tercer Cuatrimestre</td>
                    <td align="center">
                        <a href="vistas/Plantillas/Tercer.xlsx" class="float btn btn-dark btn-sm" download="Plantilla Calificaciones Tercer Cuatrimestre"><i class="fa fa-fw fa-arrow-down"></i> Descargar</a>
                    </td>
                </tr>
                <tr>
                    <td align="center">Plantilla para Calificaciones Cuarto Cuatrimestre</td>
                    <td align="center">
                        <a href="vistas/Plantillas/Cuarto.xlsx" class="float btn btn-dark btn-sm" download="Plantilla Calificaciones Cuarto Cuatrimestre"><i class="fa fa-fw fa-arrow-down"></i> Descargar</a>
                    </td>
                </tr>
                <tr>
                    <td align="center">Plantilla para Calificaciones Quinto Cuatrimestre</td>
                    <td align="center">
                        <a href="vistas/Plantillas/Quinto.xlsx" class="float btn btn-dark btn-sm" download="Plantilla Calificaciones Quinto Cuatrimestre"><i class="fa fa-fw fa-arrow-down"></i> Descargar</a>
                    </td>
                </tr>
                <tr>
                    <td align="center">Plantilla para Calificaciones Sexto Cuatrimestre</td>
                    <td align="center">
                        <a href="vistas/Plantillas/Sexto.xlsx" class="float btn btn-dark btn-sm" download="Plantilla Calificaciones Sexto Cuatrimestre"><i class="fa fa-fw fa-arrow-down"></i> Descargar</a>
                    </td>
                </tr>
                <tr>
                    <td align="center">Plantilla para Calificaciones Séptimo Cuatrimestre</td>
                    <td align="center">
                        <a href="vistas/Plantillas/Septimo.xlsx" class="float btn btn-dark btn-sm" download="Plantilla Calificaciones Séptimo Cuatrimestre"><i class="fa fa-fw fa-arrow-down"></i> Descargar</a>
                    </td>
                </tr>
                <tr>
                    <td align="center">Plantilla para Calificaciones Octavo Cuatrimestre</td>
                    <td align="center">
                        <a href="vistas/Plantillas/Octavo.xlsx" class="float btn btn-dark btn-sm" download="Plantilla Calificaciones Octavo Cuatrimestre"><i class="fa fa-fw fa-arrow-down"></i> Descargar</a>
                    </td>
                </tr>
                <tr>
                    <td align="center">Plantilla para Calificaciones Noveno Cuatrimestre</td>
                    <td align="center">
                        <a href="vistas/Plantillas/Noveno.xlsx" class="float btn btn-dark btn-sm" download="Plantilla Calificaciones Noveno Cuatrimestre"><i class="fa fa-fw fa-arrow-down"></i> Descargar</a>
                    </td>
                </tr>
            </tbody>
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
