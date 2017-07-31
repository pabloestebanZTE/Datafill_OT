<!DOCTYPE html>
<html lang="en">
<head>
    <title>asignar actividad</title>
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
        <!--   CALENDAR JS    -->
        <link rel='stylesheet' href='/Datafill_OT/assets/plugins/fullcalendar/fullcalendar.css' />
        <script src='/Datafill_OT/assets/plugins/fullcalendar/lib/jquery.min.js'></script>
        <script src='/Datafill_OT/assets/plugins/fullcalendar/lib/moment.min.js'></script>
        <script src='/Datafill_OT/assets/plugins/fullcalendar/fullcalendar.js'></script>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

 <script>
    function generateOptions(){
      var js_data = '<?php echo json_encode($sites); ?>';
      var js_obj_data = JSON.parse(js_data);
      for (var i=0; i<js_obj_data.length; i++) {
          var sel = document.getElementById("sitio");
          sel.options[sel.options.length] = new Option(js_obj_data[i].name, js_obj_data[i].id);
      }
    }

    function editText(){
      var tipo = $("#tipo option:selected").attr('value');
      var services = '<?php echo json_encode($services); ?>';
      var js_obj_data = JSON.parse(services);
      for(var i = 0;i < js_obj_data.length; i++){
        if(js_obj_data[i].id == tipo){
          $("#textoGerencia").remove();
          $("#textoAlcance").remove();
          $("#textoDescripcion").remove();
          var newAlacance = "<p align='center' style='border: 2px solid #7cb6d6;' id='textoAlcance'>"+js_obj_data[i].scope+"</p>";
          var newGerencia = "<p align='center' style='border: 2px solid #7cb6d6;' id='textoGerencia'>"+js_obj_data[i].gerency+"</p>";
          var newDescripcion = "<p align='center' style='border: 2px solid #7cb6d6;' id='textoDescripcion'>"+js_obj_data[i].description+"</p>";
          var gerencia = js_obj_data[i].gerency;
          $("#divGerencia").append(newGerencia);
          $("#divAlcance").append(newAlacance);
          $("#divDescripcion").append(newDescripcion);
        }
      }
      replaceOptionsEngineers(gerencia);
    }

    function replaceOptionsEngineers(gerencia){
      $('#ingeniero').empty();
      gerencia = gerencia.split(" ");
      var ingenieros =  '<?php echo json_encode($engineers); ?>';
      var js_obj_data = JSON.parse(ingenieros);
      for(var i = 0;i < js_obj_data.length; i++){
        var gerenciaEng = js_obj_data[i].role.name.split(" ");
        if(gerenciaEng[2] == gerencia[0]){
          var newOption = "<option value='"+js_obj_data[i].id+"'>"+js_obj_data[i].name+" "+js_obj_data[i].lastname+"</option>";
          $('#ingeniero').append(newOption);
        }
      }
    }

    $(document).ready(function() {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,listWeek'
            },
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                {
                    title: 'All Day Event All Day Event All Day Event All Day Event All Day Event All Day EventAll Day EventAll Day Event',
                    start: '2017-07-29'
                },
                {
                    title: 'All Day Event',
                    start: '2017-07-28'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2017-07-29'
                }
            ]
        });
    });

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
                            <li><a href="#">Ver Actividad</a></li>
                            <li><a href="#">Asignar Actividad</a></li>
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
     <br><br>

