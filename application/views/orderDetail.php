<!DOCTYPE html>
<html lang="en">
<head>
    <title>Lista Actividades</title>
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
                         <li class="cam"><a href="#">Salir</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
     </header>
<!--      fin header         -->
     <br><br><br>
<div id="container">
<?php
//echo "<br>";
//print_r($service);
      echo ";<div class='whole' style='margin: 8px'>";
          echo "<div class='type'>";
           echo "<p>Orden</p>";
          echo "</div>";
        echo "<div class='plan'>";

          echo "<div class='header'>";
           echo "<span></span><img src='/Datafill_OT/assets/img/orden.png'><sup></sup>";
          echo "</div>";

              echo "<div class='content'>";
                echo "<ul>";  
                  echo "<li>INGENIERO: ".$service->getUser()->getName()." ".$service->getUser()->getLastname()."</li>";
                  echo "<li>ORDEN:    ".$service->getOrder()->getId()."</li>";
                  echo "<li>ID ACTIVIDAD:    ".$service->getId()."</li>";
                  echo "<li>EB:    ".$service->getSite()->getName()."</li>";
                  echo "<li>DURACION:    ".$service->getDuration()."</li>";
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
                  echo "<li>TIPO:    ".$service->getService()->getType()."</li>";
                  echo "<li>G TAREA:    ".$service->getService()->getGerency()."</li>";
                  echo "<div class='header'>D TAREA:    ".$service->getService()->getDescription()."</div>";
                  echo "<div class='header'>ALCANCE:    ".$service->getService()->getScope()."</div>";
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
                      echo "<li>FECHA INICIO:    ".$service->getDateStartP()."</li>";
                      echo "<li>FECHA FIN:     ".$service->getDateFinishP()."</li>";  
                      echo "<div id='ultimate'>";
                       echo "<p>Fecha inicio real</p>";
                      echo "</div>"; 
                      echo "<li><input type='date' name='fInicior' id='fInicior' class='form-control' value='' placeholder='Fecha Inicio Real' required style='display: center; color: white; background-color: #333;'></li>";
                      echo "<div id='ultimate'>";
                       echo "<p>Fecha fin real</p>";
                      echo "</div>"; 
                      echo "<li><input type='date' name='fFinr' id='fFinr' class='form-control' value='' placeholder='Fecha Fin Real' required style='display: center; color: white; background-color: #333;'></li>";                     
                    echo "</ul>";
                  echo "</div>";

            echo "</div>";            
      echo "</div>";
                      echo "<div class='whole' style='margin-left: 28px'>";
                        echo "<div class='type'>";
                          echo "<p>Observaciones</p>";
                        echo "</div>";
                          echo "<div class='plan'>";
                            echo "<span></span><img src='/Datafill_OT/assets/img/editar.png'><sup></sup>";
                            echo "<div class='content'>";
                                  echo "<ul>";
                                    echo "<div class='header'>OBSERVACIONES ACTIVIDAD: ".$service->getClaroDescription()."</div>";
                                    echo "<div class='header'>OBSERVACIONES COORDINADOR: ".$service->getDescription()."</div></li>";
                                    
?>
                                <div id='ultimate'>
                                    <p>Observaciones de cierre</p>
                                </div>
                                    <li>
                                      <textarea class="form-control" name="observaciones" placeholder="Observaciones" style="display: center; color: white; background-color: #333;">                                  
                                      </textarea>
                                    </li>
                                  </ul>
                            </div>
                            <div class="content">
                            <div id="ultimate">
                                <p>CRQ</p>
                            </div>
                              <ul>
                                <input type='text' name="crq" id="crq" class="form-control" value='' placeholder='Digite el CRQ' required style="display: center; color: white; background-color: #333;">
                              </ul>
                            </div>
                            <div class="content">
                            <div id="ultimate">
                                <p>Estado</p>
                            </div>
                              <ul>
                                <select name="state" id="state" class="form-control" required style="display: center; color: white; background-color: #333;">
                                  <option value="">Seleccione Estado</option>
                                  <option value="">Seleccione Estado</option>
                                  <option value="">Seleccione Estado</option>
                                  <option value="">Seleccione Estado</option>
                                  <option value="">Seleccione Estado</option>
                                </select>
                              </ul>
                            </div>
                          </div>
                              <a class="boton_personalizado" href="#">CERRAR <i class="glyphicon glyphicon-share-alt"></i></a>
                      </div>
      <!--______________________________________________________________-->
        

    </form>
</div><br><br>.
</body>
</html>