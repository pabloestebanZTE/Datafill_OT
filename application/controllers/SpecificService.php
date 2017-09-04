<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class SpecificService extends CI_Controller {

      function __construct() {
        parent::__construct();
        $this->load->model('data/configdb_model');
        $this->load->model('data/dao_service_model');
        $this->load->model('service_spec_model');
        $this->load->model('order_model');
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
        $answer['message'] = "ok";
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
  //-----------------------------------------------------------------
      
      public function upExcel(){


        print_r($_FILES['idarchivo']['name']);
//----------funcion para convertir excel en arreglo...-----------------
        header('Content-Type: text/plain');
        $backslash = "\ ";
        $argv[1] = "files".$backslash[0].$_FILES['idarchivo']['name'];// a esta variable $argv[1] le asignamos la ruta del documento, se usan backslash(\)
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
                    var_dump($Row);
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
            print_r($arreglo);
//--------------------------------fin de la funcion para convertir excel en arreglo...

        $order = new order_model;
        $order->createOrder($arreglo[0][0][1],"",str_replace("/", "-", substr($arreglo[0][5][1], 0, -6)));//fnc str_replace() para remplazar algun caracter o string por otro, fnc substr()borra caracteres
        $activity = new service_spec_model;
        //$this->dao_order_model->insertOrder($order);
          for ($g=9; $g < count($arreglo[0]); $g++) { 
            if ($arreglo[0][$g][0]!="") {
                 
  //------------ funcion para traer solo el sitio especifico de una cadena larga de caracteres con la funcion substr_count(x,y), la cual cuenta cuantas veces esta el string(y) en el string(x)              
                  $allSites = $this->dao_site_model->getAllSites();//llama todos los sitios de la db
                  $site = $arreglo[0][$g][3];//celda del excel o arreglo donde esta el sitio
                  for ($i=0; $i < count($allSites); $i++) {
                    $flag = substr_count($site, $allSites[$i]->getName());
                      if ($flag >0){
                        //nombre del sitio (BD)
                        $siteName= $allSites[$i]->getName();
                        //ID del sitio (BD)
                        $siteId= $allSites[$i]->getId();
                      }
                  }
    //funcion para quitar caracteres de una cadena con substr(x,desde donde comienza, caracteres a suprimir) en este caso la uso para quitarle la hora al campo date creation
                  $dateCreation = str_replace("/", "-", substr($arreglo[0][5][1], 0, -6));
                
//funciones para comparar el tipo(type) extraido del excel, y convertirlo en el id del tipo(type) q esta en bd
                $service = (explode("-",$arreglo[0][$g][1])[0]);// funcion para dividir una cadena de caracteres dependiendo la llave, en este caso se usa para tomar la primera parte, antes del guion (-)
                $allService = $this->dao_service_model->getAllServices();//trae todos los servicios
                  for ($i=0; $i <count($allService) ; $i++){//comparacion de tipo excel y bd y con a id               
                    if ($service == $allService[$i]->getType()) {
                        $typeId = $allService[$i]->getId();//id del tipo de db
                    }                
                  }
                //-----------creacion del objeto---------------------------
                $activity->createServiceS("", "", $arreglo[0][$g][0], $arreglo[0][$g][3], "", "", $dateCreation, $arreglo[0][$g][4], $arreglo[0][0][1], $siteId, $typeId, "",  $arreglo[0][4][1], $arreglo[0][2][1], $arreglo[0][3][1], "Creada","");
                print_r($activity);               
                //$this->dao_service_model->insertFromExcel($activity);
            }    
        }                                              
      }
  }
?>
