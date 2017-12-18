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
      //  $this->load->library('session');
        $this->load->helper('form');
      }

      public function assignService(){
        $answer['services'] = $this->dao_service_model->getAllServices();
      }

      //=================
      public function assignByMail(){
/*        header('Content-Type: text/plain');
*/       /* print_r(explode("\n", $_POST['actividades']));*/
        //validacion si viene de correo de asignacion
        $_POST['actividades'] = str_replace("\t", "\n", $_POST['actividades']);
        $clave = explode("\n", $_POST['actividades'])[8];
        $clave = str_replace(array("\n", "\r", "\t"), '', $clave);
        if ($clave == "Proyecto:") {           
          //creacion orden          
          $orden = explode("Detalle de servicios", $_POST['actividades']);       
          $asignar['ot'] = str_replace(array("\n", "\r", "\t", " "), '', explode("\n", $orden[0])[3]);
          $asignar['solicitante'] =  explode("\n", $orden[0])[7];
          $asignar['proyecto'] = explode("\n", $orden[0])[9];
          $asignar['descripcion'] = explode("\n", $orden[0])[11];
          $asignar['fCreacion'] = str_replace("/", "-", substr(explode("\n", $orden[0])[13], 0, -9));
          //separacion  actividades
          $tareas = explode("Forecast", $_POST['actividades']);
          $id = explode("\n", $tareas[1]);
            $plus = 0;
          $value = count($id);
          for($x = 1; $x < $value; $x=$x+6){
             
            if($id[$x] != ""){

              //creacion actividades
              $asignar['actividades'][$plus] = str_replace(array("\n", "\r", "\t", " "), '', $id[$x]);
              //fin actividades

              //creacion tipo
              //funciones para comparar el tipo extraido text area, y convertirlo en el id del tipo q esta en bd
              $service = (explode("-",$id[$x+1])[0]);// funcion para dividir una cadena de caracteres dependiendo la llave, en este caso se usa para tomar la primera parte, antes del guion (-)

              if ((explode("-",$id[$x+1])[0][2]) == "0"){//los T10 T11 Y T12 hay q convertirlos en C1 C2 Y C3 respectivamente
                $service = "C1";
              }
              if ((explode("-",$id[$x+1])[0][2]) == "1"){
                $service = "C2";
              }
              if ((explode("-",$id[$x+1])[0][2]) == "2"){
                $service = "C3";
              }
              //traer todos los servicios
              $allService = $this->dao_service_model->getAllServices();//trae todos los servicios
                for ($i=0; $i <count($allService) ; $i++){//comparacion de tipo excel y bd y con a id
                  if ($service == $allService[$i]->getType()) {
                      $typeId = $allService[$i]->getId();//id del tipo de db
                      $typeName = $allService[$i]->getType();//id del tipo de db

                  }
                }          
                $asignar['tipo']['idTipo'][$plus] = $typeId;
                $asignar['tipo']['name'][$plus] = $typeName;

              // fin creacion tipo

              //creacion regional
              $asignar['regional'][$plus] = $id[$x+2];
              //fin creacion regional

              //creacion cantidad
              $asignar['cantidad'][$plus] = $id[$x+3];
              //fin creacion cantidad

              //creacion descripcionActividad
              $asignar['descripcionActividad'][$plus] = $id[$x+4];
              //fin creacion descripcionActividad

              //creacion forecast
              $asignar['forecast'][$plus] = str_replace("/", "-", $id[$x+5]);
              //fin creacion  forecast

              //creacion site
              //funcion para traer solo el sitio especifico de una cadena larga de caracteres con la funcion substr_count(x,y), la cual cuenta cuantas veces esta el string(y) en el string(x)
              $allSites = $this->dao_site_model->getAllSites();//llama todos los sitios de la db
              $site = $id[$x+4];//celda del excel o arreglo donde esta el sitio
              $flag2 = 0;
              for ($i=0; $i < count($allSites); $i++) {
                $flag = substr_count($site, $allSites[$i]->getName());//cuenta cuantas veces esta allsites en site
                if ($flag == 1){
                  //nombre del sitio (BD)
                  $asignar['sitio']['name'][$plus] = $allSites[$i]->getName();
                  //ID del sitio (BD)
                  $asignar['sitio']['id'][$plus]= $allSites[$i]->getId();
                  $flag2 = 1;
                }
              }
              //si no existe el sitio, lo añade a bd con id
              if($flag2 == 0){
                    $asignar['sitio']['name'][$plus]= (explode("staciones:", $site)[1]);
                    $asignar['sitio']['id'][$plus]= count($allSites)+1;//añade id nuevo
                    $newSite = new site_model;
                    $newSite->createSite($asignar['sitio']['id'][$plus], $asignar['sitio']['name'][$plus]);
                     $this->dao_site_model->insertNewSite($newSite);
                    $allSites[count($allSites)] = $newSite;
              }
              //fin creacion site

              $plus++;
            }
          }
            $asignar['eng'] = $this->dao_user_model->getAllEngineers();//llama todos los ing para pintar en select
            /*print_r($asignar);*/
            $array['asignar'] = $asignar;
            $this->load->view('excelAssign', $array);
        }else{
          $answer['error'] = "error";
          $this->load->view('assignService', $answer);
        }
      }

      public function cancelByMail(){
        /*header('Content-Type: text/plain');*/
        //verificacion si viene de correo cancelacion
        $_POST['cancelacion'] = str_replace("\t", "\n", $_POST['cancelacion']);
        $clav1 = explode("\n", $_POST['cancelacion'])[8];
        $clave1 = str_replace(array("\n", "\r", "\t"), '', $clav1);
        $clav2 = explode("\n", $_POST['cancelacion'])[23];
        $clave2 = str_replace(array("\n", "\r", "\t"), '', $clav2);
        //si es de cancelacion ejecuta la accion
        if ($clave1 == "Fecha de creación:" && $clave2 != "Fecha ejecución") {
          $orden = explode("Servicios unitarios", $_POST['cancelacion']); 
          $cancelar['ot'] = str_replace(array("\n", "\r", "\t", " "), '', explode("\n", $orden[0])[3]);
          $cancelar['solicitante'] = explode("\n", $orden[0])[5];
          $cancelar['descripcion'] = explode("\n", $orden[0])[7];
          $cancelar['fCreacion'] = str_replace("/", "-", substr(explode("\n", $orden[0])[9], 0, -9));
          $tareas = explode("Descripción", $orden[1]);
          $id = explode("\n", $tareas[1]);
          $plus = 0;
          for ($x=1; $x < count($id) ;  $x=$x+4) { 
            if ($id[$x] != "") {
              $cancelar['idActividad'][$plus] = str_replace(array("\n", "\r", "\t", " "), '',$id[$x]);
              $cancelar['tipo'][$plus] = (explode("-",$id[$x+1])[0]);
              $cancelar['cantidad'][$plus] = $id[$x+2];
              $cancelar['descripcionActividad'][$plus] = $id[$x+3];
              $plus++;
            }
          }
          $array['cancelar'] = $cancelar;
          $this->load->view('excelCancel', $array);
        }else{
          $answer['error'] = "error";
          $this->load->view('assignService', $answer);
        }
      }

      public function executeByExcel(){
       /* header('Content-Type: text/plain');*/
        $_POST['ejecucion'] = str_replace("\t", "\n", $_POST['ejecucion']);
        $clave = str_replace(array("\n", "\r", "\t"), '',explode("\n", $_POST['ejecucion'])[23]);
        if ($clave == "Fecha ejecución") {          
          $orden = explode("Servicios unitarios", $_POST['ejecucion']);
          $ejecutar['ot'] = str_replace(array("\n", "\r", "\t", " "), '', explode("\n", $orden[0])[3]);
          $ejecutar['solicitante'] = explode("\n", $orden[0])[5];
          $ejecutar['descripcion'] = explode("\n", $orden[0])[7];
          $ejecutar['fCreacion'] = str_replace("/", "-", substr(explode("\n", $orden[0])[9], 0, -9));
          $tareas = explode("Ejecutada en inst. proveedor", $orden[1]);
          $id = explode("\n", $tareas[1]);
          $plus = 0;
          for ($x=1; $x < count($id) ; $x=$x+7) { 
            if ($id[$x] != "") {
              $ejecutar['idActividad'][$plus] = str_replace(array("\n", "\r", "\t", " "), '', $id[$x]);
              $ejecutar['tipo'][$plus] = (explode("-",$id[$x+1])[0]);
              $ejecutar['cantidad'][$plus] = $id[$x+2];
              $ejecutar['descripcionActividad'][$plus] = $id[$x+3];
              $ejecutar['estado'][$plus] = $id[$x+4];
              $ejecutar['fEjecucion'][$plus] = $id[$x+5];
              $ejecutar['ejecProveedor'][$plus] = $id[$x+6];
              $plus++;
            }
          }
          $array['ejecutar'] = $ejecutar;
          $this->load->view('excelExecute', $array);
        }else{
          $answer['error'] = "error";
          $this->load->view('assignService', $answer);
        }

      }


      public function saveServiceS(){
        date_default_timezone_set("America/Bogota");
        $mysqlDateTime = date('c');
        $service = new service_spec_model;
        $service->createServiceS( "", "", $_POST['idActividad'], $_POST['observacionesC'], $_POST['fechaA'], $_POST['fechaA'], explode("T", $mysqlDateTime)[0], $_POST['fechafc'], $_POST['idOrden'], explode("@", $_POST['sitio'])[1], $_POST['tipo'], $_POST['ingeniero'], $_POST['observaciones'], $_POST['ingSol'], $_POST['proyecto'], "Asignado", "");
        $this->dao_service_model->insertServiceS($service);
        $this->listServices();
      }

      public function listServices(){//revisar esta funcion que la llama
        $answer['eng'] = $this->dao_user_model->getAllEngineers();//llama todos los ing para pintar en select
        $answer['services'] = $this->dao_service_model->getAllServicesS();
        for ($y=0; $y < count($answer['services']); $y++) {
          $answer['services'][$y]->enviadas = $this->dao_service_model->getEnviadoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->canceladas = $this->dao_service_model->getCanceladoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->ejecutadas = $this->dao_service_model->getEjecutadoByOrder($answer['services'][$y]->getId());
        }
        $answer['message'] = $_SESSION['mensaje'];
        $this->load->view('listServices', $answer);
        
      }
