<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Editar fechas</title>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!--   ICONO PAGINA    -->
        <link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
        <!--   BOOTSTRAP    -->
        <link href="<?= URL::to('assets/css/bootstrap.css'); ?>" rel="stylesheet" />
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
                        <li class="cam fz-18"><a href="#"><i class="glyphicon glyphicon-warning-sign"></i><span class="badge badge-mn"><?php print_r($this->Dao_service_model->cantFechasInconsistentes()->cant); ?></span></a></li>
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
     </header><br>
<!--      fin header         -->
<?php $this->load->helper('camilo'); ?>
		<div class="container-max">
			<h2 align="center" style="color:#207be5">FECHAS INCONSITENTES</h2>
			<table class="table table-bordered table-striped table-hover" id="table-fechas">
				<thead>
					<tr>
						<th>#</th>
						<th>Orden</th>
						<th>Claro</th>
						<th>F.creacion</th>
						<th>F.asignacion a ZTE</th>
						<th>Forecast</th>
						<th>F.asignacion ingeniero</th>
						<th>F.inicio ingeniero</th>
						<th>F.fin ingeniero</th>
						<th>F.ejecucion</th>
						<th>Estado</th>
						<th>Ingeniero</th>
						<th>    </th>
					</tr>
					<tbody>
						<?php for ($i=0; $i < count($fechas); $i++) {
							?>
						<tr id="<?=$fechas[$i]->claro?>">
							<td><?php echo $i ?></td>
							<td id="orden_<?=$fechas[$i]->claro?>"><?=$fechas[$i]->orden?></td>
							<td><?=$fechas[$i]->claro?></td>
								<?php 									
									if (comparar_fecha($fechas[$i]->creacion, $fechas[$i]->asig_a_ZTE )) {?>
							        <td id="creac_<?=$fechas[$i]->claro?>" style="border: 1px solid red; color: red;" ><?=$fechas[$i]->creacion?></td>
								<?php } else { ?>
												<td id="creac_<?=$fechas[$i]->claro?>" ><?=$fechas[$i]->creacion?></td>
								<?php } ?>
		  <!--ASIGNACION ZTE --><?php
								if ($_SESSION['role'] == 4) { 
									if (comparar_fecha($fechas[$i]->asig_a_ZTE, $fechas[$i]->asignacion)) { ?>
										<td><input id="as_zte_<?=$fechas[$i]->claro?>" class="cambiofecha" type="date" value="<?=$fechas[$i]->asig_a_ZTE?>" style="border: 1px solid red; color: red;"/></td>
									<?php } else { ?>
										<td><input id="as_zte_<?=$fechas[$i]->claro?>" class="cambiofecha" type="date" value="<?=$fechas[$i]->asig_a_ZTE?>"/></td>
								<?php } 
								} else { 
								?>
									<td><?=$fechas[$i]->asig_a_ZTE?></td>
								<?php } ?>
								<td><?=$fechas[$i]->forecast?></td>
	   <!-- ASIGNACION INGENIERO --><?php
									if ($_SESSION['role'] == 4) {
										if (comparar_fecha($fechas[$i]->asignacion, $fechas[$i]->inicio_ing)) { ?>
											<td><input id="asign_<?=$fechas[$i]->claro?>" class="cambiofecha" type="date" value="<?=$fechas[$i]->asignacion?>" style="border: 1px solid red; color:red;"/></td>
										<?php } else { ?>
											<td><input id="asign_<?=$fechas[$i]->claro?>" class="cambiofecha" type="date" value="<?=$fechas[$i]->asignacion?>"/></td>
									<?php } 
										}else{
									?>
									<td><?=$fechas[$i]->asignacion?></td>
									<?php } ?>
	      <!-- INICIO INGENIERO --><?php
									if ($_SESSION['role'] != 4 || $_SESSION['role'] == 4 ) {
										if (comparar_fecha($fechas[$i]->inicio_ing, $fechas[$i]->fin_ing)) { ?>
										<td><input id="ini_ing_<?=$fechas[$i]->claro?>" class="cambiofecha" type="date" value="<?=$fechas[$i]->inicio_ing?>" style="border: 1px solid red; color:red;"/></td>
										<?php } else {?>
										<td><input id="ini_ing_<?=$fechas[$i]->claro?>" class="cambiofecha" type="date" value="<?=$fechas[$i]->inicio_ing?>"/></td>
										<?php }
											}
										 ?>
              <!-- FIN INGENIERO --><?php
									if ($_SESSION['role'] != 4 || $_SESSION['role'] == 4) {
										if (comparar_fecha($fechas[$i]->fin_ing, $fechas[$i]->ejecucion)) { ?>
										<td><input id="fin_ing_<?=$fechas[$i]->claro?>" class="cambiofecha" type="date" value="<?=$fechas[$i]->fin_ing?>" style="border: 1px solid red; color: red;"/></td>
										<?php	}else{ ?>
										<td><input id="fin_ing_<?=$fechas[$i]->claro?>" class="cambiofecha" type="date" value="<?=$fechas[$i]->fin_ing?>"/></td>
										<?php }
											}
									 	?>							
					<!--EJECUCION --> <?php 
									if ($_SESSION['role'] == 4) { ?>
										<td><input id="ejec_<?=$fechas[$i]->claro?>" class="cambiofecha" type="date" value="<?=$fechas[$i]->ejecucion?>"/></td>
										<?php }else{ ?>
										<td><?=$fechas[$i]->ejecucion?></td>
										<?php } ?>


					<!-- ESTADO --><?php 
									if ($_SESSION['role'] == 4) { ?>	
									<td>
										<select name="estado" id="estado_<?=$fechas[$i]->claro?>">
											<option value="<?= $fechas[$i]->estado ?>" selected><?= $fechas[$i]->estado ?></option>
											<option value="Asignada">Asignada</option>
											<option value="Enviado">Enviado</option>
											<option value="Ejecutado">Ejecutado</option>
											<option value="Cancelado">Cancelado</option>
									</td>
										<?php } else { ?>
									<td><?= $fechas[$i]->estado ?></td>
										<?php } ?>
									<td><?=$fechas[$i]->ingeniero?></td>
							<td><button class="btn-guardar btn btn-success btn-xs" title="Guardar"><i class="glyphicon glyphicon-send"></i></button></td>
						</tr>
						<?php  }
						?>
					</tbody>
				</table>
			</tbody>
		</div>
		<!-- DataTables -->
		<script src="<?= URL::to('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
		<script src="<?= URL::to('assets/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>
		<script type="text/javascript">
			$(document).ready(
				function () {
					$('#table-fechas').DataTable( {
		        // "scrollX": true
		      });
				}

			);

				$('.btn-guardar').on('click', function(){
					var item = $(this);
					var claro = item.parents('tr').attr("id");

					var fcrea = $('#creac_' + claro).html();
					var ot = $('#orden_' + claro).html();
					var fzte = $('#as_zte_' + claro).val();
					var fasi = $('#asign_' + claro).val();
					var finic = $('#ini_ing_' + claro).val();
					var ffin = $('#fin_ing_' + claro).val();
					var feje = $('#ejec_' + claro).val();
					var esta = $('#estado_' + claro).val();


					var fechas0 = new Date(fcrea);
					var fechas1 = new Date(fzte);
					var fechas2 = new Date(fasi);
					var fechas3 = new Date(finic);
					var fechas4 = new Date(ffin);
					var fechas5 = new Date(feje);

					var vali = true;
					//validacion si la fecha es menor
					if (fechas1.getTime() < fechas0.getTime()) {
						swal("error","La fecha de asignacion ZTE es menor a la de creacion", "error");
						$('#as_zte_' + claro).css('border', '1px solid red');
						$('#creac_' + claro).css('border', '1px solid red');
						vali = false;
					} else {
						$('#as_zte_' + claro).css('border', 'none');
						$('#creac_' + claro).css('border', 'none');
					}
					if (fechas2.getTime() < fechas1.getTime()) {
						swal("error", "La fecha de asignacion ZTE es mayor a la fecha de asignacion a ingeniero", "error");
						$('#as_zte_' + claro).css('border', '1px solid red');
						$('#asign_' + claro).css('border', '1px solid red');
						vali = false;
					}else{
						$('#as_zte_' + claro).css('border', 'none');
						$('#asign_' + claro).css('border', 'none');
					}
					if (fechas3.getTime() < fechas2.getTime()) {
						swal("error", "La fecha de asignacion a ingeniero es mayor a la de inicio de ingeniero", "error");
						$('#ini_ing_' + claro).css('border', '1px solid red');
						$('#asign_' + claro).css('border', '1px solid red');
						vali = false;
					}else{
						$('#ini_ing_' + claro).css('border', 'none');
						$('#asign_' + claro).css('border', 'none');
					}
					if (fechas4.getTime() < fechas3.getTime()) {
						swal("error", "La fecha de inicio de ingeniero es mayor a la fecha de finalizacion del ingeniero",
							"error");
						$('#ini_ing_' + claro).css('border', '1px solid red');
						$('#fin_ing_' + claro).css('border', '1px solid red');
						vali = false;
					}else{
						$('#ini_ing_' + claro).css('border', 'none');
						$('#fin_ing_' + claro).css('border', 'none');
					}
					if (fechas5.getTime() < fechas4.getTime()) {
						swal("error", "La fecha de ejecucion es mayor a la fecha finalizacion del ingeniero", "error");
						$('#ejec_' + claro).css('border', '1px solid red');
						$('#fin_ing_' + claro).css('border', '1px solid red');
						vali = false;
					}else{
						$('#ejec_' + claro).css('border', 'none');
						$('#fin_ing_' + claro).css('border', 'none');

					}
					/*
					$('#orden_<?=$fechas[$i]->claro?>').val(ot);
					$('#as_zte_<?=$fechas[$i]->claro?>').val(fzte);
					$('#asign_<?=$fechas[$i]->claro?>').val(fasi);
					$('#ini_ing_<?=$fechas[$i]->claro?>').val(finic);
					$('#fin_ing_<?=$fechas[$i]->claro?>').val(ffin);
					$('#ejec_<?=$fechas[$i]->claro?>').val(feje);
					$('#estado_<?=$fechas[$i]->claro?>').val(esta);*/
					if (vali) {
							$.post("<?= URL::base(); ?>" +"/Service/upDateFechInconsistentes",

		                {
		                    idClaro: claro,
							idOrder: ot,
							idDateStar: fasi,
							idEstado: esta,
							idZte: fzte,
							idIni: finic,
							idFin: ffin,
							idEjec: feje,
		                },
		                // callback
		                function(data){
		                    console.log(data);
		                    var res = JSON.parse(data);
		                    console.log(res);
		                    if (res == 1) {
		                        swal("Se actualizo correctamente!", "", "success");
		                       // location.reload(vista.urlbase + "Service/tablaFechasUp");
		                        setTimeout('document.location.reload()',1000);
		                    }else {
		                      swal("No actualizo correctamente!", "", "error");
		                    }
		          });
					}
				});
		</script>
	</body>
</html>
