  <!DOCTYPE html>
<html lang="en">
<head>
    <title>Ejecutar con Excel</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!--   ICONO PAGINA    -->
        <link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
        <!--   BOOTSTRAP    -->
        <link href="/Datafill_OT/assets/css/bootstrap.css" rel="stylesheet" />
        <link href="/Datafill_OT/assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
        <link href="/Datafill_OT/assets/css/bootstrap.min.css" rel="stylesheet">
        <!--   HEADER CSS    -->
        <link href="/Datafill_OT/assets/css/styleHeader.css" rel="stylesheet" />


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
     </header><br><br><br><br>
<!--      fin header         -->

 <a id="bt_enviar" class="btn btn-primary col-xs-4" href="/Datafill_OT/index.php/SpecificService/saveExecuteExcel" style="background-color: green; margin-left: 55%" >Cambiar Estado<span class="glyphicon glyphicon-send" aria-hidden="true"></span></a>
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
         echo "<h5>OT: ".$excel[0][0][1]."</h5><h5>Solicitante: ".$excel[0][1][1]."a</h5><h5>Fecha de Creacion: ".$excel[0][3][1]."</h5>";
         echo "<h5>Descripción: ".$excel[0][2][1]."</h5>";
       echo "</div>";
       echo "<!-- /.box-header -->";
       echo "<div class='box-body'>";
         echo "<table id='example1' class='table table-bordered table-striped'>";
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
           for ($i=12; $i < count($excel[0]) ; $i++) { 
             
           echo "<tr>";
             echo "<td>".$excel[0][$i][0]."</td>";
             echo "<td>".$excel[0][$i][1]."</td>";
             echo "<td>".$excel[0][$i][2]."</td>";
             echo "<td>".$excel[0][$i][3]."</td>";
             echo "<td>".$excel[0][$i][4]."</td>";
             echo "<td>".$excel[0][$i][5]."</td>";
             echo "<td>".$excel[0][$i][6]."</td>";
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
<script src="/Datafill_OT/assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- DataTables -->
<script src="/Datafill_OT/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/Datafill_OT/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>

<script>
  $(function () {
    $("#example1").DataTable();
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
