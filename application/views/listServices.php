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
    <!-- bottstrap select -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
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
               body += "<th><input type='checkbox' name='checkbox[]' id= "+i+" value="+servicio.services[i].idClaro+" onclick='mostrarForm("+i+")'></th>";
               body += "<td><a href='/Datafill_OT/index.php/service/serviceDetails?K_ID_SP_SERVICE="+servicio.services[i].id+"'>"+servicio.services[i].idClaro+"</td>";
               body += "<td>"+servicio.services[i].proyecto+"</td>";
               body += "<td>"+servicio.services[i].service.type+"</td>";
               body += "<td>"+servicio.services[i].quantity+"</td>";
               body += "<td>"+servicio.services[i].site.name+"</td>";
               body += "<td>"+servicio.services[i].user.name+" "+servicio.services[i].user.lastname+"</td>";
               body += "<td>"+servicio.services[i].dateStartP+"</td>";
               if (servicio.services[i].estado == 'Cancelado') {
                body += "<td>"+servicio.services[i].dateStartP+"</td>";
               }else{
                body += "<td>"+servicio.services[i].dateFinishR+"</td>";
               }
               body += "<td>"+servicio.services[i].dateForecast+"</td>";
               body += "<td>"+servicio.services[i].dateFinishClaro+"</td>";
               body += "<td id='"+servicio.services[i].estado+"'>"+servicio.services[i].estado+"</td>";
               body += "</tr>";
            }else{
              $('#body').html("<td id='idActividad"+i+"'></td>");           
               body += "<tr>";
               body += "<th> </th>";
               body += "<td>"+servicio.services[i].idClaro+"</td>";
               body += "<td>"+servicio.services[i].proyecto+"</td>";
               body += "<td>"+servicio.services[i].service.type+"</td>";
               body += "<td>"+servicio.services[i].quantity+"</td>";
               body += "<td>"+servicio.services[i].site.name+"</td>";
               body += "<td>"+servicio.services[i].user.name+" "+servicio.services[i].user.lastname+"</td>";
               body += "<td>"+servicio.services[i].dateStartP+"</td>";
               if (servicio.services[i].estado == 'Cancelado') {
                body += "<td>"+servicio.services[i].dateStartP+"</td>";
               }else{
                body += "<td>"+servicio.services[i].dateFinishR+"</td>";
               }
               body += "<td>"+servicio.services[i].dateForecast+"</td>";
               body += "<td>"+servicio.services[i].dateFinishClaro+"</td>";
               body += "<td id='"+servicio.services[i].estado+"'>"+servicio.services[i].estado+"</td>";
               body += "</tr>";
            }
          }

           $('#body').html(body);
        $('#modalEvento').modal('show');
      }
      
      var suma = 0;
      
      function mostrarForm(h){        
        div = document.getElementById(h);
         // alert(div.checked);
          var sumando = 0;
          if(div.checked == true){
            sumando = -1;
          } else {
            sumando  = 1;
          }
          suma =  suma + sumando;
          if (suma == 0){
            mostrar = document.getElementById('formulario');
            mostrar.style.display = 'none';
            $('#fInicior').removeAttr("required");

            mostrar2 = document.getElementById('reasignar');
            mostrar2.style.display = 'none';

          } else {
            mostrar = document.getElementById('formulario');
            mostrar.style.display = 'block';

            $('#fInicior').prop("required", true);
            $('#fFinr').prop("required", true);
            $('#state').prop("required", true);            

            mostrar2 = document.getElementById('reasignar');
            mostrar2.style.display = 'block';
          }
      }

      function quitarRequired(){
            $('#fInicior').removeAttr("required");
            $('#fFinr').removeAttr("required");
            $('#state').removeAttr("required");
      }

      function showMessage(mensaje){
        if(mensaje == "ok"){
          swal({
            title: "Bien hecho!",
            text: "Actividad aignada satisfactoriamente",
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
        if(mensaje == "no seleccionado") {
          swal({
            title: "No seleccionaste un ingeniero!",
            text: "intenta de nuevo ",
            type: "info",
            confirmButtonText: "Ok"
          });
        }
        if(mensaje == "actualizado") {
          swal({
            title: "Bien hecho!",
            text: "Actividades actualizadas satisfactoriamente\nCorreos enviados",
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

    <!--========================================= tabla transporte =========================================-->
<?php   
  if ($_SESSION["role"] == 1 || $_SESSION["role"] == 3 || $_SESSION["role"] == 4) {
    
    echo "<div class='container'>";
        echo "<center>";
          echo "<legend >Lista de Actividades Transporte</legend>";
        echo "</center>";
       // <!-- /.box-header -->
        echo "<div class='box-body'>";
          echo "<table id='example1' class='table table-bordered table-striped'>";
              echo "<thead>";
                  echo "<tr>";
                      echo "<th>Id orden</th>";
                      echo "<th>Fecha Creacion</th>";
                      echo "<th>Ingeniero Solicitante</th>";
                      echo "<th>Forecast aprox.</th>";
                      echo "<th>F. Asignación</th>";
                      echo "<th>Proyecto</th>";
                      echo "<th>Regional</th>";
                      echo "<th>Ingenieros Asignado</th>";
                      echo "<th>Descripción de la orden</th>";
                      echo "<th>Cant Acti</th>";
                      echo "<th>Progress</th>";
                  echo "</tr>";
              echo "</thead>";
              echo "<tbody>";                  
               /*   print_r($_SESSION["userName"]);
                  echo "<br>";
                  print_r($_SESSION["id"]);
                  echo "<br>";
                  print_r($_SESSION["role"]);*/
                 //print_r($services);
                  $cien=0;$porEnviadas=0;$porEjecutadas=0;$porCanceladas=0;
                    if(isset($services)){
                        for($i = 0; $i < count($services); $i++){                          
                          $cien = count($services[$i]->services);
                          $porEnviadas = (count($services[$i]->enviadas)*100)/$cien;
                          $porEjecutadas = (count($services[$i]->ejecutadas)*100)/$cien;
                          $porCanceladas = (count($services[$i]->canceladas)*100)/$cien;
                          $avance = $porCanceladas+$porEjecutadas+$porEnviadas;
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
                                      echo "<td>";
                                        echo "<div class='containerfluid'>";

                                            echo "<div class='row'>";
                                              echo "<div class='col-md-12'>";
                                                echo "<div class='progress' style='height: 13px;'>";
                                                  echo "<div class='progress-bar progress-bar-warning progress-bar-striped active' role='progressbar' style='width: ".$avance."%; min-width: 13%;'>";
                                                    echo "<div style='font-size: 10px; margin-top: -3px;'>".$avance."%</div>";                         
                                                  echo "</div>";
                                                echo "</div>";
                                              echo "</div>";
                                            echo "</div><br>";

                                            echo "<div class='row'>";
                                              echo "<div class='col-md-12'>";
                                                echo "<div class='progress' style='height: 13px;'>";
                                                  echo "<div class='progress-bar progress-bar-success progress-bar-striped active' role='progressbar' style='width: ".$porEjecutadas."%; min-width: 13%;'>";
                                                    echo "<div style='font-size: 10px; margin-top: -3px;'>".$porEjecutadas."%</div>";                         
                                                  echo "</div>";
                                                echo "</div>";
                                              echo "</div>";
                                            echo "</div>";

                                            echo "<div class='row'>";
                                              echo "<div class='col-md-12'>";
                                                echo "<div class='progress' style='height: 13px;'>";
                                                  echo "<div class='progress-bar progress-bar-info progress-bar-striped active' role='progressbar' style='width: ".$porEnviadas."%; min-width: 13%;'>";
                                                    echo "<div style='font-size: 10px; margin-top: -3px;'>".$porEnviadas."%</div>";                         
                                                  echo "</div>";
                                                echo "</div>";
                                              echo "</div>";
                                            echo "</div>";

                                            echo "<div class='row'>";
                                              echo "<div class='col-md-12'>";
                                                echo "<div class='progress' style='height: 13px;'>";
                                                  echo "<div class='progress-bar progress-bar-danger progress-bar-striped active' role='progressbar' style='width: ".$porCanceladas."%; min-width: 13%;'>";
                                                    echo "<div style='font-size: 10px; margin-top: -3px;'>".$porCanceladas."%</div>";                         
                                                  echo "</div>";
                                                echo "</div>";
                                              echo "</div>";
                                            echo "</div>";
                                         echo "</div>";
                                      echo "</td>";
                                   echo "</tr>";
                                  unset($ing);
                                  }
                          }
                        }
                    }
                   
              echo "</tbody>";
          echo "</table>";
        echo "</div>";
    echo "</div>";
    //===================================<!-- fin tabla transporte ===================================-->
  }  
  if ($_SESSION["role"] == 2 || $_SESSION["role"] == 3 || $_SESSION["role"] == 4) {
    //========================================<!-- tabla gdatos========================================-->
    echo "<br><br><br>";
    echo "<div class='container'>";
        echo "<center>";
          echo "<legend >Lista de Actividades GDATOS</legend>";
        echo "</center>";
        //<!-- /.box-header -->
        echo "<div class='box-body'>";
          echo "<table id='example3' class='table table-bordered table-striped'>";
              echo "<thead>";
                  echo "<tr>";
                      echo "<th>Id orden</th>";
                      echo "<th>Fecha Creacion</th>";
                      echo "<th>Ingeniero Solicitante</th>";
                      echo "<th>Forecast aprox.</th>";
                      echo "<th>F. Asignación</th>";
                      echo "<th>Proyecto</th>";
                      echo "<th>Regional</th>";
                      echo "<th>Ingenieros Asignado</th>";
                      echo "<th>Descripción de la orden</th>";
                      echo "<th>Cant Acti</th>";
                      echo "<th>Progress</th>";
                  echo "</tr>";
              echo "</thead>";
              echo "<tbody>";
                    $cien=0;$porEnviadas=0;$porEjecutadas=0;$porCanceladas=0;
                    if(isset($services)){
                        for($i = 0; $i < count($services); $i++){
                          $cien = count($services[$i]->services);
                          $porEnviadas = (count($services[$i]->enviadas)*100)/$cien;
                          $porEjecutadas = (count($services[$i]->ejecutadas)*100)/$cien;
                          $porCanceladas = (count($services[$i]->canceladas)*100)/$cien;
                          $avance = $porCanceladas+$porEjecutadas+$porEnviadas;
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
                                  echo "<td>";
                                        echo "<div class='containerfluid'>";
                                        
                                            echo "<div class='row'>";
                                              echo "<div class='col-md-12'>";
                                                echo "<div class='progress' style='height: 13px;'>";
                                                  echo "<div class='progress-bar progress-bar-warning progress-bar-striped active' role='progressbar' style='width: ".$avance."%; min-width: 13%;'>";
                                                    echo "<div style='font-size: 10px; margin-top: -3px;'>".$avance."%</div>";                         
                                                  echo "</div>";
                                                echo "</div>";
                                              echo "</div>";
                                            echo "</div><br>";

                                            echo "<div class='row'>";
                                              echo "<div class='col-md-12'>";
                                                echo "<div class='progress' style='height: 13px;'>";
                                                  echo "<div class='progress-bar progress-bar-success progress-bar-striped active' role='progressbar' style='width: ".$porEjecutadas."%; min-width: 13%;'>";
                                                    echo "<div style='font-size: 10px; margin-top: -3px;'>".$porEjecutadas."%</div>";                         
                                                  echo "</div>";
                                                echo "</div>";
                                              echo "</div>";
                                            echo "</div>";

                                            echo "<div class='row'>";
                                              echo "<div class='col-md-12'>";
                                                echo "<div class='progress' style='height: 13px;'>";
                                                  echo "<div class='progress-bar progress-bar-info progress-bar-striped active' role='progressbar' style='width: ".$porEnviadas."%; min-width: 13%;'>";
                                                    echo "<div style='font-size: 10px; margin-top: -3px;'>".$porEnviadas."%</div>";                         
                                                  echo "</div>";
                                                echo "</div>";
                                              echo "</div>";
                                            echo "</div>";

                                            echo "<div class='row'>";
                                              echo "<div class='col-md-12'>";
                                                echo "<div class='progress' style='height: 13px;'>";
                                                  echo "<div class='progress-bar progress-bar-danger progress-bar-striped active' role='progressbar' style='width: ".$porCanceladas."%; min-width: 13%;'>";
                                                    echo "<div style='font-size: 10px; margin-top: -3px;'>".$porCanceladas."%</div>";                         
                                                  echo "</div>";
                                                echo "</div>";
                                              echo "</div>";
                                            echo "</div>";


                                         echo "</div>";
                                      echo "</td>";
                                   echo "</tr>";
                                  unset($ing);
                                }
                          }
                        }
                    }
              echo "</tbody>";
          echo "</table>";
        echo "</div>";
         //===================================<!-- fin tabla GDATOS ===================================-->
  }
?>
<!-- Modal -->
  <form method="post" action="">
  <form method="post">
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
                    <th> </th>
                    <th>Id actividad</th>
                    <th>Proyecto</th>
                    <th>Tipo</th>
                    <th>Cant.</th>
                    <th>Estación base</th>
                    <th>Ingeniero Asignado</th>
                    <th>F. Asignación</th>
                    <th>Fecha Cierre </th>     
                    <th>F. Forecast</th>
                    <th>F. Ejecución</th>
                    <th>estado</th>     
                  </tr>    
              </thead>
              <tbody name="body" id="body">
              </tbody>
            </table>
          </div>
<?php  
    if ($_SESSION["role"] == 0 || $_SESSION["role"] == 4) {
       echo "<div class='container m-l-5' style='display: none' id='reasignar'>";
        echo "<h2>Reasignar Actividades</h2>";
        echo "<div class='row-fluid'>";
          echo "<div class='input-group'>";
            echo "<span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>";
            echo "<select class='selectpicker' name='Ingeniero' data-show-subtext='true' data-live-search='true' data-style='btn-primary' data-width='80%'>";
              echo "<option value=''>Seleccione Ingeniero</option>";
              for ($i=0; $i < count($eng); $i++) { 
                if ($eng[$i]->role->name == 'Ingeniero Datafill GDRCD') {
                  $eng[$i]->role->name = '&nbsp&nbsp-&nbspGDATOS';
                }
                if ($eng[$i]->role->name == 'Ingeniero Datafill GDRT') {
                  $eng[$i]->role->name = '&nbsp&nbsp-&nbspTRANSPORTE';
                }
                if ($eng[$i]->role->name == 'Ingeniero Datafill GRF') {
                  $eng[$i]->role->name = '&nbsp&nbsp-&nbspRF';
                }
                echo "<option data-subtext=".$eng[$i]->role->name." value= ".$eng[$i]->id."><b>".$eng[$i]->name." ".$eng[$i]->lastname."</b></option>";
              }             
            echo "</select>";
            echo "<button style='margin-left: 40px;' type='submit' class='btn btn-success'  onclick=\"quitarRequired(); this.form.action='http://localhost/Datafill_OT/index.php/SpecificService/reasign'\">Reasignar</button>";
          echo "</div>  ";
        echo "</div>";
      echo "</div><br><br>";
    }
?>      
 </form> 
        <div class="container" style="display: none" id="formulario">
          <h2>Cerrar Actividades</h2>
            <div class="form-group">
              <label class="control-label col-sm-2" for="email">Fecha Inicio Real:</label>
              <div class="col-sm-10">
                <input type="date" class="form-control m-b-5" id="fInicior" placeholder="Fecha Inicio Real" name="fInicior" >
              </div>
            </div><br>
            <div class="form-group">
              <label class="control-label col-sm-2" for="email">Fecha Fin Real:</label>
              <div class="col-sm-10">
                <input type="date" class="form-control m-b-5" id="fFinr" placeholder="Fecha Fin Real" name="fFinr" >
              </div>
            </div><br>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">CRQ:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control m-b-5" id="crq" placeholder="CRQ" name="crq">
              </div>
            </div><br>

            <div class="form-group m-b-5">
            <label class="control-label col-sm-2" for="pwd">Estado:</label>
              <div class="col-sm-10"> 
                <select class="form-control m-b-5" id="state" name="state" >
                  <option value="">seleccione estado</option>
                  <option value="Enviado">Enviado</option>
                  <option value="Cancelado">Cancelado</option>
                </select>
              </div>
            </div><br>

            <div class="form-group m-b-5">
              <label class="control-label col-sm-2" for="pwd">Observaciones de Cierrre:</label>
                <div class="col-sm-10">
                   <textarea class="form-control m-b-5" rows="2" id="observacionesCierre" name="observacionesCierre" placeholder="Observaciones de Cierre"></textarea>
                </div>
            </div><br>

            <div class="form-group m-b-5">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success btn-block" onclick="this.form.action='http://localhost/Datafill_OT/index.php/SpecificService/updateSpectService'">Enviar</button>
              </div>
            </div>
        </div>
  </form>
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-info btn-block" id="btnCerrarModal" data-dismiss="modal">CERRAR</button> -->
          </div>
        </div>
      </div>
    </div>
<!--  container  -->


  <!--footer-->
  <div class="for-full-back " id="footer">
      Zolid By ZTE Colombia | All Right Reserved
  </div>

  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
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
