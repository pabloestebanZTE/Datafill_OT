<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ver RF</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="content-type" content="text/html; charsetutf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


        <!--   ICONO PAGINA    -->
        <link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
        <!--   botones tabla    -->
        <link rel="stylesheet" href="/Datafill_OT/assets/css/botonesStyle.css" type="text/css" media="all">
        <!--   BOOTSTRAP    -->
        <link href="/Datafill_OT/assets/css/bootstrap.css" rel="stylesheet" />
        <link href="/Datafill_OT/assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
        <link href="/Datafill_OT/assets/css/bootstrap.min.css" rel="stylesheet">
        <!--   HEADER CSS    -->
        <link href="/Datafill_OT/assets/css/styleHeader.css" rel="stylesheet" />

        <script src="/Datafill_OT/assets/js/jquery-2.1.1.min.js"></script>
        <script src="/Datafill_OT/assets/js/bootstrap.js"></script>

            <script type="text/javascript" src="/AdminZTE/assets/js/tabs.js"></script>

</head>
<body>
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
                        <li class="cam"><a href="/Datafill_OT/index.php/Service/RF">RF</a>
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

<?php

           echo "<div class='wrapper tabs'>";



                  $meses[1] = 'Enero';
                  $meses[2] = 'Febrero';
                  $meses[3] = 'Marzo';
                  $meses[4] = 'Abril';
                  $meses[5] = 'Mayo';
                  $meses[6] = 'Junio';
                  $meses[7] = 'Julio';
                  $meses[8] = 'Agosto';

                  echo "<ul class='nav'>";
                    echo "<center>";
                    for ($p = 1; $p <= count($meses); $p++){
                      if ($p == 1){
                        echo "<li class='selected'><a href='#tab".$p."'><center>".$meses[$p]."</center></a></li>";
                      } else {
                        echo "<li><a href='#tab".$p."'><center>".$meses[$p]."</center></a></li>";
                      }
                    }
                    echo "</center>";
                  echo "</ul>";



                                      echo "<div class='tab-content' id='tab1'>";
                                        echo "hola;";
                                      echo "</div>";

                                      echo "<div class='tab-content' id='tab2'>";

                                        echo "camilo;";
      echo "<div>";
      
        echo "<h3>RF</h3>";
        echo "<table class='table table-hover table-striped' style='font-size: 9px'>";
          echo "<thead>";
            echo "<tr style='background-color: #207BE5; color: white'>";
              echo "<th>Fecha Solicitada</th>";
              echo "<th>Solicitada por</th>";
              echo "<th>Estado</th>";
              echo "<th>Tipo</th>";
              echo "<th>Elemento</th>";
              echo "<th>Fecha Asignada</th>";
              echo "<th>Asignada_a</th>";
              echo "<th>Asignada_a</th>";
              echo "<th>Fecha Enviada</th>";
              echo "<th>Archivo</th>";
              echo "<th>Obs</th>";
              echo "<th>Modulo</th>";
              echo "<th>id</th>";
              echo "<th>Remedy</th>";
              echo "<th>Peso Orden</th>";
              echo "<th>Fecha Facturacion</th>";
              echo "<th>Mes Facturacion</th>";
              echo "<th>Fecha Revision</th>";
              echo "<th>Fecha Crudo</th>";
              echo "<th>Fecha OTGDRT</th>";
              echo "<th>Modulo</th>";
              echo "<th>idBSS</th>";
              echo "<th>Codigo</th>";
            echo "</tr>";
          echo "</thead>";
          echo "<tbody>";
          for ($i=1; $i <count($excel[0]) ; $i++) { 
            echo "<tr>";
              echo "<td>".$excel[0][$i][0]."</td>";
              echo "<td>".$excel[0][$i][1]."</td>";
              echo "<td>".$excel[0][$i][2]."</td>";
              echo "<td>".$excel[0][$i][3]."</td>";
              echo "<td>".$excel[0][$i][4]."</td>";
              echo "<td>".$excel[0][$i][5]."</td>";
              echo "<td>".$excel[0][$i][6]."</td>";
              echo "<td>".$excel[0][$i][7]."</td>";
              echo "<td>".$excel[0][$i][8]."</td>";
              echo "<td>".$excel[0][$i][9]."</td>";
              echo "<td>".$excel[0][$i][10]."</td>";
              echo "<td>".$excel[0][$i][11]."</td>";
              echo "<td>".$excel[0][$i][12]."</td>";
              echo "<td>".$excel[0][$i][13]."</td>";
              echo "<td>".$excel[0][$i][14]."</td>";
              echo "<td>".$excel[0][$i][15]."</td>";
              echo "<td>".$excel[0][$i][16]."</td>";
              echo "<td>".$excel[0][$i][17]."</td>";
              echo "<td>".$excel[0][$i][18]."</td>";
              echo "<td>".$excel[0][$i][19]."</td>";
              echo "<td>".$excel[0][$i][20]."</td>";
              echo "<td>".$excel[0][$i][21]."</td>";
              echo "<td>".$excel[0][$i][22]."</td>";
            echo "</tr>";
          }
           echo "<tfoot>";
            echo "<tr style='background-color: #207BE5; color: white'>";
              echo "<th>Fecha Solicitada</th>";
              echo "<th>Solicitada por</th>";
              echo "<th>Estado</th>";
              echo "<th>Tipo</th>";
              echo "<th>Elemento</th>";
              echo "<th>Fecha Asignada</th>";
              echo "<th>Asignada_a</th>";
              echo "<th>Asignada_a</th>";
              echo "<th>Fecha Enviada</th>";
              echo "<th>Archivo</th>";
              echo "<th>Obs</th>";
              echo "<th>Modulo</th>";
              echo "<th>id</th>";
              echo "<th>Remedy</th>";
              echo "<th>Peso Orden</th>";
              echo "<th>Fecha Facturacion</th>";
              echo "<th>Mes Facturacion</th>";
              echo "<th>Fecha Revision</th>";
              echo "<th>Fecha Crudo</th>";
              echo "<th>Fecha OTGDRT</th>";
              echo "<th>Modulo</th>";
              echo "<th>idBSS</th>";
              echo "<th>Codigo</th>";
            echo "</tr>";
          echo "</tfoot>";
      echo "<div>";

                                      echo "</div>";
                                     echo "</div>";

?>
    <script type="text/javascript"> Cufon.now(); </script>

    <script>
      $(document).ready(function() {
        tabs.init();
      })
    </script>
</body>
</html>
