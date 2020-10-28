<!doctype html>

<html lang="en-US" xmlns:fb="https://www.facebook.com/2008/fbml" xmlns:addthis="https://www.addthis.com/help/api-spec"
      prefix="og: http://ogp.me/ns#" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CUESTIONARIO</title>
    <link rel="shortcut icon" href="https://demo.learncodeweb.com/favicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!--Slide
        <![endif]-->
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
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
                            <a title="Administradores" href="./?vista=verCuestionarios" class="nav-link">Cuestionarios</a>
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
                        
                    </ul>
                </div>
            </nav>
        </header>
    </div> <!--/.container-->
</div>

<div class="container">
    <br>
    <div class="card">
        <div class="card-header">
            <i class="fa fa-fw fa-globe"></i>
            <strong>CUESTIONARIO:  <?=$cuest->Nombre?></strong>
            <a href="./?vista=verCuestionarios" class="float-right btn btn-dark btn-sm">
                <i class="fa fa-fw fa-arrow-left"></i> Ver Cuestionarios
            </a>
        </div>
    

    <div class="card-body">
        <div class="col-sm-6">
            <h5 class="card-title">¡Los campos con <span class="text-danger">*</span> son obligatorios!</h5>
                <form method="post" enctype="multipart/form-data" action="./?vista=guardarR">
                    <input type="hidden" name="cant" id="cant" value="<?=$cantidad?>">
                    <?php
                    $i=0;
                    $cant=count($reactivos);
                    if ( $cant > 0) {
                        foreach($reactivos as $pregunta){ 
                            $t = $i*2;
                            $p = $t+1;
                            $r = $t+2;
                            $i = $i+1;
                            ?>

                            <div class="form-group">
                                <input type="hidden" name="<?=$p?>" id="<?=$p?>" value="<?=$pregunta->Id?>">
                                <label><?=$pregunta->Pregunta?><span class="text-danger">*</span></label><br>
                                <label><input type="radio" id="<?=$r?>" name="<?=$r?>" value="1"><?=$pregunta->Respuesta1?></label>
                                <label><input type="radio" id="<?=$r?>" name="<?=$r?>" value="2" ><?=$pregunta->Respuesta2?></label>
                                <?php
                                if ($pregunta->Respuesta3 != null){
                                ?>
                                    <label><input type="radio" id="<?=$r?>" name="<?=$r?>" value="3" ><?=$pregunta->Respuesta3?></label>
                                <?php
                                }
                                if ($pregunta->Respuesta4 != null){?>
                                    <label><input type="radio" id="<?=$r?>" name="<?=$r?>" value="4" ><?=$pregunta->Respuesta4?></label>
                                <?php
                                }?>

                            </div>
                    <?php
                        }
                    }
                    ?>
                    
                    <div class="form-group">
                        <button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary">
                             <i class="fa fa-fw fa-check"></i>Enviar
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
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
<script src='vistas/js/multiple-image-slider.js'></script>
</body>
</html>