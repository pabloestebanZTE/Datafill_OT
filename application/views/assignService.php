  <!DOCTYPE html>
<html lang="en">
<head>
    <title>Asignar Actividad</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!--   ICONO PAGINA    -->
        <link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
        <!--   BOOTSTRAP    -->
        <link href="<?= URL::to('assets/css/bootstrap.css'); ?>" rel="stylesheet" />
        <link href="<?= URL::to('assets/css/font-awesome.min.css'); ?>" rel="stylesheet" />
        <link href="<?= URL::to('assets/plugins/datatables/dataTables.bootstrap.css'); ?>" rel="stylesheet">
        <!--   HEADER CSS    -->
        <link href="<?= URL::to('assets/css/styleHeader.css'); ?>" rel="stylesheet" />
        <!--   botones tabla    -->
        <link rel="stylesheet" href="<?= URL::to('assets/css/botonesStyle2.css'); ?>" type="text/css" media="all">
        <!--   FORMULARIO CSS    -->
        <link href="<?= URL::to('assets/css/formStyle.css'); ?>" rel="stylesheet" />
        <!--    JS    -->
        <script src='<?= URL::to('assets/plugins/fullcalendar/lib/jquery.min.js'); ?>'></script>
        <script type="text/javascript" src="<?= URL::to('assets/js/tabs.js'); ?>"></script>
        <!--   SWEET ALERT    -->
        <link rel="stylesheet" href="<?= URL::to('assets/plugins/sweetalert-master/dist/sweetalert.css'); ?>" />
        <script type="text/javascript" src="<?= URL::to('assets/plugins/sweetalert-master/dist/sweetalert.min.js'); ?>"></script>

        <!-- Push.js   -->
        <script src="<?= URL::to('assets/js/push.min.js'); ?>"></script> 

        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

       <script>         
       baseurl = "<?php echo URL::base(); ?>";
          function showMessage(mensaje){
           if(mensaje == "error"){
            swal({
              title: "error!",
              text: "Verifique la información",
              type: "error",
              confirmButtonText: "Ok"
            });
           } 
          }



       </script>
    
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
                            <li><a href="<?= URL::to('Service/listServices'); ?>">Ver Actividades</a></li>
                            <li><a href="https://accounts.google.com/ServiceLogin/signinchooser?passive=1209600&continue=https%3A%2F%2Faccounts.google.com%2FManageAccount&followup=https%3A%2F%2Faccounts.google.com%2FManageAccount&flowName=GlifWebSignIn&flowEntry=ServiceLogin" title="drive" target='_blank'>Drive</a></li>
                        </ul>
                        </li>
                        <li class="cam"><a href="#services">RF</a>
                            <ul>
                                <li class="cam"><a href="<?= URL::to('Service/RF'); ?>">Actualizar RF</a></li>
                                <li class="cam"><a href="<?= URL::to('SpecificService/viewRF'); ?>">Ver RF</a></li>
                            </ul>
                        </li>
                         <li class="cam"><a href="<?= URL::to('Grafics/getGrafics'); ?>">Graficas</a>
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
     <br>

