
<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Report extends CI_Controller {

      function __construct() {
        parent::__construct();
        require_once APPPATH . 'models/bin/PHPExcel-1.8.1/Classes/PHPExcel/Settings.php';
        PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
        $this->load->model('bin/PHPExcel-1.8.1/Classes/PHPExcel');
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
		      		<td>TIEMPO</td>
		      		<td>CANT</td>
		      		<td>ESTACION</td>
		      		<td>NOMBRE ING</td>
		      		<td>F ASIFGNACION</td>
		      		<td>F CIERRE ING</td>
		      		<td>F EJECUCION</td>
		      		<td>ESTADO</td>
		      		<td>PROYECTO</td>

		      		<td>F FORECAST</td>
		      		<td>F CREACION</td>
		      		<td>SOLICITANTE</td>
              <td>REGION</td>
		      		<td>DESCRIPCION</td>

				</tr>
<?php 
				$color = "";$enviado = 0;$ejecutado = 0;$cancelado = 0; $asignado = 0;

					foreach ($respuesta as $value) {					
						echo '<tr>';
				      		echo '<td>'.$value->ORDEN.'</td>';
				      		echo '<td>'.$value->ACTIVIDAD.'</td>';
                  echo '<td>'.$value->TIPO.'</td>';
				      		echo '<td>'.$value->TIEMPO.'</td>';
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

				      		echo '<td>'.$value->F_FORECAST.'</td>';
				      		echo '<td>'.$value->F_CREACION.'</td>';
				      		echo '<td>'.$value->SOLICITANTE.'</td>';
                  echo '<td>'.$value->REGION.'</td>';
				      		echo '<td>'.$value->DESCRIPCION.'</td>';
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


      //genero el reporte total de factuiracion
      public function billing_report(){
      	$this->load->helper('camilo');
        $mes = $_GET['mesSel'] + 0;     	
      	// $mes = 02;
        // echo "<br><br><br>";
        // print_r($mes);
        //  echo gettype($mes);

      	$meses = ['','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
      	$data['dias'] = dias_habiles_mes($mes);
      	$data['services'] = $this->Dao_service_model->cant_by_month_executed($mes);
      	$data['rf'] = $this->Dao_rf_model->cant_by_month_rf($mes);
        $data['asig'] = $this->Dao_service_model->cant_by_month_assign($mes);

        // Inicio validacion de que las fechas de ejecucion no sean sab dom o fest... si lo son tomaran el sigiente dia habil
        // si dicho dia habil es despues del mes actual se le asigna la fecha del ultimo dia del arreglo de dias habiles.
        // recorro las fechas de ejecucion del arreglo de servicios
        for ($i=0; $i < count($data['services']) ; $i++) { 
          // validacion retorna falso si no es sab domingo o fes...o true si lo es
          $validacion = is_sat_sun_or_fest($data['services']->f_ejecucion);
          // si validacion es flase sigue el proceso normal
          if ($validacion) {
            // si es true y es fin de semana (sab dom) retorno la fecha del siguiente lunes
            $data['services'][$i]->f_ejecucion = habilPostFinSemana($data['services'][$i]->f_ejecucion);
            // valido si la fecha es festivo... si lo es retorno la fecha despues
            $data['services'][$i]->f_ejecucion = habilPostFestivo($data['services'][$i]->f_ejecucion);
            $flag = 0;// var pra el conteo de fechas q coinciden
            // recorro el arreglo dias para la validacion de existencia
            for ($j=0; $j < count($data['dias']) ; $j++) { 
              // Comparo si la fecha de ejecucion calculada existe en el arreglo de dias
              if ($data['services'][$i]->f_ejecucion == $data['dias'][$j] ) {
                $flag++;// si coincide el contadosr aumenta
              }
            }
            // si el contador es igual a 0 significa q no coincidio con ninguna fecha del array dias entonces significa q la fecha de ejecucion
            // es mayor al ultimo dia habil del mes.. entonces le asigno la ultima fecha habil del array dias
            if ($flag === 0) {
              $data['services'][$i]->f_ejecucion = $data['dias'][$this->endKey($data['dias'])];
            }
            
          }
        }

        // Lo mismo para rf
        for ($i=0; $i < count($data['rf']) ; $i++) { 
          $validacion = is_sat_sun_or_fest($data['rf']->f_ejecucion);
          if ($validacion) {
            $data['rf'][$i]->f_ejecucion = habilPostFinSemana($data['rf'][$i]->f_ejecucion);
            $data['rf'][$i]->f_ejecucion = habilPostFestivo($data['rf'][$i]->f_ejecucion);
            $flag = 0;// var pra el conteo de fechas q coinciden
            for ($j=0; $j < count($data['dias']) ; $j++) { 
              if ($data['rf'][$i]->f_ejecucion == $data['dias'][$j] ) {
                $flag++;// si coincide el contadosr aumenta
              }
            }
            if ($flag === 0) {
              $data['rf'][$i]->f_ejecucion = $data['dias'][$this->endKey($data['dias'])];
            }
            
          }
        }

        // igual para las asignada (en ejecucion)
        for ($i=0; $i < count($data['asig']) ; $i++) { 
          $validacion = is_sat_sun_or_fest($data['asig']->f_asignacion);
          if ($validacion) {
            $data['asig'][$i]->f_asignacion = habilPostFinSemana($data['asig'][$i]->f_asignacion);
            $data['asig'][$i]->f_asignacion = habilPostFestivo($data['asig'][$i]->f_asignacion);
            $flag = 0;// var pra el conteo de fechas q coinciden
            for ($j=0; $j < count($data['dias']) ; $j++) { 
              if ($data['asig'][$i]->f_asignacion == $data['dias'][$j] ) {
                $flag++;// si coincide el contadosr aumenta
              }
            }
            if ($flag === 0) {
              $data['asig'][$i]->f_asignacion = $data['dias'][$this->endKey($data['dias'])];
            }
            
          }
        }





        // header('Content-Type: text/plain');
        // print_r($data);

      	$this->generate_report($data);
      }

      //
      public function generate_report($data){
      	//Inicio uso de phpExcel
      	$objPhpExcel = new PHPExcel();
        //Propiedades de archivo.
        $objPhpExcel->getProperties()->setCreator("ZTE");
        $objPhpExcel->getProperties()->setLastModifiedBy("ZTE");
        $objPhpExcel->getProperties()->setTitle("Reporte Facturación de ".$meses[$mes]);
        $objPhpExcel->getProperties()->setSubject("Reporte Facturacion - Zolid");
        $objPhpExcel->getProperties()->setDescription("Reporte Facturación de ".$meses[$mes]);
        //Seleccionamos la página.
        $objPhpExcel->setActiveSheetIndex(0);

        /******************************************ESTILOS******************************************/
        //Estilo cabeceras rojas
    $style_rojo =array('font'=>array('name'=>'Arial','bold'=>true,'italic'=>false,'strike'=>false,'size'=>11,'color'=>array('rgb'=>'FFFFFF')),'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('argb'=>'ff0000')),'borders'=>array('allborders'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'=>0,'wrap'=>TRUE));

    $style_azul =array('font'=>array('name'=>'Arial','bold'=>false,'italic'=>false,'strike'=>false,'size'=>12,'color'=>array('rgb'=>'000000')),'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('argb'=>'c5d9f1')),'borders'=>array('allborders'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'=>0,'wrap'=>TRUE));

	 $style_mora =array('font'=>array('name'=>'Arial','bold'=>false,'italic'=>false,'strike'=>false,'size'=>12,'color'=>array('rgb'=>'000000')),'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('argb'=>'f2dddc')),'borders'=>array('allborders'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'=>0,'wrap'=>TRUE));

	  $style_amarillo =array('font'=>array('name'=>'Arial','bold'=>false,'italic'=>false,'strike'=>false,'size'=>12,'color'=>array('rgb'=>'000000')),'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('argb'=>'ffffcc')),'borders'=>array('allborders'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'=>0,'wrap'=>TRUE));

	  $style_estandar =array('font'=>array('name'=>'Calibri','bold'=>false,'italic'=>false,'strike'=>false,'size'=>11,'color'=>array('rgb'=>'000000')),'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('argb'=>'FFFFFF')),'borders'=>array('allborders'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'=>0,'wrap'=>TRUE));

	  $style_estandar2 =array('font'=>array('name'=>'Calibri','bold'=>true,'italic'=>false,'strike'=>false,'size'=>8,'color'=>array('rgb'=>'000000')),'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('argb'=>'FFFFFF')),'borders'=>array('allborders'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'=>0,'wrap'=>TRUE));

    $style_rojo2 =array('font'=>array('name'=>'Calibri','bold'=>false,'italic'=>false,'strike'=>false,'size'=>8,'color'=>array('rgb'=>'FFFFFF')),'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('argb'=>'FF0000')),'borders'=>array('allborders'=>array(/*'style'=>PHPExcel_Style_Border::BORDER_THIN*/)),'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'=>0,'wrap'=>TRUE));

        /******************FIN ESTILOS********************************/
        // cOMBINACIONES DE COLUMNAS-.,.
		$objPhpExcel->getActiveSheet()
                ->mergeCells('B1:B2')
                ->mergeCells('C1:C2')
                ->mergeCells('D1:D2')
                ->mergeCells('E1:E2')
                ->mergeCells('F1:F2')
                ->mergeCells('B4:B9')
                ->mergeCells('B10:B15')
                ->mergeCells('B16:B18');        

		/*******************************INICIO CAMPOS FIJOS*******************************/
        //Escribir cabecearas. Y TITULOS LATERALES
        $objPhpExcel->getActiveSheet()
                    ->setCellValue("B1", "GERENCIA")
                    ->setCellValue("C1", "TIPO DE SERVICIO")
                    ->setCellValue("D1", "DESCRIPCION")
                    ->setCellValue("E1", "Cantidad Proyectada")
                    ->setCellValue("F1", '$ Unitarios')
                    //laterales
                    ->setCellValue("B4", '     GRF      (Anexo 2)      DATAFILL')
                    ->setCellValue("B10", 'GDRT     (Anexo 3)     TRANSPORTE')
                    ->setCellValue("B16", 'GDRCD     (Anexo 4)     DATOS')
                    //TIPOS
                    ->setCellValue("C4", "D1")
                    ->setCellValue("C5", "D2")
                    ->setCellValue("C6", "D3")
                    ->setCellValue("C7", "D4")
                    ->setCellValue("C8", "D5")
                    ->setCellValue("C9", "D6")
                    ->setCellValue("C10", "T1")
                    ->setCellValue("C11", "T2")
                    ->setCellValue("C12", "T3")
                    ->setCellValue("C13", "T4")
                    ->setCellValue("C14", "T5")
                    ->setCellValue("C15", "T6")
                    ->setCellValue("C16", "C1")
                    ->setCellValue("C17", "C2")
                    ->setCellValue("C18", "C3")
                     // descripcion
                    ->setCellValue("D4", "Cambio de Parametros, Cancelacion")
                    ->setCellValue("D5", "Creacion Elemento, Eliminacion Elemento")
                    ->setCellValue("D6", "Correccion por cambio Tx, Creacion Nodo Prueba")
                    ->setCellValue("D7", "Ampliacion, Sitio Nuevo")
                    ->setCellValue("D8", "Sitio Nuevo GSM")
                    ->setCellValue("D9", "Informe Core Nacional")
                    ->setCellValue("D10", "ORDENES DE CONFIGURACION DE SERVICIOS DE RED DE TRANSPORTE")
                    ->setCellValue("D11", "ORDENES DE TRABAJO PARA CANALES DE TRANSMISION")
                    ->setCellValue("D12", "DISEÑO DE GESTIÓN PARA ELEMENTOS DE TRANSMISION")
                    ->setCellValue("D13", "VIABILIZAR Y DISEÑAR RUTAS DE TRANSMISIÓN")
                    ->setCellValue("D14", "DOCUMENTACIÓN EN BASES DE DATOS COMCEL")
                    ->setCellValue("D15", "PREFACTIBILIDAD Y GESTIÓN DE TRANSMISIÓN PARA PROYECTOS CORPORATIVOS.")
                    ->setCellValue("D16", "GENERACION DE ORDENES RELACIONADAS A ELEMENTOS Y SERVICIOS DEL PACKET CORE")
                    ->setCellValue("D17", "ORDENES DE TRABAJOS RELACIONADOS CON ACTIVIDADES EN EL BBIP Y RED TÉCNICA")
                    ->setCellValue("D18", "SERVICIOS DE COORDINACION Y SEGUIMIENTO PARA EL CORE DATOS")
                    //cantidad proyectada
                    ->setCellValue("E4", "106")
                    ->setCellValue("E5", "126")
                    ->setCellValue("E6", "18")
                    ->setCellValue("E7", "7")
                    ->setCellValue("E8", "1")
                    ->setCellValue("E9", "1")
                    ->setCellValue("E10", "259")
                    ->setCellValue("E11", "289")
                    ->setCellValue("E12", "76")
                    ->setCellValue("E13", "267")
                    ->setCellValue("E14", "51")
                    ->setCellValue("E15", "178")
                    ->setCellValue("E16", "25")
                    ->setCellValue("E17", "25")
                    ->setCellValue("E18", "150")
                    ->setCellValue("E19", "1579")
                     // $ Unitarios
                    ->setCellValue("F4", "$19.738")
                    ->setCellValue("F5", "$39.477")
                    ->setCellValue("F6", "$78.954")
                    ->setCellValue("F7", "$78.954")
                    ->setCellValue("F8", "$105.272")
                    ->setCellValue("F9", "$157.908")
                    ->setCellValue("F10", "$44.397")
                    ->setCellValue("F11", "$44.397")
                    ->setCellValue("F12", "$51.797")
                    ->setCellValue("F13", "$44.397")
                    ->setCellValue("F14", "$19.423")
                    ->setCellValue("F15", "$19.423")
                    ->setCellValue("F16", "$156.229")
                    ->setCellValue("F17", "$156.229")
                    ->setCellValue("F18", "$104.153")
                    
                    ->setCellValue("D22", "TOTALES RF")
                    ->setCellValue("D23", "TOTALES GDRT")
                    ->setCellValue("D24", "TOTALES GRCD")
                    ->setCellValue("D25", "TOTAL ACTIVIDADES OT Y DATAFILL");
        /*************************************FIN CAMPOS FIJOS*************************************/
        //Declaro el arreglo para itinerar las letras
        $col = ['H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA'];
        // Declaracion de variables a usar

        // Declaracion de variables a usar
        // pro = proyectadas
       	$cant_dias = count($data['dias']);// cant dias trabajados en el mes
       	$d1_pro = 106 / $cant_dias;
       	$d2_pro = 126 / $cant_dias;
       	$d3_pro = 18 / $cant_dias;
       	$d4_pro = 7 / $cant_dias;
       	$d5_pro = 1 / $cant_dias;
       	$d6_pro = 1 / $cant_dias;
       	$t1_pro = 259 / $cant_dias;
       	$t2_pro = 289 / $cant_dias;
       	$t3_pro = 76 / $cant_dias;
       	$t4_pro = 267 / $cant_dias;
       	$t5_pro = 51 / $cant_dias;
       	$t6_pro = 178 / $cant_dias;
       	$c1_pro = 25 / $cant_dias;
       	$c2_pro = 25 / $cant_dias;
       	$c3_pro = 150 / $cant_dias;
        $total_rf = $d1_pro + $d2_pro + $d3_pro + $d4_pro + $d5_pro + $d6_pro;
        $total_tr = $t1_pro + $t2_pro + $t3_pro + $t4_pro + $t5_pro + $t6_pro;
        $total_gd = $c1_pro + $c2_pro + $c3_pro;
        $total_pro = $total_rf + $total_tr + $total_gd;


        $d1 = 0 ;// var para calcular cant de act d1 ejecutadas en ese mes
        $d2 = 0 ;// var para calcular cant de act d2 ejecutadas en ese mes
        $d3 = 0 ;// var para calcular cant de act d3 ejecutadas en ese mes
        $d4 = 0 ;// var para calcular cant de act d4 ejecutadas en ese mes
        $d5 = 0 ;// var para calcular cant de act d5 ejecutadas en ese mes
        $d6 = 0 ;// var para calcular cant de act d6 ejecutadas en ese mes
        $t1 = 0 ;// var para calcular cant de act t1 ejecutadas en ese mes
        $t2 = 0 ;// var para calcular cant de act t2 ejecutadas en ese mes
        $t3 = 0 ;// var para calcular cant de act t3 ejecutadas en ese mes
        $t4 = 0 ;// var para calcular cant de act t4 ejecutadas en ese mes
        $t5 = 0 ;// var para calcular cant de act t5 ejecutadas en ese mes
        $t6 = 0 ;// var para calcular cant de act t6 ejecutadas en ese mes
        $c1 = 0 ;// var para calcular cant de act c1 ejecutadas en ese mes
        $c2 = 0 ;// var para calcular cant de act c2 ejecutadas en ese mes
        $c3 = 0 ;// var para calcular cant de act c3 ejecutadas en ese mes

        $as_d1 = 0 ;// var para calcular cant de act d1 asignadas en ese mes
        $as_d2 = 0 ;// var para calcular cant de act d2 asignadas en ese mes
        $as_d3 = 0 ;// var para calcular cant de act d3 asignadas en ese mes
        $as_d4 = 0 ;// var para calcular cant de act d4 asignadas en ese mes
        $as_d5 = 0 ;// var para calcular cant de act d5 asignadas en ese mes
        $as_d6 = 0 ;// var para calcular cant de act d6 asignadas en ese mes
        $as_t1 = 0 ;// var para calcular cant de act t1 asignadas en ese mes
        $as_t2 = 0 ;// var para calcular cant de act t2 asignadas en ese mes
        $as_t3 = 0 ;// var para calcular cant de act t3 asignadas en ese mes
        $as_t4 = 0 ;// var para calcular cant de act t4 asignadas en ese mes
        $as_t5 = 0 ;// var para calcular cant de act t5 asignadas en ese mes
        $as_t6 = 0 ;// var para calcular cant de act t6 asignadas en ese mes
        $as_c1 = 0 ;// var para calcular cant de act c1 asignadas en ese mes
        $as_c2 = 0 ;// var para calcular cant de act c2 asignadas en ese mes
        $as_c3 = 0 ;// var para calcular cant de act c3 asignadas en ese mes




        $q=0; // variable para aumento de caldas (+1)
        $p=0; // variable para aumento de caldas (+2)
        $j = 0;// Variabkle para referencia de dias (*3 columnas)
        // Lleno el resto de los campos recorridos y calculados
        for ($i=0; $i < ($cant_dias-1); $i++) {
        	$p = $j + 2;
        	$q = $j + 1;
        	$fecha_dia = new DateTime($data['dias'][$i]);
        	// combinacion de caldas
        	$objPhpExcel->getActiveSheet()
                      ->mergeCells("$col[$j]1:$col[$p]1")// primer desde h
                      ->mergeCells("$col[$j]2:$col[$p]2");//segun... desde h
        	// //lleno celdas combinadas
        	$objPhpExcel->getActiveSheet()
                      ->setCellValue("$col[$j]1", dia_espanol($data['dias'][$i]))
                      ->setCellValue("$col[$j]2", $fecha_dia->format('j-M'));
        	// Lleno celdas individuales DE TITULO
          $objPhpExcel->getActiveSheet()
                      ->setCellValue("$col[$j]3",'PROY.')
                      ->setCellValue("$col[$q]3",'FINA.')
                      ->setCellValue("$col[$p]3",'EN EJEC.')
                      // proyectadas
                      ->setCellValue("$col[$j]4",$d1_pro)
                      ->setCellValue("$col[$j]5",$d2_pro)
                      ->setCellValue("$col[$j]6",$d3_pro)
                      ->setCellValue("$col[$j]7",$d4_pro)
                      ->setCellValue("$col[$j]8",$d5_pro)
                      ->setCellValue("$col[$j]9",$d6_pro)
                      ->setCellValue("$col[$j]10",$t1_pro)
                      ->setCellValue("$col[$j]11",$t2_pro)
                      ->setCellValue("$col[$j]12",$t3_pro)
                      ->setCellValue("$col[$j]13",$t4_pro)
                      ->setCellValue("$col[$j]14",$t5_pro)
                      ->setCellValue("$col[$j]15",$t6_pro)
                      ->setCellValue("$col[$j]16",$c1_pro)
                      ->setCellValue("$col[$j]17",$c2_pro)
                      ->setCellValue("$col[$j]18",$c3_pro)

                      ->setCellValue("$col[$j]19",$total_pro)

                      ->setCellValue("$col[$j]22",$total_rf)
                      ->setCellValue("$col[$j]23",$total_tr)
                      ->setCellValue("$col[$j]24",$total_gd)
                      ->setCellValue("$col[$j]25",$total_pro)

                      // LLeno con guiones las celdas de FINA y EN EJEC
                      ->setCellValue("$col[$q]4","-")
                      ->setCellValue("$col[$q]5","-")
                      ->setCellValue("$col[$q]6","-")
                      ->setCellValue("$col[$q]7","-")
                      ->setCellValue("$col[$q]8","-")
                      ->setCellValue("$col[$q]9","-")
                      ->setCellValue("$col[$q]10","-")
                      ->setCellValue("$col[$q]11","-")
                      ->setCellValue("$col[$q]12","-")
                      ->setCellValue("$col[$q]13","-")
                      ->setCellValue("$col[$q]14","-")
                      ->setCellValue("$col[$q]15","-")
                      ->setCellValue("$col[$q]16","-")
                      ->setCellValue("$col[$q]17","-")
                      ->setCellValue("$col[$q]18","-")

                      ->setCellValue("$col[$p]4","-")
                      ->setCellValue("$col[$p]5","-")
                      ->setCellValue("$col[$p]6","-")
                      ->setCellValue("$col[$p]7","-")
                      ->setCellValue("$col[$p]8","-")
                      ->setCellValue("$col[$p]9","-")
                      ->setCellValue("$col[$p]10","-")
                      ->setCellValue("$col[$p]11","-")
                      ->setCellValue("$col[$p]12","-")
                      ->setCellValue("$col[$p]13","-")
                      ->setCellValue("$col[$p]14","-")
                      ->setCellValue("$col[$p]15","-")
                      ->setCellValue("$col[$p]16","-")
                      ->setCellValue("$col[$p]17","-")
                      ->setCellValue("$col[$p]18","-");

          //**************************************************
          // recordar fecha ejectado no sea festico
          //***********************************************

          $total_rf_ej = 0;
          $total_tr_ej = 0;
          $total_gd_ej = 0;
          $total_tr_asig = 0;
          $total_gd_asig = 0;

          $total_eje = 0;
          $total_asig = 0;
          // Leno los datos de los servicios Recorro los servicios tr y gdatos
          for ($s=0; $s < count($data['services']) ; $s++) {
            // $data['services'][$s]->f_ejecucion = habilPostFinSemana($data['services'][$s]->f_ejecucion);
            // $data['services'][$s]->f_ejecucion = habilPostFestivo($data['services'][$s]->f_ejecucion);
            
            //si la fecha habil es igual a la fecha_ejecucion
            if ($data['services'][$s]->f_ejecucion == $fecha_dia->format('Y-m-d')) {
              // Dependiendo el tipo lo pinta en la casilla dicha
              switch ($data['services'][$s]->tipo) {
                case 'C1':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$q]16",$data['services'][$s]->cant);
                  $total_gd_ej = $total_gd_ej + $data['services'][$s]->cant;
                  $c1 = $c1 + $data['services'][$s]->cant;
                  break;
                case 'C2':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$q]17",$data['services'][$s]->cant);
                  $total_gd_ej = $total_gd_ej + $data['services'][$s]->cant;
                  $c2 = $c2 + $data['services'][$s]->cant;
                  break;
                case 'C3':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$q]18",$data['services'][$s]->cant);
                  $total_gd_ej = $total_gd_ej + $data['services'][$s]->cant;
                  $c3 = $c3 + $data['services'][$s]->cant;
                  break;
                case 'T1':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$q]10",$data['services'][$s]->cant);
                  $total_tr_ej = $total_tr_ej + $data['services'][$s]->cant;
                  $t1 = $t1 + $data['services'][$s]->cant;
                  break;
                case 'T2':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$q]11",$data['services'][$s]->cant);
                  $total_tr_ej = $total_tr_ej + $data['services'][$s]->cant;
                  $t2 = $t2 + $data['services'][$s]->cant;
                  break;
                case 'T3':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$q]12",$data['services'][$s]->cant);
                  $total_tr_ej = $total_tr_ej + $data['services'][$s]->cant;
                  $t3 = $t3 + $data['services'][$s]->cant;
                  break;
                case 'T4':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$q]13",$data['services'][$s]->cant);
                  $total_tr_ej = $total_tr_ej + $data['services'][$s]->cant;
                  $t4 = $t4 + $data['services'][$s]->cant;
                  break;
                case 'T5':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$q]14",$data['services'][$s]->cant);
                  $total_tr_ej = $total_tr_ej + $data['services'][$s]->cant;
                  $t5 = $t5 + $data['services'][$s]->cant;
                  break;
                case 'T6':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$q]15",$data['services'][$s]->cant);
                  $total_tr_ej = $total_tr_ej + $data['services'][$s]->cant;
                  $t6 = $t6 + $data['services'][$s]->cant;
                  break;
              }

            }
          }

          // Leno los datos de los servicios Recorro rf 
          for ($t=0; $t < count($data['rf']) ; $t++) {
            //si la fecha habil es igual a la fecha_ejecucion
            if ($data['rf'][$t]->f_ejecucion == $fecha_dia->format('Y-m-d')) {
              // Dependiendo el tipo lo pinta en la casilla dicha
              switch ($data['rf'][$t]->tipo) {
                case 'D1':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$q]4",$data['rf'][$t]->cant);
                  $total_rf_ej = $total_rf_ej + $data['rf'][$t]->cant;
                  $d1 = $d1 + $data['services'][$s]->cant;
                  break;
                case 'D2':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$q]5",$data['rf'][$t]->cant);
                  $total_rf_ej = $total_rf_ej + $data['rf'][$t]->cant;
                  $d2 = $d2 + $data['services'][$s]->cant;
                  break;
                case 'D3':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$q]6",$data['rf'][$t]->cant);
                  $total_rf_ej = $total_rf_ej + $data['rf'][$t]->cant;
                  $d3 = $d3 + $data['services'][$s]->cant;
                  break;
                case 'D4':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$q]7",$data['rf'][$t]->cant);
                  $total_rf_ej = $total_rf_ej + $data['rf'][$t]->cant;
                  $d4 = $d4 + $data['services'][$s]->cant;
                  break;
                case 'D5':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$q]8",$data['rf'][$t]->cant);
                  $total_rf_ej = $total_rf_ej + $data['rf'][$t]->cant;
                  $d5 = $d5 + $data['services'][$s]->cant;
                  break;
                case 'D6':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$q]9",$data['rf'][$t]->cant);
                  $total_rf_ej = $total_rf_ej + $data['rf'][$t]->cant;
                  $d6 = $d6 + $data['services'][$s]->cant;
                  break;
              }

            }
          }



          // Leno los datos de los servicios en ejecucion (asignados)
          for ($s=0; $s < count($data['asig']) ; $s++) {
            //si la fecha habil es igual a la fecha_ejecucion
            if ($data['asig'][$s]->f_asignacion == $fecha_dia->format('Y-m-d')) {
              // Dependiendo el tipo lo pinta en la casilla dicha
              switch ($data['asig'][$s]->tipo) {
                case 'C1':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$p]16",$data['asig'][$s]->cant);
                  $total_gd_asig = $total_gd_asig + $data['asig'][$s]->cant;
                  $as_c1 = $as_c1 + $data['asig'][$s]->cant;
                  break;
                case 'C2':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$p]17",$data['asig'][$s]->cant);
                  $total_gd_asig = $total_gd_asig + $data['asig'][$s]->cant;
                  $as_c2 = $as_c2 + $data['asig'][$s]->cant;
                  break;
                case 'C3':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$p]18",$data['asig'][$s]->cant);
                  $total_gd_asig = $total_gd_asig + $data['asig'][$s]->cant;
                  $as_c3 = $as_c3 + $data['asig'][$s]->cant;
                  break;
                case 'T1':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$p]10",$data['asig'][$s]->cant);
                  $total_tr_asig = $total_tr_asig + $data['asig'][$s]->cant;
                  $as_t1 = $as_t1 + $data['asig'][$s]->cant;
                  break;
                case 'T2':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$p]11",$data['asig'][$s]->cant);
                  $total_tr_asig = $total_tr_asig + $data['asig'][$s]->cant;
                  $as_t2 = $as_t2 + $data['asig'][$s]->cant;
                  break;
                case 'T3':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$p]12",$data['asig'][$s]->cant);
                  $total_tr_asig = $total_tr_asig + $data['asig'][$s]->cant;
                  $as_t3 = $as_t3 + $data['asig'][$s]->cant;
                  break;
                case 'T4':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$p]13",$data['asig'][$s]->cant);
                  $total_tr_asig = $total_tr_asig + $data['asig'][$s]->cant;
                  $as_t4 = $as_t4 + $data['asig'][$s]->cant;
                  break;
                case 'T5':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$p]14",$data['asig'][$s]->cant);
                  $total_tr_asig = $total_tr_asig + $data['asig'][$s]->cant;
                  $as_t5 = $as_t5 + $data['asig'][$s]->cant;
                  break;
                case 'T6':
                  $objPhpExcel->getActiveSheet()->setCellValue("$col[$p]15",$data['asig'][$s]->cant);
                  $total_tr_asig = $total_tr_asig + $data['asig'][$s]->cant;
                  $as_t6 = $as_t6 + $data['asig'][$s]->cant;
                  break;

              }
            }
          }

         // Pinto el calculo de total ejecutadas... TABLA TOTALES
          $total_eje = $total_tr_ej + $total_gd_ej + $total_rf_ej;
          $total_asig = $total_tr_asig + $total_gd_asig + $total_rf_asig;
          $objPhpExcel->getActiveSheet()
                      ->setCellValue("$col[$q]19",$total_eje)
                      ->setCellValue("$col[$p]19",$total_asig)

                      ->setCellValue("$col[$q]22",$total_rf_ej)
                      ->setCellValue("$col[$q]23",$total_tr_ej)
                      ->setCellValue("$col[$q]24",$total_gd_ej)
                      ->setCellValue("$col[$q]25",$total_eje)

                      ->setCellValue("$col[$p]22",$total_rf_asig)
                      ->setCellValue("$col[$p]23",$total_tr_asig)
                      ->setCellValue("$col[$p]24",$total_gd_asig)
                      ->setCellValue("$col[$p]25",$total_asig);
           $j = $j+3;
        }

        //Aplicamos estilos a las celdas.
        $objPhpExcel->getActiveSheet()->getStyle('B1:F3')->applyFromArray($style_rojo);

        $objPhpExcel->getActiveSheet()->getStyle("H1:$col[$p]2")->applyFromArray($style_estandar);
        $objPhpExcel->getActiveSheet()->getStyle("E19:$col[$p]19")->applyFromArray($style_estandar);
        $objPhpExcel->getActiveSheet()->getStyle("H3:$col[$p]3")->applyFromArray($style_estandar2);

        $objPhpExcel->getActiveSheet()->getStyle("B4:$col[$p]9")->applyFromArray($style_azul);
        $objPhpExcel->getActiveSheet()->getStyle("B10:$col[$p]15")->applyFromArray($style_mora);
        $objPhpExcel->getActiveSheet()->getStyle("B16:$col[$p]18")->applyFromArray($style_amarillo);

        $objPhpExcel->getActiveSheet()->getStyle("C22:$col[$p]22")->applyFromArray($style_azul);
        $objPhpExcel->getActiveSheet()->getStyle("C23:$col[$p]23")->applyFromArray($style_mora);
        $objPhpExcel->getActiveSheet()->getStyle("C24:$col[$p]24")->applyFromArray($style_amarillo);
        $objPhpExcel->getActiveSheet()->getStyle("C25:$col[$p]25")->applyFromArray($style_estandar);
        
        $objPhpExcel->getActiveSheet()->getStyle($col[$p+2]."4:".$col[$p+7]."19")->applyFromArray($style_estandar);
        // $objPhpExcel->getActiveSheet()->getStyle($col[$p+2]."4:".$col[$p+7]."19")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
        // $objPhpExcel->getActiveSheet()->getStyle($col[$p+2]."4:".$col[$p+7]."19")->getNumberFormat()->setFormatCode('#,##0.00');

        //*************************INICIO TABLA 2 DE LA HOJA 1*************************
        $objPhpExcel->getActiveSheet()
                    ->setCellValue($col[$p+2]."3", "Cant.Proy")
                    ->setCellValue($col[$p+3]."3", "Finaliz")
                    ->setCellValue($col[$p+4]."3", "En ejec.")
                    ->setCellValue($col[$p+5]."3", "Cant.Proy")
                    ->setCellValue($col[$p+6]."3", "Finaliz")
                    ->setCellValue($col[$p+7]."3", "En ejec.");
        // Cant proyectada
        $objPhpExcel->getActiveSheet()
                    ->setCellValue($col[$p+2]."4", "106")
                    ->setCellValue($col[$p+2]."5", "126")
                    ->setCellValue($col[$p+2]."6", "18")
                    ->setCellValue($col[$p+2]."7", "7")
                    ->setCellValue($col[$p+2]."8", "1")
                    ->setCellValue($col[$p+2]."9", "1")
                    ->setCellValue($col[$p+2]."10", "259")
                    ->setCellValue($col[$p+2]."11", "289")
                    ->setCellValue($col[$p+2]."12", "76")
                    ->setCellValue($col[$p+2]."13", "267")
                    ->setCellValue($col[$p+2]."14", "51")
                    ->setCellValue($col[$p+2]."15", "178")
                    ->setCellValue($col[$p+2]."16", "25")
                    ->setCellValue($col[$p+2]."17", "25")
                    ->setCellValue($col[$p+2]."18", "150")
                    ->setCellValue($col[$p+2]."19", "1579");
        // cant Finalizada
        $objPhpExcel->getActiveSheet()
                    ->setCellValue($col[$p+3]."4", $d1)
                    ->setCellValue($col[$p+3]."5", $d2)
                    ->setCellValue($col[$p+3]."6", $d3)
                    ->setCellValue($col[$p+3]."7", $d4)
                    ->setCellValue($col[$p+3]."8", $d5)
                    ->setCellValue($col[$p+3]."9", $d6)
                    ->setCellValue($col[$p+3]."10", $t1)
                    ->setCellValue($col[$p+3]."11", $t2)
                    ->setCellValue($col[$p+3]."12", $t3)
                    ->setCellValue($col[$p+3]."13", $t4)
                    ->setCellValue($col[$p+3]."14", $t5)
                    ->setCellValue($col[$p+3]."15", $t6)
                    ->setCellValue($col[$p+3]."16", $c1)
                    ->setCellValue($col[$p+3]."17", $c2)
                    ->setCellValue($col[$p+3]."18", $c3)
                    ->setCellValue($col[$p+3]."19", $d1+$d2+$d3+$d4+$d5+$d6+$t1+$t2+$t3+$t4+$t5+$t6+$c1+$c2+$c3);
                    // en ejecucucion??????
        // cant Finalizada
        $objPhpExcel->getActiveSheet()
                    ->setCellValue($col[$p+4]."4", $as_d1)
                    ->setCellValue($col[$p+4]."5", $as_d2)
                    ->setCellValue($col[$p+4]."6", $as_d3)
                    ->setCellValue($col[$p+4]."7", $as_d4)
                    ->setCellValue($col[$p+4]."8", $as_d5)
                    ->setCellValue($col[$p+4]."9", $as_d6)
                    ->setCellValue($col[$p+4]."10", $as_t1)
                    ->setCellValue($col[$p+4]."11", $as_t2)
                    ->setCellValue($col[$p+4]."12", $as_t3)
                    ->setCellValue($col[$p+4]."13", $as_t4)
                    ->setCellValue($col[$p+4]."14", $as_t5)
                    ->setCellValue($col[$p+4]."15", $as_t6)
                    ->setCellValue($col[$p+4]."16", $as_c1)
                    ->setCellValue($col[$p+4]."17", $as_c2)
                    ->setCellValue($col[$p+4]."18", $as_c3)
                    ->setCellValue($col[$p+4]."19", $as_d1+$as_d2+$as_d3+$as_d4+$as_d5+$as_d6+$as_t1+$as_t2+$as_t3+$as_t4+$as_t5+$as_t6+$as_c1+$as_c2+$as_c3);


        // Cantidad proyectada $
        $objPhpExcel->getActiveSheet()
                    ->setCellValue($col[$p+5]."4", "$ 2.092.228 ")
                    ->setCellValue($col[$p+5]."5", "$ 4.974.102 ")
                    ->setCellValue($col[$p+5]."6", "$ 1.421.172 ")
                    ->setCellValue($col[$p+5]."7", "$ 552.678 ")
                    ->setCellValue($col[$p+5]."8", "$ 105.272 ")
                    ->setCellValue($col[$p+5]."9", "$ 157.908 ")
                    ->setCellValue($col[$p+5]."10", "$ 11.498.823 ")
                    ->setCellValue($col[$p+5]."11", "$ 12.830.733 ")
                    ->setCellValue($col[$p+5]."12", "$ 3.936.572 ")
                    ->setCellValue($col[$p+5]."13", "$ 11.853.999 ")
                    ->setCellValue($col[$p+5]."14", "$ 990.573 ")
                    ->setCellValue($col[$p+5]."15", "$ 3.457.294 ")
                    ->setCellValue($col[$p+5]."16", "$ 3.905.725 ")
                    ->setCellValue($col[$p+5]."17", "$ 3.905.725 ")
                    ->setCellValue($col[$p+5]."18", "$ 15.622.950 ")
                    ->setCellValue($col[$p+5]."19", "$ 77.305.754");



        // Cantidad finalizadas $
        $objPhpExcel->getActiveSheet()
                    ->setCellValue($col[$p+6]."4", '$ '.number_format($d1 * 19738))
                    ->setCellValue($col[$p+6]."5", '$ '.number_format($d2 * 39477))
                    ->setCellValue($col[$p+6]."6", '$ '.number_format($d3 * 78954))
                    ->setCellValue($col[$p+6]."7", '$ '.number_format($d4 * 78954))
                    ->setCellValue($col[$p+6]."8", '$ '.number_format($d5 * 105272))
                    ->setCellValue($col[$p+6]."9", '$ '.number_format($d6 * 157908))
                    ->setCellValue($col[$p+6]."10", '$ '.number_format($t1 * 44397))
                    ->setCellValue($col[$p+6]."11", '$ '.number_format($t2 * 44397))
                    ->setCellValue($col[$p+6]."12", '$ '.number_format($t3 * 51797))
                    ->setCellValue($col[$p+6]."13", '$ '.number_format($t4 * 44397))
                    ->setCellValue($col[$p+6]."14", '$ '.number_format($t5 * 19423))
                    ->setCellValue($col[$p+6]."15", '$ '.number_format($t6 * 19423))
                    ->setCellValue($col[$p+6]."16", '$ '.number_format($c1 * 156229))
                    ->setCellValue($col[$p+6]."17", '$ '.number_format($c2 * 156229))
                    ->setCellValue($col[$p+6]."18", '$ '.number_format($c3 * 104153))
                    ->setCellValue($col[$p+6]."19", '$ '.number_format(($d1 * 19738) +
                                                    ($d2 * 39477) +
                                                    ($d3 * 78954) +
                                                    ($d4 * 78954) +
                                                    ($d5 * 105272) +
                                                    ($d6 * 157908) +
                                                    ($t1 * 44397) +
                                                    ($t2 * 44397) +
                                                    ($t3 * 51797) +
                                                    ($t4 * 44397) +
                                                    ($t5 * 19423) +
                                                    ($t6 * 19423) +
                                                    ($c1 * 156229) +
                                                    ($c2 * 156229) +
                                                    ($c3 * 104153)));
        //  Cantidad finalizadas $ en ejecucion
        $objPhpExcel->getActiveSheet()
                    ->setCellValue($col[$p+7]."4", '$ '.number_format($as_d1 * 19738))
                    ->setCellValue($col[$p+7]."5", '$ '.number_format($as_d2 * 39477))
                    ->setCellValue($col[$p+7]."6", '$ '.number_format($as_d3 * 78954))
                    ->setCellValue($col[$p+7]."7", '$ '.number_format($as_d4 * 78954))
                    ->setCellValue($col[$p+7]."8", '$ '.number_format($as_d5 * 105272))
                    ->setCellValue($col[$p+7]."9", '$ '.number_format($as_d6 * 157908))
                    ->setCellValue($col[$p+7]."10", '$ '.number_format($as_t1 * 44397))
                    ->setCellValue($col[$p+7]."11", '$ '.number_format($as_t2 * 44397))
                    ->setCellValue($col[$p+7]."12", '$ '.number_format($as_t3 * 51797))
                    ->setCellValue($col[$p+7]."13", '$ '.number_format($as_t4 * 44397))
                    ->setCellValue($col[$p+7]."14", '$ '.number_format($as_t5 * 19423))
                    ->setCellValue($col[$p+7]."15", '$ '.number_format($as_t6 * 19423))
                    ->setCellValue($col[$p+7]."16", '$ '.number_format($as_c1 * 156229))
                    ->setCellValue($col[$p+7]."17", '$ '.number_format($as_c2 * 156229))
                    ->setCellValue($col[$p+7]."18", '$ '.number_format($as_c3 * 104153))
                    ->setCellValue($col[$p+7]."19", '$ '.number_format(($as_d1 * 19738) +
                                                    ($as_d2 * 39477) +
                                                    ($as_d3 * 78954) +
                                                    ($as_d4 * 78954) +
                                                    ($as_d5 * 105272) +
                                                    ($as_d6 * 157908) +
                                                    ($as_t1 * 44397) +
                                                    ($as_t2 * 44397) +
                                                    ($as_t3 * 51797) +
                                                    ($as_t4 * 44397) +
                                                    ($as_t5 * 19423) +
                                                    ($as_t6 * 19423) +
                                                    ($as_c1 * 156229) +
                                                    ($as_c2 * 156229) +
                                                    ($as_c3 * 104153)));

        //*****************************FIN TABLA 2***************************

        //*************************INICIO TABLA 3 DE LA HOJA 1*************************
                     // Titulos
        $objPhpExcel->getActiveSheet()
                    ->setCellValue($col[$p+4]."21", "TOTALES")
                    ->setCellValue($col[$p+5]."21", "CANTIDAD PROYECTADA")
                    ->setCellValue($col[$p+6]."21", "FINALIZADA CLARO")
                    ->setCellValue($col[$p+7]."21", "EN EJECUCION")
                    //tituos laterales
                    ->setCellValue($col[$p+4]."22", "TOTALES RF")
                    ->setCellValue($col[$p+4]."23", "TOTALES GDRT")
                    ->setCellValue($col[$p+4]."24", "TOTALES GRCD")
                    ->setCellValue($col[$p+4]."25", "TOTAL")
                    // cantidad $ proyextada por tipo
                    ->setCellValue($col[$p+5]."22",'$ 9.303.360')
                    ->setCellValue($col[$p+5]."23",'$ 44.567.994')
                    ->setCellValue($col[$p+5]."24",'$ 23.434.400')
                    ->setCellValue($col[$p+5]."25",'$ 77.305.754')
                    // cantidad $ finalizada  por tipo
                    ->setCellValue($col[$p+6]."22", '$ '.number_format(($d1 * 19738) + ($d2 * 39477) + ($d3 * 78954) + ($d4 * 78954) + ($d5 * 105272) + ($d6 * 157908)))#rf

                    ->setCellValue($col[$p+6]."23", '$ '.number_format(($t1 * 44397) + ($t2 * 44397) + ($t3 * 51797) + ($t4 * 44397) + ($t5 * 19423) + ($t6 * 19423)))#tr

                    ->setCellValue($col[$p+6]."24", '$ '.number_format(($c1 * 156229) + ($c2 * 156229) + ($c3 * 104153)))#gd

                    ->setCellValue($col[$p+6]."25", '$ '.number_format(($d1 * 19738) + ($d2 * 39477) + ($d3 * 78954) + ($d4 * 78954) + ($d5 * 105272) + ($d6 * 157908) + ($t1 * 44397) + ($t2 * 44397) + ($t3 * 51797) + ($t4 * 44397) + ($t5 * 19423) + ($t6 * 19423) + ($c1 * 156229) + ($c2 * 156229) + ($c3 * 104153)))

                    // cantidad $ finalizada  por tipo En ejecucion
                    ->setCellValue($col[$p+7]."22", '$ '.number_format(($as_d1 * 19738) + ($as_d2 * 39477) + ($as_d3 * 78954) + ($as_d4 * 78954) + ($as_d5 * 105272) + ($as_d6 * 157908)))#rf

                    ->setCellValue($col[$p+7]."23", '$ '.number_format(($as_t1 * 44397) + ($as_t2 * 44397) + ($as_t3 * 51797) + ($as_t4 * 44397) + ($as_t5 * 19423) + ($as_t6 * 19423)))#tr

                    ->setCellValue($col[$p+7]."24", '$ '.number_format(($as_c1 * 156229) + ($as_c2 * 156229) + ($as_c3 * 104153)))#gd

                    ->setCellValue($col[$p+7]."25", '$ '.number_format(($as_d1 * 19738) + ($as_d2 * 39477) + ($as_d3 * 78954) + ($as_d4 * 78954) + ($as_d5 * 105272) + ($as_d6 * 157908) + ($as_t1 * 44397) + ($as_t2 * 44397) + ($as_t3 * 51797) + ($as_t4 * 44397) + ($as_t5 * 19423) + ($as_t6 * 19423) + ($as_c1 * 156229) + ($as_c2 * 156229) + ($as_c3 * 104153)));
              

        // Estilos de la tabla 2 de la hoja 1
        $objPhpExcel->getActiveSheet()->getStyle($col[$p+4]."21:".$col[$p+7]."21")->applyFromArray($style_estandar);#titulos    
        $objPhpExcel->getActiveSheet()->getStyle($col[$p+4]."22:".$col[$p+7]."22")->applyFromArray($style_azul);#total rf
        $objPhpExcel->getActiveSheet()->getStyle($col[$p+4]."23:".$col[$p+7]."23")->applyFromArray($style_mora);#total tr
        $objPhpExcel->getActiveSheet()->getStyle($col[$p+4]."24:".$col[$p+7]."24")->applyFromArray($style_amarillo);#total gd
        $objPhpExcel->getActiveSheet()->getStyle($col[$p+4]."25:".$col[$p+7]."25")->applyFromArray($style_estandar);#total    
        //ESTILOS PARA TABLAS 2
        $objPhpExcel->getActiveSheet()->getStyle($col[$p+2]."2:".$col[$p+7]."3")->applyFromArray($style_rojo2);

        //*****************************FIN TABLA 4***************************
        /*******************************INICIO TABLA 4*******************************/

        $objPhpExcel->getActiveSheet()
                    ->setCellValue($col[$p+9]."4", "")
                    ->setCellValue($col[$p+10]."4", "D1")
                    ->setCellValue($col[$p+11]."4", "D2")
                    ->setCellValue($col[$p+12]."4", "D3")
                    ->setCellValue($col[$p+13]."4", "D4")
                    ->setCellValue($col[$p+14]."4", "D5")
                    ->setCellValue($col[$p+15]."4", "D6")
                    ->setCellValue($col[$p+16]."4", "T1")
                    ->setCellValue($col[$p+17]."4", "T2")
                    ->setCellValue($col[$p+18]."4", "T3")
                    ->setCellValue($col[$p+19]."4", "T4")
                    ->setCellValue($col[$p+20]."4", "T5")
                    ->setCellValue($col[$p+21]."4", "T6")
                    ->setCellValue($col[$p+22]."4", "C1")
                    ->setCellValue($col[$p+23]."4", "C2")
                    ->setCellValue($col[$p+24]."4", "C3")
                    // titulos laterales
                    ->setCellValue($col[$p+9]."5", "Cant.Proy")
                    ->setCellValue($col[$p+9]."6", "Finaliz")
                    ->setCellValue($col[$p+9]."7", "En ejec.")
                    // cantidad $ proyectada
                    ->setCellValue($col[$p+10]."5", "$ 2.092.228")
                    ->setCellValue($col[$p+11]."5", "$ 4.974.102")
                    ->setCellValue($col[$p+12]."5", "$ 1.421.172")
                    ->setCellValue($col[$p+13]."5", "$ 552.678")
                    ->setCellValue($col[$p+14]."5", "$ 105.272")
                    ->setCellValue($col[$p+15]."5", "$ 157.908")
                    ->setCellValue($col[$p+16]."5", "$ 11.498.823")
                    ->setCellValue($col[$p+17]."5", "$ 12.830.733")
                    ->setCellValue($col[$p+18]."5", "$ 3.936.572")
                    ->setCellValue($col[$p+19]."5", "$ 11.853.999")
                    ->setCellValue($col[$p+20]."5", "$ 990.573")
                    ->setCellValue($col[$p+21]."5", "$ 3.457.294")
                    ->setCellValue($col[$p+22]."5", "$ 3.905.725")
                    ->setCellValue($col[$p+23]."5", "$ 3.905.725")
                    ->setCellValue($col[$p+24]."5", "$ 15.622.950")
                    // cantidad $ finalizada
                    ->setCellValue($col[$p+10]."6", '$ '.number_format($d1 * 19738))
                    ->setCellValue($col[$p+11]."6", '$ '.number_format($d2 * 39477))
                    ->setCellValue($col[$p+12]."6", '$ '.number_format($d3 * 78954))
                    ->setCellValue($col[$p+13]."6", '$ '.number_format($d4 * 78954))
                    ->setCellValue($col[$p+14]."6", '$ '.number_format($d5 * 105272))
                    ->setCellValue($col[$p+15]."6", '$ '.number_format($d6 * 157908))
                    ->setCellValue($col[$p+16]."6", '$ '.number_format($t1 * 44397))
                    ->setCellValue($col[$p+17]."6", '$ '.number_format($t2 * 44397))
                    ->setCellValue($col[$p+18]."6", '$ '.number_format($t3 * 51797))
                    ->setCellValue($col[$p+19]."6", '$ '.number_format($t4 * 44397))
                    ->setCellValue($col[$p+20]."6", '$ '.number_format($t5 * 19423))
                    ->setCellValue($col[$p+21]."6", '$ '.number_format($t6 * 19423))
                    ->setCellValue($col[$p+22]."6", '$ '.number_format($c1 * 156229))
                    ->setCellValue($col[$p+23]."6", '$ '.number_format($c2 * 156229))
                    ->setCellValue($col[$p+24]."6", '$ '.number_format($c3 * 104153))
                    // en ejecucion 
                    ->setCellValue($col[$p+10]."7", '$ '.number_format($as_d1 * 19738))
                    ->setCellValue($col[$p+11]."7", '$ '.number_format($as_d2 * 39477))
                    ->setCellValue($col[$p+12]."7", '$ '.number_format($as_d3 * 78954))
                    ->setCellValue($col[$p+13]."7", '$ '.number_format($as_d4 * 78954))
                    ->setCellValue($col[$p+14]."7", '$ '.number_format($as_d5 * 105272))
                    ->setCellValue($col[$p+15]."7", '$ '.number_format($as_d6 * 157908))
                    ->setCellValue($col[$p+16]."7", '$ '.number_format($as_t1 * 44397))
                    ->setCellValue($col[$p+17]."7", '$ '.number_format($as_t2 * 44397))
                    ->setCellValue($col[$p+18]."7", '$ '.number_format($as_t3 * 51797))
                    ->setCellValue($col[$p+19]."7", '$ '.number_format($as_t4 * 44397))
                    ->setCellValue($col[$p+20]."7", '$ '.number_format($as_t5 * 19423))
                    ->setCellValue($col[$p+21]."7", '$ '.number_format($as_t6 * 19423))
                    ->setCellValue($col[$p+22]."7", '$ '.number_format($as_c1 * 156229))
                    ->setCellValue($col[$p+23]."7", '$ '.number_format($as_c2 * 156229))
                    ->setCellValue($col[$p+24]."7", '$ '.number_format($as_c3 * 104153));

                    //ESTILOS
                    $objPhpExcel->getActiveSheet()->getStyle($col[$p+9]."4:".$col[$p+24]."7")->applyFromArray($style_estandar);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+9] )->setWidth(15);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+10])->setWidth(15);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+11])->setWidth(15);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+12])->setWidth(15);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+13])->setWidth(15);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+14])->setWidth(15);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+15])->setWidth(15);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+16])->setWidth(15);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+17])->setWidth(15);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+18])->setWidth(15);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+19])->setWidth(15);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+20])->setWidth(15);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+21])->setWidth(15);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+22])->setWidth(15);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+23])->setWidth(15);
                    $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+24])->setWidth(15);


                    /***************************FIN TABLA 4***************************/

        // cONGELO LA COLUMNA IZQUIERDA
        $objPhpExcel->getActiveSheet()->freezePane('C1');
        //Aplicamos las dimenciones a las columna...
        $objPhpExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(12);
        $objPhpExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(25);

        //Aplicamos las dimenciones a las columna...
        $objPhpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(0);
        $objPhpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
        $objPhpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
        $objPhpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(49);
        $objPhpExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
        $objPhpExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
        $objPhpExcel->getActiveSheet()->getColumnDimension('G')->setWidth(0);

        $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+2])->setWidth(16);
        $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+3])->setWidth(14);
        $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+4])->setWidth(14);
        $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+5])->setWidth(30);
        $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+6])->setWidth(25);
        $objPhpExcel->getActiveSheet()->getColumnDimension($col[$p+7])->setWidth(24);



        /**************************INICIO SEGUNDA HOJA**************************/

        // $sheet = $objPhpExcel->getActiveSheet();

        // //Start adding next sheets
        

        //   // Add new sheet
        //   $objWorkSheet = $objPhpExcel->createSheet(1); //Setting index when creating

        //   //Write cells
        //   $objWorkSheet->setCellValue('A1', 'Hello')
        //                ->setCellValue('B2', 'world!')
        //                ->setCellValue('C1', 'Hello')
        //                ->setCellValue('D2', 'world!');

        //   // Rename sheet
        //   $objWorkSheet->setTitle("osea hellow");

        /***************************FIN SEGUNDA HOJA***************************/
                //Ahora pintamos los datos...
        //Ponemos un nombre a la hoja.
        $objPhpExcel->getActiveSheet()->setTitle("Reporte Facturación de ".$meses[$mes]);
        //Hacemos la hoja activa...
        $objPhpExcel->setActiveSheetIndex(0);
        //Guardamos.
        $objWriter = new PHPExcel_Writer_Excel2007($objPhpExcel);
        $filename = 'Reporte Facturación de '.$meses[$mes].' - (' . date("Y-m-d") . ').xlsx';
        $objWriter->save($filename);
        Redirect::to(URL::to($filename));
      }

      private function setCellValue(&$sheet, $cell, $value) {
        $value = str_replace(array("<br/>"), "", $value);
        $sheet->setCellValue($cell, $value);
      }

      //retorna la ultima llave de un arreglo
      private function endKey($array){
          end($array);
          return key( $array );  
      }



}





