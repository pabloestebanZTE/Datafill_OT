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
        <!--   INPUTFILE CSS    -->
        <link href="/Datafill_OT/assets/css/inputFile.css" rel="stylesheet" />


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
<!--      fin header         -->
<form method="post" enctype="multipart/form-data" action="http://localhost/Datafill_OT/index.php/SpecificService/upLoadRF">
  <input type="file" name="idarchivo">
  <p>Arrastra tu archivo aquí o haz clic en esta área.</p>
<button type="submit" class="btn btn-primary" onclick = "enableSelect();this.form.action = 'http://localhost/Datafill_OT/index.php/SpecificService/upLoadRF'">UpLoad  <span class="glyphicon glyphicon-ok"></span></button>
</form>

<script src="/Datafill_OT/assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- DataTables -->
<script src="/Datafill_OT/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/Datafill_OT/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>

<script>
  $(document).ready(function(){
  $('form input').change(function () {
    $('form p').text(this.files.length + " file(s) selected");
  });
});
</script>

</body>
</html>