<?php
    
      echo "<div class='wrapper tabs'>";
             $meses[1] = 'Asignación';
             $meses[2] = 'Cancelación';
             $meses[3] = 'Ejecución';
             echo "<center>";
         echo "<ul class='nav'>";
           for ($p = 1; $p <= count($meses); $p++){
             if ($p == 1){
               echo "<li class='selected'><a href='#tab".$p."'><center>".$meses[$p]."</center></a></li>";
             } else {
               echo "<li><a href='#tab".$p."'><center>".$meses[$p]."</center></a></li>";
             }
           }
         echo "</ul>";
         echo "</center>";
         //--------asignacion
          echo "<div class='tab-content' id='tab1'><br>";

              echo "<div class='container'>";
                  echo "<form class= 'well form-horizontal' action='' method='post'  id='assignService' name='assignServie' enctype= 'multipart/form-data'>";
                      echo "<fieldset>";
                          echo "<legend >Asignación</legend>";
                          //-------- Text area------
                          echo "<div class='form-group'>";
                            echo "<label class='col-md-1 control-label'></label>";
                              echo "<div class='col-md-9 inputGroupContainer'>";
                                echo "<div class='input-group'>";
                                  echo "<span class='input-group-addon'><i class='glyphicon glyphicon-file'></i></span>";
                                  echo "<textarea class='form-control' rows='14' name='actividades' placeholder='Copiar asignación'></textarea>";
                                echo "</div>";
                          echo "</div><br><br><br><br>";
                            echo "<center>";
                                echo "<button type= 'submit' class= 'btn btn-primary' onclick = \"this.form.action = '".URL::to('SpecificService/assignByMail')."'\">Asignacion  <span class= 'glyphicon glyphicon-ok'></span></button>";
                              echo "</center>";
                            // echo "// <!-- Select Basic";
                            // echo "// <a class="btn btn-primary" onclick = "cloneEng()" id="clonar" >";
                            // echo "// <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>";
                            // echo "// ";
                            // echo "// <div class="form-group" id="inge">";
                            // echo "// <label class="col-md-4 control-label">Ingeniero</label>";
                            // echo "// <div class="col-md-6 selectContainer">";
                            // echo "// <div class="input-group">";
                            // echo "// <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>";
                            // echo "// <select name="inge" class="form-control selectpicker" >";
                            // echo "// <option value=" " >Seleccione Ingeniero</option>";
                            // echo "// <option>ingeniero</option>";
                            // echo "// <option>ingeniero</option>";
                            // echo "// </select>";
                            // echo "// ";
                            // echo "// </div>";
                            // echo "// </div>";
                            // echo "// </div>";
                            // echo "// /.row -->";
                        echo "</fieldset>";
                    echo "</form>";
                echo "</div>";
          echo "</div>";

  echo "<div class='tab-content' id='tab2'><br>";
      echo "<div class= 'container'>";
        echo "<form class= 'well form-horizontal' action='' method='post'  id='assignService' name='assignServie' enctype= 'multipart/form-data'>";
         echo "<fieldset>";
         //-------------------------text area---------------------------------
            echo "<legend >Cancelación</legend>";
          echo "<div class='form-group'>";
              echo "<label class='col-md-1 control-label'></label>";
                echo "<div class='col-md-9 inputGroupContainer'>";
                  echo "<div class='input-group'>";
                    echo "<span class='input-group-addon'><i class='glyphicon glyphicon-file'></i></span>";
                    echo "<textarea class='form-control' rows='14' name='cancelacion' placeholder='Copiar Cancelación'></textarea>";
                  echo "</div>";
                echo "</div>";
          echo "</div>";
            echo "<center>";
               echo "<button type='submit' class='btn btn-primary' onclick = \"this.form.action = '".URL::to('SpecificService/cancelByMail')."'\">Cancelación <span class='glyphicon glyphicon-ok'></span></button>";
            echo "</center>";
         echo "</fieldset>";
        echo "</form>";
      echo "</div>";
echo "</div>";


 echo "<div class='tab-content' id='tab3'><br>";
    echo "<div class='container'>";
      echo "<form class='well form-horizontal' action='' method='post'  id='assignService' name='assignServie' enctype='multipart/form-data'>";
       echo "<fieldset>";
          echo "<legend >Ejecución</legend>";
        // -------------------<!-- Text area-->-----------------------------
        echo "<div class='form-group'>";
            echo "<label class='col-md-1 control-label'></label>";
              echo "<div class='col-md-9 inputGroupContainer'>";
                echo "<div class='input-group'>";
                  echo "<span class='input-group-addon'><i class='glyphicon glyphicon-file'></i></span>";
                  echo "<textarea class='form-control' rows='14' name='ejecucion' placeholder='Copiar Ejecución'></textarea>";
                echo "</div>";
              echo "</div>";
        echo "</div>";
          echo "<center>";
             echo "<button type='submit' class='btn btn-primary' onclick = \"this.form.action = '".URL::to('SpecificService/executeByExcel')."'\">Ejecución  <span class='glyphicon glyphicon-ok'></span></button>";
          echo "</center>";
       echo "</fieldset>";
      echo "</form>";
    echo "</div>";
