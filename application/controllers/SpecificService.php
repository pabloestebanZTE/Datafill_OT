<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class SpecificService extends CI_Controller {

      function __construct() {
        parent::__construct();
        $this->load->model('data/configdb_model');
        $this->load->model('data/dao_service_model');
        $this->load->model('data/configdb_model');
        $this->load->model('service_spec_model');
        $this->load->model('order_model');
        $this->load->model('rf_model');
       // $this->load->model('mail/mail_manager_model');
        $this->load->model('data/configdb_model');
        $this->load->library('session');
        $this->load->helper('form');
      }

      public function assignService(){
        $answer['services'] = $this->dao_service_model->getAllServices();
      }

      public function saveServiceS(){
        date_default_timezone_set("America/Bogota");
        $mysqlDateTime = date('c');
        $service = new service_spec_model;
        $service->createServiceS( "", "", $_POST['idActividad'], $_POST['observacionesC'], $_POST['fechaA'], $_POST['fechaA'], explode("T", $mysqlDateTime)[0], $_POST['fechafc'], $_POST['idOrden'], explode("@", $_POST['sitio'])[1], $_POST['tipo'], $_POST['ingeniero'], $_POST['observaciones'], $_POST['ingSol'], $_POST['proyecto'], "Creada", "");
        $this->dao_service_model->insertServiceS($service);
        $this->listServices();
      }

      public function listServices(){
        $answer['services'] = $this->dao_service_model->getAllServicesS();
        $answer['message'] = $_SESSION['mensaje'];
        $this->load->view('listServices', $answer);
      }
//CAMILO-------------------------------------------------------------------------------------
      public function updateSpectService(){
        $close = new service_spec_model;
        $close->closeService($_POST['fInicior'], $_POST['fFinr'], $_POST['crq'], $_POST['state'], $_POST['observacionesCierre']);
        $close->setIdClaro($_POST['idService']);
        $close->setId($_POST['keyId']);
        $this->dao_service_model->updateClose($close);

      }
//CAMILO-----------------------------------------------------------------para leer excel

      public function viewExcel(){

          $tamano = $_FILES["idarchivo"]['size'];
          $tipo = $_FILES["idarchivo"]['type'];
          $archivo = $_FILES["idarchivo"]['name'];
          $prefijo = substr(md5(uniqid(rand())),0,6);

          if ($archivo != "") {
      		// guardamos el archivo a la carpeta files
      		  $destino =  "files/".$prefijo."_".$archivo;
      		    if (copy($_FILES['idarchivo']['tmp_name'],$destino)) {
      			       $status = "Archivo subido: <b>".$archivo."</b>";
                   echo $status;
              } else {
          			$status = "Error al subir el archivo";
                echo $status;
          		  }
        	} else {
          		$status = "Error al subir archivo";
              echo $status;
          	}

           //$rand = rand(1000,999999);
           //$origen = $_FILES['idarchivo']['tmp_name'];
           //$destino = $rand.$_FILES['idarchivo']['name'];
           //move_uploaded_file($origen, $destino);

      //----------funcion para convertir excel en arreglo.
       //header('Content-Type: text/plain');//convierte a texto plano
        $argv[1] = $destino;// a esta variable $argv[1] le asignamos la ruta del documento, se usan backslash(\)
        if (isset($argv[1]))
        {
          $Filepath = $argv[1];
        }
        elseif (isset($_GET['File']))
        {
          $Filepath = $_GET['File'];
        }
        else
        {
          if (php_sapi_name() == 'cli')
          {
            echo 'Please specify filename as the first argument'.PHP_EOL;
          }
          else
          {
            echo 'Please specify filename as a HTTP GET parameter "File", e.g., "/test.php?File=test.xlsx"';
          }
          exit;
        }

          require('spreadsheet/php-excel-reader/excel_reader2.php');//necesario para convercion
          require('spreadsheet/SpreadsheetReader.php');//necesario para convercion
          date_default_timezone_set('UTC');
            $StartMem = memory_get_usage();
            $i = 0;
            $j = 0;
            try
            {
              $Spreadsheet = new SpreadsheetReader($Filepath);
              $BaseMem = memory_get_usage();
              $Sheets = $Spreadsheet -> Sheets();
              foreach ($Sheets as $Index => $Name){
                $Time = microtime(true);
                $Spreadsheet -> ChangeSheet($Index);
                foreach ($Spreadsheet as $Key => $Row){
                  $arreglo[$i][$j] = $Row;
                  if ($Row){
                    //print_r($Row);
                  } else{
                    //var_dump($Row);
                    }
                  $CurrentMem = memory_get_usage();
                  if ($Key && ($Key % 500 == 0)){
                  }
                  $j++;
                }
                $i++;
              }
            }
            catch (Exception $E)
            {
              echo $E -> getMessage();
            }
            //echo "\n\n";
            //echo "\n\n";
         $array['excel'] = $arreglo;
         $_SESSION['excel'] = $arreglo;
         //print_r($_SESSION['excel']);
         //llamar vista segun opcion
         if ($_GET['option']==1) {
          $array['eng'] = $this->dao_user_model->getAllEngineers();//llama todos los ing para pintar en select
          $this->load->view('excelAssign', $array);
         }
         if ($_GET['option']==2) {
          $this->load->view('excelCancel', $array);
         }
         if ($_GET['option']==3) {
          $this->load->view('excelExecute', $array);
         }

         return $array['excel'];
      }

//------------------------------RF-----------------------
      public function upLoadRF(){
        header('Content-Type: text/plain');//convierte a texto plano
        $rf['excel'] = $this->viewExcel();
        $users = $this->dao_user_model->getAllEngineers();//llama los ingenieros para comparar con el excel
        //print_r($rf['excel']);
        for ($i=1; $i < count($rf['excel'][0]) ; $i++) {
          //cambio fechas de formato / por -
          $dateReq = str_replace("/", "-", $rf['excel'][0][$i][0]);
          $dateA = str_replace("/", "-", $rf['excel'][0][$i][5]);
          $dateS = str_replace("/", "-", $rf['excel'][0][$i][7]);
          $dateB = str_replace("/", "-", $rf['excel'][0][$i][14]);
          $dateRev = str_replace("/", "-", $rf['excel'][0][$i][16]);
          $dateRa = str_replace("/", "-", $rf['excel'][0][$i][17]);
          $dateOT = str_replace("/", "-", $rf['excel'][0][$i][18]);
          //rellenar campo code(codigo) vacio
          $cod = $rf['excel'][0][$i][21];

          if ($rf['excel'][0][$i][21] == "") {
            if (substr_count($rf['excel'][0][$i][3], "1900") == 1) {
               $cod = "D3";
            }
            if (substr_count($rf['excel'][0][$i][3], "850") == 1) {
               $cod = "D4";
            }
          }

          //print_r($users);
          $engA = $rf['excel'][0][$i][6];
            print_r(similar_text((explode(" ", $engA))[0], explode(" ", $users[2]->getName())[0], $porc));
          for ($j=0; $j <count($users) ; $j++) {
            if ((explode(" ", $engA))[0] == explode(" ", $users[$j]->getName())[0]) {
              if (explode(" ", $users[$j]->getLastname())[0] == explode(" ", $engA)[1] || explode(" ", $users[$j]->getLastname())[0] == explode(" ", $engA)[2] || explode(" ", $users[$j]->getLastname())[0] == explode(" ", $engA)[3]) {
                $EngA = $users[$j]->getId();
                $engName = $users[$j]->getName();
              }
            }
          }

          //print_r($engName);

          $up = new rf_model;
          $up->createRF("", $dateReq, $rf['excel'][0][$i][1], $rf['excel'][0][$i][2], $rf['excel'][0][$i][3], $rf['excel'][0][$i][4], $dateA, $rf['excel'][0][$i][6], $dateS, $rf['excel'][0][$i][8], $rf['excel'][0][$i][9], $rf['excel'][0][$i][10], $rf['excel'][0][$i][11], $rf['excel'][0][$i][12], $rf['excel'][0][$i][13], $dateB, $rf['excel'][0][$i][15], $dateRev, $dateRa, $dateOT, $rf['excel'][0][$i][20], $cod);

          echo "<br><br>";
          //print_r($up);
          $this->dao_rf_model->updateRF($up);



        }
          $this->load->view('viewRF', $rf);

      }
     //--------------------guardar en bd asignar con excel
      public function saveServicesExcel(){
       $order = new order_model;
       $order->createOrder($_SESSION['excel'][0][0][1],"",str_replace("/", "-", substr($_SESSION['excel'][0][5][1], 0, -5)));//fnc str_replace() para remplazar algun caracter o string por otro, fnc substr()borra caracteres
        $this->dao_order_model->insertOrder($order);
       $activity = new service_spec_model;
       $count2 = 0;
          for ($g=12; $g < count($_SESSION['excel'][0]); $g++) {
            if ($_SESSION['excel'][0][$g][0]!="") {

  //------------ funcion para traer solo el sitio especifico de una cadena larga de caracteres con la funcion substr_count(x,y), la cual cuenta cuantas veces esta el string(y) en el string(x)
                  $allSites = $this->dao_site_model->getAllSites();//llama todos los sitios de la db
                  $site = $_SESSION['excel'][0][$g][4];//celda del excel o arreglo donde esta el sitio
                  $flag2 = 0;
                  for ($i=0; $i < count($allSites); $i++) {
                    $flag = substr_count($site, $allSites[$i]->getName());//cuenta cuantas veces esta allsites en site
                    if ($flag == 1){
                      //nombre del sitio (BD)
                      $siteName= $allSites[$i]->getName();
                      //ID del sitio (BD)
                      $siteId= $allSites[$i]->getId();
                      $flag2 = 1;
                    }
                  }
                  //si no existe el sitio, lo añade a bd con id
                  if($flag2 == 0){
                        $siteName= (explode("staciones:", $site)[1]);
                        $siteId= count($allSites)+1;//añade id nuevo
                        $newSite = new site_model;
                        $newSite->createSite($siteId,  $siteName);
                         $this->dao_site_model->insertNewSite($newSite);
                        $allSites[count($allSites)] = $newSite;
                  }
    //funcion para quitar caracteres de una cadena con substr(x,desde donde comienza, caracteres a suprimir) en este caso la uso para quitarle la hora al campo date creation
                  $dateCreation = str_replace("/", "-", substr($_SESSION['excel'][0][5][1], 0, -5));
                  $dateForecast = str_replace("/", "-", $_SESSION['excel'][0][$g][5]);

//funciones para comparar el tipo(type) extraido del excel, y convertirlo en el id del tipo(type) q esta en bd
                $service = (explode("-",$_SESSION['excel'][0][$g][1])[0]);// funcion para dividir una cadena de caracteres dependiendo la llave, en este caso se usa para tomar la primera parte, antes del guion (-)

                if ((explode("-",$_SESSION['excel'][0][$g][1])[0][2]) == "0"){//los T10 T11 Y T12 hay q convertirlos en C1 C2 Y C3 respectivamente
                  $service = "C1";
                }
                if ((explode("-",$_SESSION['excel'][0][$g][1])[0][2]) == "1"){
                  $service = "C2";
                }
                if ((explode("-",$_SESSION['excel'][0][$g][1])[0][2]) == "2"){
                  $service = "C3";
                }
                $allService = $this->dao_service_model->getAllServices();//trae todos los servicios
                  for ($i=0; $i <count($allService) ; $i++){//comparacion de tipo excel y bd y con a id
                    if ($service == $allService[$i]->getType()) {
                        $typeId = $allService[$i]->getId();//id del tipo de db
                    }
                  }
                 $cant1 = $_POST['cantidad1'] + 11;
                 $cant2 = $_POST['cantidad2'] + $cant1;
                 $cant3 = $_POST['cantidad3'] + $cant2;
                 $eng = $_POST['inge1'];
                 if ($cant1 < $g) {
                   $eng = $_POST['inge2'];
                 }
                 if ($cant2 < $g) {
                   $eng = $_POST['inge3'];
                 }
                //-----------creacion del objeto---------------------------
                $activity->createServiceS($eng, "", $_SESSION['excel'][0][$g][0], $_SESSION['excel'][0][$g][4], "", "", $dateCreation, $dateForecast, $_SESSION['excel'][0][0][1], $siteId, $typeId, "",  $_SESSION['excel'][0][4][1], $_SESSION['excel'][0][2][1], $_SESSION['excel'][0][3][1], "Creada","");
                $activity->setQuantity($_SESSION['excel'][0][$g][3]);
                $activity->setRegion($_SESSION['excel'][0][$g][2]);
              // print_r($activity);
                $countActivities = $this->dao_service_model->insertFromExcel($activity);
                $count2+=$countActivities;
          }
        }
        if ($count2 > 0){
          $engs = $this->dao_user_model->getAllEngineersClaro();
          $asig = $this->dao_user_model->getUserById($eng);
          $engC = $_SESSION['excel'][0][2][1];

          for ($i=0; $i <count($engs) ; $i++) {

            if ((explode(" ", $engC))[0] == explode(" ", $engs[$i]->getName())[0]) {
              if (explode(" ", $engs[$i]->getLastname())[0] == explode(" ", $engC)[1] || explode(" ", $engs[$i]->getLastname())[0] == explode(" ", $engC)[2] || explode(" ", $engs[$i]->getLastname())[0] == explode(" ", $engC)[3]) {
                $mailEngC = $engs[$i]->getMail();
                $engName = $engs[$i]->getName();
              }
            }
          }

          //-------------------------------email------------------

          $cuerpo = "<html>
                        <head>
                        <title>asignacion</title>
                         <link rel= 'stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css'>
                         <link rel= 'stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css'>
                          <script src='//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js'></script>

                        </head>
                       <body>
                        <h4>Buen Día ".$engName.", el Ingeniero asignado para esta actividad es el siguiente:</h4><br>

                           <table id='example2' class='table table-bordered table-striped' border='1'>
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

          $this->load->library('email');

          $config['mailtype'] = 'html'; // o text
          $this->email->initialize($config);

          $this->email->from('zolid@zte.com', 'ZOLID_ZTE');

          $this->email->to(strtolower($mailEngC).', '.strtolower($asig->getMail()));

          //$this->email->to('yuyupa14@gmail.com, andrea.rosero.ext@claro.com.co, andrea.lorenaroserochasoy@zte.com.cn, pablo.esteban@zte.com.cn, bredybuitrago@gmail.com');
          $this->email->cc(' andrea.rosero.ext@claro.com.co, cesar.rios.ext@claro.com.co');
          $this->email->bcc('bredybuitrago@gmail.com ,bredi.buitrago@zte.com.cn, pablo.esteban@zte.com.cn');

          $this->email->subject("Notificación de asignación de orden de servicio. Orden: ".$_SESSION['excel'][0][0][1].". Proyecto: ".$_SESSION['excel'][0][3][1].".");
          $this->email->message($cuerpo);

          $this->email->send();


          if($this->email->send())
          $this->session->set_flashdata("email_sent","Email sent successfully.");
          else
          $this->session->set_flashdata("email_sent","Error in sending Email.");


          $_SESSION['mensaje'] = "ok";
        } else {
          $_SESSION['mensaje'] = "error";
        }
        $this->listServices();
      }

      public function saveCancelExcel(){
        $cancel = new service_spec_model;
        for ($g=12; $g < count($_SESSION['excel'][0]); $g++) {
          if ($_SESSION['excel'][0][$g][0]!="") {
            $cancel->createServiceS("", "", $_SESSION['excel'][0][$g][0], $_SESSION['excel'][0][$g][3], "", "", "", "", $_SESSION['excel'][0][0][1], "", "", "", $_SESSION['excel'][0][2][1], $_SESSION['excel'][0][1][1], "", "cancelada", "");
          }
          $this->dao_service_model->CancelFromExcel($cancel);
        }
        $this->listServices();
      }

      public function saveExecuteExcel(){
        $executed = new service_spec_model;
        for ($g=12; $g < count($_SESSION['excel'][0]); $g++) {
          if ($_SESSION['excel'][0][$g][0]!="") {
            $executed->createServiceS("", "", $_SESSION['excel'][0][$g][0], $_SESSION['excel'][0][$g][3], "", "", "", "", $_SESSION['excel'][0][0][1], "", "", "", $_SESSION['excel'][0][2][1], $_SESSION['excel'][0][1][1], "", "ejecutada", "");
          }
             $this->dao_service_model->executeFromExcel($executed);
        }
             $this->listServices();
      }

  }
?>
