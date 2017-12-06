<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Service extends CI_Controller {

      function __construct() {
        parent::__construct();
        $this->load->model('data/configdb_model');
        $this->load->model('data/dao_service_model');
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
/*        header('Content-Type: text/plain');
*/        $answer['services'] = $this->dao_order_model->getAllOrders();
        $this->load->view('listServices', $answer);
      }

      public function serviceDetails(){
        $answer['service']=$this->dao_service_model->getServiceById($_GET['K_ID_SP_SERVICE']);
        $this->load->view('orderDetail',$answer);
      }

      public function RF(){
        $this->load->view('updateRF');
      }
  }

?>
