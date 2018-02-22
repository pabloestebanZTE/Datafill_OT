<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ejecutar</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!--   ICONO PAGINA    -->
        <link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
        <!--   BOOTSTRAP    -->
        <link href="<?= URL::to('assets/css/bootstrap.css'); ?>" rel="stylesheet" />
        <link href="<?= URL::to('assets/plugins/datatables/dataTables.bootstrap.css'); ?>" rel="stylesheet">
        <link href="<?= URL::to('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <!--   HEADER CSS    -->
        <link href="<?= URL::to('assets/css/styleHeader.css'); ?>" rel="stylesheet" />


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
                         <li class="cam"><a href="#contact-sec">Contactos</a>
                        </li>
                        </li>
                         <li class="cam"><a href="<?= URL::to('welcome/index'); ?>">Salir</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
     </header><br><br><br><br>
<!--      fin header         -->
<form class="form-group" action=" " method="post"  id="cancel" name="cancel">
  <?php

        for ($r=0; $r < count($ejecutar['idActividad']); $r++) {          
          echo "<input type='hidden' name='actividades_".$r."' id='actividades_".$r."' value='".$ejecutar['idActividad'][$r]."'>";
          echo "<input type='hidden' name='fechaEjecucion_".$r."' id='fechaEjecucion_".$r."' value='".$ejecutar['fEjecucion'][$r]."'>";
        }
        echo "<input type='hidden' name='cant' value='".count($ejecutar['idActividad'])."'>";
  ?>


   <input type="submit" name="bt_form" id="bt_form" value="enviar ejecucion" class="btn btn-primary col-xs-4  " style="background-color: orange; margin-left: 55%" onclick = "this.form.action = '<?= URL::to('SpecificService/saveExecuteExcel'); ?>'">
</form>
<section class="content">
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
      <div class="box">

<section class="content">
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
      <div class="box">
  <?php
       echo "<div class='box-header'>";
         echo "<h5>OT: ".$ejecutar['ot']."</h5><h5>Solicitante: ".$ejecutar['solicitante']."a</h5><h5>Fecha de Creacion: ".$ejecutar['fCreacion']."</h5>";
         echo "<h5>Descripción: ".$ejecutar['descripcion']."</h5>";
       echo "</div>";
       echo "<!-- /.box-header -->";
       echo "<div class='box-body'>";
         echo "<table id='example' class='table table-bordered table-striped'>";
           echo "<thead>";
           echo "<tr>";
             echo "<th>ID Actividad</th>";
             echo "<th>Tipo Actividad</th>";
             echo "<th>Cantidad</th>";
             echo "<th>Descripcion</th>";
             echo "<th>Estado</th>";
             echo "<th>Fecha Ejecución</th>";
             echo "<th>Ejecutada en inst. proveedor</th>";
           echo "</tr>";
           echo "</thead>";
           echo "<tbody>";
           for ($i=0; $i < count($ejecutar['idActividad']) ; $i++) { 
             
           echo "<tr>";
             echo "<td>".$ejecutar['idActividad'][$i]."</td>";
             echo "<td>".$ejecutar['tipo'][$i]."</td>";
             echo "<td>".$ejecutar['cantidad'][$i]."</td>";
             echo "<td>".$ejecutar['descripcionActividad'][$i]."</td>";
             echo "<td>".$ejecutar['estado'][$i]."</td>";
             echo "<td>".$ejecutar['fEjecucion'][$i]."</td>";
             echo "<td>".$ejecutar['ejecProveedor'][$i]."</td>";
           echo "</tr>";
           }

           echo "<tfoot>";
           echo "<tr>";
             echo "<th>ID Actividad</th>";
             echo "<th>Tipo Actividad</th>";
             echo "<th>Cantidad</th>";
             echo "<th>Descripcion</th>";
             echo "<th>Estado</th>";
             echo "<th>Fecha Ejecución</th>";
             echo "<th>Ejecutada en inst. proveedor</th>";
           echo "</tr>";
           echo "</tfoot>";
         echo "</table>";
       echo "</div>";
  ?>   <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>

  <!--footer-->
  <div class="for-full-back " id="footer">
      Zolid By ZTE Colombia | All Right Reserved
  </div>
<script src="<?= URL::to('assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<!-- DataTables -->
<script src="<?= URL::to('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= URL::to('assets/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>

<script>
  $(function () {
    $("#example").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>

</body>
</html>
