<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Service extends CI_Controller {

      function __construct() {
        parent::__construct();
        $this->load->model('data/configdb_model');
        $this->load->model('data/dao_service_model');
        $this->load->model('data/dao_order_model');
        $this->load->model('data/dao_user_model');
        $this->load->model('data/dao_site_model');
      }

      public function assignService(){
        $answer['services'] = $this->dao_service_model->getAllServices();
        $answer['engineers'] = $this->dao_user_model->getAllEngineers();
      //  $answer['sites'] = $this->dao_site_model->getAllSites();
        $answer['orders'] = $this->dao_order_model->getAllOrders();

        $this->load->view('assignService', $answer);
      }

      public function listServices(){
        $answer['services'] = $this->dao_service_model->getAllServicesS();
        $this->load->view('listServices', $answer);
      }

      public function serviceDetails(){
        $answer['service']=$this->dao_service_model->getServiceById($_GET['K_ID_SP_SERVICE']);
        $this->load->view('orderDetail',$answer);
      }

      public function orderDetails(){
        $answer['order']=$this->dao_order_model->getOrderById($_GET['K_ID_ORDER']);
        $answer['services'] = $this->dao_service_model->getServicesPerOrder($_GET['K_ID_ORDER']);
        $this->load->view('OTDetails',$answer);
      }

      public function updateState(){

        $activitiesQ = count($_POST) - 5;
        $service  = new service_spec_model;
        $service->setDateFinishZTE($_POST['FCZ']);
        $service->setDateStartOrder($_POST['FIO']);
        $service->setDateFinishClaro($_POST['FCC']);
        $service->setDateFinishR($_POST['FE']);
        $service->setEstado($_POST['Estado']);
        for($i = 0; $i < $activitiesQ; $i++){
          $service->setId($_POST['check'.$i]);
          $this->dao_service_model->updateService($service);
        }
      }
  }

?>
