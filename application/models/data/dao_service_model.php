<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class dao_service_model extends CI_Model{

        public function __construct(){
            $this->load->model('data/configdb_model');
            $this->load->model('data/dao_order_model');
            $this->load->model('service_model');
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
                  $sService->createService($row['K_ID_SP_SERVICE'], $row['N_DURATION'], $row['K_IDCLARO'], $row['N_DESCRIPTION'], $row['D_DATE_START_P'], $row['D_DATE_FINISH_P'], $row['D_DATE_CREATION'], $row['D_FORECAST'], $this->dao_order_model->getOrderById($row['K_IDORDER']), $this->dao_site_model->getSitePerId($row['K_IDSITE']), $this->getServicePerId($row['K_IDSERVICE']), $row['K_IDUSER']);
                  $sService->setDateFinishP($row['D_DATE_FINISH_R']);
                  $sService->setDateStartP($row['D_DATE_START_R']);
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
    }
?>