echo "</div>";

?>


<!-- <div class="container">
  <form class="well form-horizontal" action=" " method="post"  id="assignService" name="assignServie">
      <legend >Asignar Actividad</legend>
    <fieldset class="col-md-6 control-label">
      Select Basic
      <div class="form-group">
        <label class="col-md-3 control-label">Orden</label>
          <div class="col-md-8 selectContainer">
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
              <select name="orden" id="orden" class="form-control selectpicker" onchange=editIdOrder();>
                <option value="" >ID Orden</option>
                <?php
                  if(isset($orders)){
                    for($i =0; $i < count($orders); $i++){
                      echo "<option value='".$orders[$i]->getId()."'>".$orders[$i]->getId()."</option>";
                    }
                  }
                 ?>
              </select>
          </div>
        </div>
      </div>
      Text input
      <div class="form-group">
        <label class="col-md-3 control-label">ID Actividad</label>
        <div class="col-md-8 inputGroupContainer">
          <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></span>
            <input  name="idActividad" placeholder="ID Actividad" class="form-control" required type="text">
          </div>
        </div>
      </div>
      Select Basic
      <div class="form-group">
        <label class="col-md-3 control-label">Tipo</label>
          <div class="col-md-8 selectContainer">
          <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
            <select name="tipo" id="tipo" class="form-control selectpicker" onchange="editText()"; required>
              <option value="" >Seleccione tipo de actividad</option>
              <?php
                if(isset($services)){
                  for($i =0; $i < count($services); $i++){
                    echo "<option value='".$services[$i]->getId()."'>".$services[$i]->getType()."</option>";
                  }
                }
               ?>
            </select>
          </div>
        </div>
      </div>
      text informacion
      <div class="form-group">
        <label class="col-md-3 control-label">Gerencia Tarea</label>
         <div class="col-md-8 inputGroupContainer">
           <div id="divGerencia" class="input-group">
             <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span>
                 <p align="center" style="border: 2px solid #7cb6d6;" id="textoGerencia">Gerencia Actividad</p>
           </div>
        </div>
      </div>
      text informacion
      <div class="form-group">
        <label class="col-md-3 control-label">Descripción Tarea</label>
         <div class="col-md-8 inputGroupContainer">
           <div id="divDescripcion" class="input-group">
             <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span>
                 <p align="center" style="border: 2px solid #7cb6d6;" id="textoDescripcion">Descripción Actividad</p>
           </div>
        </div>
      </div>
      text informacion
      <div class="form-group">
        <label class="col-md-3 control-label">Alcance Tarea</label>
         <div class="col-md-8 inputGroupContainer">
           <div id="divAlcance"  class="input-group">
             <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span>
                 <p align="center" style="border: 2px solid #7cb6d6;" id="textoAlcance">Alcance Actividad</p>
           </div>
        </div>
      </div>
    </fieldset>
    fin seccion izquierda form--

    inicio seccion derecha form--
      <fieldset >
        Input Orden
        <div class="form-group">
          <label class="col-md-3 control-label">ID Orden</label>
            <div class="col-md-8 selectContainer">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
                  <input type='text' name="idOrden" id="idOrden" class="form-control" value='' placeholder='Digite el Id de la orden' required>
            </div>
          </div>
        </div>
        EB input
        <div class="form-group">
          <label class="col-md-3 control-label">Nombre EB</label>
          <div class="col-md-8 inputGroupContainer">
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></span>
              <input type='text' class="form-control" onKeyUp='sel(this.value)' placeholder='Digite el nombre del EB' required>
            </div>
          </div>
        </div>
        Select Basic
        <div class="form-group">
          <label class="col-md-3 control-label">EB</label>
          <div class="col-md-8 selectContainer">
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-pushpin"></i></span>
              <select name="sitio" id="sitio" class="form-control selectpicker" required disabled>
                <option value="" ></option>
                <?php
                  if (isset($sites)) {
                    echo '<script type="text/javascript">generateOptions();</script>';
                  }
                 ?>
              </select>
            </div>
          </div>
        </div>
        Date input
        <div class="form-group">
          <label class="col-md-3 control-label">Fecha Forecast</label>
            <div class="col-md-8 inputGroupContainer">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input name="fechafc" placeholder="Fecha Forecast" class="form-control" required type="date">
              </div>
          </div>
        </div>
        Text area
        <div class="form-group">
          <label class="col-md-3 control-label">Observaciones Actividad</label>
            <div class="col-md-8 inputGroupContainer">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                <textarea class="form-control" name="observaciones" placeholder="Observaciones actividad"></textarea>
              </div>
          </div>
        </div>
        Text area
        <div class="form-group">
          <label class="col-md-3 control-label">Observaciones Coordinador</label>
            <div class="col-md-8 inputGroupContainer">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                <textarea class="form-control" name="observacionesC" placeholder="Observaciones coordinador"></textarea>
              </div>
          </div>
        </div>
        Select Basic
        <div class="form-group">
          <label class="col-md-3 control-label">Ingeniero</label>
            <div class="col-md-8 selectContainer">
             <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <select name="ingeniero" id="ingeniero" onchange="loadCalendar()" class="form-control selectpicker" required>
                  <option value="" >Seleccione el Ingeniero</option>
                </select>
             </div>
            </div>
        </div>
        Select Basic
        <div class="form-group">
          <label class="col-md-3 control-label">Ingeniero Solicitante</label>
            <div class="col-md-8 selectContainer">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input type='text' id="ingSol" name="ingSol" class="form-control" placeholder='Ingeniero Solicitante' required>
              </div>
            </div>
        </div>
        Select Basic
        <div class="form-group">
          <label class="col-md-3 control-label">Proyecto</label>
            <div class="col-md-8 selectContainer">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></span>
                <input type='text' id="proyecto" name="proyecto" class="form-control" placeholder='Proyecto' required>
              </div>
            </div>
        </div>
        Date Plan
        <div class="form-group">
          <label class="col-md-3 control-label">Fecha Asignación</label>
            <div class="col-md-8 inputGroupContainer">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input name="fechaA" id="fechaA" placeholder="Fecha Asignación" class="form-control" required type="date">
              </div>
          </div>
        </div>
      </fieldset>
      fin seccion derecha--

        Button
        <center>
            <div class="form-group">
                <label class="col-md-12 control-label"></label>
                 <div class="col-md-12">
                     <button type="submit" class="btn btn-primary" onclick = "enableSelect();this.form.action = '<?= URL::to('SpecificService/saveServiceS'); ?>'">Crear <span class="glyphicon glyphicon-ok"></span></button>
                </div>
            </div>
        </center>
    </form>
</div> -->

  <!--footer-->
  <div class="for-full-back " id="footer">
      Zolid By ZTE Colombia | All Right Reserved
  </div>
  <!-- <script type="text/javascript"> Cufon.now(); </script> -->

  <script>
    $(document).ready(function() {
      tabs.init();
    })
  </script>

  <?php
      if (isset($error)) {
        if($error == "error"){
          echo '<script type="text/javascript">showMessage("error");</script>';
        }
      }
      if (isset($message)) {

        echo '<script type="text/javascript">';
        echo 'pushMessage("'.$message.'");';
      }

  ?>
         function pushMessage(mensaje){         

            if (mensaje == "ok") {
              Push.create( "Bien hecho!", {
                      body: "Actividad asignada satisfactoriamente",
                      icon: baseurl + '/assets/img/logoblue.png',
                      timeout: 6000,
                      onClick: function () {
                          window.focus();
                          this.close();
                      }
              });
            }else if(mensaje == "error"){
              Push.create( "error!", {
                      body: "Actividades ya existentes ",
                      icon: baseurl + '/assets/img/error.png',
                      timeout: 6000,
                      onClick: function () {
                          window.focus();
                          this.close();
                      }
              });
            }
          }      
        </script>
</body>
</html>
