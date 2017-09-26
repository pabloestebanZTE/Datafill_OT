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
        <link href="/Datafill_OT/assets/css/bootstrap.css" rel="stylesheet" />
        <link href="/Datafill_OT/assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
        <link href="/Datafill_OT/assets/css/bootstrap.min.css" rel="stylesheet">
        <!--   HEADER CSS    -->
        <link href="/Datafill_OT/assets/css/styleHeader.css" rel="stylesheet" />

        <script src="/Datafill_OT/assets/js/jquery-2.1.1.min.js"></script>
        <script src="/Datafill_OT/assets/js/bootstrap.js"></script>
  
<style>

  #content{

    position: relative;
    min-height: 50%;
    width: 80%;
    top: 20%;
    left: 10%;


  }
  #tabla{
    margin-bottom: 30px;
  }
  #botones{
    margin-bottom: 15px;
  }

  .selected{
    cursor: pointer;
  }
  .selected:hover{
    background-color: rgba(0, 0, 0, 0.1);
    color: white;
  }
  .seleccionada{
    background-color: rgba(0, 0, 0, 0.1);
    color: white;
  }
</style>
<script>
  var cont = 0;
  $(document).ready(function(){
    $('#bt_add').click(function(){
      agregar();
    });
    $('#bt_del').click(function(){
      eliminar(id_fila_selected);
    });
    $('#bt_delall').click(function(){
      eliminarTodasFilas();
    });
    

  });
  var id_fila_selected=[];
  function agregar(){
    var user = '<?php echo json_encode($eng); ?>';
        var users = JSON.parse(user);

cont++;
    var fila='<tr class="selected" id="fila'+cont+'" onclick="seleccionar(this.id);">';
 fila = fila + '<td>'+cont+'</td>';
   fila = fila + '<td>';
    fila = fila + '<select name="inge'+cont+'" id="inge" class="form-control selectpicker" required>';
        fila = fila + '<option value=" " >Seleccione Ingeniero</option>';
          for(var i = 0; i<users.length; i++){
        fila = fila + "<option value="+users[i].id+ ">"+users[i].name+" "+users[i].lastname+"</option>";
             }
    fila = fila + '</select>';
   fila = fila + '</td>';
   fila = fila + '<td>';
     fila = fila + '<input type="text" class="form-control selectpicker" name="porcen'+cont+'" id="porcen'+cont+'" value="" max="100">';
   fila = fila + '</td>';
   fila = fila + '<td>';
   if(cont>1){
     fila = fila + '<input type="text" class="form-control selectpicker" name="cantidad'+cont+'" id="cantidad'+cont+'" value = "0" onkeyup="validateValuesCant()">';
   } else {
    var cantidadExcel = '<?php echo count($excel[0]) - 12?>'
     fila = fila + '<input type="text" class="form-control selectpicker" name="cantidad'+cont+'" id="cantidad'+cont+'" value ="'+0+'" onkeyup="validateValuesCant()">';
   }
   fila = fila + '</td>';
   fila = fila + '<td>';
     fila = fila + '<input type="text" class="form-control selectpicker" name="project">';
   fila = fila + '</td>';
fila = fila + '</tr>';

          $('#tabla').append(fila);
          reordenar();
  }

  function validateValuesCant(){
     var cantidadExcel = '<?php echo count($excel[0]) - 12?>'
     var sumados = 0; 
    for(var i = 1; i<=cont; i++){
      var s = document.getElementById("cantidad"+i);  
      sumados = sumados + parseInt(s.value);
      // sumados += s.value;
      var porc = document.getElementById("porcen"+i); 
      //console.log(porc); 
      porc.value = 100/cantidadExcel*parseInt(s.value);
    }
    if(sumados != cantidadExcel){
      var btform = document.getElementById("bt_form");
      btform.style.display = 'none';
    } else {
      var btform = document.getElementById("bt_form");
      btform.style.display = 'block';    }
    console.log(sumados);
    console.log(cantidadExcel);
  }
/*
  function seleccionar(id_fila){
    if($('#'+id_fila).hasClass('seleccionada')){
      $('#'+id_fila).removeClass('seleccionada');
    }
    else{
      $('#'+id_fila).addClass('seleccionada');
    }
    //2702id_fila_selected=id_fila;
    id_fila_selected.push(id_fila);
  }
  
  function eliminar(id_fila){
    for(var i=0; i<id_fila.length; i++){
      $('#'+id_fila[i]).remove();
    }
    reordenar();
  }
*/
  function reordenar(){
    var num=1;
    $('#tabla tbody tr').each(function(){
      $(this).find('td').eq(0).text(num);
      num++;
    });
  }
  function eliminarTodasFilas(){
$('#tabla tbody tr').each(function(){
      $(this).remove();
    });
    cont = 0;
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
     </header><br><br><br><br>
<?php// print_r($eng); ?>
<form class="form-group" action=" " method="post"  id="assignEng" name="assignEng"> 
  <div id="content">
    <div class="btn-group col-xs-8" id="botones">
        <a id="bt_add" class="btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
        <a id="bt_delall" class="btn btn-primary"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></a>
    </div>
      <input type="submit" name="bt_form" id="bt_form" value="enviar Asignacion " class="btn btn-primary col-xs-4  " style="background-color: green; display: none" onclick = "this.form.action = 'http://localhost/Datafill_OT/index.php/SpecificService/saveServicesExcel'">
        <table id="tabla" class="table table-bordered">
        <thead>
          <tr>
            <td>Nº</td>
            <td>Asignacion de Ingeniero</td>
            <td>porcentaje(%)</td>
            <td>cantidad</td>
            <td>proyecto</td>
          </tr>
        </thead>
  </table>
  </div>         
</form>
<!--      fin header         -->
<section class="content">
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
      <div class="box">
  <?php
       echo "<div class='box-header'>";
         echo "<h5>OT: ".$excel[0][0][1]."</h5><h5>Solicitante: ".$excel[0][2][1]."a</h5><h5>Fecha de Creacion: ".$excel[0][5][1]."</h5>";
         echo "<h5>Proyecto: ".$excel[0][3][1]."</h5><h5>Descripción: ".$excel[0][4][1]."</h5>";
       echo "</div>";
       echo "<!-- /.box-header -->";
       echo "<div class='box-body'>";
         echo "<table id='example1' class='table table-bordered table-striped'>";
           echo "<thead>";
           echo "<tr>";
             echo "<th>ID Actividad</th>";
             echo "<th>Tipo Actividad</th>";
             echo "<th>Regional</th>";
             echo "<th>Cantidad</th>";
             echo "<th>Descripcion</th>";
             echo "<th>Forecast</th>";
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
           echo "</tr>";
           }

           echo "<tfoot>";
           echo "<tr>";
             echo "<th>ID Actividad</th>";
             echo "<th>Tipo Actividad</th>";
             echo "<th>Regional</th>";
             echo "<th>Cantidad</th>";
             echo "<th>Descripcion</th>";
             echo "<th>Forecast</th>";
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