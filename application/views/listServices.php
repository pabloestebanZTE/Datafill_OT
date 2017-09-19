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
    <!--   FORMULARIO CSS    -->
    <link href="/Datafill_OT/assets/css/formStyle.css" rel="stylesheet" />
    <!--   SWEET ALERT    -->
    <link rel="stylesheet" href="/Datafill_OT/assets/plugins/sweetalert-master/dist/sweetalert.css" />
    <script type="text/javascript" src="/Datafill_OT/assets/plugins/sweetalert-master/dist/sweetalert.min.js"></script>

    <script type="text/javascript" charset="utf-8" async defer>
      //Funcion para mostrar mensaje de error de validacion de datos
      function showMessage(mensaje){
        console.log(mensaje);
         if(mensaje == "ok"){
          swal({
            title: "Bien hecho!",
            text: "Actividad creada satisfactoriamente",
            type: "success",
            confirmButtonText: "Ok"
          });
        } else {
          swal({
            title: "error!",
            text: "Actividades ya existentes ",
            type: "error",
            confirmButtonText: "Ok"
          });
        } 
      }
    </script>
    <style>
        body {
            margin: 40px 10px;
            padding: 0;
            font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
            font-size: 14px;
        }

        #calendar {
            width: 50%;
            margin: 0 auto;
        }
    </style>
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
     <br><br>

<div class="container">
  <form class="well form-horizontal" action=" " method="post"  id="assignService" name="assignServie">
    <center>
      <legend >Lista de Actividades</legend>
    </center>

    <table id="demo" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <th>Id actividad</th>
                <th>Id orden</th>
                <th>Tipo</th>
                <th>Estación base</th>
                <th>Ingeniero Asignado</th>
                <th>F. Forecast</th>
                <th>F. Asignación</th>
                <th>Ingeniero Solicitante</th>
                <th>Proyecto</th>
                <th>estado</th>
            </tr>

            <?php
              if(isset($services)){
                  for($i = 0; $i < count($services); $i++){
                      if ($services[$i]->getUser() != "") {
                        echo "<tr>";
                        echo "<td><a href='/Datafill_OT/index.php/service/serviceDetails?K_ID_SP_SERVICE=".$services[$i]->getId()."'>".$services[$i]->getIdClaro()."</a></td>";
                        echo "<td>".$services[$i]->getOrder()->getId()."</td>";
                        echo "<td>".$services[$i]->getService()->getType()."</td>";
                        echo "<td>".$services[$i]->getSite()->getName()."</td>";
                        echo "<td>".$services[$i]->getUser()->getName()." ".$services[$i]->getUser()->getLastname()."</td>";
                        echo "<td>".$services[$i]->getDateForecast()."</td>";
                        echo "<td>".$services[$i]->getDateStartP()."</td>";
                        echo "<td>".$services[$i]->getIngSol()."</td>";
                        echo "<td>".$services[$i]->getProyecto()."</td>";
                        echo "<td>".$services[$i]->getEstado()."</td>";
                        echo "</tr>";
                      }
                  }
              }
             ?>
        </tbody>
    </table>
  </form>
</div>

<!--          container ------------>


  <!--footer-->
  <div class="for-full-back " id="footer">
      Zolid By ZTE Colombia | All Right Reserved
  </div>

  <script src="/Datafill_OT/assets/plugins/tableFilter/tablefilter.js"></script>
  <link rel="stylesheet" type="text/css" href="/Datafill_OT/assets/plugins/tableFilter/style/tablefilter.css">
  <script data-config>
    var filtersConfig = {
      base_path: '/Datafill_OT/assets/plugins/tableFilter/',
      filters_row_index: 1,
      alternate_rows: true,
      grid_cont_css_class: 'grd-main-cont',
      grid_tblHead_cont_css_class: 'grd-head-cont',
      grid_tbl_cont_css_class: 'grd-cont',
      loader: true
    };
      var tf1 = new TableFilter('demo', filtersConfig);
      tf1.init();
  </script>

    <?php
      if (isset($message)) {
        if($message == "ok"){
          echo '<script type="text/javascript">showMessage("ok");</script>';
        } else {
           echo '<script type="text/javascript">showMessage("error");</script>';
        }
      }
    ?>
</body>
</html>
