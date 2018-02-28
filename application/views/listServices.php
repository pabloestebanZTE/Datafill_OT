<!DOCTYPE html>
<html lang="en">
<head>
    <title>Lista Actividades</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--   ICONO PAGINA    -->
    <link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
    <!--   BOOTSTRAP    -->
    <link href="<?= URL::to('assets/css/bootstrap.css'); ?>" rel="stylesheet" />
    <link href="<?= URL::to('assets/css/font-awesome.min.css'); ?>" rel="stylesheet" />
    <script type="text/javascript" src="<?= URL::to('assets/plugins/jQuery/jquery-3.1.1.js'); ?>"></script>
    <script type="text/javascript" src="<?= URL::to('assets/plugins/bootstrap.js'); ?>"></script>
    <!-- bottstrap select -->
    <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" /> -->
    <!-- modal stilo -->
    <link rel="stylesheet" href="<?= URL::to('assets/css/emergente.min.css'); ?>">
    <!-- datatables-->
    <link href="<?= URL::to('assets/plugins/datatables/dataTables.bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?= URL::to('assets/css/bootstrap.min.css" rel="stylesheet'); ?>">
    <!--   HEADER CSS    -->
    <link href="<?= URL::to('assets/css/styleHeader.css?v=1.0'); ?>" rel="stylesheet" />
     <!-- boton -->
    <link href="<?= URL::to('assets/css/styleBoton.css'); ?>" rel="stylesheet" />
    <!-- menu sticky -->
    <link href="<?= URL::to('assets/css/styleMenuSticky.css'); ?>" rel="stylesheet" />
    <!-- checkbox -->
    <link href="<?= URL::to('assets/css/checkboxStyle.css'); ?>" rel="stylesheet" />
    <!--   SWEET ALERT    -->
    <link rel="stylesheet" href="<?= URL::to('assets/plugins/sweetalert-master/dist/sweetalert.css'); ?>" />
    <script type="text/javascript" src="<?= URL::to('assets/plugins/sweetalert-master/dist/sweetalert.min.js'); ?>"></script>
    <!-- <script type="text/javascript" src="<?= URL::to('assets/js/showMessage.js'); ?>"></script> -->


    <script type="text/javascript" charset="utf-8" async defer>
      //Funcion para mostrar mensaje de error de validacion de datos

      function modalEditar(servicio, orden, idIng, role){
         $('#orden').html("Orden: "+orden);
         var body = "";
         //------------------Tabla Modal------------------
          for (var i = 0; i < servicio.services.length; i++) {
            if (servicio.services[i].user.id == idIng || role == 0 || role == 4 || role == 5) {
               body += "<tr>";
               body += "<input type='hidden' name='ot' id='ot' value='"+orden+"'>";
               body += "<th><input type='checkbox' class='checkbox' name='checkbox[]' id= "+i+" value="+servicio.services[i].idClaro+" onclick='validarForm()'></th>";
               // body += "<th><input type='checkbox' name='checkbox' id= "+i+" value="+servicio.services[i].idClaro+" '></th>";
               body += "<td><a href='<?= URL::to('service/serviceDetails?K_ID_SP_SERVICE="+servicio.services[i].id+"'); ?>'>"+servicio.services[i].idClaro+"</td>";
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

           validarLink(servicio.link);
           
      }
      
      //-------------Validar input link------------
      function validarLink(link){
        if (link != null && link != "") {
             var drive = document.getElementById('link');
             drive.disabled = true;
             drive.value = link;

           } else {
             var drive = document.getElementById('link');
             drive.disabled = false;
             drive.value = "";
           }
      }

     //-------------validar check para mostrar u ocultar formulario -------------
     function validarForm(){  
        var checkboxs = document.getElementsByClassName('checkbox');
          var flag = 0;
          //Validar si algun check está marcado
          for (var i = 0; i < checkboxs.length; i++) {
            if (checkboxs[i].checked == true) {
              flag = 1;
            }
          }
          if (flag == 1) {
            mostrarForm();
          }
          else if (flag == 0) {
            ocultarForm();
          }          
      }
      // Mostrar formulario del modal
      function mostrarForm(){
       var  form = document.getElementById('formulario');
        form.style.display = 'block';
        //Del form dejamos requeridos inputs
        $('#fInicior').prop("required", true);
        $('#fFinr').prop("required", true);
        $('#state').prop("required", true);
        //Mostrar select segun el roll
        var roll = document.getElementById('session_role').value;
        if (roll == 4 || roll == 0) {
          var select = document.getElementById('reasignar');
          select.style.display = 'block';
        }
      }
      //Ocultar formulario del modal
      function ocultarForm(){
       var form = document.getElementById('formulario');
        form.style.display = 'none';
        document.getElementById('squaredTwo').checked = false;

        $('#fInicior').removeAttr("required");
        //ocultamos el select
        var select = document.getElementById('reasignar');
          select.style.display = 'none';
      }

      function quitarRequired(){
            $('#fInicior').removeAttr("required");
            $('#fFinr').removeAttr("required");
            $('#state').removeAttr("required");
      }
      //checkbox para marcar o desmarcar el resto de checkbox
      function marcar(source, id){
        checkboxes=document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
        for(i=0;i<checkboxes.length;i++) //recoremos todos los controles
        {
          if(checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
          {
            checkboxes[i].checked=source.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
            validarForm(id);
          }
        }
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
   
</head>
<body data-url="<?= URL::base(); ?>">
    <input type="hidden" id="session_id" value="<?= $_SESSION["id"] ?>"/>
    <input type="hidden" id="session_role" value="<?= $_SESSION["role"] ?>"/>
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
                    <a class="logo"><img id="logo" src="<?= URL::to('assets/img/logo2.png'); ?>" /></a>
                </div>
                <!-- Collect the nav links for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="cam"><a >Bienvenid@ <?php print_r( $_SESSION['userName']) ?></a>
                        </li>
                        <li class="cam"><a href="<?= URL::to('user/principalView'); ?>">Home</a>
                        </li>
                        <li class="cam"><a href="#services">Servicios</a>
                        <ul>
                            <li><a href="<?= URL::to('Service/assignService'); ?>">Agendar Actividad</a></li>
                            <li><a href="<?= URL::to('Service/listService'); ?>s">Ver Actividades</a></li>
                            <li><a href="https://accounts.google.com/ServiceLogin/signinchooser?passive=1209600&continue=https%3A%2F%2Faccounts.google.com%2FManageAccount&followup=https%3A%2F%2Faccounts.google.com%2FManageAccount&flowName=GlifWebSignIn&flowEntry=ServiceLogin" title="drive" target='_blank'>Drive</a></li>
                        </ul>
                        </li>
                        <li class="cam"><a href="#services">RF</a>
                            <ul>
                                <li class="cam"><a href="<?= URL::to('Service/RF'); ?>">Actualizar RF</a></li>
                                <li class="cam"><a href="<?= URL::to('SpecificService/viewRF'); ?>">Ver RF</a></li>
                            </ul>
                        </li>
                         <li class="cam"><a href="#contact-sec">Contactos</a>
                        </li>
                        </li>
                         <li class="cam"><a href="<?= URL::to('welcome/index'); ?>">Salir</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
     </header>
<!--      fin header         -->
     <br><br><br><br>

<!-- menu sticky -->
<div class="contenedor closed" id="content_fixed">
<div id="btn_fixed" >
  <span class="rotate-90 text">
    <i class="glyphicon glyphicon-chevron-up"></i><span style="margin-left: 10px;">Ver menú</span>
  </span>
</div>
<div class="hidden" id="menu_fixed">
<span id="btn_close_fixed">
  <i class="glyphicon glyphicon-chevron-right"></i> Cerrar
</span>
<a href="#section_transport" class="boton" id="Transporte">TRANSPORTE</a>
<a href="#section_GDATOS" class="boton" id="GDatos">GDATOS</a>
  <div class="menu-fixed">
    <ul>
      <li class="total" title="progreso total de la orden"><span>% Total Progreso</span></li>
      <li class="ejecutado" title="ejecutadas de la orden"><span>% ejecutadas</span></li>
      <li class="enviado" title="enviadas de la orden"><span>% enviadas</span></li>
      <li class="cancelado" title="canceladas de la orden"><span>% cancelado</span></li>
    </ul>
  </div>
</div>
</div>
<!-- menu sticky 2 Rporte -->
  <div class="contenedor2 closed2" id="content_fixed2">
  <div id="btn_fixed2" >
    <span class="rotate-902 text2">
      <i class="glyphicon glyphicon-chevron-up"></i><span style="margin-left: 10px;"> Reportes</span>
    </span>
  </div>
  <div class="hidden" id="menu_fixed2">
  <span id="btn_close_fixed2">
    <i class="glyphicon glyphicon-chevron-right"></i> Cerrar
  </span>
  <a href="<?= URL::to('Report/totalReport?id='.$_SESSION["id"].'&&role='.$_SESSION["role"].''); ?>" class="boton2" id="total">TOTAL</a>
  <a href="<?= URL::to('Report/thisMonthReport?id='.$_SESSION["id"].'&&role='.$_SESSION["role"].''); ?>" class="boton2" id="esteMes">Total este Mes</a>
  <!-- <a href="#" class="boton2" id="porMes">Por Mes</a> -->

  <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle boton2" type="button" id="porMes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Por Mes</button>
  <div class="dropdown-menu per" aria-labelledby="dropdownMenuButton">
    <a class="mes" href="<?= URL::to('Report/thisMonthReport?mesSel=01&id='.$_SESSION["id"].'&&role='.$_SESSION["role"].''); ?>">Enero</a>
    <a class="mes" href="<?= URL::to('Report/thisMonthReport?mesSel=02&id='.$_SESSION["id"].'&&role='.$_SESSION["role"].''); ?>">Febrero</a>
    <a class="mes" href="<?= URL::to('Report/thisMonthReport?mesSel=03&id='.$_SESSION["id"].'&&role='.$_SESSION["role"].''); ?>">Marzo</a>
    <a class="mes" href="<?= URL::to('Report/thisMonthReport?mesSel=04&id='.$_SESSION["id"].'&&role='.$_SESSION["role"].''); ?>">Abril</a>
    <a class="mes" href="<?= URL::to('Report/thisMonthReport?mesSel=05&id='.$_SESSION["id"].'&&role='.$_SESSION["role"].''); ?>">Mayo</a>
    <a class="mes" href="<?= URL::to('Report/thisMonthReport?mesSel=06&id='.$_SESSION["id"].'&&role='.$_SESSION["role"].''); ?>">Junio</a>
    <a class="mes" href="<?= URL::to('Report/thisMonthReport?mesSel=07&id='.$_SESSION["id"].'&&role='.$_SESSION["role"].''); ?>">Julio</a>
    <a class="mes" href="<?= URL::to('Report/thisMonthReport?mesSel=08&id='.$_SESSION["id"].'&&role='.$_SESSION["role"].''); ?>">Agosto</a>
    <a class="mes" href="<?= URL::to('Report/thisMonthReport?mesSel=09&id='.$_SESSION["id"].'&&role='.$_SESSION["role"].''); ?>">Septiembre</a>
    <a class="mes" href="<?= URL::to('Report/thisMonthReport?mesSel=10&id='.$_SESSION["id"].'&&role='.$_SESSION["role"].''); ?>">Octubre</a>
    <a class="mes" href="<?= URL::to('Report/thisMonthReport?mesSel=11&id='.$_SESSION["id"].'&&role='.$_SESSION["role"].''); ?>">Noviembre</a>
    <a class="mes" href="<?= URL::to('Report/thisMonthReport?mesSel=12&id='.$_SESSION["id"].'&&role='.$_SESSION["role"].''); ?>">Diciembre</a>
  </div>
</div>
 <!--  <div class="menu-fixed2">
   <ul>
     <li class="total2" title="progreso total de la orden"><span>% Total Progreso</span></li>
     <li class="ejecutado2" title="ejecutadas de la orden"><span>% ejecutadas</span></li>
     <li class="enviado2" title="enviadas de la orden"><span>% enviadas</span></li>
     <li class="cancelado2" title="canceladas de la orden"><span>% cancelado</span></li>
   </ul>
 </div> -->
  </div>
</div>

    <!--========================================= tabla transporte =========================================-->
<?php   
  if ($_SESSION["role"] == 1 || $_SESSION["role"] == 3 || $_SESSION["role"] == 4) {
    
    echo "<div style='display: block; padding-top: 40px' id='section_transport'></div><div class='container'>";        
        //<!-- /.box-header -->
        echo "<div class='box-body'>";
        echo "<center>";
          echo "<legend >Lista de Actividades TRANSPORTE</legend>";
        echo "</center>";
          echo "<table id='tableTransport' class='table table-bordered table-striped' width='100%'>";
          echo "</table>";
        echo "</div>";
      echo "</div>";
  //           
  //   //===================================<!-- fin tabla transporte ===================================-->
  } 

  if ($_SESSION["role"] == 2 || $_SESSION["role"] == 3 || $_SESSION["role"] == 4) {
  //   //========================================<!-- tabla gdatos========================================-->
    echo "<div id='section_GDATOS'></div><br><br><br>";
    echo "<div class='container' >";        
  //       //<!-- /.box-header -->
        echo "<div class='box-body'>";
        echo "<center>";
          echo "<legend>Lista de Actividades GDATOS</legend>";
        echo "</center>";
          echo "<table id='tableGDATOS' class='table table-bordered table-striped'>";
          echo "</table>";
        echo "</div>";
     echo "</div>";

  //        //===================================<!-- fin tabla GDATOS ===================================-->
  }
?>
<!-- Modal -->
  <form method="post" action="">
  <form method="post">
    <div class="modal fade" id="modalEvento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" onclick="ocultarForm()" aria-label="Close"><span aria-hidden="true"><i class='glyphicon glyphicon-eye-close'></i> cerrar</span></button>
            <h1 class="modal-title">Detalles del Evento</h1>
            <h4 id="orden"></h4>
          </div>
          <div class="modal-body">
            <table id='example5' class='table table-bordered table-striped'>
              <thead>
                  <tr>
                    <th>
                      <div class="squaredTwo">
                        <input type="checkbox" value="None" id="squaredTwo" class="checkbox" name="checkbox" onclick="marcar(this);" />
                        <label for="squaredTwo"></label>
                      </div>
                    </th>
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
            </table>
          </div>
     <!-- if ($_SESSION["role"] == 0 || $_SESSION["role"] == 4) { -->
   <div class='container m-l-5' style='display: none' id='reasignar'>
    <h2>Reasignar Actividades</h2>
    <div class='row-fluid'>
      <div class='input-group'>
        <span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>
        <select class='selectBre' name='Ingeniero' data-show-subtext='true' data-live-search='true'  data-width='80%'>
          <option value=''>Seleccione Ingeniero</option>
            <optgroup label="Transporte  GDRT">
            <option value="80158472" class="ing"><b>Andres Alberto Rubio Idrobo</b></option>
            <option value="1032364958"><b>Cesar David Duran Alvarez</b></option>
            <option value="1030565500"><b>David Arevalo Bravo</b></option>
            <option value="1022350779"><b>Giovanny Reyes Torres</b></option>
            <option value="80392886"><b>Juan Carlos Olmos Bonilla</b></option>
            <option value="1016028754"><b>Lina Casallas Melgarejo</b></option>
            <option value="1014251868"><b>Marcela Fernanda Herrera Quila</b></option>
            <option value="80160305"><b>Miguel Angel Moreno Alarcon</b></option>
            </optgroup>
            <optgroup label="GDATOS  GDRCD">
            <option value="1070916624"><b>Daniel Guillermo Reyes Prieto</b></option>
            <option value="1012399862"><b>Jhon Fredy Novoa</b></option>
            <option value="1065631508"><b>Julián Camilo Durán Hernández</b></option>
          </optgroup>                      
        </select>
        <button style='margin-left: 40px;' type='submit' class='btn btn-success'  onclick="quitarRequired(); this.form.action='<?= URL::to('SpecificService/reasign'); ?>'">Reasignar</button>
      </div>  
    </div>
  </div><br><br>
 </form> 
        <div class="container" style="display: none" id="formulario">
          <h2>Cerrar Actividades</h2>
            <div class="form-group" >
              <label class="control-label col-sm-2" for="email">Link Drive OT :</label>
              <div class="col-sm-10" id="enlace">
                <input type="input" class="form-control m-b-5" id="link" placeholder="Link Drive" name="link" >
              </div>
            </div><br>
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
                <button type="submit" class="btn btn-success btn-block" onclick="this.form.action='<?= URL::to('SpecificService/updateSpectService'); ?>'">Enviar</button>
              </div>
            </div>
        </div>
  </form>
  
</tbody>
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
  <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script> -->
    <?php
      if (isset($message)) {
          echo '<script type="text/javascript">showMessage("'.$message.'");</script>';        
      }
    ?>
    <!-- DataTables -->
<script src="<?= URL::to('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= URL::to('assets/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>
<!-- llenar tablas -->
<script type="text/javascript" src="<?= URL::to('assets/js/listServices.js?v= time() '); ?>"></script>
</body>
</html>