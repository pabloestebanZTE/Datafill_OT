<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class dao_service_model extends CI_Model{

        public function __construct(){
            $this->load->model('data/configdb_model');
            $this->load->model('data/dao_order_model');
            $this->load->model('data/dao_site_model');
            $this->load->model('data/dao_user_model');
            $this->load->model('data/dao_rf_model');
            $this->load->model('service_model');
            $this->load->model('order_model');
            $this->load->model('service_spec_model');
        }

        public function getAllServices(){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT * FROM service;";
            if ($session != "false"){
              $result = $session->query($sql);
              if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                  $service = new service_model;
                  $service->createService($row['K_IDSERVICE'], $row['N_GERENCY'], $row['N_TYPE'], $row['N_DESCRIPTION'], $row['N_SCOPE'], $row['N_DURATION']);
                  $answer[$i] = $service;
                  $i++;
                }
              }
            } else {
              $answer = "Error de informacion";
            }
            return $answer;
          }

          public function getServicesPerUser($userId){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT * FROM specific_service WHERE K_IDUSER = ".$userId.";";
            if ($session != "false"){
              $result = $session->query($sql);
              if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                  $sService = new service_spec_model;
                  $sService->createServiceS($row['K_ID_SP_SERVICE'], $row['N_DURATION'], $row['K_IDCLARO'], $row['N_DESCRIPTION'], $row['D_DATE_START_P'], $row['D_DATE_FINISH_P'], $row['D_DATE_CREATION'], $row['D_FORECAST'], $this->dao_order_model->getOrderById($row['K_IDORDER']), $this->dao_site_model->getSitePerId($row['K_IDSITE']), $this->getServicePerId($row['K_IDSERVICE']), $row['K_IDUSER'], $row['N_CLARO_DESCRIPTION'], $row['N_INGENIERO_SOL'],$row['N_PROYECTO'], $row['N_ESTADO'], $row['N_CRQ']);
                  $sService->setDateFinishR($row['D_DATE_FINISH_R']);
                  $sService->setDateStartR($row['D_DATE_START_R']);
                  $answer[$i] = $sService;
                  $i++;
                }
              }
            } else {
              $answer = "Error de informacion";
            }
            return $answer;
          }

          public function getServicePerId($serviceId){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT * FROM service WHERE K_IDSERVICE = ".$serviceId.";";
            $result = $session->query($sql);
            $row = $result->fetch_assoc();
            $service = new service_model;
            $service->createService($row['K_IDSERVICE'], $row['N_GERENCY'], $row['N_TYPE'], $row['N_DESCRIPTION'], $row['N_SCOPE'], $row['N_DURATION']);
            return $service;
          }

          public function insertServiceS($service){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT count(*) FROM specific_service;";
            if ($session != "false"){
              $result = $session->query($sql);
              $row = $result->fetch_assoc();
              $order = $this->dao_order_model->getOrderById($service->getOrder());
              if($order->getId() == ""){
                $newOrder = new order_model;
                $newOrder->createOrder($service->getOrder(), "", $service->getDateCreation());
                $this->dao_order_model->insertOrder($newOrder);
              }
              $sql2 = "INSERT INTO specific_service (K_IDUSER, K_IDSERVICE, K_IDSITE, K_IDORDER, D_DATE_START_P, D_DATE_FINISH_P, D_FORECAST, K_IDCLARO, N_DESCRIPTION, D_DATE_CREATION, N_ING_SOL, N_ESTADO, N_PROYECTO, N_CRQ, N_CLARO_DESCRIPTION)
                values (".$service->getUser().", ".$service->getService().", ".$service->getSite()." , '".$service->getOrder()."', STR_TO_DATE('".$service->getDateStartP()."', '%Y-%m-%d'), STR_TO_DATE('".$service->getDateFinishP()."', '%Y-%m-%d'), STR_TO_DATE('".$service->getDateForecast()."', '%Y-%m-%d'), '".$service->getIdClaro()."', '".$service->getDescription()."', STR_TO_DATE('".$service->getDateCreation()."', '%Y-%m-%d'), '".$service->getIngSol()."', '".$service->getEstado()."', '".$service->getProyecto()."', '".$service->getCRQ()."', '".$service->getClaroDescription()."');";               
              $result = $session->query($sql2);
            } else {
              $answer = "Error de informacion";
            }
          }

 //CAMILO-------------------------------------------------INSERTA DATOS DE EXCEL  

          public function insertFromExcel($activity){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT count(*) FROM specific_service;";
            $count = 0;
            if ($session != "false"){
              $result = $session->query($sql);
              $row = $result->fetch_assoc();
              $order = $this->dao_order_model->getOrderById($activity->getOrder());
              if($order->getId() == ""){
                $newOrder = new order_model;
                $newOrder->createOrder($activity->getOrder(), "", $activity->getDateCreation());
                $this->dao_order_model->insertOrder($newOrder);
              }
               $timezone = date_default_timezone_get();
               $date = date('m-d-Y', time());

               $sql3 = "SELECT  COUNT(*) FROM specific_service where K_IDCLARO = ".$activity->getIdClaro().";";
               $result = $session->query($sql3);
               $row = $result->fetch_assoc();
               if($row['COUNT(*)'] == 0){
                  $sql2 = "INSERT INTO specific_service (K_IDUSER, K_IDCLARO, N_DESCRIPTION, N_CLARO_DESCRIPTION, D_DATE_CREATION, D_FORECAST, K_IDORDER, K_IDSITE, K_IDSERVICE, N_ING_SOL, N_PROYECTO, N_ESTADO, N_CANTIDAD, N_REGION, D_DATE_START_P) values (".$activity->getId().", ".$activity->getIdClaro().",'$activity->getDescription(), en el sao service_model no deja entrar la descripcion por alguna razon', '$activity->getClaroDescription(), otra descrtipcion, dao_service_model insertFromExcel', STR_TO_DATE('".$activity->getDateCreation()."','%d-%m-%Y'), STR_TO_DATE('".$activity->getDateForecast()."','%m-%d-%Y'),".$activity->getOrder().",".$activity->getSite().",".$activity->getService().",'".$activity->getIngSol()."','".$activity->getProyecto()."','".$activity->getEstado()."' ,".$activity->getQuantity().", '".$activity->getRegion()."',STR_TO_DATE('".$date."','%m-%d-%Y'));";
                    $result = $session->query($sql2);
                    $count++;
               } 
            } else {
              $answer = "Error de informacion";
            }
            return $count;
          }
