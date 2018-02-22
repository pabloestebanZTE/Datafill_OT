
<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Report extends CI_Controller {

      function __construct() {
        parent::__construct();
        $this->load->model('data/configdb_model');
        $this->load->model('data/Dao_rf_model');
        $this->load->model('data/Dao_service_model');
        // $this->load->model('data/Dao_report_model');
      }
      //crea el objeto con el total de actividades
      public function totalReport(){
      	$mes = "";$idUser = "";$role = "";
      	if (isset($_GET['id']) && isset($_GET['role'])) {
      		$idUser = $_GET['id'];
      		$role = $_GET['role'];
      	}

      	// header('Content-Type: text/plain');
      	$respuesta = $this->Dao_service_model->getTotalActivities($mes, $idUser, $role);
      	$nombre = "ReporteTotal  ";
      	$this->generateReport($respuesta, $nombre);
      }
      //crea el objeto de actividades del mes actual
      public function thisMonthReport(){
      	$month = date('m');$idUser = "";$role = "";
      	if (isset($_GET['mesSel'])) {
      		$month = $_GET['mesSel'];
      	}
      	if (isset($_GET['id']) && isset($_GET['role'])) {
      		$idUser = $_GET['id'];
      		$role = $_GET['role'];
      	}
      	$respuesta = $this->Dao_service_model->getTotalActivities($month, $idUser, $role);
      	$nombre = "Reporte_mes_".$month." ";
      	$this->generateReport($respuesta, $nombre);
      }
      //descarga un excel con los datos del objeto enviado
      public function generateReport($respuesta, $nombre){
      	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
      	header("Content-Disposition: attachment;filename= ".$nombre." ".date('d-M-Y H:i:a').".xls");
      	header("Pragma: no-cache");
      	header("Expires: 0");
?>      
      <table>
      	<tr>
      		<td>
		      <table width="80%" border="1">
      			<h4 align="center">Reporte Datafill del <?php echo date('d-M-Y H:i:a') ?></h4>
		      	<tr bgcolor="blue" style="color: white;" align="center">
		      		<td>ORDEN</td>
		      		<td>ACTIVIDAD</td>
		      		<td>TIPO</td>
		      		<td>CANT</td>
		      		<td>ESTACION</td>
		      		<td>NOMBRE ING</td>
		      		<td>F ASIFGNACION</td>
		      		<td>F CIERRE ING</td>
		      		<td>F EJECUCION</td>
		      		<td>ESTADO</td>
		      		<td>PROYECTO</td>

				</tr>
<?php 
				$color = "";$enviado = 0;$ejecutado = 0;$cancelado = 0; $asignado = 0;

					foreach ($respuesta as $value) {					
						echo '<tr>';
				      		echo '<td>'.$value->ORDEN.'</td>';
				      		echo '<td>'.$value->ACTIVIDAD.'</td>';
				      		echo '<td>'.$value->TIPO.'</td>';
				      		echo '<td>'.$value->CANT.'</td>';
				      		echo '<td>'.utf8_decode($value->ESTACION).'</td>';
				      		echo '<td>'.utf8_decode($value->NOMBRE_ING).'</td>';
				      		echo '<td>'.$value->F_ASIFGNACION.'</td>';
				      		echo '<td>'.$value->F_CIERRE_ING.'</td>';
				      		echo '<td>'.$value->F_EJECUCION.'</td>';
				      		if ($value->ESTADO == 'Enviado') {
				      			$color = "#a6a6fc";
				      			$enviado ++;
				      		}elseif ($value->ESTADO == 'Ejecutado') {
				      			$color = "#59f859";
				      			$ejecutado ++;
				      		}elseif ($value->ESTADO == 'Cancelado') {
				      			$color = "#ff8383";
				      			$cancelado ++;				      			
				      		}else {
				      			$color = "#f4f4f4";
				      			$asignado ++;				      			
				      		}
				      		echo '<td bgcolor="'.$color.'">'.$value->ESTADO.'</td>';
				      		echo '<td>'.utf8_decode($value->PROYECTO).'</td>';
						echo '</tr>';
					}

				?>		
		      </table>
			</td>
			<td>
				<table>
					<tr>
						<td></td>
					</tr>
				</table>
			</td>
			<td>
		      <table width="100%" border="1" >
		      <h4 align="center">TOTAL</h4>
		      	<tr>
		      		<td>Asig</td>
		      		<td><?php echo $asignado; ?></td>
				</tr>
				<tr>
		      		<td bgcolor="blue" style="color:white;">Env</td>
		      		<td><?php echo $enviado; ?></td>
				</tr>
				<tr>
		      		<td bgcolor="red" style="color:white;">Canc</td>
		      		<td><?php echo $cancelado; ?></td>
				</tr>	
				<tr>
		      		<td bgcolor="green" style="color:white;">Ejec</td>
		      		<td><?php echo $ejecutado; ?></td>
				</tr>	
				<tr>
		      		<td bgcolor="purple" style="color:white;">Total</td>
		      		<td><?php echo $asignado + $enviado + $cancelado + $ejecutado; ?></td>
				</tr>
		      </table>
		   </td>   
	   </tr>   
	</table>
<?php 	

      }
      
  }

?>
