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
        $answer['sites'] = $this->dao_site_model->getAllSites();
        $answer['orders'] = $this->dao_order_model->getAllOrders();

        $this->load->view('assignService', $answer);
      }

      public function listServices(){
        $answer['services'] = $this->dao_service_model->getAllServicesS();
        $this->load->view('listServices', $answer);
      }

      public function serviceDetails(){
        $answer['service']=$this->dao_service_model->getServiceById($_GET['K_ID_SP_SERVICE']);
/*
                $destinatario = "bredybuitrago@gmail.com,pablo.esteban@zte.com.cn"; 
                $asunto = "Este mensaje es de prueba"; 
                $hearder = 'MIME-Version: 1.0' . "\r\n";
                $hearder .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $hearder .= "From: desarrolladores_ZTE";
                $cuerpo = "
                <html> 
                <head> 
                   <title>Prueba de correo</title> 
                </head> 
                <body> 
                <h1>Hola prueba</h1> 
                <p> 
                <b>Este es el correo  electrónico de prueba</b>. Esta es una prueba de envio de correo . Este es el cuerpo del mensaje, es una prueba sin envio de ninguna variable y pruebo enviando a dos destinatarios, ya no se que mas escrbirle al cuerpo para quede mas largo y lo pueda visualizar mejor.
                </p> 
                </body> 
                </html> 
                "; 
                echo "<br><br><br>";
                echo "correo enviado";
                mail($destinatario,$asunto,$cuerpo,$hearder);
*/
        $this->load->view('orderDetail',$answer);
      }
  }

?>
