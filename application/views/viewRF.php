<!DOCTYPE html>
<html lang="en">
<head>
    <title>RF</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- font awesone -->
        <link rel="stylesheet" href="<?= URL::to('assets/plugins/font-awesome/css/font-awesome.min.css') ?>"/>
        <!-- datatables -->
        <link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
        <!--   BOOTSTRAP    -->
        <link href="<?= URL::to('assets/css/bootstrap.min.css'); ?>" rel="stylesheet"> 
        <!--   HEADER CSS    -->
        <link href="<?= URL::to('assets/css/styleHeader.css'); ?>" rel="stylesheet" />
        <!-- Modal Cami -->
        <link href="<?= URL::to('assets/css/styleModalCami.css'); ?>" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="<?= URL::to('assets/plugins/datatables/css/jquery.dataTables.min.css'); ?>">        
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
        <script type="text/javascript" src="<?= URL::to('assets/plugins/jQuery/jquery-3.1.1.js'); ?>"></script>

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

<div class="container">
<h1 class="h1">RF</h1><hr>

<div class="container" align="center">
    <button type="button" class="btn btn-primary" id="nuevos"><i class="fa fa-fw fa-plus"></i> Nuevos <span id="nuevosBadge" class="badge">...</span></button>
    <button type="button" class="btn btn-warning" id="cambios"><i class="fa fa-fw fa-refresh"></i> Cambios <span id="cambiosBadge" class="badge">...</span></button>    
</div>

 <!-- Modal tabla actividades rf nuevas-->
 <div class="modal fade" id="ModalEventosNuevos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= URL::to('assets/img/close.ico'); ?>" alt="cerrar" class="modalImage" ></button>
        <h4 class="modal-title" id="titleEvent">Modal tabla nuevas</h4>
      </div>
      <div class="modal-body" id="cuerpoModal">   

        <table id="tableEventos" class='table table-bordered table-striped' width='100%'>

        </table>

      </div>
      <div class="modal-footer">
        <h4 class="foot">Zolid By ZTE Colombia | All Right Reserved</h4>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar  <i class="glyphicon glyphicon-chevron-up"></i></button>
      </div>
    </div>
  </div>
</div>
<!-- fin modal actividades nuevas -->
<!-- Modal tabla actividades rf cambios-->
 <div class="modal fade" id="ModalEventosCambios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= URL::to('assets/img/close.ico'); ?>" alt="cerrar" class="modalImage" ></button>
        <h4 class="modal-title" id="titleEvent">Modal tabla Cambios</h4>
      </div>
      <div class="modal-body" id="cuerpoModal">  

            <div class="tab-content">

                <div id="Matriz" class="tab-pane fade in active">
                   <h3>TABLA CAMBIOS</h3>
                   <table id="tableEventos" class='table table-bordered table-striped' width='100%'>
                </div>

                <div id="Inventario" class="tab-pane fade">
                      <h3>TABLA LOG</h3>
                      <table id="tableLog" class='table table-bordered table-striped' width='100%'></table>
                </div>

            </div> 

       

        </table>

      </div>
      <div class="modal-footer">
        <h4 class="foot">Zolid By ZTE Colombia | All Right Reserved</h4>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar  <i class="glyphicon glyphicon-chevron-up"></i></button>
      </div>
    </div>
  </div>
</div>
<!-- fin modal actividades rf cambios -->









  <!-- tABLA RF -->
  <table id="tableRF" class='table table-bordered table-striped table-hover' width='100%'></table>

</div> <br><br><br>    
<!-- FOOTER -->
<div class="for-full-back " id="footer">Zolid By ZTE Colombia | All Right Reserved</div>
      <!-- DataTables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="<?= URL::to("assets/plugins/datatables/js/datatables.colvis.js") ?>" type="text/javascript"></script>

<script type="text/javascript">var baseurl = "<?php echo URL::base(); ?>";</script>
<script type="text/javascript" src="<?= URL::to('assets/js/services/rf.js'); ?>"></script>
</body>
</html>
