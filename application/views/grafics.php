<!DOCTYPE html>
<html lang="en">
<head>
    <title>Graficas</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!--   ICONO PAGINA    -->
        <!-- datatables -->
        <link href="<?= URL::to('assets/plugins/datatables/dataTables.bootstrap2.css'); ?>" rel="stylesheet">
        <link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
        <!--   BOOTSTRAP    -->
        <link href="<?= URL::to('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <!--   HEADER CSS    -->
        <link href="<?= URL::to('assets/css/styleHeader.css'); ?>" rel="stylesheet" />
        <!-- Modal Cami -->
        <link href="<?= URL::to('assets/css/styleModalCami.css'); ?>" rel="stylesheet" />

        <script src="<?= URL::to('assets/js/Chart.min.js'); ?>"></script>
        <script src="<?= URL::to('assets/js/jquery.min.js'); ?>"></script>


</head>
<body data-url="<?= URL::base(); ?>">
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
                        <li class="cam fz-18"><a href="#"><i class="glyphicon glyphicon-warning-sign"></i><span class="badge badge-mn"><?php print_r($this->Dao_service_model->cantFechasInconsistentes()->cant); ?></span></a></li>
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
                         <li class="cam"><a href="<?= URL::to('welcome/index'); ?>">Salir</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
     </header><br><br><br><br>
<!--      fin header         -->
<center><h1 class="h1">GRAFICAS POR MESES</h1></center>
<div class="container">
  <!-- GRAFICAS -->
  <canvas id="graficsTotal" width="400" height="155"></canvas>
</div>
<!-- Modal Graficas Mes-->
<div class="modal fade" id="graficsModal" tabindex="-1"  data-toggle="modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= URL::to('assets/img/close.ico'); ?>" alt="cerrar" class="modalImage" ></button>
        <h4 class="modal-title" id="titleMonth">Modal title</h4>
      </div>
      <div class="modal-body" id="contentModalGrafics">        
            <canvas id="modalGrafics" width="400" height="150"></canvas>
      </div>
      <div class="modal-footer">
        <h4 class="foot">Zolid By ZTE Colombia | All Right Reserved</h4>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar  <i class="glyphicon glyphicon-chevron-up"></i></button>
      </div>
    </div>
  </div>
</div>

<!-- Modal tabla detalles-->
<div class="modal fade" id="tablaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= URL::to('assets/img/close.ico'); ?>" alt="cerrar" class="modalImage" ></button>
        <h4 class="modal-title" id="titleType">Modal tabla</h4>
      </div>
      <div class="modal-body">   

        <table id="tableDetail" class='table table-bordered table-striped' width='100%'>
          
        </table>


      </div>
      <div class="modal-footer">
      <h4 class="foot">Zolid By ZTE Colombia | All Right Reserved</h4>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar  <i class="glyphicon glyphicon-chevron-up"></i></button>
      </div>
    </div>
  </div>
</div>

  <div class="for-full-back " id="footer">
      Zolid By ZTE Colombia | All Right Reserved
  </div>
      <!-- DataTables -->
<script src="<?= URL::to('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
  <!-- Latest compiled and minified JavaScript -->
<script type="text/javascript" src="<?= URL::to('assets/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript">var baseurl = "<?php echo URL::base(); ?>";</script>
<script type="text/javascript" src="<?= URL::to('assets/js/grafics.js'); ?>"></script>
</body>
</html>
