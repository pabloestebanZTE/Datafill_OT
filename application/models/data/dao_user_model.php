<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class dao_user_model extends CI_Model{

        public function __construct(){
            $this->load->model('data/configdb_model');
            $this->load->model('user_model');
            $this->load->model('role_model');
        }

        public function getAllEngineers(){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT * FROM user where K_IDROLE = 1 or K_IDROLE = 2 or K_IDROLE = 3;";
            if ($session != "false"){
              $result = $session->query($sql);
              if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                  $eng = new user_model;
                  $eng->createUser($row['K_IDUSER'], $row['N_NAME'], $row['N_LASTNAME'], $row['N_PHONE'], $row['N_CELPHONE'], $row['N_MAIL']);
                  $sql2 = "SELECT * FROM role WHERE K_IDROLE = ".$row['K_IDROLE'].";";
                  $result2 = $session->query($sql2);
                  $row2 = $result2->fetch_assoc();
                  $role = new role_model;
                  $role->createRole($row2['K_IDROLE'], $row2['N_NAME']);
                  $eng->setRole($role);
                  $answer[$i] = $eng;
                  $i++;
                }
              }
            } else {
              $answer = "Error de informacion";
            }
              return $answer;
          }
    }
?>
