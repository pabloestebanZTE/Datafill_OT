<!DOCTYPE html>
<html lang="en">
<head>
    <title>Detalles Actividad</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--   ICONO PAGINA    -->
    <link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
    <!--   BOOTSTRAP    -->
    <link href="/Datafill_OT/assets/css/bootstrap.css" rel="stylesheet" />
    <link href="/Datafill_OT/assets/css/font-awesome.min.css" rel="stylesheet" />
    <!--   HEADER CSS    -->
    <link href="/Datafill_OT/assets/css/styleHeader.css" rel="stylesheet" />
    <!--LIST CSS-->
  <link rel="stylesheet" type="text/css" href="/Datafill_OT/assets/css/styleList.css">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:Condensed" />
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,800' rel='stylesheet' type='text/css'>
    <!--   SWEET ALERT    -->
    <link rel="stylesheet" href="/Datafill_OT/assets/plugins/sweetalert-master/dist/sweetalert.css" />
    <script type="text/javascript" src="/Datafill_OT/assets/plugins/sweetalert-master/dist/sweetalert.min.js"></script>

</head>

<body>
    <!-- Navigation -->
    <header>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="logo"><img id="logo" src="/Datafill_OT/assets/img/logo2.png" /></a>
                </div>
                <!-- Collect the nav links for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="cam"><a >Bienvenid@ <?php print_r( $_SESSION['userName']) ?></a>
                        </li>
                        <li class="cam"><a href="/Datafill_OT/index.php/user/principalView">Home</a>
                        </li>
                        <li class="cam"><a href="#services">Servicios</a>
                        <ul>
                            <li><a href="/Datafill_OT/index.php/Service/assignService">Agendar Actividad</a></li>
                            <li><a href="/Datafill_OT/index.php/Service/listServices">Ver Actividades</a></li>
                            <li><a href="#">Ver Ingenieros</a></li>
                        </ul>
                        </li>
                        <li class="cam"><a href="#price-sec">Reportes</a>
                        </li>
                         <li class="cam"><a href="#contact-sec">Contactos</a>
                        </li>
                        </li>
                         <li class="cam"><a href="/Datafill_OT/index.php/welcome/index">Salir</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
     </header>
<!--      fin header         -->
     <br><br><br>
  <div id="container">
    <form action=" " method="post"  id="assignService" name="assignServie">
    <?php
      echo "<div class='whole' style='margin: 8px'>";
        echo "<div class='type'>";
          echo "<p>Orden</p>";
        echo "</div>";
      echo "<div class='plan'>";

      echo "<div class='header'>";
        echo "<span></span><img src='/Datafill_OT/assets/img/orden.png'><sup></sup>";
      echo "</div>";

      echo "<div class='content'>";
        echo "<ul>";
          echo "<div class='header'>Ing solicitante: ".$service->getIngSol()."</div>";
          echo "<div class='header'>Proyecto: ".$service->getProyecto()."</div>";
          echo "<div class='header'>Ing Asignado: ".$service->getUser()->getName()." ".$service->getUser()->getLastname()."</div>";
          echo "<li>Orden:    ".$service->getOrder()->getId()."</li>";
          echo "<li>ID Actividad:    ".$service->getIdClaro()."</li>";
          echo "<li>Estación Base:    ".$service->getSite()->getName()."</li>";
          echo "<li>Duración:    ".$service->getDuration()."</li>";
        echo "</ul>";
        echo "</div>";
        echo "</div>";
      echo "</div>";
      //------------------------------------------------------------------------------
      echo "<div class='whole' style='margin: 8px'>";
        echo "<div class='type'>";
          echo "<p>Tipo Actividad</p>";
        echo "</div>";
        echo "<div class='plan'>";
          echo "<div class='header'>";
            echo "<span></span><img src='/Datafill_OT/assets/img/actividades.png'><sup></sup>";
            echo "<p class='month'></p>";
          echo "</div>";
          echo "<div class='content'>";
            echo "<ul>";
              echo "<li>Tipo:    ".$service->getService()->getType()."</li>";
              echo "<div class='header'>Gerencia Tarea:    ".$service->getService()->getGerency()."</div>";
              echo "<div class='header'>Descripción Tarea:    ".$service->getService()->getDescription()."</div>";
              echo "<div class='header'>Alcance:    ".$service->getService()->getScope()."</div>";
            echo "</ul>";
          echo "</div>";
        echo "</div>";
      echo "</div>";
          //<!--____________________________________________-->

      echo "<div class='whole' style='margin: 8px'>";
        echo "<div class='type'>";
          echo "<p>Fechas</p>";
        echo "</div>";
        echo "<div class='plan'>";
          echo "<div class='header'>";
            echo "<span></span><img src='/Datafill_OT/assets/img/fecha.png'><sup></sup>";
            echo "<p class='month'></p>";
          echo "</div>";
          echo "<div class='content'>";
            echo "<ul>";
              echo "<li>Fecha Creacion:    ".$service->getDateCreation()."</li>";
              echo "<li>Fecha Inicio:    ".$service->getDateStartP()."</li>";
              echo "<li>Fecha Fin:     ".$service->getDateFinishP()."</li>";
              echo "<li>Fecha Inicio Real:     ".$service->getDateStartR()."</li>";
              echo "<li>Fecha Fin Real:     ".$service->getDateFinishR()."</li>";
              echo "<li>Fecha Forecast:     ".$service->getDateForecast()."</li>";
            echo "</ul>";
          echo "</div>";
        echo "</div>";
      echo "</div>";
