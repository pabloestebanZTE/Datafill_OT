
<?php
/*
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Mail_manager_model extends CI_Model{

        public function __construct(){
            $this->load->model('data/configdb_model');
            $this->load->model('order_model');
        }

      	public function mailAssign($engs, $eng){

      		//header('Content-Type: text/plain');      		
      		$asig = $this->dao_user_model->getUserById($eng);
      		//print_r($asig);
      		$engC = $_SESSION['excel'][0][2][1];
      		//print_r((explode(" ", $engC)));
      		
      		for ($i=0; $i <count($engs) ; $i++) { 
      			
	      		if ((explode(" ", $engC))[0] == explode(" ", $engs[$i]->getName())[0]) {
	      			if (explode(" ", $engs[$i]->getLastname())[0] == explode(" ", $engC)[1] || explode(" ", $engs[$i]->getLastname())[0] == explode(" ", $engC)[2] || explode(" ", $engs[$i]->getLastname())[0] == explode(" ", $engC)[3]) {
	      				$mailEngC = $engs[$i]->getMail();
	      				$engName = $engs[$i]->getName();
	      			}
	      		} 
      		}

$destinatario2 = $mailEngC.", ".$asig->getMail().", Andrea.Rosero.ext@claro.com.co, cesar.rios.ext@claro.com.co";
$destinatario = "bredybuitrago@gmail.com,pablo.esteban@zte.com.cn"; 
$asunto = " Notificación de asignación de orden de servicio. Orden: ".$_SESSION['excel'][0][0][1].". Proyecto: ".$_SESSION['excel'][0][3][1]."."; 
$hearder = 'MIME-Version: 1.0' . "\r\n";
$hearder .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$hearder .= "From: ZOLID_ZTE";
$cuerpo = "<html> 
			<head> 
			   <title>asignacion</title> 

				<link rel= 'stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css'>				 
				<link rel= 'stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css'>	 
				<script src='//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js'></script>

			</head> 
			<body> 
			<h4>Buen Día ".$engName.", el Ingeniero asignado para esta actividad es el siguiente:</h4><br>
			
			<table id='example2' class='table table-bordered table-striped'>
				 <thead>
			       <tr>
			         <th>Nombres</th>
			         <th>Apellidos</th>
			         <th>Identificacion</th>
			         <th>Numero Corporativo</th>
			         <th>Correo</th>
			       </tr>
			     </thead>

			     <tr>
		             <td>".$asig->getName()."</td>
		             <td>".$asig->getLastname()."</td>
		             <td>".$asig->getId()."</td>
		             <td>".$asig->getCellphone()."</td>
		             <td>".$asig->getMail()."</td>
		           </tr>

			</table> <br>

			<div class='box-header'>
         <h5>OT: ".$_SESSION['excel'][0][0][1]."</h5>
         <h5>Solicitante: ".$_SESSION['excel'][0][2][1]."a</h5><h5>Fecha de Creacion: ".$_SESSION['excel'][0][5][1]."</h5>
         <h5>Proyecto: ".$_SESSION['excel'][0][3][1]."</h5><h5>Descripción: ".$_SESSION['excel'][0][4][1]."</h5>
       </div>

				<div class='box-body'>
			     <table id='example1' class='table table-bordered table-striped'>
			       <thead>
			       <tr>
			         <th>ID Actividad</th>
			         <th>Tipo Actividad</th>
			         <th>Regional</th>
			         <th>Cantidad</th>
			         <th>Descripcion</th>
			         <th>Forecast</th>
			       </tr>
			       </thead>
			       <tbody>
			       ";
			       for ($i=12; $i < count($_SESSION['excel'][0]) ; $i++) {  
			            $cuerpo = $cuerpo."<tr>
								             <td>".$_SESSION['excel'][0][$i][0]."</td>
								             <td>".$_SESSION['excel'][0][$i][1]."</td>
								             <td>".$_SESSION['excel'][0][$i][2]."</td>
								             <td>".$_SESSION['excel'][0][$i][3]."</td>
								             <td>".$_SESSION['excel'][0][$i][4]."</td>
								             <td>".$_SESSION['excel'][0][$i][5]."</td>
								           </tr>
								           ";
			   		}

						$cuerpo = $cuerpo."<tfoot>
									           <tr>
									             <th>ID Actividad</th>
									             <th>Tipo Actividad</th>
									             <th>Regional</th>
									             <th>Cantidad</th>
									             <th>Descripcion</th>
									             <th>Forecast</th>
									           </tr>
									        </tfoot>
			     </table>
			   </div><br><br>
			   <p style= 'color: blue'> Este es un correo automático. Por favor, no responda este mensaje. </p>
			                
			</body> 
			</html> 
			"; 
            mail($destinatario,$asunto,$cuerpo,$hearder);
       }
    }
*/    
?>

