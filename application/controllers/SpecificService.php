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
        $this->load->model('data/Dao_service_model');
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
        //$dic es el campo de validacion q uso para saber si la copia viene de outlook o z-mail
        $dic = str_replace(array("\n", "\r", "\t"), '', explode("\n", $_POST['actividades'])[4]);
        //si es diferente a ot viene de zmail 
        if ($dic != "OT:" ) {
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

                  if (str_replace(array("\n", "\r", "\t", " "), '', explode("\n", $orden[0])[10]) == 'Prioridad:'){
                      $asignar['prioridad'] = explode("\n", $orden[0])[11];
                      $asignar['descripcion'] = explode("\n", $orden[0])[13];
                      $asignar['fCreacion'] = str_replace("/", "-", substr(explode("\n", $orden[0])[15], 0, -9));  
                  } else {
                      $asignar['prioridad'] = " ";
                      $asignar['descripcion'] = explode("\n", $orden[0])[11];
                      $asignar['fCreacion'] = str_replace("/", "-", substr(explode("\n", $orden[0])[13], 0, -9));
                  }

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
                      // str_replace(array("\n", "\r", "\t"), '', $res[$f]->k_id_onair)
                      if($flag2 == 0){
                            $asignar['sitio']['name'][$plus]= (explode("staciones:", $site)[1]);
                            //elimino los parentecis 
                             $asignar['sitio']['name'][$plus]= str_replace(array("(", ")"), '', $asignar['sitio']['name'][$plus]);
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

                    $array['asignar'] = $asignar;
                    $this->load->view('excelAssign', $array);
                  }else{
                    $answer['error'] = "error";
                    $this->load->view('assignService', $answer);
                  }
        } else {

            $clave = explode("\n", $_POST['actividades'])[14];
            $clave = str_replace(array("\n", "\r", "\t"), '', $clave);
            if ($clave == "Proyecto:") { 
                  //creacion orden          
                  $orden = explode("Detalle de servicios", $_POST['actividades']);

                  $asignar['ot'] = str_replace(array("\n", "\r", "\t", " "), '', explode("\n", $orden[0])[6]);
                  $asignar['solicitante'] =  explode("\n", $orden[0])[12];
                  $asignar['proyecto'] = explode("\n", $orden[0])[16];

                  if (str_replace(array("\n", "\r", "\t", " "), '', explode("\n", $orden[0])[18]) == 'Prioridad:'){
                     $asignar['prioridad'] = str_replace(array("\n", "\r", "\t", " "), '', explode("\n", $orden[0])[20]);
                      $asignar['descripcion'] = explode("\n", $orden[0])[24];
                     $asignar['fCreacion'] = str_replace("/", "-", substr(explode("\n", $orden[0])[28], 0, -9));
                    
                  } else {
                     $asignar['prioridad'] = " ";
                     $asignar['descripcion'] = explode("\n", $orden[0])[20];
                     $asignar['fCreacion'] = str_replace("/", "-", substr(explode("\n", $orden[0])[24], 0, -9));
                  }

                  //separacion  actividades
                  $tareas = explode("Forecast", $_POST['actividades']);
                  $id = explode("\n", $tareas[1]);
                    $plus = 0;
                  $value = count($id);
                  for($x = 2; $x < $value; $x=$x+12){
                    if($id[$x] != ""){

                      //creacion actividades
                      $asignar['actividades'][$plus] = str_replace(array("\n", "\r", "\t", " "), '', $id[$x]);
                      //fin actividades

                      //creacion tipo
                      //funciones para comparar el tipo extraido text area, y convertirlo en el id del tipo q esta en bd
                      $service = (explode("-",$id[$x+2])[0]);// funcion para dividir una cadena de caracteres dependiendo la llave, en este caso se usa para tomar la primera parte, antes del guion (-)

                      if ((explode("-",$id[$x+2])[0][2]) == "0"){//los T10 T11 Y T12 hay q convertirlos en C1 C2 Y C3 respectivamente
                        $service = "C1";
                      }
                      if ((explode("-",$id[$x+2])[0][2]) == "1"){
                        $service = "C2";
                      }
                      if ((explode("-",$id[$x+2])[0][2]) == "2"){
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
                      $asignar['regional'][$plus] = $id[$x+4];
                      //fin creacion regional

                      //creacion cantidad
                      $asignar['cantidad'][$plus] = $id[$x+6];
                      //fin creacion cantidad

                      //creacion descripcionActividad
                      $asignar['descripcionActividad'][$plus] = $id[$x+8];
                      //fin creacion descripcionActividad

                      //creacion forecast
                      $asignar['forecast'][$plus] = str_replace("/", "-", $id[$x+10]);
                      //fin creacion  forecast

                      //creacion site
                      //funcion para traer solo el sitio especifico de una cadena larga de caracteres con la funcion substr_count(x,y), la cual cuenta cuantas veces esta el string(y) en el string(x)
                      $allSites = $this->dao_site_model->getAllSites();//llama todos los sitios de la db
                      $site = $id[$x+8];//celda del excel o arreglo donde esta el sitio
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
      }

      public function cancelByMail(){
        //diferencio de que formato de correo viene
        $dic = str_replace(array("\n", "\r", "\t"), '', explode("\n", $_POST['actividades'])[4]);
        // print_r(str_replace(array("\n", "\r", "\t"), '', explode("\t", explode("\n", $_POST['actividades'])[0])[6]));
        if ($dic != "ID:") {//comparo el formato
           //verificacion si viene de correo cancelacion
            $_POST['actividades'] = str_replace("\t", "\n", $_POST['actividades']);
            $clav1 = explode("\n", $_POST['actividades'])[8];
            $clave1 = str_replace(array("\n", "\r", "\t"), '', $clav1);
            $clav2 = explode("\n", $_POST['actividades'])[23];
            $clave2 = str_replace(array("\n", "\r", "\t"), '', $clav2);
              // variable para verificar si es una ejecucion sin cabecera le sum0 cero para comvertirlo a entero
              $dic2 = str_replace(array("\n", "\r", "\t"), '',explode("\n", $_POST['actividades'])[6]) + 0;
            //si es de cancelacion ejecuta la accion
            if ($clave1 == "Fecha de creación:" && $clave2 != "Fecha ejecución") {
              $orden = explode("Servicios unitarios", $_POST['actividades']); 
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
            }elseif ($dic2 != "Fecha ejecución" && $dic2 > 0) {
               $can =  explode("\n", $_POST['actividades']);
               // defino las variables de cancelar
              $cancelar['ot'] = str_replace(array("\n", "\r", "\t", " "), '',$can[6]);
              $cancelar['solicitante'] = "<span style='color:red;'>No hay información</span>";
              $cancelar['descripcion'] = str_replace(array("\n", "\r", "\t"), '',$can[8]);
              $cancelar['fCreacion'] = "<span style='color:red;'>No hay información</span>";
               $plus = 0;
               for ($i=7; $i < count($can) ; $i= $i+6) { 
                  $cancelar['idActividad'][$plus] = str_replace(array("\n", "\r", "\t", " "), '',$can[$i]);
                  $cancelar['tipo'][$plus] = str_replace(array("\n", "\r", "\t", " "), '',(explode("-",$can[$i+2])[0]));
                  $cancelar['cantidad'][$plus] = str_replace(array("\n", "\r", "\t", " "), '',$can[$i+3]);
                  $cancelar['descripcionActividad'][$plus] = str_replace(array("\n", "\r", "\t", " "), '',$can[$i+4]);
                  $plus++;
               }
               $array['cancelar'] = $cancelar;
               $this->load->view('excelCancel', $array);

                // print_r( explode("\n", $_POST['actividades'] ));
            }
            else{
              $answer['error'] = "error";
              $this->load->view('assignService', $answer);
            }
        } 

          else {
              //verificacion si viene de correo cancelacion
              $_POST['actividades'] = str_replace("\t", "\n", $_POST['actividades']);
              $clav1 = explode("\n", $_POST['actividades'])[16];
              $clave1 = str_replace(array("\n", "\r", "\t"), '', $clav1);
              $clav2 = explode("\n", $_POST['actividades'])[40];
              $clave2 = str_replace(array("\n", "\r", "\t"), '', $clav2);
              //si es de cancelacion ejecuta la accion
              if ($clave1 == "Fecha de creación:" && $clave2 != "Fecha ejecución") {
                $orden = explode("Servicios unitarios", $_POST['actividades']); 
                $cancelar['ot'] = str_replace(array("\n", "\r", "\t", " "), '', explode("\n", $orden[0])[6]);
                $cancelar['solicitante'] = explode("\n", $orden[0])[10];
                $cancelar['descripcion'] = explode("\n", $orden[0])[14];
                $cancelar['fCreacion'] = str_replace("/", "-", substr(explode("\n", $orden[0])[18], 0, -9));
                $tareas = explode("Descripción", $orden[1]);
                $id = explode("\n", $tareas[1]);
                $plus = 0;
                for ($x=2; $x < count($id) ;  $x=$x+8) { 
                  if ($id[$x] != "") {
                    $cancelar['idActividad'][$plus] = str_replace(array("\n", "\r", "\t", " "), '',$id[$x]);
                    $cancelar['tipo'][$plus] = (explode("-",$id[$x+2])[0]);
                    $cancelar['cantidad'][$plus] = $id[$x+4];
                    $cancelar['descripcionActividad'][$plus] = $id[$x+6];
                    $plus++;
                  }
                }
                $array['cancelar'] = $cancelar;
                $this->load->view('excelCancel', $array);
              }

              else{
                $answer['error'] = "error";
                $this->load->view('assignService', $answer);
              }

        }
      }

      public function executeByExcel(){
        $dic = str_replace(array("\n", "\r", "\t"), '', explode("\n", $_POST['actividades'])[40]);
        if ($dic != "Fecha ejecución") {
              $_POST['actividades'] = str_replace("\t", "\n", $_POST['actividades']);
              $clave = str_replace(array("\n", "\r", "\t"), '',explode("\n", $_POST['actividades'])[23]);
              if ($clave == "Fecha ejecución") {          
                $orden = explode("Servicios unitarios", $_POST['actividades']);
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
                    $ejecutar['estado'][$plus] = str_replace(array("\n", "\r", "\t", " "), '',$id[$x+4]);
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
        } else {
            // print_r(str_replace(array("\n", "\r", "\t"), '', explode("\n", $_POST['actividades'])));
            $_POST['actividades'] = str_replace("\t", "\n", $_POST['actividades']);
              $clave = str_replace(array("\n", "\r", "\t"), '',explode("\n", $_POST['actividades'])[40]);
              if ($clave == "Fecha ejecución") {          
                $orden = explode("Servicios unitarios", $_POST['actividades']);
                // print_r(str_replace(array("\n", "\r", "\t", " "), '', explode("\n", $orden[0])));
                $ejecutar['ot'] = str_replace(array("\n", "\r", "\t", " "), '', explode("\n", $orden[0])[6]);
                $ejecutar['solicitante'] = explode("\n", $orden[0])[10];
                $ejecutar['descripcion'] = explode("\n", $orden[0])[14];
                $ejecutar['fCreacion'] = str_replace("/", "-", substr(explode("\n", $orden[0])[18], 0, -9));
                $tareas = explode("Ejecutada en inst. proveedor", $orden[1]);
                $id = explode("\n", $tareas[1]);
                $id[14] = str_replace(array("\n", "\r", "\t"), '', $id[14]);
                $plus = 0;

                if ($id[14] == "X") {
                    for ($x=2; $x < count($id) ; $x=$x+14) { 
                      if ($id[$x] != "") {
                        $ejecutar['idActividad'][$plus] = str_replace(array("\n", "\r", "\t", " "), '', $id[$x]);
                        $ejecutar['tipo'][$plus] = (explode("-",$id[$x+2])[0]);
                        $ejecutar['cantidad'][$plus] = $id[$x+4];
                        $ejecutar['descripcionActividad'][$plus] = $id[$x+6];
                        $ejecutar['estado'][$plus] = str_replace(array("\n", "\r", "\t", " "), '',$id[$x+8]);
                        $ejecutar['fEjecucion'][$plus] = $id[$x+10];
                        $ejecutar['ejecProveedor'][$plus] = $id[$x+12];
                       $plus++;
                     }
                    }
                } else {
                    for ($x=2; $x < count($id) ; $x=$x+12) { 
                      if ($id[$x] != "") {
                        $ejecutar['idActividad'][$plus] = str_replace(array("\n", "\r", "\t", " "), '', $id[$x]);
                        $ejecutar['tipo'][$plus] = (explode("-",$id[$x+2])[0]);
                        $ejecutar['cantidad'][$plus] = $id[$x+4];
                        $ejecutar['descripcionActividad'][$plus] = $id[$x+6];
                        $ejecutar['estado'][$plus] = str_replace(array("\n", "\r", "\t", " "), '',$id[$x+8]);
                        $ejecutar['fEjecucion'][$plus] = $id[$x+10];
                        $ejecutar['ejecProveedor'][$plus] = "";
                       $plus++;
                     }
                    }
                }

                $array['ejecutar'] = $ejecutar;
                $this->load->view('excelExecute', $array);
              }else{
                $answer['error'] = "error";
                $this->load->view('assignService', $answer);
              }
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
        header('Location: '. URL::to("Service/listServices"));
        
      }
//CAMILO-------------------------------------------------------------------------------------
      public function updateSpectService(){
        // print_r($_POST);
        // echo "<br><br><br><br>";
        if (!$_POST['checkbox']) {
          $_POST['checkbox'][0] = $_POST['idService'];  
        }
        for ($i=0; $i < count($_POST['checkbox']); $i++) { 
          $close = new service_spec_model;
          $close->closeService($_POST['fInicior'], $_POST['fFinr'], $_POST['crq'], $_POST['state'], $_POST['observacionesCierre'], $_POST['link']);
          $close->setIdClaro($_POST['checkbox'][$i]);
          // print_r($close);
          // echo "<br><br><br>";
          $this->dao_service_model->updateClose($close);
        }
        if (!$_POST['orden']) {
          $_POST['orden'] = $this->dao_service_model->getServiceByIdActivity($_POST['checkbox'][0])->order->getId();
        }
        $this->dao_order_model->link($_POST['link'], $_POST['orden']);        
        $_SESSION["message"] = 'actualizado';
        header('Location: '. URL::to("Service/listServices"));
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

      public function updateLinkFormModal(){
          $actualizados = [];//arreglo q lleno con los id de los registros actualizados
          foreach ($_POST as $key => $value) {
              // solo tomo lk1 y lk2 del post y que no vengan vacios
              if ((substr_count($key, '_lk1') == 1 || substr_count($key, '_lk2') == 1) && ($value != "")) {
                    //si el indice viene del link 1 _lk1
                    if (substr_count($key, '_lk1')) {
                       $columna = "N_LINK_SEND";//nombre de la columna a editar en la base de datos
                       $actividad = str_replace("_lk1", "", $key);
                    } else if (substr_count($key, '_lk2')) {
                       $columna = "N_LINK_EXECUTE";
                       $actividad = str_replace("_lk2", "", $key);
                    }
                    //funcion para actualizar, le paso el id de la actividad, el link y la columna de la bd deseada
                    //retorna exitoso o error
                    $respuesta = $this->dao_service_model->updateLink1($actividad, $value, $columna);    

                    if ($respuesta == 'exitoso') {
                        // si se actualizó añade ese indice al arreglo de actualizados
                        array_push($actualizados, $key);
                    }
              }
          }
          echo json_encode($actualizados);
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

            similar_text(explode(" ", $engA)[0], explode(" ", $users[$j]->getName())[0], $pName);//porcentaje de similar entre primer nombre de db y primera palabra (nombre) de rf
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


//**************************guardar en bd asignar con mail**************************
      public function saveServicesExcel(){
         // header('Content-Type: text/plain');
       $order = new order_model;
       $order->createOrder(str_replace(array("\n", "\r", "\t", " "), '',$_POST['OT']),"",$_POST['fCreacion']);
       $order->setPrioridad($_POST['prioridad']);
       $order->setD_ASIG_Z($_POST['D_ASIG_Z']);
       $this->dao_order_model->insertOrder($order);
       $activity = new service_spec_model;
       $count2 = 0; 
       $flag = 0;
       $ingeMails = [];


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
              //le sumo 1 porque del formulario viene desed name= [inge1] y  del for inicia en 0
              $h = $g+1;
              //capturo los mails de los ingenieros para el envio de correo algunos indices quedan vacios
              $ingeMails[$g] = $this->dao_user_model->getMailById($_POST["inge".$h]);
              //-----------creacion del objeto---------------------------
                  $activity = new service_spec_model;
              $activity->createServiceS($eng, "", $_POST['actividades_'.$g], $_POST['descripcionActividad_'.$g], "", "", $_POST['fCreacion'], $_POST['forecast_'.$g], $_POST['OT'], $_POST['sitio_'.$g], $_POST['tipo_'.$g], "", $_POST['descripcion'], $_POST['solicitante'], $_POST['proyecto'], "Asignada","");
              $activity->setQuantity($_POST['cantidadActiv_'.$g]);
              $activity->setRegion($_POST['regional_'.$g]);              
              $countActivities = $this->dao_service_model->insertFromExcel($activity);
              $count2+=$countActivities;
              $actividades[$g] = $activity;

            }
          }
        }
        //si flag es 1 es porque la actividad ya existe
        //*-***************************************************************************************************************
        if ($flag == 0) {
          //limpio el arreglo eliminando indices vacios
          $ingeMails = array_filter($ingeMails, "strlen");
          //Convierto el arreglo en string separado por ", "
          $correos = "";
          $correos = implode(", ", $ingeMails);
          $cantAct = count($actividades);
                if ($count2 > 0){

                    //Ingenieros de claro
                    //$engs = $this->dao_user_model->getAllEngineersClaro();
                    $asig = $this->dao_user_model->getUserById($eng);

                        //comparacion Ingenieros claro para extraer su mail con su id

                        /*$engC = $_SESSION['excel'][0][2][1];
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
                        }*/

                    //-------------------------------email------------------
                    $cuerpo = "<html>
                                  <head>
                                  <title>asignacion</title>
                                   <link rel= 'stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css'>
                                   <link rel= 'stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css'>
                                    <script src='//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js'></script>

                                  </head>
                                 <body>
                                  <h4 style= 'color: blue'>Buen Día ingeniero, le han sido asignadas actividades de la orden ".$actividades[0]->order."</h4><br>

                          <div class='box-header'>
                             <h5>OT: ".$actividades[0]->order."</h5>
                             <h5>Solicitante: ".$actividades[0]->ingSol."</h5>
                             <h5>Fecha de Creacion: ".$actividades[0]->dateCreation."</h5>
                             <h5>Proyecto: ".$actividades[0]->proyecto."</h5>
                             <h5>Descripción: ".$actividades[0]->claroDescription."</h5>
                           </div>

                            <div class='box-body'>
                               <table id='example1' class='table table-bordered table-striped' border = '1'>
                                 <thead style='background-color: #818181;color: #fff;'>
                                 <tr>
                                   <th>ID Actividad</th>
                                   <th>Regional</th>
                                   <th>Cantidad</th>
                                   <th>Descripcion</th>
                                   <th>Forecast</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                 ";


                                 for ($i=0; $i < $cantAct ; $i++) {
                                      $cuerpo = $cuerpo."<tr>
                                                 <td>".$actividades[$i]->idClaro."</td>
                                                 <td>".$actividades[$i]->region."</td>
                                                 <td>".$actividades[$i]->quantity."</td>
                                                 <td>".$actividades[$i]->description."</td>
                                                 <td>".$actividades[$i]->dateForecast."</td>
                                               </tr>
                                               ";
                                }

                                $cuerpo = $cuerpo."<tfoot style='background-color: #818181;color: #fff;'>
                                                 <tr>
                                                   <th>ID Actividad</th>
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

/********************************************************************************************************************/


                     $this->load->library('parser');

          $config = Array(
              'protocol'  => 'smtp',
              'smtp_host' => 'ssl://smtp.googlemail.com',
              'smtp_port' => 465,
              'smtp_user' => 'zolid.datafill@gmail.com',
              'smtp_pass' => 'z0lid.datafil1',
              'mailtype'  => 'html',
              'charset'   => 'utf-8',
              'priority'  => 5
          );

          $this->load->library('email', $config);
          $this->email->set_newline("\r\n");
          $this->email->from('zolid.datafill@gmail.com', 'ZOLID'); // change it to yours
          $this->email->to($correos);// change it to yours
          // $this->email->cc('bredi.buitrago@zte.com.cn, johnfbr1998@gmail.com');
          $this->email->subject("Notificacion de ASIGNACIÓN de orden de servicio. Orden: ".$actividades[0]->order.". Proyecto: ".$actividades[0]->proyecto.".");
          $this->email->message($cuerpo);
          $this->email->send();

          // if($this->email->send())
          // { 
          //   echo "se envio correctamente";
          // }
          // else
          // {
          //     show_error($this->email->print_debugger());
          // }



/********************************************************************************************************************/




                    // $this->load->library('email');
                    // $config['mailtype'] = 'html'; // o text
                    // $this->email->initialize($config);
                    // $this->email->from('datafill@zte.com', 'DATAFILL');
                    // $this->email->to($correos);
                    
                    // $this->email->subject("Notificacion de ASIGNACIÓN de orden de servicio. Orden: ".$actividades[0]->order.". Proyecto: ".$actividades[0]->proyecto.".");
                    // $this->email->message($cuerpo);
                    // $this->email->send();
                }
          $mensaje["message"] = 'ok';
          $this->load->view('assignService', $mensaje);
          // header('Location: '. URL::to("Service/listServices"));
        }else{
          $mensaje["message"] = 'error';
          $this->load->view('assignService', $mensaje);
          // header('Location: '. URL::to("Service/listServices"));
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
                          <title>Cancelación</title>
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
                                  <thead style='background-color: #ff0000;color: #fff;'>
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
               $cuerpo = $cuerpo."<tfoot style='background-color: #ff0000;color: #fff;'>
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





          // $this->load->library('email');
          // $config['mailtype'] = 'html'; // o text
          // $this->email->initialize($config);
          // $this->email->from('datafill@zte.com', 'DATAFILL');

          // $this->email->to(strtolower($mails));
          
          // $this->email->subject("Notificación de CANCELACIÓN de orden de servicio. Orden: ".$existe[0]->order->getId().". Proyecto: ".$existe[0]->proyecto.".");
          // $this->email->message($cuerpo);
          // $this->email->send();



          $this->load->library('parser');

          $config = Array(
              'protocol'  => 'smtp',
              'smtp_host' => 'ssl://smtp.googlemail.com',
              'smtp_port' => 465,
              'smtp_user' => 'zolid.datafill@gmail.com',
              'smtp_pass' => 'z0lid.datafil1',
              'mailtype'  => 'html',
              'charset'   => 'utf-8',
              'priority'  => 5
          );

          $this->load->library('email', $config);
          $this->email->set_newline("\r\n");
          $this->email->from('zolid.datafill@gmail.com', 'ZOLID'); // change it to yours
          $this->email->to(strtolower($mails));// change it to yours
          // $this->email->cc('bredi.buitrago@zte.com.cn, johnfbr1998@gmail.com');
          $this->email->subject("Notificación de CANCELACIÓN de orden de servicio. Orden: ".$existe[0]->order->getId().". Proyecto: ".$existe[0]->proyecto.".");
          $this->email->message($cuerpo);
          $this->email->send();









          $_SESSION["message"] = 'actualizado';
          header('Location: '. URL::to("Service/listServices"));        
        } else {
          $_SESSION["message"] = 'no existe';
          header('Location: '. URL::to("Service/listServices"));
        }
      }

      public function saveExecuteExcel(){
        $flag = 0;
        for ($i=0; $i < $_POST['cant']; $i++) { 
          if ($_POST['actividades_'.$i] != "") {
            $existe[$i] = $this->dao_service_model->getServiceByIdActivity($_POST['actividades_'.$i]);
            $existe[$i]->fechaEjecucion = str_replace(array("\n", "\r", "\t", " "), '', $_POST['fechaEjecucion_'.$i]);


            if ($existe[$i]) {
              $this->dao_service_model->executeFromExcel($_POST['actividades_'.$i], $_POST['fechaEjecucion_'.$i], $_POST['estado_'.$i]);
            }else{
              $flag = 1;
            }
          }
        }   
        if ($flag ==0) {
          $cuerpo = "<html>
                          <head>
                          <title>Ejecución</title>
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
                                  <thead style='background-color: #1ba616;color: #fff;'>
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
               $cuerpo = $cuerpo."<tfoot style='background-color: #1ba616;color: #fff;'>
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
          //verifico y contateno ing a enviar correo
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

          // $this->load->library('email');
          // $config['mailtype'] = 'html'; // o text
          // $this->email->initialize($config);
          // $this->email->from('datafill@zte.com', 'DATAFILL');

          // $this->email->to(strtolower($mails));
          // //$this->email->to('bredybuitrago@outlook.com, yuyupa14@gmail.com');
          
          // //$this->email->to('yuyupa14@gmail.com, andrea.rosero.ext@claro.com.co, andrea.lorenaroserochasoy@zte.com.cn, pablo.esteban@zte.com.cn, bredybuitrago@gmail.com');
          // //$this->email->cc('andrea.rosero.ext@claro.com.co, andrea.lorenaroserochasoy@zte.com.cn');//, cesar.rios.ext@claro.com.co
          // //$this->email->bcc('bredybuitrago@gmail.com ,bredi.buitrago@zte.com.cn, pablo.esteban@zte.com.cn');
          // $this->email->subject("Notificación de EJECUCIÓN de orden de servicio. Orden: ".$existe[0]->order->getId().". Proyecto: ".$existe[0]->proyecto.".");
          // $this->email->message($cuerpo);
          // $this->email->send();


          $this->load->library('parser');

          $config = Array(
              'protocol'  => 'smtp',
              'smtp_host' => 'ssl://smtp.googlemail.com',
              'smtp_port' => 465,
              'smtp_user' => 'zolid.datafill@gmail.com',
              'smtp_pass' => 'z0lid.datafil1',
              'mailtype'  => 'html',
              'charset'   => 'utf-8',
              'priority'  => 5
          );

          $this->load->library('email', $config);
          $this->email->set_newline("\r\n");
          $this->email->from('zolid.datafill@gmail.com', 'ZOLID'); // change it to yours
          $this->email->to(strtolower($mails));// change it to yours
          // $this->email->cc('bredi.buitrago@zte.com.cn, johnfbr1998@gmail.com');
          $this->email->subject("Notificación de EJECUCIÓN de orden de servicio. Orden: ".$existe[0]->order->getId().". Proyecto: ".$existe[0]->proyecto.".");
          $this->email->message($cuerpo);
          $this->email->send();






          $_SESSION["message"] = 'actualizado';
          header('Location: '. URL::to("Service/listServices"));
        }else{
          $_SESSION["message"] = 'no existe';
          header('Location: '. URL::to("Service/listServices"));
        }   
      }
      // Metodo para reasignar una o varias actividades a otro ingeniero
      public function reasign(){
        $a=[];
        // Si se eligio ingeniero
        if ($_POST['Ingeniero']) {
          // recorre todas las actividades selecciona
          for ($i=0; $i < count($_POST['checkbox']); $i++) {
            $activity[$i] = $this->dao_service_model->getServiceByIdActivity($_POST['checkbox'][$i]);

            $this->dao_service_model->updateEng($_POST['checkbox'][$i], $_POST['Ingeniero']);
          }
          //elimino ingenieros repetidos para envio de correo
         for ($k=0; $k < count($activity); $k++) { 
            $a[$k] = $activity[$k]->user->mail; 
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
          //llamamos los datos del ing seleccionado con su id
          $_POST['Ingeniero'] = $this->dao_user_model->getUserById($_POST['Ingeniero']);          
          // print_r($_POST['Ingeniero']->name." ".$_POST['Ingeniero']->lastname);
          //concateno ingeniero mail ingeniero seleccionado con ingenieros asignados
          $mails = $_POST['Ingeniero']->mail.", ".$mails;
          $cuerpo = "<html>
                          <head>
                          <title>reasignacion</title>
                          <link rel= 'stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css'>
                          <link rel= 'stylesheet' href='//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css'>
                          <script src='//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js'></script>
                          </head>
                          <body>
                            <h4 style= 'color: #7851DA'>Buen Día ingeniero(s), las siguientes actividades de la orden ".$_POST['ot']." han sido reasignadas a:</h4><h3>".$_POST['Ingeniero']->name." ".$_POST['Ingeniero']->lastname."</h3><br>
                            <div class='box-header'>
                              <h5><b>OT: </b>".$_POST['ot']."</h5>
                              <h5><b>Solicitante: </b>".$activity[0]->ingSol."</h5>
                              <h5><b>Fecha de Creacion: </b>".$activity[0]->dateCreation."</h5>
                              <h5><b>Proyecto: </b>".$activity[0]->proyecto."</h5>
                              <h5><b>Descripción: </b>".$activity[0]->claroDescription."</h5>
                            </div>
                            <div class='box-body'>
                              <table id='example1' class='table table-bordered table-striped' border = '1'>
                                  <thead style='background-color: #4486f8;color: #fff;'>
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
                      for ($j=0; $j < count($activity) ; $j++) {
                  $cuerpo = $cuerpo."<tr>
                                        <td>".$activity[$j]->idClaro."</td>
                                        <td>".$activity[$j]->service->type."</td>
                                        <td>".$activity[$j]->region."</td>
                                        <td>".$activity[$j]->quantity."</td>
                                        <td>".$activity[$j]->description."</td>
                                        <td>".$activity[$j]->fechaEjecucion."</td>
                                        <td>".$activity[$j]->dateForecast."</td>
                                      </tr>
                                  </tbody>";
                      }
               $cuerpo = $cuerpo."<tfoot style='background-color: #4486f8;color: #fff;'>
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

          // $this->load->library('email');
          // $config['mailtype'] = 'html'; // o text
          // $this->email->initialize($config);
          // $this->email->from('datafill@zte.com', 'DATAFILL');

          // $this->email->to(strtolower($mails));
          // //$this->email->to('bredybuitrago@outlook.com, yuyupa14@gmail.com');
          
          // //$this->email->to('yuyupa14@gmail.com, andrea.rosero.ext@claro.com.co, andrea.lorenaroserochasoy@zte.com.cn, pablo.esteban@zte.com.cn, bredybuitrago@gmail.com');
          // //$this->email->cc('andrea.rosero.ext@claro.com.co, andrea.lorenaroserochasoy@zte.com.cn');//, cesar.rios.ext@claro.com.co
          // //$this->email->bcc('bredybuitrago@gmail.com ,bredi.buitrago@zte.com.cn, pablo.esteban@zte.com.cn');
          // $this->email->subject("Notificación de REASIGNACIÓN de orden de servicio. Orden: ".$_POST['ot'].". Proyecto: ".$activity[0]->proyecto.".");
          // $this->email->message($cuerpo);
          // $this->email->send();

          

          $this->load->library('parser');

          $config = Array(
              'protocol'  => 'smtp',
              'smtp_host' => 'ssl://smtp.googlemail.com',
              'smtp_port' => 465,
              'smtp_user' => 'zolid.datafill@gmail.com',
              'smtp_pass' => 'z0lid.datafil1',
              'mailtype'  => 'html',
              'charset'   => 'utf-8',
              'priority'  => 5
          );

          $this->load->library('email', $config);
          $this->email->set_newline("\r\n");
          $this->email->from('zolid.datafill@gmail.com', 'ZOLID'); // change it to yours
          $this->email->to(strtolower($mails));// change it to yours
          // $this->email->cc('bredi.buitrago@zte.com.cn, johnfbr1998@gmail.com');
          $this->email->subject("Notificación de REASIGNACIÓN de orden de servicio. Orden: ".$_POST['ot'].". Proyecto: ".$activity[0]->proyecto.".");
          $this->email->message($cuerpo);
          $this->email->send();




          


          $_SESSION["message"] = 'actualizado';          
          header('Location: '. URL::to("Service/listServices"));
        } else {
          $_SESSION["message"] = 'no seleccionado';
          header('Location: '. URL::to("Service/listServices"));
        
        }
      }     
  }