//CAMILO-------------------------------------------------------------------------------------
      public function updateSpectService(){
        if (!$_POST['checkbox']) {
          $_POST['checkbox'][0] = $_POST['idService'];  
        }
        for ($i=0; $i < count($_POST['checkbox']); $i++) { 
          $close = new service_spec_model;
          $close->closeService($_POST['fInicior'], $_POST['fFinr'], $_POST['crq'], $_POST['state'], $_POST['observacionesCierre']);
          $close->setIdClaro($_POST['checkbox'][$i]);
          $this->dao_service_model->updateClose($close);
        }
        $this->dao_order_model->link($_POST['link'], $_POST['orden']);        
        $answer['eng'] = $this->dao_user_model->getAllEngineers();//llama todos los ing para pintar en select
        $answer['message'] = "actualizado";
        $answer['services'] = $this->dao_order_model->getAllOrders();
        for ($y=0; $y < count($answer['services']); $y++) {
          $answer['services'][$y]->enviadas = $this->dao_service_model->getEnviadoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->canceladas = $this->dao_service_model->getCanceladoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->ejecutadas = $this->dao_service_model->getEjecutadoByOrder($answer['services'][$y]->getId());
        }
        $this->load->view('listServices', $answer);
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
                  for($x = 0; $x < count($Row); $x++){
                    $Row[$x] = utf8_decode($Row[$x]);
                  }
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

//------------------------------RF------------------------------------------------------------------------
      public function upLoadRF(){
       //  header('Content-Type: text/plain');//convierte a texto plano
        $rf['excel'] = $this->viewExcel();
        $users = $this->dao_user_model->getAllEngineers();//llama los ingenieros para comparar con el excel
        for ($i=1; $i < count($rf['excel'][0]) ; $i++) {
          //cambio fechas de formato / por -
          $dateReq = str_replace("/", "-", $rf['excel'][0][$i][0]);
          $dateA = str_replace("/", "-", $rf['excel'][0][$i][5]);
          $dateS = str_replace("/", "-", $rf['excel'][0][$i][7]);
          $dateB = str_replace("/", "-", $rf['excel'][0][$i][14]);
          $dateRev = str_replace("/", "-", $rf['excel'][0][$i][16]);
          $dateRa = str_replace("/", "-", $rf['excel'][0][$i][17]);
          $dateOT = str_replace("/", "-", $rf['excel'][0][$i][18]);
          //modificacion excel para hacer la comparacion con la info de la bd
          if ($dateReq != "") {
            $dateReq = "20".explode("-", $dateReq)[2]."-".explode("-", $dateReq)[0]."-".explode("-", $dateReq)[1];
          }else{
            $dateReq = "0000-00-00";
          }
          if ($dateA != "") {
            $dateA = "20".explode("-", $dateA)[2]."-".explode("-", $dateA)[0]."-".explode("-", $dateA)[1];
          }else{
            $dateA = "0000-00-00";
          }
          if ($dateS != "") {
            $dateS = "20".explode("-", $dateS)[2]."-".explode("-", $dateS)[0]."-".explode("-", $dateS)[1];
          }else {
            $dateS = "0000-00-00";
          }
          if ($dateB != "") {
            $dateB = "20".explode("-", $dateB)[2]."-".explode("-", $dateB)[0]."-".explode("-", $dateB)[1];
          }else {
            $dateB = "0000-00-00";
          }
          if ($dateRev != "") {
            $dateRev = "20".explode("-", $dateRev)[2]."-".explode("-", $dateRev)[0]."-".explode("-", $dateRev)[1];
          }else {
            $dateRev = "0000-00-00";
          }
          if ($dateRa != "") {
            $dateRa = "20".explode("-", $dateRa)[2]."-".explode("-", $dateRa)[0]."-".explode("-", $dateRa)[1];
          }else {
            $dateRa = "0000-00-00";
          }
          if ($dateOT != "") {
            $dateOT = "20".explode("-", $dateOT)[2]."-".explode("-", $dateOT)[0]."-".explode("-", $dateOT)[1];
          }else {
            $dateOT = "0000-00-00";
          }
        //-------------------------------fin modificacion-------------------------------
          //----------completar campo code(codigo) vacio-------------------------
          $cod = $rf['excel'][0][$i][21];

          if ($rf['excel'][0][$i][21] == "") {
            if (substr_count($rf['excel'][0][$i][3], "1900") == 1) {
               $cod = "D3";
            }
            if (substr_count($rf['excel'][0][$i][3], "850") == 1) {
               $cod = "D4";
            }
          }
          //------------------------------fin completar----------------------------
          //---------comparacion nombre excel con  nombre base de datos en rf
          $engA = $rf['excel'][0][$i][6];
          $engAname = "";
          $idEngA = "";
          for ($j=0; $j <count($users) ; $j++) {

            similar_text((explode(" ", $engA))[0], explode(" ", $users[$j]->getName())[0], $pName);//porcentaje de similar entre primer nombre de db y primera palabra (nombre) de rf
            similar_text(explode(" ", $users[$j]->getLastname())[0], explode(" ", $engA)[1], $pLastname1);//porcentaje de similar entre primer apellido de db y segunda palabra (apellido) de rf
            similar_text(explode(" ", $users[$j]->getLastname())[0], explode(" ", $engA)[2], $pLastname2);//porcentaje de similar entre primer apellido de db y tercera (apellido) de rf
            similar_text(explode(" ", $users[$j]->getLastname())[0], explode(" ", $engA)[3], $pLastname3);//porcentaje de similar entre primer apellido de db y cuarta (apellido) de rf
            if ($pName > 70) {
              if ($pLastname1 > 69 || $pLastname2 > 69 || $pLastname3 > 69) {
                $idEngA = $users[$j]->getId();
                $engAname = $users[$j]->getName();
              }
            }
          }
          /*print_r($rf);*/
          //-------------------------fin comparacion----------
          //-------------------------creacion de objeto rf-----------------
          $up = new rf_model;
          $up->createRF("", $dateReq, $rf['excel'][0][$i][1], $rf['excel'][0][$i][2], $rf['excel'][0][$i][3], $rf['excel'][0][$i][4], $dateA, $idEngA, $dateS, $rf['excel'][0][$i][8], $rf['excel'][0][$i][9], $rf['excel'][0][$i][10], $rf['excel'][0][$i][11], $rf['excel'][0][$i][12], $rf['excel'][0][$i][13], $dateB, $rf['excel'][0][$i][15], $dateRev, $dateRa, $dateOT, $rf['excel'][0][$i][20], $cod);
         $this->dao_rf_model->updateRF($up);
        }
          $rf = $this->dao_rf_model->getAllRF();
          for ($k=0; $k < count($rf); $k++) { 
            if ($rf[$k]->assignedTo) {
              $rf[$k]->assignedTo = $this->dao_user_model->getUserById($rf[$k]->assignedTo);
              $rf[$k]->assignedTo = $rf[$k]->assignedTo->name." ".$rf[$k]->assignedTo = $rf[$k]->assignedTo->lastname;
            }
          }
          $AllRF['rf'] = $rf;
          $this->load->view('viewRF', $AllRF);
      }

      public function viewRF(){
        $rf = $this->dao_rf_model->getAllRF();
        for ($k=0; $k < count($rf); $k++) { 
          if ($rf[$k]->assignedTo) {
            $rf[$k]->assignedTo = $this->dao_user_model->getUserById($rf[$k]->assignedTo);
            $rf[$k]->assignedTo = $rf[$k]->assignedTo->name." ".$rf[$k]->assignedTo = $rf[$k]->assignedTo->lastname;
          }
        }
        $AllRF['rf'] = $rf;
          $this->load->view('viewRF', $AllRF);
      }


//--------------------guardar en bd asignar con mail---------------------------------------------
      public function saveServicesExcel(){
       $order = new order_model;
       $order->createOrder(str_replace(array("\n", "\r", "\t", " "), '',$_POST['OT']),"",$_POST['fCreacion']);
       $this->dao_order_model->insertOrder($order);
       $activity = new service_spec_model;
       $count2 = 0; 
       $flag = 0;
        for ($g=0; $g < $_POST['contador'] ; $g++) {
          $existe = $this->dao_service_model->getServiceByIdActivity($_POST['actividades_'.$g]);
          if ($existe) {
            $flag = 1;            
          }else{
            if ($_POST['actividades_'.$g] !="") {
              
               $cant1 = $_POST['cantidad1'];
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
              $activity->createServiceS($eng, "", $_POST['actividades_'.$g], $_POST['descripcionActividad_'.$g], "", "", $_POST['fCreacion'], $_POST['forecast_'.$g], $_POST['OT'], $_POST['sitio_'.$g], $_POST['tipo_'.$g], "", $_POST['descripcion'], $_POST['solicitante'], $_POST['proyecto'], "Asignada","");
              $activity->setQuantity($_POST['cantidadActiv_'.$g]);
              $activity->setRegion($_POST['regional_'.$g]);
              // print_r($activity);
              $countActivities = $this->dao_service_model->insertFromExcel($activity);
              $count2+=$countActivities;
            }
          }
        }
        //si flag es 1 es porque la actividad ya existe
        //*-***************************************************************************************************************
         /* if ($count2 > 0){
          $engs = $this->dao_user_model->getAllEngineersClaro();
          $asig = $this->dao_user_model->getUserById($eng);
          $engC = $_SESSION['excel'][0][2][1];

          for ($i=0; $i <count($engs) ; $i++) {

            similar_text((explode(" ", $engC))[0], explode(" ", $engs[$i]->getName())[0], $pName);//porcentaje de similar entre primer nombre de db y primera palabra (nombre) de excel
            similar_text(explode(" ", $engs[$i]->getLastname())[0], explode(" ", $engC)[1], $pLastname1);//porcentaje de similar entre primer apellido de db y segunda palabra (apellido) de excel
            similar_text(explode(" ", $engs[$i]->getLastname())[0], explode(" ", $engC)[2], $pLastname2);//porcentaje de similar entre primer apellido de db y tercera (apellido) de excel
            similar_text(explode(" ", $engs[$i]->getLastname())[0], explode(" ", $engC)[3], $pLastname3);//porcentaje de similar entre primer apellido de db y cuarta (apellido) de excel

            if ($pName > 70) {
              if ($pLastname1 > 69 || $pLastname2 > 69 || $pLastname3 > 69) {
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

        //  $this->email->to(strtolower($mailEngC).', '.strtolower($asig->getMail()));
          $this->email->to('bredybuitrago@outlook.com, yuyupa14@gmail.com');

          //$this->email->to('yuyupa14@gmail.com, andrea.rosero.ext@claro.com.co, andrea.lorenaroserochasoy@zte.com.cn, pablo.esteban@zte.com.cn, bredybuitrago@gmail.com');
          $this->email->cc('andrea.rosero.ext@claro.com.co, andrea.lorenaroserochasoy@zte.com.cn');//, cesar.rios.ext@claro.com.co

          $this->email->bcc('bredybuitrago@gmail.com ,bredi.buitrago@zte.com.cn, pablo.esteban@zte.com.cn');

          $this->email->subject("Notificación de asignación de orden de servicio. Orden: ".$_SESSION['excel'][0][0][1].". Proyecto: ".$_SESSION['excel'][0][3][1].".");

          $this->email->message($cuerpo);

          $this->email->send();

          $_SESSION['mensaje'] = "ok";
        } else {
          $_SESSION['mensaje'] = "error";
        }
        $_SESSION['excel']= null;*/
        if ($flag == 0) {
          $answer['message'] = "ok";
          $answer['eng'] = $this->dao_user_model->getAllEngineers();//llama todos los ing para pintar en select
          $answer['services'] = $this->dao_order_model->getAllOrders();
          for ($y=0; $y < count($answer['services']); $y++) {
          $answer['services'][$y]->enviadas = $this->dao_service_model->getEnviadoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->canceladas = $this->dao_service_model->getCanceladoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->ejecutadas = $this->dao_service_model->getEjecutadoByOrder($answer['services'][$y]->getId());
        }
          $this->load->view('listServices', $answer);
        }else{
          $answer['message'] = "error";
          $answer['eng'] = $this->dao_user_model->getAllEngineers();//llama todos los ing para pintar en select
          $answer['services'] = $this->dao_order_model->getAllOrders();
          for ($y=0; $y < count($answer['services']); $y++) {
          $answer['services'][$y]->enviadas = $this->dao_service_model->getEnviadoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->canceladas = $this->dao_service_model->getCanceladoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->ejecutadas = $this->dao_service_model->getEjecutadoByOrder($answer['services'][$y]->getId());
        }
          $this->load->view('listServices', $answer);
        }
      }

      public function saveCancelExcel(){
        //header('Content-Type: text/plain');
        $flag = 0;  
        for ($i=0; $i < $_POST['cant']; $i++) { 
          if ($_POST['actividades_'.$i] != "") {
            $existe[$i] = $this->dao_service_model->getServiceByIdActivity($_POST['actividades_'.$i]);
            if ($existe[$i]) {
              $this->dao_service_model->CancelFromExcel($_POST['actividades_'.$i]);
            }else{
              $flag = 1;
            }
          }
        }       

        if($flag == 0){
           $cuerpo = "<html>
                          <head>
                          <title>asignacion</title>
                          <link rel= 'stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css'>
                          <link rel= 'stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css'>
                          <script src='//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js'></script>
                          </head>
                          <body>
                            <h4 style= 'color: red'>Buen Día ".$existe[0]->user->name.", las siguientes actividades de la orden ".$existe[0]->order->getId()." han sido Canceladas:</h4><br>
                            <div class='box-header'>
                              <h5><b>OT: </b>".$existe[0]->order->getId()."</h5>
                              <h5><b>Solicitante: </b>".$existe[0]->ingSol."</h5>
                              <h5><b>Fecha de Creacion: </b>".$existe[0]->dateCreation."</h5>
                              <h5><b>Proyecto: </b>".$existe[0]->proyecto."</h5>
                              <h5><b>Descripción: </b>".$existe[0]->claroDescription."</h5>
                            </div>
                            <div class='box-body'>
                              <table id='example1' class='table table-bordered table-striped' border = '1'>
                                  <thead>
                                    <tr>
                                      <th>ID Actividad</th>
                                      <th>Tipo Actividad</th>
                                      <th>Regional</th>
                                      <th>Descripcion</th>
                                      <th>Fecha Cancel</th>
                                      <th>Forecast</th>
                                    </tr>
                                  </thead>
                                  <tbody>";
                      for ($j=0; $j < $_POST['cant'] ; $j++) {
                  $cuerpo = $cuerpo."<tr>
                                        <td>".$existe[$j]->idClaro."</td>
                                        <td>".$existe[$j]->service->type."</td>
                                        <td>".$existe[$j]->region."</td>
                                        <td>".$existe[$j]->description."</td>
                                        <td>".$existe[$j]->dateStartP."</td>
                                        <td>".$existe[$j]->dateForecast."</td>
                                      </tr>
                                  </tbody>";
                      }
               $cuerpo = $cuerpo."<tfoot>
                                      <tr>
                                        <th>ID Actividad</th>
                                        <th>Tipo Actividad</th>
                                        <th>Regional</th>
                                        <th>Descripcion</th>
                                        <th>Fecha Cancel</th>
                                        <th>Forecast</th>
                                       </tr>
                                    </tfoot>
                              </table>
                                 </div><br><br>
                              <p style= 'color: blue'> Este es un correo automático. Por favor, no responda este mensaje. </p>
                          </body>
                     </html>";
          for ($k=0; $k < $_POST['cant']; $k++) { 
            $a[$k] = $existe[$k]->user->mail;            
          }
          $to = array_values(array_unique ($a));
          $mails  = "";
          for ($h=0; $h < count($to); $h++) {
            if($h<count($to) -1){
              $mails = $mails.$to[$h].", ";  
            } else {
              $mails = $mails.$to[$h];  
            }
          }

          $this->load->library('email');
          $config['mailtype'] = 'html'; // o text
          $this->email->initialize($config);
          $this->email->from('zolid@zte.com', 'ZOLID_ZTE');

         // $this->email->to(strtolower($mails));
          $this->email->to('bredybuitrago@outlook.com, yuyupa14@gmail.com');
          
          //$this->email->to('yuyupa14@gmail.com, andrea.rosero.ext@claro.com.co, andrea.lorenaroserochasoy@zte.com.cn, pablo.esteban@zte.com.cn, bredybuitrago@gmail.com');
          //$this->email->cc('andrea.rosero.ext@claro.com.co, andrea.lorenaroserochasoy@zte.com.cn');//, cesar.rios.ext@claro.com.co
          //$this->email->bcc('bredybuitrago@gmail.com ,bredi.buitrago@zte.com.cn, pablo.esteban@zte.com.cn');
          $this->email->subject("Notificación de Cancelación de orden de servicio. Orden: ".$existe[0]->order->getId().". Proyecto: ".$existe[0]->proyecto.".");
          $this->email->message($cuerpo);
          $this->email->send();




          $answer['message'] = "actualizado";
          $array['eng'] = $this->dao_user_model->getAllEngineers();//llama todos los ing para pintar en select
          $answer['services'] = $this->dao_order_model->getAllOrders();for ($y=0; $y < count($answer['services']); $y++) {
          $answer['services'][$y]->enviadas = $this->dao_service_model->getEnviadoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->canceladas = $this->dao_service_model->getCanceladoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->ejecutadas = $this->dao_service_model->getEjecutadoByOrder($answer['services'][$y]->getId());
        }
          $this->load->view('listServices', $answer);        
        } else {
          $answer['message'] = "no existe";
          $answer['eng'] = $this->dao_user_model->getAllEngineers();//llama todos los ing para pintar en select
          $answer['services'] = $this->dao_order_model->getAllOrders();
          for ($y=0; $y < count($answer['services']); $y++) {
          $answer['services'][$y]->enviadas = $this->dao_service_model->getEnviadoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->canceladas = $this->dao_service_model->getCanceladoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->ejecutadas = $this->dao_service_model->getEjecutadoByOrder($answer['services'][$y]->getId());
        }
          $this->load->view('listServices', $answer);
        }
      }

      public function saveExecuteExcel(){
        /*header('Content-Type: text/plain');
        print_r($_POST);*/
        $flag = 0;
        for ($i=0; $i < $_POST['cant']; $i++) { 
          if ($_POST['actividades_'.$i] != "") {
            $existe[$i] = $this->dao_service_model->getServiceByIdActivity($_POST['actividades_'.$i]);
            $existe[$i]->fechaEjecucion = str_replace(array("\n", "\r", "\t", " "), '', $_POST['fechaEjecucion_'.$i]); 
            if ($existe[$i]) {
              $this->dao_service_model->executeFromExcel($_POST['actividades_'.$i], $_POST['fechaEjecucion_'.$i]);
            }else{
              $flag = 1;
            }
          }
        }   
        if ($flag ==0) {
          $cuerpo = "<html>
                          <head>
                          <title>asignacion</title>
                          <link rel= 'stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css'>
                          <link rel= 'stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css'>
                          <script src='//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js'></script>
                          </head>
                          <body>
                            <h4 style= 'color: green'>Buen Día ".$existe[0]->user->name.", las siguientes actividades de la orden ".$existe[0]->order->getId()." han sido ejecutadas:</h4><br>
                            <div class='box-header'>
                              <h5><b>OT: </b>".$existe[0]->order->getId()."</h5>
                              <h5><b>Solicitante: </b>".$existe[0]->ingSol."</h5>
                              <h5><b>Fecha de Creacion: </b>".$existe[0]->dateCreation."</h5>
                              <h5><b>Proyecto: </b>".$existe[0]->proyecto."</h5>
                              <h5><b>Descripción: </b>".$existe[0]->claroDescription."</h5>
                            </div>
                            <div class='box-body'>
                              <table id='example1' class='table table-bordered table-striped' border = '1'>
                                  <thead>
                                    <tr>
                                      <th>ID Actividad</th>
                                      <th>Tipo Actividad</th>
                                      <th>Regional</th>
                                      <th>Cantidad</th>
                                      <th>Descripcion</th>
                                      <th>Fecha Ejecución</th>
                                      <th>Forecast</th>
                                    </tr>
                                  </thead>
                                  <tbody>";
                      for ($j=0; $j < $_POST['cant'] ; $j++) {
                  $cuerpo = $cuerpo."<tr>
                                        <td>".$existe[$j]->idClaro."</td>
                                        <td>".$existe[$j]->service->type."</td>
                                        <td>".$existe[$j]->region."</td>
                                        <td>".$existe[$j]->quantity."</td>
                                        <td>".$existe[$j]->description."</td>
                                        <td>".$existe[$j]->fechaEjecucion."</td>
                                        <td>".$existe[$j]->dateForecast."</td>
                                      </tr>
                                  </tbody>";
                      }
               $cuerpo = $cuerpo."<tfoot>
                                      <tr>
                                        <th>ID Actividad</th>
                                        <th>Tipo Actividad</th>
                                        <th>Regional</th>
                                        <th>Cantidad</th>
                                        <th>Descripción</th>
                                        <th>Fecha Ejecución</th>
                                        <th>Forecast</th>
                                       </tr>
                                    </tfoot>
                              </table>
                                 </div><br><br>
                              <p style= 'color: blue'> Este es un correo automático. Por favor, no responda este mensaje. </p>
                          </body>
                     </html>";
          for ($k=0; $k < $_POST['cant']; $k++) { 
            $a[$k] = $existe[$k]->user->mail;            
          }
          $to = array_values(array_unique ($a));
          $mails  = "";
          for ($h=0; $h < count($to); $h++) {
            if($h<count($to) -1){
              $mails = $mails.$to[$h].", ";  
            } else {
              $mails = $mails.$to[$h];  
            }
          }

          $this->load->library('email');
          $config['mailtype'] = 'html'; // o text
          $this->email->initialize($config);
          $this->email->from('zolid@zte.com', 'ZOLID_ZTE');

         // $this->email->to(strtolower($mails));
          $this->email->to('bredybuitrago@outlook.com, yuyupa14@gmail.com');
          
          //$this->email->to('yuyupa14@gmail.com, andrea.rosero.ext@claro.com.co, andrea.lorenaroserochasoy@zte.com.cn, pablo.esteban@zte.com.cn, bredybuitrago@gmail.com');
          //$this->email->cc('andrea.rosero.ext@claro.com.co, andrea.lorenaroserochasoy@zte.com.cn');//, cesar.rios.ext@claro.com.co
          //$this->email->bcc('bredybuitrago@gmail.com ,bredi.buitrago@zte.com.cn, pablo.esteban@zte.com.cn');
          $this->email->subject("Notificación de Cancelación de orden de servicio. Orden: ".$existe[0]->order->getId().". Proyecto: ".$existe[0]->proyecto.".");
          $this->email->message($cuerpo);
          $this->email->send();

          $answer['message'] = "actualizado";
          $answer['eng'] = $this->dao_user_model->getAllEngineers();//llama todos los ing para pintar en select
          $answer['services'] = $this->dao_order_model->getAllOrders();
          for ($y=0; $y < count($answer['services']); $y++) {
          $answer['services'][$y]->enviadas = $this->dao_service_model->getEnviadoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->canceladas = $this->dao_service_model->getCanceladoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->ejecutadas = $this->dao_service_model->getEjecutadoByOrder($answer['services'][$y]->getId());
        }
          $this->load->view('listServices', $answer);              
        }else{
          $answer['message'] = "no existe";
          $answer['eng'] = $this->dao_user_model->getAllEngineers();//llama todos los ing para pintar en select
          $answer['services'] = $this->dao_order_model->getAllOrders();
          for ($y=0; $y < count($answer['services']); $y++) {
          $answer['services'][$y]->enviadas = $this->dao_service_model->getEnviadoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->canceladas = $this->dao_service_model->getCanceladoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->ejecutadas = $this->dao_service_model->getEjecutadoByOrder($answer['services'][$y]->getId());
        }
          $this->load->view('listServices', $answer);
        }   
      }

      public function reasign(){
        if ($_POST['Ingeniero']) {
          for ($i=0; $i < count($_POST['checkbox']); $i++) {
            $this->dao_service_model->updateEng($_POST['checkbox'][$i], $_POST['Ingeniero']);
          }
          $answer['eng'] = $this->dao_user_model->getAllEngineers();//llama todos los ing para pintar en select
          $answer['message'] = "actualizado";
          $answer['services'] = $this->dao_order_model->getAllOrders();
          for ($y=0; $y < count($answer['services']); $y++) {
          $answer['services'][$y]->enviadas = $this->dao_service_model->getEnviadoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->canceladas = $this->dao_service_model->getCanceladoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->ejecutadas = $this->dao_service_model->getEjecutadoByOrder($answer['services'][$y]->getId());
        }
          $this->load->view('listServices', $answer);
        } else {
          $answer['message'] = "no seleccionado";
          $answer['eng'] = $this->dao_user_model->getAllEngineers();//llama todos los ing para pintar en select
          $answer['services'] = $this->dao_order_model->getAllOrders();
          for ($y=0; $y < count($answer['services']); $y++) {
          $answer['services'][$y]->enviadas = $this->dao_service_model->getEnviadoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->canceladas = $this->dao_service_model->getCanceladoByOrder($answer['services'][$y]->getId());
          $answer['services'][$y]->ejecutadas = $this->dao_service_model->getEjecutadoByOrder($answer['services'][$y]->getId());
        }
          $this->load->view('listServices', $answer);
        }
      }

     
  }

?>