<div class="container">
  <form class="well form-horizontal" action=" " method="post"  id="contact_form">
    <center>
      <legend >Asignar Actividad</legend>
    </center>
    <fieldset class="col-md-6 control-label">
      <!-- Select Basic -->
      <div class="form-group">
        <label class="col-md-3 control-label">ID Orden</label>
          <div class="col-md-8 selectContainer">
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
            <select name="orden" class="form-control selectpicker" required >
              <option value="" >ID Orden</option>
              <option>Id Orden</option>
              <option>Id Orden</option>
              <option>Id Orden</option>
            </select>
          </div>
        </div>
      </div>
      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-3 control-label">ID Actividad</label>
        <div class="col-md-8 inputGroupContainer">
          <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></span>
            <input  name="idActividad" placeholder="ID Actividad" class="form-control" required type="text">
          </div>
        </div>
      </div>
      <!-- Select Basic -->
      <div class="form-group">
        <label class="col-md-3 control-label">Tipo</label>
          <div class="col-md-8 selectContainer">
          <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
            <select name="tipo" id="tipo" class="form-control selectpicker" onchange="editText()"; required>
              <option value="" >seleccione tipo de Actividad</option>
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
      <!--text informacion-->
      <div class="form-group">
        <label class="col-md-3 control-label">Gerencia Tarea</label>
         <div class="col-md-8 inputGroupContainer">
           <div id="divGerencia" class="input-group">
             <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span>
                 <p align="center" style="border: 2px solid #7cb6d6;" id="textoGerencia">Gerencia Actividad</p>
           </div>
        </div>
      </div>
      <!--text informacion-->
      <div class="form-group">
        <label class="col-md-3 control-label">Descripción Tarea</label>
         <div class="col-md-8 inputGroupContainer">
           <div id="divDescripcion" class="input-group">
             <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span>
                 <p align="center" style="border: 2px solid #7cb6d6;" id="textoDescripcion">Descripción Actividad</p>
           </div>
        </div>
      </div>
      <!--text informacion-->
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
    <!--  fin seccion izquierda form---->

    <!--  inicio seccion derecha form---->
      <fieldset >
        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-3 control-label">Sitio</label>
          <div class="col-md-8 selectContainer">
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-pushpin"></i></span>
              <select name="sitio" id="sitio" class="form-control selectpicker" required>
                <option value="" >seleccione el lugar</option>
                <?php
                  if (isset($sites)) {
                    echo '<script type="text/javascript">generateOptions();</script>';
                  }
                 ?>
              </select>
            </div>
          </div>
        </div>
        <!-- Date input-->
        <div class="form-group">
          <label class="col-md-3 control-label">Fecha Forecast</label>
            <div class="col-md-8 inputGroupContainer">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input name="fechafc" placeholder="Fecha Forecast" class="form-control" required type="date">
              </div>
          </div>
        </div>
        <!-- Text area -->
        <div class="form-group">
          <label class="col-md-3 control-label">Observaciones Actividad</label>
            <div class="col-md-8 inputGroupContainer">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                <textarea class="form-control" name="observaciones" placeholder="Observaciones actividad"></textarea>
              </div>
          </div>
        </div>
        <!-- Text area -->
        <div class="form-group">
          <label class="col-md-3 control-label">Observaciones Coordinador</label>
            <div class="col-md-8 inputGroupContainer">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                <textarea class="form-control" name="observacionesC" placeholder="Observaciones coordinador"></textarea>
              </div>
          </div>
        </div>
        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-3 control-label">Ingeniero</label>
            <div class="col-md-8 selectContainer">
             <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <select name="ingeniero" id="ingeniero" class="form-control selectpicker" required>
                  <option value="" >Seleccione el Ingeniero</option>
                </select>
             </div>
            </div>
        </div>
      </fieldset>
      <!--   fin seccion derecha---->

        <!-- Button -->
        <center>
            <div class="form-group">
                <label class="col-md-12 control-label"></label>
                 <div class="col-md-12">
                     <button type="submit" class="btn btn-primary" >Crear <span class="glyphicon glyphicon-ok"></span></button>
                </div>
            </div>
        </center>

    </form>
</div>

<!--          container ------------>

  <!--calendar-->
  <div id='calendar'></div><br><br><br>

  <!--footer-->
  <div class="for-full-back " id="footer">
      Zolid By ZTE Colombia | All Right Reserved
  </div>
</body>
</html>