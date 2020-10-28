<!doctype html>

<html lang="en-US" xmlns:fb="https://www.facebook.com/2008/fbml" xmlns:addthis="https://www.addthis.com/help/api-spec"
      prefix="og: http://ogp.me/ns#" class="no-js">

<!-- Se agregan los enlaces pertinentes para añadir formato a la página-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Agregar Evento</title>
    <link rel="shortcut icon" href="https://demo.learncodeweb.com/favicon.ico">
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
                            <a title="Tutores" href="" class="nav-link">Tutores</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="nav-item">
                            <a title="Administradores" href="" class="nav-link">Administradores</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="active nav-item">
                            <a title="Eventos" href="./?vista=consultarEvento" class="nav-link">Eventos</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="nav-item">
                            <a title="FormatoT" href="./?vista=consultarFormato" class="nav-link">Formato de tutorías</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="nav-item">
                            <a title="Transitar" href="" class="nav-link">Transitar de cuatrimestre</a>
                        </li>
                        <li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"
                            class="nav-item">
                            <a title="Reportes" href="./?vista=consultarGrupo" class="nav-link">Reportes</a>
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
                                                    <!--FORMULARIO PARA UN NUEVO EVENTO-->
<div class="container">
    <br>
    <div class="card">

        <div class="card-header">
            <i class="fa fa-fw fa-plus-circle"></i>
            <strong>Agregar Evento</strong>
            <a href="./?vista=consultarEvento" class="float-right btn btn-dark btn-sm"><i class="fa fa-fw fa-globe"></i>Consultar Eventos</a>
        </div>

        <div class="card-body">
            <div class="col-sm-6">
                <h5 class="card-title">¡Los campos con <span class="text-danger">*</span> son obligatorios!</h5>
                <form method="post" enctype="multipart/form-data" action="./?vista=agregarEvento">
                    <div class="form-group">
                        <label>NOMBRE: <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresa el nombre para el evento" required>
                    </div>
                    <div class="form-group">
                        <label>IMAGEN (.jpg o .jpeg): <span class="text-danger">*</span></label>
                        <input type="file" id="imagen" name="imagen" accept="image/jpg, image/jpeg" required>
                    </div>

                    <div class="form-group">
                        <label>URL: <span class="text-danger">*</span></label>
                        <input type="text" name="url" id="url" class="form-control" placeholder="Ingresa el url" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary">
                            <i class="fa fa-fw fa-plus-circle"></i> Agregar Evento
                        </button>
                    </div>
                </form>
            </div>
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
</body>
</html>