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

        <script type="text/javascript" src="/Datafill_OT/assets/js/tabs.js"></script>

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
                                <li><a href="https://drive.google.com/drive/u/2/my-drive" target='_blank'>Drive</a></li>
                            </ul>
                        </li>
                        <li class="cam"><a href="#services">RF</a>
                            <ul>
                                <li class="cam"><a href="/Datafill_OT/index.php/Service/RF">Actualizar RF</a></li>
                                <li class="cam"><a href="/Datafill_OT/index.php/SpecificService/viewRF">Ver RF</a></li>
                            </ul>
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
        $meses[9] = 'Septiembre';
        $meses[10] = 'Octubre';
        $meses[11] = 'Noviembre';
        $meses[12] = 'Diciembre';

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
        //----------------------tabla 1-------------------------------
        echo "<div class='tab-content' id='tab1'><br>";
            echo "<div>";
              echo "<h3>RF</h3>";
              echo "<table id='demo1' cellpadding='0' cellspacing='0' style='font-size: 9px'>";
                echo "<thead>";
                  echo "<tr style='background-color: #207BE5; color: white'>";
                    echo "<th>Fecha Solicitada</th>";
                    echo "<th>Solicitada por</th>";
                    echo "<th>Estado</th>";
                    echo "<th>Tipo</th>";
                    echo "<th>Elemento</th>";
                    echo "<th>Fecha Asignada</th>";
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
                    echo "<th>idBSS</th>";
                    echo "<th>Codigo</th>";
                  echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                for ($i=0; $i <count($rf) ; $i++) {
                  if (explode("-",$rf[$i]->getDateRequested())[1] == 1) {
                    echo "<tr style='background-color: ".$rf[$i]->getColor().";'>";
                        echo "<td>".$rf[$i]->getDateRequested()."</td>";
                        echo "<td>".$rf[$i]->getRequestedBy()."</td>";
                        echo "<td>".$rf[$i]->getStatus()."</td>";
                        echo "<td>".$rf[$i]->getType()."</td>";
                        echo "<td>".$rf[$i]->getElement()."</td>";
                        echo "<td>".$rf[$i]->getDateAssigned()."</td>";
                        echo "<td>".$rf[$i]->getAssignedTo()."</td>";
                        echo "<td>".$rf[$i]->getDateSent()."</td>";
                        echo "<td>".$rf[$i]->getFile()."</td>";
                        echo "<td>".$rf[$i]->getObs()."</td>";
                        echo "<td>".$rf[$i]->getModule()."</td>";
                        echo "<td>".$rf[$i]->getId()."</td>";
                        echo "<td>".$rf[$i]->getRemedy()."</td>";
                        echo "<td>".$rf[$i]->getWeightOrder()."</td>";
                        echo "<td>".$rf[$i]->getDateBilling()."</td>";
                        echo "<td>".$rf[$i]->getMonthBilling()."</td>";
                        echo "<td>".$rf[$i]->getDateReview()."</td>";
                        echo "<td>".$rf[$i]->getDateRaw()."</td>";
                        echo "<td>".$rf[$i]->getDateOTGDRT()."</td>";
                        echo "<td>".$rf[$i]->getIdBSS()."</td>";
                        echo "<td>".$rf[$i]->getCode()."</td>";
                      echo "</tr>";
                  }
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
                    echo "<th>idBSS</th>";
                    echo "<th>Codigo</th>";
                  echo "</tr>";
                echo "</tfoot>";
              echo "</table>";
            echo "</div>";
           echo "</div>";
         //-------------------fin tabla 1-----------------------

  //----------------------tabla 2-------------------------------
    echo "<div class='tab-content' id='tab2'><br>";
        echo "<div>";
          echo "<h3>RF</h3>";
          echo "<table id='demo2' cellpadding='0' cellspacing='0' style='font-size: 9px'>";
            echo "<thead>";
              echo "<tr style='background-color: #207BE5; color: white'>";
                echo "<th>Fecha Solicitada</th>";
                echo "<th>Solicitada por</th>";
                echo "<th>Estado</th>";
                echo "<th>Tipo</th>";
                echo "<th>Elemento</th>";
                echo "<th>Fecha Asignada</th>";
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
                echo "<th>idBSS</th>";
                echo "<th>Codigo</th>";
              echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            for ($i=0; $i <count($rf) ; $i++) {
              if (explode("-",$rf[$i]->getDateRequested())[1] == 2) {
                echo "<tr style='background-color: ".$rf[$i]->getColor().";'>";
                    echo "<td>".$rf[$i]->getDateRequested()."</td>";
                    echo "<td>".$rf[$i]->getRequestedBy()."</td>";
                    echo "<td>".$rf[$i]->getStatus()."</td>";
                    echo "<td>".$rf[$i]->getType()."</td>";
                    echo "<td>".$rf[$i]->getElement()."</td>";
                    echo "<td>".$rf[$i]->getDateAssigned()."</td>";
                    echo "<td>".$rf[$i]->getAssignedTo()."</td>";
                    echo "<td>".$rf[$i]->getDateSent()."</td>";
                    echo "<td>".$rf[$i]->getFile()."</td>";
                    echo "<td>".$rf[$i]->getObs()."</td>";
                    echo "<td>".$rf[$i]->getModule()."</td>";
                    echo "<td>".$rf[$i]->getId()."</td>";
                    echo "<td>".$rf[$i]->getRemedy()."</td>";
                    echo "<td>".$rf[$i]->getWeightOrder()."</td>";
                    echo "<td>".$rf[$i]->getDateBilling()."</td>";
                    echo "<td>".$rf[$i]->getMonthBilling()."</td>";
                    echo "<td>".$rf[$i]->getDateReview()."</td>";
                    echo "<td>".$rf[$i]->getDateRaw()."</td>";
                    echo "<td>".$rf[$i]->getDateOTGDRT()."</td>";
                    echo "<td>".$rf[$i]->getIdBSS()."</td>";
                    echo "<td>".$rf[$i]->getCode()."</td>";
                  echo "</tr>";
              }
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
                echo "<th>idBSS</th>";
                echo "<th>Codigo</th>";
              echo "</tr>";
            echo "</tfoot>";
          echo "</table>";
        echo "</div>";
       echo "</div>";
     //-------------------fin tabla 2-----------------------

   //----------------------tabla 3-------------------------------
     echo "<div class='tab-content' id='tab3'><br>";
         echo "<div>";
           echo "<h3>RF</h3>";
           echo "<table id='demo3' cellpadding='0' cellspacing='0' style='font-size: 9px'>";
             echo "<thead>";
               echo "<tr style='background-color: #207BE5; color: white'>";
                 echo "<th>Fecha Solicitada</th>";
                 echo "<th>Solicitada por</th>";
                 echo "<th>Estado</th>";
                 echo "<th>Tipo</th>";
                 echo "<th>Elemento</th>";
                 echo "<th>Fecha Asignada</th>";
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
                 echo "<th>idBSS</th>";
                 echo "<th>Codigo</th>";
               echo "</tr>";
             echo "</thead>";
             echo "<tbody>";
             for ($i=0; $i <count($rf) ; $i++) {
               if (explode("-",$rf[$i]->getDateRequested())[1] == 3) {
                 echo "<tr style='background-color: ".$rf[$i]->getColor().";'>";
                     echo "<td>".$rf[$i]->getDateRequested()."</td>";
                     echo "<td>".$rf[$i]->getRequestedBy()."</td>";
                     echo "<td>".$rf[$i]->getStatus()."</td>";
                     echo "<td>".$rf[$i]->getType()."</td>";
                     echo "<td>".$rf[$i]->getElement()."</td>";
                     echo "<td>".$rf[$i]->getDateAssigned()."</td>";
                     echo "<td>".$rf[$i]->getAssignedTo()."</td>";
                     echo "<td>".$rf[$i]->getDateSent()."</td>";
                     echo "<td>".$rf[$i]->getFile()."</td>";
                     echo "<td>".$rf[$i]->getObs()."</td>";
                     echo "<td>".$rf[$i]->getModule()."</td>";
                     echo "<td>".$rf[$i]->getId()."</td>";
                     echo "<td>".$rf[$i]->getRemedy()."</td>";
                     echo "<td>".$rf[$i]->getWeightOrder()."</td>";
                     echo "<td>".$rf[$i]->getDateBilling()."</td>";
                     echo "<td>".$rf[$i]->getMonthBilling()."</td>";
                     echo "<td>".$rf[$i]->getDateReview()."</td>";
                     echo "<td>".$rf[$i]->getDateRaw()."</td>";
                     echo "<td>".$rf[$i]->getDateOTGDRT()."</td>";
                     echo "<td>".$rf[$i]->getIdBSS()."</td>";
                     echo "<td>".$rf[$i]->getCode()."</td>";
                   echo "</tr>";
               }
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
                 echo "<th>idBSS</th>";
                 echo "<th>Codigo</th>";
               echo "</tr>";
             echo "</tfoot>";
          echo "</table>";
       echo "</div>";
      echo "</div>";
      //-------------------fin tabla 3-----------------------

    //----------------------tabla 4-------------------------------
      echo "<div class='tab-content' id='tab4'><br>";
          echo "<div>";
            echo "<h3>RF</h3>";
            echo "<table id='demo4' cellpadding='0' cellspacing='0' style='font-size: 9px'>";
              echo "<thead>";
                echo "<tr style='background-color: #207BE5; color: white'>";
                  echo "<th>Fecha Solicitada</th>";
                  echo "<th>Solicitada por</th>";
                  echo "<th>Estado</th>";
                  echo "<th>Tipo</th>";
                  echo "<th>Elemento</th>";
                  echo "<th>Fecha Asignada</th>";
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
                  echo "<th>idBSS</th>";
                  echo "<th>Codigo</th>";
                echo "</tr>";
              echo "</thead>";
              echo "<tbody>";
              for ($i=0; $i <count($rf) ; $i++) {
                if (explode("-",$rf[$i]->getDateRequested())[1] == 4) {
                  echo "<tr style='background-color: ".$rf[$i]->getColor().";'>";
                      echo "<td>".$rf[$i]->getDateRequested()."</td>";
                      echo "<td>".$rf[$i]->getRequestedBy()."</td>";
                      echo "<td>".$rf[$i]->getStatus()."</td>";
                      echo "<td>".$rf[$i]->getType()."</td>";
                      echo "<td>".$rf[$i]->getElement()."</td>";
                      echo "<td>".$rf[$i]->getDateAssigned()."</td>";
                      echo "<td>".$rf[$i]->getAssignedTo()."</td>";
                      echo "<td>".$rf[$i]->getDateSent()."</td>";
                      echo "<td>".$rf[$i]->getFile()."</td>";
                      echo "<td>".$rf[$i]->getObs()."</td>";
                      echo "<td>".$rf[$i]->getModule()."</td>";
                      echo "<td>".$rf[$i]->getId()."</td>";
                      echo "<td>".$rf[$i]->getRemedy()."</td>";
                      echo "<td>".$rf[$i]->getWeightOrder()."</td>";
                      echo "<td>".$rf[$i]->getDateBilling()."</td>";
                      echo "<td>".$rf[$i]->getMonthBilling()."</td>";
                      echo "<td>".$rf[$i]->getDateReview()."</td>";
                      echo "<td>".$rf[$i]->getDateRaw()."</td>";
                      echo "<td>".$rf[$i]->getDateOTGDRT()."</td>";
                      echo "<td>".$rf[$i]->getIdBSS()."</td>";
                      echo "<td>".$rf[$i]->getCode()."</td>";
                    echo "</tr>";
                }
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
                  echo "<th>idBSS</th>";
                  echo "<th>Codigo</th>";
                echo "</tr>";
              echo "</tfoot>";
          echo "</table>";
        echo "</div>";
       echo "</div>";
       //-------------------fin tabla 4-----------------------

     //----------------------tabla 5-------------------------------
       echo "<div class='tab-content' id='tab5'><br>";
           echo "<div>";
             echo "<h3>RF</h3>";
             echo "<table id='demo5' cellpadding='0' cellspacing='0' style='font-size: 9px'>";
               echo "<thead>";
                 echo "<tr style='background-color: #207BE5; color: white'>";
                   echo "<th>Fecha Solicitada</th>";
                   echo "<th>Solicitada por</th>";
                   echo "<th>Estado</th>";
                   echo "<th>Tipo</th>";
                   echo "<th>Elemento</th>";
                   echo "<th>Fecha Asignada</th>";
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
                   echo "<th>idBSS</th>";
                   echo "<th>Codigo</th>";
                 echo "</tr>";
               echo "</thead>";
               echo "<tbody>";
               for ($i=0; $i <count($rf) ; $i++) {
                 if (explode("-",$rf[$i]->getDateRequested())[1] == 5) {
                   echo "<tr style='background-color: ".$rf[$i]->getColor().";'>";
                       echo "<td>".$rf[$i]->getDateRequested()."</td>";
                       echo "<td>".$rf[$i]->getRequestedBy()."</td>";
                       echo "<td>".$rf[$i]->getStatus()."</td>";
                       echo "<td>".$rf[$i]->getType()."</td>";
                       echo "<td>".$rf[$i]->getElement()."</td>";
                       echo "<td>".$rf[$i]->getDateAssigned()."</td>";
                       echo "<td>".$rf[$i]->getAssignedTo()."</td>";
                       echo "<td>".$rf[$i]->getDateSent()."</td>";
                       echo "<td>".$rf[$i]->getFile()."</td>";
                       echo "<td>".$rf[$i]->getObs()."</td>";
                       echo "<td>".$rf[$i]->getModule()."</td>";
                       echo "<td>".$rf[$i]->getId()."</td>";
                       echo "<td>".$rf[$i]->getRemedy()."</td>";
                       echo "<td>".$rf[$i]->getWeightOrder()."</td>";
                       echo "<td>".$rf[$i]->getDateBilling()."</td>";
                       echo "<td>".$rf[$i]->getMonthBilling()."</td>";
                       echo "<td>".$rf[$i]->getDateReview()."</td>";
                       echo "<td>".$rf[$i]->getDateRaw()."</td>";
                       echo "<td>".$rf[$i]->getDateOTGDRT()."</td>";
                       echo "<td>".$rf[$i]->getIdBSS()."</td>";
                       echo "<td>".$rf[$i]->getCode()."</td>";
                     echo "</tr>";
                 }
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
                   echo "<th>idBSS</th>";
                   echo "<th>Codigo</th>";
                 echo "</tr>";
               echo "</tfoot>";
            echo "</table>";
         echo "</div>";
        echo "</div>";
        //-------------------fin tabla 5-----------------------

      //----------------------tabla 6-------------------------------
        echo "<div class='tab-content' id='tab6'><br>";
            echo "<div>";
              echo "<h3>RF</h3>";
              echo "<table id='demo6' cellpadding='0' cellspacing='0' style='font-size: 9px'>";
                echo "<thead>";
                  echo "<tr style='background-color: #207BE5; color: white'>";
                    echo "<th>Fecha Solicitada</th>";
                    echo "<th>Solicitada por</th>";
                    echo "<th>Estado</th>";
                    echo "<th>Tipo</th>";
                    echo "<th>Elemento</th>";
                    echo "<th>Fecha Asignada</th>";
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
                    echo "<th>idBSS</th>";
                    echo "<th>Codigo</th>";
                  echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                for ($i=0; $i <count($rf) ; $i++) {
                  if (explode("-",$rf[$i]->getDateRequested())[1] == 6) {
                    echo "<tr style='background-color: ".$rf[$i]->getColor().";'>";
                        echo "<td>".$rf[$i]->getDateRequested()."</td>";
                        echo "<td>".$rf[$i]->getRequestedBy()."</td>";
                        echo "<td>".$rf[$i]->getStatus()."</td>";
                        echo "<td>".$rf[$i]->getType()."</td>";
                        echo "<td>".$rf[$i]->getElement()."</td>";
                        echo "<td>".$rf[$i]->getDateAssigned()."</td>";
                        echo "<td>".$rf[$i]->getAssignedTo()."</td>";
                        echo "<td>".$rf[$i]->getDateSent()."</td>";
                        echo "<td>".$rf[$i]->getFile()."</td>";
                        echo "<td>".$rf[$i]->getObs()."</td>";
                        echo "<td>".$rf[$i]->getModule()."</td>";
                        echo "<td>".$rf[$i]->getId()."</td>";
                        echo "<td>".$rf[$i]->getRemedy()."</td>";
                        echo "<td>".$rf[$i]->getWeightOrder()."</td>";
                        echo "<td>".$rf[$i]->getDateBilling()."</td>";
                        echo "<td>".$rf[$i]->getMonthBilling()."</td>";
                        echo "<td>".$rf[$i]->getDateReview()."</td>";
                        echo "<td>".$rf[$i]->getDateRaw()."</td>";
                        echo "<td>".$rf[$i]->getDateOTGDRT()."</td>";
                        echo "<td>".$rf[$i]->getIdBSS()."</td>";
                        echo "<td>".$rf[$i]->getCode()."</td>";
                      echo "</tr>";
                  }
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
                    echo "<th>idBSS</th>";
                    echo "<th>Codigo</th>";
                  echo "</tr>";
                echo "</tfoot>";
            echo "</table>";
          echo "</div>";
         echo "</div>";
         //-------------------fin tabla 6-----------------------

       //----------------------tabla 7-------------------------------
         echo "<div class='tab-content' id='tab7'><br>";
             echo "<div>";
               echo "<h3>RF</h3>";
               echo "<table id='demo7' cellpadding='0' cellspacing='0' style='font-size: 9px'>";
                 echo "<thead>";
                   echo "<tr style='background-color: #207BE5; color: white'>";
                     echo "<th>Fecha Solicitada</th>";
                     echo "<th>Solicitada por</th>";
                     echo "<th>Estado</th>";
                     echo "<th>Tipo</th>";
                     echo "<th>Elemento</th>";
                     echo "<th>Fecha Asignada</th>";
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
                     echo "<th>idBSS</th>";
                     echo "<th>Codigo</th>";
                   echo "</tr>";
                 echo "</thead>";
                 echo "<tbody>";
                 for ($i=0; $i <count($rf) ; $i++) {
                   if (explode("-",$rf[$i]->getDateRequested())[1] == 7) {
                     echo "<tr style='background-color: ".$rf[$i]->getColor().";'>";
                         echo "<td>".$rf[$i]->getDateRequested()."</td>";
                         echo "<td>".$rf[$i]->getRequestedBy()."</td>";
                         echo "<td>".$rf[$i]->getStatus()."</td>";
                         echo "<td>".$rf[$i]->getType()."</td>";
                         echo "<td>".$rf[$i]->getElement()."</td>";
                         echo "<td>".$rf[$i]->getDateAssigned()."</td>";
                         echo "<td>".$rf[$i]->getAssignedTo()."</td>";
                         echo "<td>".$rf[$i]->getDateSent()."</td>";
                         echo "<td>".$rf[$i]->getFile()."</td>";
                         echo "<td>".$rf[$i]->getObs()."</td>";
                         echo "<td>".$rf[$i]->getModule()."</td>";
                         echo "<td>".$rf[$i]->getId()."</td>";
                         echo "<td>".$rf[$i]->getRemedy()."</td>";
                         echo "<td>".$rf[$i]->getWeightOrder()."</td>";
                         echo "<td>".$rf[$i]->getDateBilling()."</td>";
                         echo "<td>".$rf[$i]->getMonthBilling()."</td>";
                         echo "<td>".$rf[$i]->getDateReview()."</td>";
                         echo "<td>".$rf[$i]->getDateRaw()."</td>";
                         echo "<td>".$rf[$i]->getDateOTGDRT()."</td>";
                         echo "<td>".$rf[$i]->getIdBSS()."</td>";
                         echo "<td>".$rf[$i]->getCode()."</td>";
                       echo "</tr>";
                   }
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
                     echo "<th>idBSS</th>";
                     echo "<th>Codigo</th>";
                   echo "</tr>";
                 echo "</tfoot>";
              echo "</table>";
           echo "</div>";
          echo "</div>";
          //-------------------fin tabla 7-----------------------

        //----------------------tabla 8-------------------------------
          echo "<div class='tab-content' id='tab8'><br>";
              echo "<div>";
                echo "<h3>RF</h3>";
                echo "<table id='demo8' cellpadding='0' cellspacing='0' style='font-size: 9px'>";
                  echo "<thead>";
                    echo "<tr style='background-color: #207BE5; color: white'>";
                      echo "<th>Fecha Solicitada</th>";
                      echo "<th>Solicitada por</th>";
                      echo "<th>Estado</th>";
                      echo "<th>Tipo</th>";
                      echo "<th>Elemento</th>";
                      echo "<th>Fecha Asignada</th>";
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
                      echo "<th>idBSS</th>";
                      echo "<th>Codigo</th>";
                    echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";
                  for ($i=0; $i <count($rf) ; $i++) {
                    if (explode("-",$rf[$i]->getDateRequested())[1] == 8) {
                      echo "<tr style='background-color:".$rf[$i]->getColor().";'>";//".$rf[$i]->getColor()."
                          echo "<td>".$rf[$i]->getDateRequested()."</td>";
                          echo "<td>".$rf[$i]->getRequestedBy()."</td>";
                          echo "<td>".$rf[$i]->getStatus()."</td>";
                          echo "<td>".$rf[$i]->getType()."</td>";
                          echo "<td>".$rf[$i]->getElement()."</td>";
                          echo "<td>".$rf[$i]->getDateAssigned()."</td>";
                          echo "<td>".$rf[$i]->getAssignedTo()."</td>";
                          echo "<td>".$rf[$i]->getDateSent()."</td>";
                          echo "<td>".$rf[$i]->getFile()."</td>";
                          echo "<td>".$rf[$i]->getObs()."</td>";
                          echo "<td>".$rf[$i]->getModule()."</td>";
                          echo "<td>".$rf[$i]->getId()."</td>";
                          echo "<td>".$rf[$i]->getRemedy()."</td>";
                          echo "<td>".$rf[$i]->getWeightOrder()."</td>";
                          echo "<td>".$rf[$i]->getDateBilling()."</td>";
                          echo "<td>".$rf[$i]->getMonthBilling()."</td>";
                          echo "<td>".$rf[$i]->getDateReview()."</td>";
                          echo "<td>".$rf[$i]->getDateRaw()."</td>";
                          echo "<td>".$rf[$i]->getDateOTGDRT()."</td>";
                          echo "<td>".$rf[$i]->getIdBSS()."</td>";
                          echo "<td>".$rf[$i]->getCode()."</td>";
                        echo "</tr>";
                    }
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
                      echo "<th>idBSS</th>";
                      echo "<th>Codigo</th>";
                    echo "</tr>";
                  echo "</tfoot>";
              echo "</table>";
            echo "</div>";
           echo "</div>";
           //-------------------fin tabla 8-----------------------

         //----------------------tabla 9-------------------------------
           echo "<div class='tab-content' id='tab9'><br>";
               echo "<div>";
                 echo "<h3>RF</h3>";
                 echo "<table id='demo9' cellpadding='0' cellspacing='0' style='font-size: 9px'>";
                   echo "<thead>";
                     echo "<tr style='background-color: #207BE5; color: white'>";
                       echo "<th>Fecha Solicitada</th>";
                       echo "<th>Solicitada por</th>";
                       echo "<th>Estado</th>";
                       echo "<th>Tipo</th>";
                       echo "<th>Elemento</th>";
                       echo "<th>Fecha Asignada</th>";
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
                       echo "<th>idBSS</th>";
                       echo "<th>Codigo</th>";
                     echo "</tr>";
                   echo "</thead>";
                   echo "<tbody>";
                   for ($i=0; $i <count($rf) ; $i++) {
                     if (explode("-",$rf[$i]->getDateRequested())[1] == 9) {
                       echo "<tr style='background-color:".$rf[$i]->getColor().";'>";//".$rf[$i]->getColor()."
                           echo "<td>".$rf[$i]->getDateRequested()."</td>";
                           echo "<td>".$rf[$i]->getRequestedBy()."</td>";
                           echo "<td>".$rf[$i]->getStatus()."</td>";
                           echo "<td>".$rf[$i]->getType()."</td>";
                           echo "<td>".$rf[$i]->getElement()."</td>";
                           echo "<td>".$rf[$i]->getDateAssigned()."</td>";
                           echo "<td>".$rf[$i]->getAssignedTo()."</td>";
                           echo "<td>".$rf[$i]->getDateSent()."</td>";
                           echo "<td>".$rf[$i]->getFile()."</td>";
                           echo "<td>".$rf[$i]->getObs()."</td>";
                           echo "<td>".$rf[$i]->getModule()."</td>";
                           echo "<td>".$rf[$i]->getId()."</td>";
                           echo "<td>".$rf[$i]->getRemedy()."</td>";
                           echo "<td>".$rf[$i]->getWeightOrder()."</td>";
                           echo "<td>".$rf[$i]->getDateBilling()."</td>";
                           echo "<td>".$rf[$i]->getMonthBilling()."</td>";
                           echo "<td>".$rf[$i]->getDateReview()."</td>";
                           echo "<td>".$rf[$i]->getDateRaw()."</td>";
                           echo "<td>".$rf[$i]->getDateOTGDRT()."</td>";
                           echo "<td>".$rf[$i]->getIdBSS()."</td>";
                           echo "<td>".$rf[$i]->getCode()."</td>";
                         echo "</tr>";
                     }
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
                       echo "<th>idBSS</th>";
                       echo "<th>Codigo</th>";
                     echo "</tr>";
                   echo "</tfoot>";
                echo "</table>";
             echo "</div>";
            echo "</div>";
            //-------------------fin tabla 9-----------------------
             //----------------------tabla 10-------------------------------
           echo "<div class='tab-content' id='tab10'><br>";
               echo "<div>";
                 echo "<h3>RF</h3>";
                 echo "<table id='demo10' cellpadding='0' cellspacing='0' style='font-size: 9px'>";
                   echo "<thead>";
                     echo "<tr style='background-color: #207BE5; color: white'>";
                       echo "<th>Fecha Solicitada</th>";
                       echo "<th>Solicitada por</th>";
                       echo "<th>Estado</th>";
                       echo "<th>Tipo</th>";
                       echo "<th>Elemento</th>";
                       echo "<th>Fecha Asignada</th>";
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
                       echo "<th>idBSS</th>";
                       echo "<th>Codigo</th>";
                     echo "</tr>";
                   echo "</thead>";
                   echo "<tbody>";
                   for ($i=0; $i <count($rf) ; $i++) {
                     if (explode("-",$rf[$i]->getDateRequested())[1] == 10) {
                       echo "<tr style='background-color:".$rf[$i]->getColor().";'>";//".$rf[$i]->getColor()."
                           echo "<td>".$rf[$i]->getDateRequested()."</td>";
                           echo "<td>".$rf[$i]->getRequestedBy()."</td>";
                           echo "<td>".$rf[$i]->getStatus()."</td>";
                           echo "<td>".$rf[$i]->getType()."</td>";
                           echo "<td>".$rf[$i]->getElement()."</td>";
                           echo "<td>".$rf[$i]->getDateAssigned()."</td>";
                           echo "<td>".$rf[$i]->getAssignedTo()."</td>";
                           echo "<td>".$rf[$i]->getDateSent()."</td>";
                           echo "<td>".$rf[$i]->getFile()."</td>";
                           echo "<td>".$rf[$i]->getObs()."</td>";
                           echo "<td>".$rf[$i]->getModule()."</td>";
                           echo "<td>".$rf[$i]->getId()."</td>";
                           echo "<td>".$rf[$i]->getRemedy()."</td>";
                           echo "<td>".$rf[$i]->getWeightOrder()."</td>";
                           echo "<td>".$rf[$i]->getDateBilling()."</td>";
                           echo "<td>".$rf[$i]->getMonthBilling()."</td>";
                           echo "<td>".$rf[$i]->getDateReview()."</td>";
                           echo "<td>".$rf[$i]->getDateRaw()."</td>";
                           echo "<td>".$rf[$i]->getDateOTGDRT()."</td>";
                           echo "<td>".$rf[$i]->getIdBSS()."</td>";
                           echo "<td>".$rf[$i]->getCode()."</td>";
                         echo "</tr>";
                     }
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
                       echo "<th>idBSS</th>";
                       echo "<th>Codigo</th>";
                     echo "</tr>";
                   echo "</tfoot>";
                echo "</table>";
             echo "</div>";
            echo "</div>";
            //-------------------fin tabla 10-----------------------
             //----------------------tabla 11-------------------------------
           echo "<div class='tab-content' id='tab11'><br>";
               echo "<div>";
                 echo "<h3>RF</h3>";
                 echo "<table id='demo11' cellpadding='0' cellspacing='0' style='font-size: 9px'>";
                   echo "<thead>";
                     echo "<tr style='background-color: #207BE5; color: white'>";
                       echo "<th>Fecha Solicitada</th>";
                       echo "<th>Solicitada por</th>";
                       echo "<th>Estado</th>";
                       echo "<th>Tipo</th>";
                       echo "<th>Elemento</th>";
                       echo "<th>Fecha Asignada</th>";
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
                       echo "<th>idBSS</th>";
                       echo "<th>Codigo</th>";
                     echo "</tr>";
                   echo "</thead>";
                   echo "<tbody>";
                   for ($i=0; $i <count($rf) ; $i++) {
                     if (explode("-",$rf[$i]->getDateRequested())[1] == 11) {
                       echo "<tr style='background-color:".$rf[$i]->getColor().";'>";//".$rf[$i]->getColor()."
                           echo "<td>".$rf[$i]->getDateRequested()."</td>";
                           echo "<td>".$rf[$i]->getRequestedBy()."</td>";
                           echo "<td>".$rf[$i]->getStatus()."</td>";
                           echo "<td>".$rf[$i]->getType()."</td>";
                           echo "<td>".$rf[$i]->getElement()."</td>";
                           echo "<td>".$rf[$i]->getDateAssigned()."</td>";
                           echo "<td>".$rf[$i]->getAssignedTo()."</td>";
                           echo "<td>".$rf[$i]->getDateSent()."</td>";
                           echo "<td>".$rf[$i]->getFile()."</td>";
                           echo "<td>".$rf[$i]->getObs()."</td>";
                           echo "<td>".$rf[$i]->getModule()."</td>";
                           echo "<td>".$rf[$i]->getId()."</td>";
                           echo "<td>".$rf[$i]->getRemedy()."</td>";
                           echo "<td>".$rf[$i]->getWeightOrder()."</td>";
                           echo "<td>".$rf[$i]->getDateBilling()."</td>";
                           echo "<td>".$rf[$i]->getMonthBilling()."</td>";
                           echo "<td>".$rf[$i]->getDateReview()."</td>";
                           echo "<td>".$rf[$i]->getDateRaw()."</td>";
                           echo "<td>".$rf[$i]->getDateOTGDRT()."</td>";
                           echo "<td>".$rf[$i]->getIdBSS()."</td>";
                           echo "<td>".$rf[$i]->getCode()."</td>";
                         echo "</tr>";
                     }
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
                       echo "<th>idBSS</th>";
                       echo "<th>Codigo</th>";
                     echo "</tr>";
                   echo "</tfoot>";
                echo "</table>";
             echo "</div>";
            echo "</div>";
            //-------------------fin tabla 11-----------------------
             //----------------------tabla 12-------------------------------
           echo "<div class='tab-content' id='tab12'><br>";
               echo "<div>";
                 echo "<h3>RF</h3>";
                 echo "<table id='demo12' cellpadding='0' cellspacing='0' style='font-size: 9px'>";
                   echo "<thead>";
                     echo "<tr style='background-color: #207BE5; color: white'>";
                       echo "<th>Fecha Solicitada</th>";
                       echo "<th>Solicitada por</th>";
                       echo "<th>Estado</th>";
                       echo "<th>Tipo</th>";
                       echo "<th>Elemento</th>";
                       echo "<th>Fecha Asignada</th>";
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
                       echo "<th>idBSS</th>";
                       echo "<th>Codigo</th>";
                     echo "</tr>";
                   echo "</thead>";
                   echo "<tbody>";
                   for ($i=0; $i <count($rf) ; $i++) {
                     if (explode("-",$rf[$i]->getDateRequested())[1] == 12) {
                       echo "<tr style='background-color:".$rf[$i]->getColor().";'>";//".$rf[$i]->getColor()."
                           echo "<td>".$rf[$i]->getDateRequested()."</td>";
                           echo "<td>".$rf[$i]->getRequestedBy()."</td>";
                           echo "<td>".$rf[$i]->getStatus()."</td>";
                           echo "<td>".$rf[$i]->getType()."</td>";
                           echo "<td>".$rf[$i]->getElement()."</td>";
                           echo "<td>".$rf[$i]->getDateAssigned()."</td>";
                           echo "<td>".$rf[$i]->getAssignedTo()."</td>";
                           echo "<td>".$rf[$i]->getDateSent()."</td>";
                           echo "<td>".$rf[$i]->getFile()."</td>";
                           echo "<td>".$rf[$i]->getObs()."</td>";
                           echo "<td>".$rf[$i]->getModule()."</td>";
                           echo "<td>".$rf[$i]->getId()."</td>";
                           echo "<td>".$rf[$i]->getRemedy()."</td>";
                           echo "<td>".$rf[$i]->getWeightOrder()."</td>";
                           echo "<td>".$rf[$i]->getDateBilling()."</td>";
                           echo "<td>".$rf[$i]->getMonthBilling()."</td>";
                           echo "<td>".$rf[$i]->getDateReview()."</td>";
                           echo "<td>".$rf[$i]->getDateRaw()."</td>";
                           echo "<td>".$rf[$i]->getDateOTGDRT()."</td>";
                           echo "<td>".$rf[$i]->getIdBSS()."</td>";
                           echo "<td>".$rf[$i]->getCode()."</td>";
                         echo "</tr>";
                     }
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
                       echo "<th>idBSS</th>";
                       echo "<th>Codigo</th>";
                     echo "</tr>";
                   echo "</tfoot>";
                echo "</table>";
             echo "</div>";
            echo "</div>";
            //-------------------fin tabla 12-----------------------
?>
 <!--  <script type="text/javascript"> Cufon.now(); </script> -->
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
      var tf1 = new TableFilter('demo1', filtersConfig);
      tf1.init();
  </script>
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
      var tf1 = new TableFilter('demo2', filtersConfig);
      tf1.init();
  </script>
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
      var tf1 = new TableFilter('demo3', filtersConfig);
      tf1.init();
  </script>
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
      var tf1 = new TableFilter('demo4', filtersConfig);
      tf1.init();
  </script>
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
      var tf1 = new TableFilter('demo5', filtersConfig);
      tf1.init();
  </script>
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
      var tf1 = new TableFilter('demo6', filtersConfig);
      tf1.init();
  </script>
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
      var tf1 = new TableFilter('demo7', filtersConfig);
      tf1.init();
  </script>
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
      var tf1 = new TableFilter('demo8', filtersConfig);
      tf1.init();
  </script>
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
      var tf1 = new TableFilter('demo9', filtersConfig);
      tf1.init();
  </script>
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
      var tf1 = new TableFilter('demo10', filtersConfig);
      tf1.init();
  </script>
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
      var tf1 = new TableFilter('demo11', filtersConfig);
      tf1.init();
  </script>
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
      var tf1 = new TableFilter('demo12', filtersConfig);
      tf1.init();
  </script>

  <script>
    $(document).ready(function() {
      tabs.init();
    })
  </script>
</body>
</html>