//CAMILO--------------------------------------------Cancela con excel
          public function CancelFromExcel($cancel){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            if ($session != "false"){
                if ($cancel->getIdClaro() != "") {                 
                  $sql = "UPDATE specific_service SET N_ESTADO = '".$cancel->getEstado()."' WHERE K_IDCLARO = '".$cancel->getIdClaro()."';";
                   $session->query($sql);
                }   

            } else {
              $answer = "Error de informacion";
             }
          }

//CAMILO--------------------------------------------ejecuta con excel
          public function executeFromExcel($executed){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            if ($session != "false"){
                if ($executed->getIdClaro() != "") {                 
                  $sql = "UPDATE specific_service SET N_ESTADO = '".$executed->getEstado()."' WHERE K_IDCLARO = '".$executed->getIdClaro()."';";
                   $session->query($sql);
                }   

            } else {
              $answer = "Error de informacion";
             }
          }          
//CAMILO-------------------------------------------------INSERTA DATOS DE CIERRE
          public function updateClose($close){
           $dbConnection = new configdb_model();
           $session = $dbConnection->openSession();
           $sql = "UPDATE specific_service SET D_DATE_START_R = STR_TO_DATE('".$close->getDateStartR()."', '%Y-%m-%d'),  D_DATE_FINISH_R = STR_TO_DATE('".$close->getDateStartR()."', '%Y-%m-%d'),  N_ESTADO = '".$close->getEstado()."', N_CRQ = '".$close->getCRQ()."', N_CIERRE_DESCRIPTION = '".$close->getCierreDescription()."' WHERE K_IDCLARO = '".$close->getIdClaro()."'AND K_ID_SP_SERVICE = '".$close->getId()."';";
           $session->query($sql);
          }
//---------------------------------------------------------------------------------------

          public function getAllServicesS(){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT * FROM specific_service;";
            if ($session != "false"){
              $result = $session->query($sql);
              if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                  $sService = new service_spec_model;
                  $sService->createServiceS($row['K_ID_SP_SERVICE'], $row['N_DURATION'], $row['K_IDCLARO'], $row['N_DESCRIPTION'], $row['D_DATE_START_P'], $row['D_DATE_FINISH_P'], $row['D_DATE_CREATION'], $row['D_FORECAST'], $this->dao_order_model->getOrderById($row['K_IDORDER']), $this->dao_site_model->getSitePerId($row['K_IDSITE']), $this->getServicePerId($row['K_IDSERVICE']), $this->dao_user_model->getUserById($row['K_IDUSER']), $row['N_CLARO_DESCRIPTION'], $row['N_ING_SOL'],$row['N_PROYECTO'], $row['N_ESTADO'], $row['N_CRQ']);
                  $sService->setDateFinishR($row['D_DATE_FINISH_R']);
                  $sService->setDateStartR($row['D_DATE_START_R']);
                  $answer[$i] = $sService;
                  $i++;
                }
              }
            } else {
              $answer = "Error de informacion";
            }
            return $answer;
          }

          public function getServiceById($id){
              $dbConnection = new configdb_model();
              $session = $dbConnection->openSession();
              $sql ="SELECT * FROM specific_service WHERE K_ID_SP_SERVICE = '".$id."';";
              if ($session != "false"){
                $result = $session->query($sql);
                if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  $sService = new service_spec_model();
                   $sService->createServiceS($row['K_ID_SP_SERVICE'], $row['N_DURATION'], $row['K_IDCLARO'], $row['N_DESCRIPTION'], $row['D_DATE_START_P'], $row['D_DATE_FINISH_P'], $row['D_DATE_CREATION'], $row['D_FORECAST'], $this->dao_order_model->getOrderById($row['K_IDORDER']), $this->dao_site_model->getSitePerId($row['K_IDSITE']), $this->getServicePerId($row['K_IDSERVICE']), $this->dao_user_model->getUserById($row['K_IDUSER']), $row['N_CLARO_DESCRIPTION'], $row['N_ING_SOL'], $row['N_PROYECTO'], $row['N_ESTADO'], $row['N_CRQ']);
                     $sService->setDateFinishR($row['D_DATE_FINISH_R']);
                     $sService->setDateStartR($row['D_DATE_START_R']);
                     $sService->setCierreDescription($row['N_CIERRE_DESCRIPTION']); 
                }
              } else{
                  $sService = "Error de informacion";
              }
            return $sService;
          }
      }
?>
