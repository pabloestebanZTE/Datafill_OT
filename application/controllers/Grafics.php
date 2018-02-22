<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Grafics extends CI_Controller {

      function __construct() {
        parent::__construct();
        $this->load->model('data/configdb_model');
        $this->load->model('data/Dao_service_model');
        // $this->load->model('data/Dao_report_model');
      }

      public function getGrafics(){
      	 $this->load->view('grafics');

      }







 }

?>