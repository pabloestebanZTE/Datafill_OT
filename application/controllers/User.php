<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class User extends CI_Controller {

      function __construct() {
        parent::__construct();
        $this->load->model('data/dao_user_model');
        $this->load->model('data/user_model');
      }

      public function loginUser(){
        print_r($_POST);
        $userTest = new user_model;
        $response = $this->dao_user_model->getUserByUsername($_POST['username']);
        if($response != "No users" && $response != "Error de BD"){
          $pass = $this->dao_user_model->getUsernamePassword($_POST['username']);
          if($pass['N_PASSWORD'] == $_POST['password']){
            $this->load->view('index');
          } else {
            $this->load->view('login');
          }
        } else {
          $this->load->view('login');
        }
      }
  }

?>
