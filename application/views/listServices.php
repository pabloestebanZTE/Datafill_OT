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
    <link href="/Datafill_OT/assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="/Datafill_OT/assets/plugins/jQuery/jquery-3.1.1.js"></script>
    <script type="text/javascript" src="/Datafill_OT/assets/plugins/bootstrap.js"></script>
    <!-- modal stilo -->
    <link rel="stylesheet" href="/Datafill_OT/assets/css/emergente.min.css">
    <!-- datatables-->
    <link href="/Datafill_OT/assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="/Datafill_OT/assets/css/bootstrap.min.css" rel="stylesheet">
    <!--   HEADER CSS    -->
    <link href="/Datafill_OT/assets/css/styleHeader.css" rel="stylesheet" />
    <!--   SWEET ALERT    -->
    <link rel="stylesheet" href="/Datafill_OT/assets/plugins/sweetalert-master/dist/sweetalert.css" />
    <script type="text/javascript" src="/Datafill_OT/assets/plugins/sweetalert-master/dist/sweetalert.min.js"></script>

    <script type="text/javascript" charset="utf-8" async defer>
      //Funcion para mostrar mensaje de error de validacion de datos

      function modalEditar(servicio, orden, idIng, role){
        console.log(servicio);
         $('#orden').html("Orden: "+orden);
         var body = "";
          for (var i = 0; i < servicio.services.length; i++) {
            if (servicio.services[i].user.id == idIng || role == 0 || role == 4 || role == 5) {
               $('#body').html("<td id='idActividad"+i+"'></td>");           
               body += "<tr>";
               body += "<td><a href='/Datafill_OT/index.php/service/serviceDetails?K_ID_SP_SERVICE="+servicio.services[i].id+"'>"+servicio.services[i].idClaro+"</td>";
               body += "<td>"+servicio.services[i].service.type+"</td>";
               body += "<td>"+servicio.services[i].quantity+"</td>";
               body += "<td>"+servicio.services[i].site.name+"</td>";
               body += "<td>"+servicio.services[i].user.name+" "+servicio.services[i].user.lastname+"</td>";
               body += "<td>"+servicio.services[i].dateForecast+"</td>";
               body += "<td>"+servicio.services[i].dateStartP+"</td>";
               body += "<td>"+servicio.services[i].proyecto+"</td>";
               body += "<td>"+servicio.services[i].estado+"</td>";
               body += "</tr>";
            }else{
              $('#body').html("<td id='idActividad"+i+"'></td>");           
               body += "<tr>";
               body += "<td>"+servicio.services[i].idClaro+"</td>";
               body += "<td>"+servicio.services[i].service.type+"</td>";
               body += "<td>"+servicio.services[i].quantity+"</td>";
               body += "<td>"+servicio.services[i].site.name+"</td>";
               body += "<td>"+servicio.services[i].user.name+" "+servicio.services[i].user.lastname+"</td>";
               body += "<td>"+servicio.services[i].dateForecast+"</td>";
               body += "<td>"+servicio.services[i].dateStartP+"</td>";
               body += "<td>"+servicio.services[i].proyecto+"</td>";
               body += "<td>"+servicio.services[i].estado+"</td>";
               body += "</tr>";
            }
          }

           $('#body').html(body);
        $('#modalEvento').modal('show');
      }


      function showMessage(mensaje){
        if(mensaje == "ok"){
          swal({
            title: "Bien hecho!",
            text: "Actividad creada satisfactoriamente\nCorreos enviados",
            type: "success",
            confirmButtonText: "Ok"
          });
        } 
        if(mensaje == "error") {
          swal({
            title: "error!",
            text: "Actividades ya existentes ",
            type: "error",
            confirmButtonText: "Ok"
          });
        }
        if(mensaje == "no existe") {
          swal({
            title: "error!",
            text: "Actividades no existen ",
            type: "error",
            confirmButtonText: "Ok"
          });
        }
        if(mensaje == "actualizado") {
          swal({
            title: "Bien hecho!",
            text: "Actividades actualizadas satisfactoriamente",
            type: "success",
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
<!--      fin header         -->
     <br><br>
<!-- tabla transporte -->
<div class="container">
    <center>
      <legend >Lista de Actividades Transporte</legend>
    </center>
    <!-- /.box-header -->
    <div class='box-body'>
      <table id='example1' class='table table-bordered table-striped'>
          <thead>
              <tr>
                  <th>Id orden</th>
                  <th>Fecha Creacion</th>
                  <th>Ingeniero Solicitante</th>
                  <th>Forecast aprox.</th>
                  <th>F. Asignación</th>
                  <th>Proyecto</th>
                  <th>Regional</th>
                  <th>Ingenieros Asignado</th>
                  <th>Descripción de la orden</th>
                  <th>Cantidad Actividades</th>
              </tr>
          </thead>
          <tbody>
              <?php
           /*   print_r($_SESSION["userName"]);
              echo "<br>";
              print_r($_SESSION["id"]);
              echo "<br>";
              print_r($_SESSION["role"]);*/

             //print_r($services);
                if(isset($services)){
                    for($i = 0; $i < count($services); $i++){
                      $proyecto = str_replace(array("\n", "\r", "\t"), '', $services[$i]->services[0]->proyecto);
                      if ($proyecto != "GDATOS") {
                          
                          $ing[] = "";
                          $engs = "";
                          if(count($services[$i]->services) > 0){
                          for ($k=0; $k <count($services[$i]->services) ; $k++) { 
                            $ing[$k] = "- ".$services[$i]->services[$k]->user->name." ".$services[$i]->services[$k]->user->lastname."<br>";
                          }
                            $ing = array_unique($ing);
                            $ing = array_values($ing);
                            for ($k=0; $k <count($ing) ; $k++) { 
                              $engs = $engs.$ing[$k]."  ";
                            }
                          }


                              if ($services[$i]->getId() != "") {
                              echo "<tr>";
                                  echo "<td><a onclick='modalEditar(".json_encode($services[$i]).", ".$services[$i]->getId().", ".$_SESSION["id"].",".$_SESSION["role"].")'>".$services[$i]->getId()."</td>";
                                  echo "<td>".$services[$i]->getCreationDate()."</td>";
                                  echo "<td>".$services[$i]->services[0]->ingSol."</td>";
                                  echo "<td>".$services[$i]->services[0]->dateForecast."</td>";
                                  echo "<td>".$services[$i]->services[0]->dateStartP."</td>";
                                  echo "<td>".$services[$i]->services[0]->proyecto."</td>";
                                  echo "<td>".$services[$i]->services[0]->region."</td>";
                                  echo "<td>".$engs."</td>";
                                  echo "<td>".$services[$i]->services[0]->claroDescription."</td>";
                                  echo "<td>".count($services[$i]->services)."</td>";
                              echo "</tr>";
                              unset($ing);
                              }


                      }
                    }
                }
               ?>
          </tbody>

      </table> 
    </div>
</div>
<!-- fin tabla transporte -->

<!-- tabla gdatos-->
<br><br><br>
<div class="container">
    <center>
      <legend >Lista de Actividades GDATOS</legend>
    </center>
    <!-- /.box-header -->
    <div class='box-body'>
      <table id='example3' class='table table-bordered table-striped'>
          <thead>
              <tr>
                  <th>Id orden</th>
                  <th>Fecha Creacion</th>
                  <th>Ingeniero Solicitante</th>
                  <th>Forecast aprox.</th>
                  <th>F. Asignación</th>
                  <th>Proyecto</th>
                  <th>Regional</th>
                  <th>Ingenieros Asignado</th>
                  <th>Descripción de la orden</th>
                  <th>Cantidad Actividades</th>
              </tr>
          </thead>
          <tbody>
              <?php
            // print_r($services[0]->services[0]);
                if(isset($services)){
                    for($i = 0; $i < count($services); $i++){
                      $proyecto = str_replace(array("\n", "\r", "\t"), '', $services[$i]->services[0]->proyecto);
                      if ($proyecto == "GDATOS") {
                          
                          $ing[] = "";
                          $engs = "";
                          if(count($services[$i]->services) > 0){
                          for ($k=0; $k <count($services[$i]->services) ; $k++) { 
                            $ing[$k] = "- ".$services[$i]->services[$k]->user->name." ".$services[$i]->services[$k]->user->lastname."<br>";
                          }
                            $ing = array_unique($ing);
                            $ing = array_values($ing);
                            for ($k=0; $k <count($ing) ; $k++) { 
                              $engs = $engs.$ing[$k]."  ";
                            }
                          }
                             if ($services[$i]->getId() != "") {
                              echo "<tr>";
                             echo "<td><a onclick='modalEditar(".json_encode($services[$i]).", ".$services[$i]->getId().", ".$_SESSION["id"].",".$_SESSION["role"].")'>".$services[$i]->getId()."</td>";
                              echo "<td>".$services[$i]->getCreationDate()."</td>";
                              echo "<td>".$services[$i]->services[0]->ingSol."</td>";
                              echo "<td>".$services[$i]->services[0]->dateForecast."</td>";
                              echo "<td>".$services[$i]->services[0]->dateStartP."</td>";
                              echo "<td>".$services[$i]->services[0]->proyecto."</td>";
                              echo "<td>".$services[$i]->services[0]->region."</td>";
                              echo "<td>".$engs."</td>";
                              echo "<td>".$services[$i]->services[0]->claroDescription."</td>";
                              echo "<td>".count($services[$i]->services)."</td>";
                              echo "</tr>";
                              unset($ing);
                            }
                      }
                    }
                }
               ?>
          </tbody>

      </table> 
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalEvento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h1 class="modal-title">Detalles del Evento</h1>
          <h4 id="orden"></h4>
        </div>
        <div class="modal-body">
          <table id='example5' class='table table-bordered table-striped'>
            <thead>
                <tr>
                  <th>Id actividad</th>
                  <th>Tipo</th>
                  <th>Cant.</th>
                  <th>Estación base</th>
                  <th>Ingeniero Asignado</th>
                  <th>F. Forecast</th>
                  <th>F. Asignación</th>
                  <th>Proyecto</th>
                  <th>estado</th>     
                </tr>    
            </thead>
            <tbody name="body" id="body">
            </tbody>
          </table>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-defauld btn-block" id="btnCerrarModal" data-dismiss="modal">CERRAR</button>
        </div>
      </div>
    </div>
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
          echo '<script type="text/javascript">showMessage("'.$message.'");</script>';        
      }
    ?>
    <!-- DataTables -->
<script src="/Datafill_OT/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/Datafill_OT/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>

<script>
  $(function () {
    $("#example1").DataTable({
       "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "order": [[ 3, "desc" ]],

    });   
  });
</script>
<script>
  $(function () {
    $("#example3").DataTable({
      "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "order": [[ 3, "desc" ]]
    });    
  });
</script>
</body>
</html>
