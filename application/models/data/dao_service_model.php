<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class dao_service_model extends CI_Model{

        public function __construct(){
            $this->load->model('data/configdb_model');
            $this->load->model('data/dao_order_model');
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
                  $sService->createServiceS($row['K_ID_SP_SERVICE'], $row['N_DURATION'], $row['K_IDCLARO'], $row['N_DESCRIPTION'], $row['D_DATE_START_P'], $row['D_DATE_FINISH_P'], $row['D_DATE_CREATION'], $row['D_FORECAST'], $this->dao_order_model->getOrderById($row['K_IDORDER']), $this->dao_site_model->getSitePerId($row['K_IDSITE']), $this->getServicePerId($row['K_IDSERVICE']), $row['K_IDUSER']);
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
            $sql = "SELECT count(*) FROM specific_service";
            if ($session != "false"){
              $result = $session->query($sql);
              $row = $result->fetch_assoc();
              $order = $this->dao_order_model->getOrderById($service->getOrder());

              if($order->getId() == ""){
                $newOrder = new order_model;
                $newOrder->createOrder($service->getOrder(), "", $service->getDateCreation());
                $this->dao_order_model->insertOrder($newOrder);
              }

              $sql2 = "INSERT INTO specific_service (K_ID_SP_SERVICE, K_IDUSER, K_IDSERVICE, K_IDSITE, K_IDORDER, D_DATE_START_P, D_DATE_FINISH_P, D_FORECAST, K_IDCLARO, N_DESCRIPTION, D_DATE_CREATION)
                values (".$row['count(*)'].", ".$service->getUser().", ".$service->getService().", ".$service->getSite()." , ".$service->getOrder().", STR_TO_DATE('".$service->getDateStartP()."', '%Y-%m-%d'), STR_TO_DATE('".$service->getDateFinishP()."', '%Y-%m-%d'), STR_TO_DATE('".$service->getDateForecast()."', '%Y-%m-%d'), ".$service->getIdClaro().", '".$service->getDescription()."', STR_TO_DATE('".$service->getDateCreation()."', '%Y-%m-%d'));";
              $result = $session->query($sql2);
            } else {
              $answer = "Error de informacion";
            }
          }
    }
?>
