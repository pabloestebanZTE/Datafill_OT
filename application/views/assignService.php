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
                        <li class="cam"><a >Bienvenid@ <?php echo $_SESSION['userName']?></a>
                        </li>
                        <li class="cam"><a href="#"><i class="glyphicon glyphicon-warning-sign"></i><span class="badge"><?php print_r($this->Dao_service_model->cantFechasInconsistentes()->cant); ?></span></a></li>
                        <li class="cam"><a href="#home">Home</a>
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
             $meses[1] = 'Agendamiento';

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
                          echo "<legend >Agendamiento de actividades</legend>";
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

                                echo "<button  name='button1' id='button1' value='button1' type= 'submit' class= 'btn btn-primary' onclick = \"this.form.action = '".URL::to('SpecificService/assignByMail')."'\">Asignación  <span class= 'glyphicon glyphicon-ok'></span></button><br><br>";
                                echo "<button name='button2' id='button2' value='button2' type= 'submit' class= 'btn btn-danger' onclick = \"this.form.action = '".URL::to('SpecificService/cancelByMail')."'\">Cancelación  <span class= 'glyphicon glyphicon-ok'></span></button><br><br>";
                                echo "<button name='button3' id='button3' value='button3' type= 'submit' class= 'btn btn-success' onclick = \"this.form.action = '".URL::to('SpecificService/executeByExcel')."'\">Ejecución  <span class= 'glyphicon glyphicon-ok'></span></button>";
                            echo "</center>";


                        echo "</fieldset>";
                    echo "</form>";
                echo "</div>";
          echo "</div>";
?>



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
      }else {
        echo '<script type="text/javascript">';
      }

         echo "function pushMessage(mensaje){";

            echo "if (mensaje == 'ok') {";
              echo "Push.create( 'Bien hecho!', {";
                      echo "body: 'Actividad asignada satisfactoriamente',";
                      echo "icon: baseurl + '/assets/img/logoblue.png',";
                      echo "timeout: 6000,";
                      echo "onClick: function () {";
                          echo "window.focus();";
                          echo "this.close();";
                      echo "}";
              echo "});";
            echo "}else if(mensaje == 'error'){";
              echo "Push.create( 'error!', {";
                      echo "body: 'Actividades ya existentes ',";
                      echo "icon: baseurl + '/assets/img/error.png',";
                      echo "timeout: 6000,";
                      echo "onClick: function () {";
                          echo "window.focus();";
                          echo "this.close();";
                      echo "}";
              echo "});";
            echo "}";
          echo "}";
        echo "</script>";



  ?>
</body>
</html>
