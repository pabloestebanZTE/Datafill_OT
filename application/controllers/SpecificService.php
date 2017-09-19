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
        $this->load->model('mail/mail_manager_model');
        $this->load->model('data/configdb_model');
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
        //echo "<br><br><br><br>";
        //print_r($_FILES['idarchivo']['type']);
         if ( is_uploaded_file($_FILES['idarchivo']['tmp_name']) )
        {
           //echo 'El archivo se ha subido con éxito';
           $rand = rand(1000,999999);
           $origen = $_FILES['idarchivo']['tmp_name'];
           $destino = $rand.$_FILES['idarchivo']['name'];
           move_uploaded_file($origen, $destino);
        }else{
          echo "archivo no encontrado";
        }
      //----------funcion para convertir excel en arreglo.
       //header('Content-Type: text/plain');//convierte a texto plano
        $backslash = "\ ";
        $argv[1] = $rand.$_FILES['idarchivo']['name'];// a esta variable $argv[1] le asignamos la ruta del documento, se usan backslash(\)
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
        if (/*$count2 > 0*/true){
          $engs = $this->dao_user_model->getAllEngineersClaro();
          $this->mail_manager_model->mailAssign($engs);
          $_SESSION['mensaje'] = "ok";
        } else {
          $_SESSION['mensaje'] = "error";
        }
       // $this->listServices();
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
