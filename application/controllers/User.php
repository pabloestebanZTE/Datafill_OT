<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class User extends CI_Controller {

      function __construct() {
        parent::__construct();
        $this->load->model('data/configdb_model');
        $this->load->model('data/dao_user_model');
        $this->load->model('data/user_model');
        $this->load->model('data/Dao_service_model');
      }

      public function loginUser(){
        $userTest = new user_model;
        $response = $this->dao_user_model->getUserByUsername($_POST['username']);
        if($response != "No users" && $response != "Error de BD"){
          $pass = $this->dao_user_model->getUsernamePassword($_POST['username']);
          if($pass['N_PASSWORD'] == $_POST['password']){
            $this->configdb_model->startSession($response);
            $this->load->view('principal');
          } else {
            $answer['error'] = "error";
            $this->load->view('login', $answer);
          }
        } else {
          $answer['error'] = "error";
          $this->load->view('login', $answer);
        }
      }

      public function principalView(){
        $this->load->view('principal');
      }


      //
      public function email(){
        $cuerpo = "<!DOCTYPE html>
                    <html lang='en'>
                    <head>
                      <meta charset='UTF-8'>
                      <title>Document</title>
                    </head>
                    <body>
                      <h1>esta es una prueba</h1>
                      <hr>
                      <p>Cordial Saludo Señor(a)
                        XXXX
                                                  
                        A continuación se remite  el reporte de Inicio de Actividades para (NOMBRE CLIENTE)  con el cual se da inicio al proceso de Instalación del Servicio  XXXXX

                        Este documento  contiene las definiciones del servicio a instalar y los datos de contacto del Ingeniero encargado de la implementación de su servicio. Es de suma importancia que sea revisado y nos retroalimente la información que le solicitamos en el mismo. Si tiene alguna duda o inquietud no dude en contactarnos.  Si no está de acuerdo con alguna información contenida en este documento es importante que nos haga llegar sus inquietudes ya que el servicio contratado será entregado de acuerdo a la información que describimos a continuación. 
                      </p>

                      <img src= 'http://datafillot.us-west-2.elasticbeanstalk.com/assets/img/logoblue.png'  alt='MK NO PUDO'>




                    </body>
                    </html>";
            // $this->load->library('email');
            // $config['mailtype'] = 'html'; // o text
            // $this->email->initialize($config);
            // $this->email->from('elviejocami@zte.com', 'PAPI_CAMI');

            // $this->email->to('bredybuitrago@gmail.com');
            // $this->email->cc('bredi.buitrago@zte.com.cn');
            
            // $this->email->subject("prueba envio con imagen");
            // $this->email->message($cuerpo);
            // $this->email->send();

            // echo "ya se envio papu";


           $this->load->library('parser');

          $config = Array(
              'protocol'  => 'smtp',
              'smtp_host' => 'ssl://smtp.googlemail.com',
              'smtp_port' => 465,
              'smtp_user' => 'jfgrisales21@misena.edu.co',
              'smtp_pass' => 'halo02pro',
              'mailtype'  => 'html',
              'charset'   => 'utf-8',
              'priority'  => 5
          );

          $this->load->library('email', $config);
          $this->email->set_newline("\r\n");
          $this->email->from('johnfbr1998@gmail.com', 'EL_FEIBER'); // change it to yours
          $this->email->to('bredybuitrago@gmail.com');// change it to yours
          $this->email->cc('bredi.buitrago@zte.com.cn, johnfbr1998@gmail.com');
          $this->email->subject("prueba envio con imagen");
          $this->email->message($cuerpo);
          if($this->email->send())
          { 
            echo "se envio correctamente";
          }
          else
          {
              show_error($this->email->print_debugger());
          }


        
      }





  }

?>
