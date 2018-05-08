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

    public function assignService() {
        //$answer['services'] = $this->dao_service_model->getAllServices();
        //$answer['engineers'] = $this->dao_user_model->getAllEngineers();
        //$answer['sites'] = $this->dao_site_model->getAllSites();
        //$answer['orders'] = $this->dao_order_model->getAllOrders();

        $this->load->view('assignService', $answer);
    }

    public function listServices() {
        //Recibimos la variable global con el mensaje  
        $message = isset($_SESSION["message"]) ? $_SESSION["message"] : null;
        $this->load->view('listServices', ["message" => $message]);
        //Limpiamos la variable glogal
        unset($_SESSION["message"]);
    }

    public function getListServices() {
        // $answer['eng'] = $this->dao_user_model->getAllEngineers();//llama todos los ing para pintar en select
        $res = $this->dao_order_model->getAllOrders();
        $answer['services'] = $res["services"];
        $answer['count'] = $res["count"];
        // -----------Consulto cuantas actividades enviadas, canceladas, ejecutadas  y asignadas que existen-----------
        $count = count($answer['services']);
        for ($y = 0; $y < $count; $y++) {
            $answer['services'][$y]->enviadas = $this->dao_service_model->getEnviadoByOrder($answer['services'][$y]->getId());
            $answer['services'][$y]->canceladas = $this->dao_service_model->getCanceladoByOrder($answer['services'][$y]->getId());
            $answer['services'][$y]->ejecutadas = $this->dao_service_model->getEjecutadoByOrder($answer['services'][$y]->getId());
            $answer['services'][$y]->asignadas = $this->dao_service_model->getAsignadoByOrder($answer['services'][$y]->getId());
        }
        $data = [
            "draw" => intval($_GET['draw']),
            "recordsTotal" => intval($answer['count']),
            "recordsFiltered" => intval($answer['count']),
            "data" => $answer['services'],
            "sql" => $sql,
        ];
        echo json_encode($data);
    }

    public function serviceDetails() {
        $answer['service'] = $this->dao_service_model->getServiceById($_GET['K_ID_SP_SERVICE']);
        $this->load->view('orderDetail', $answer);
    }

    public function RF() {
        $this->load->view('updateRF');
    }

    public function actualizarfechaAsig(){

        $data = array(
            'K_IDORDER' => $this->input->post('idOrden'), 
            'D_DATE_START_P' => $this->input->post('fecha') 
        );
        $res = $this->dao_service_model->updateFecha($data);
        echo json_encode($res);
    }


}

