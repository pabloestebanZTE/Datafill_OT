<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class SpecificService extends CI_Controller {

      function __construct() {
        parent::__construct();
        $this->load->model('data/configdb_model');
        $this->load->model('data/dao_service_model');
        $this->load->model('service_spec_model');
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

  }

?>
