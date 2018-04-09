<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class RF extends CI_Controller {

      function __construct() {
        parent::__construct();
        $this->load->model('data/configdb_model');
        $this->load->model('data/Dao_rf_model');
      }
      // llama todas las actividades de rf
      public function getListRF(){
          $data = $this->Dao_rf_model->getAllActivitiesRF();
          echo json_encode($data);
      }

      //llama todos los estados div por status mod nuevos y con canbios
      public function getByStatusNewChange(){
        header('Content-Type: text/plain');
        $data['news'] = $this->Dao_rf_model->getRFNews();
        $data['changes'] = $this->Dao_rf_model->getRFChanges();
        $data['logChanges'] = $this->Dao_rf_model->getLogChangesInStatus1();//todo en estado 1"cambios"
        $data['cantNews'] = count($data['news']);
        $data['cantChanges'] = count($data['changes']);
        echo json_encode($data);
      }

      // Llama los log por id 
      public function getLogById(){
        $id = $this->input->post('id');
        $data = $this->Dao_rf_model->getLogById($id);
        echo json_encode($data);
      }


      public function viewRF(){
        $this->load->view('viewRF');
      }
      

 }

?>