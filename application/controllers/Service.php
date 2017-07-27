<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Service extends CI_Controller {

      function __construct() {
        parent::__construct();
        $this->load->model('data/dao_service_model');
      }

      public function assignService(){
        $answer['services'] = $this->dao_service_model->getAllServices();
      }
  }

?>