//-----------------------------------------------------------------------------

      echo "<div class='whole' style='margin: 8px'>";
        echo "<div class='type'>";
          echo "<p>Observaciones</p>";
        echo "</div>";
        echo "<div class='plan'>";
          echo "<div class='header'>";
            echo "<span></span><img src='/Datafill_OT/assets/img/comentarios.png'><sup></sup>";
            echo "<p class='month'></p>";
          echo "</div>";
          echo "<div class='content'>";
            echo "<ul>";
              echo "<div class='header'>Observaciones Actividad: ".$service->getClaroDescription()."</div>";
              echo "<div class='header'>Observaciones Coordinador: ".$service->getDescription()."</div>";
              echo "<div class='header'>Observaciones de Cierre: ".$service->getCierreDescription()."</div>";
            echo "</ul>";
          echo "</div>";
          echo "<div class='content'>";   
          echo "</div>";
        echo "</div>";
      echo "</div>";

      //---------------------------------------------

      if ($service->getCRQ() == "" ) {
      echo "<div class='whole' style='margin: 8px'>";
        echo "<div class='type'>";
          echo "<p>Datos cierre</p>";
        echo "</div>";
        echo "<div class='plan'>";
          echo "<div class='header'>";
            echo "<span></span><img src='/Datafill_OT/assets/img/editar.png'><sup></sup>";
            echo "<p class='month'></p>";
          echo "</div>";
              echo "<div id='ultimate'>";
                echo "<p>Fecha inicio real</p>";
              echo "</div>";
                echo "<input type='date' name='fInicior' id='fInicior' class='form-control' value='' placeholder='Fecha Inicio Real' required style='display: center; color: white; background-color: #333;'>";
                echo "<div id='ultimate'>";
                  echo "<p>Fecha fin real</p>";
                echo "</div>";
              echo "<input type='date' name='fFinr' id='fFinr' class='form-control' value='' placeholder='Fecha Fin Real' required style='display: center; color: white; background-color: #333;'>";
          echo "<div class='content'>";
            echo "<div id='ultimate'>";
              echo "<p>CRQ</p>";
            echo "</div>";
             echo "<ul>";
              echo "<input type='text' name='crq' id='crq' class='form-control' value='' placeholder='Digite el CRQ' required style='display: center; color: white; background-color: #333;'>";
            echo "</ul>";
          echo "</div>";
          echo "<div class='content'>";
            echo "<div id='ultimate'>";
              echo "<p>Estado</p>";
            echo "</div>";
            echo "<ul>";
              echo "<select name='state' id='state' class='form-control' required style='display: center; color: white; background-color: #333;'>";
                echo "<option value=''>Seleccione Estado</option>";
                echo "<option value='Cerrado'>Cerrado</option>";
                echo "<option value='Cancelado'>Cancelado</option>";
              echo "</select>";
            echo "</ul>";
          echo "</div>";
          echo "<div class='content'>";
            echo "<div id='ultimate'>";
              echo "<p>Observaciones de cierre</p>";
            echo "</div>";
             echo "<ul>";
               echo "<textarea class='form-control' name='observacionesCierre' placeholder='observacionesCierre' style='display: center; color: white; background-color: #333;'>";
               echo "</textarea>";
             echo "</ul>";
          echo "</div>";
        echo "</div>";
        echo "<input name='keyId' value='".$service->getId()."' hidden>";
        echo "<input name='idService' value='".$service->getIdClaro()."' hidden>";
        echo "<input class='boton_personalizado' value='cerrar &raquo' type='submit' onclick = \"this.form.action = 'http://localhost/Datafill_OT/index.php/SpecificService/updateSpectService' \">";
      echo "</div>";
      }

      echo "<div class='whole' style='margin: 8px'>";
        echo "<div class='type' id='percho'>";
          echo "<p>estado</p>";
        echo "</div>";
        echo "<div id='".$service->getEstado()."'>";
          echo "<p>".$service->getEstado()."</p>";
        echo "</div>";
        echo "<div class='plan'>";          
        echo "</div>";
      echo "</div>";
      
      echo "<div class='whole' style='margin: 8px'>";
          echo "<div class='type' style='margin-top: 15px' id='percho'>";
          echo "<p>CRQ</p>";
        echo "</div>";         
        echo "<div id='".$service->getEstado()."'>";
          echo "<p>".$service->getCRQ()."</p>";
        echo "</div>";


    ?>
    </form>
  </div><br><br>
  <div class="for-full-back " id="footer">
      Zolid By ZTE Colombia | All Right Reserved
  </div>
</body>
</html>
