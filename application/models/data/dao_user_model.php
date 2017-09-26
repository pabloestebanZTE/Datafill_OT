<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class dao_user_model extends CI_Model{

        public function __construct(){
            $this->load->model('data/configdb_model');
            $this->load->model('data/dao_service_model');
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
                $schedule = $this->dao_service_model->getServicesPerUser($eng->getId());
               // $eng->setSchedule($schedule);
                $answer[$i] = $eng;
                $i++;
              }
            }
          } else {
            $answer = "Error de BD";
          }
            return $answer;
        }
//CAMILO-----------------------------------------------------------
        public function getAllEngineersClaro(){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT * FROM user where K_IDROLE = 5;";
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
                $schedule = $this->dao_service_model->getServicesPerUser($eng->getId());
               // $eng->setSchedule($schedule);
                $answer[$i] = $eng;
                $i++;
              }
            }
          } else {
            $answer = "Error de BD";
          }
            return $answer;
        }

        public function getUserByUsername($username){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT * FROM USER WHERE N_USERNAME = '".$username."';";
          if ($session != "false"){
            $result = $session->query($sql);
            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $user = new user_model;
              $user->createUser($row['K_IDUSER'], $row['N_NAME'], $row['N_LASTNAME'], $row['N_PHONE'], $row['N_CELPHONE'], $row['N_MAIL']);
              $answer = $user;
            } else {
              $answer = "No users";
            }
          } else {
            $answer = "Error de BD";
          }
          return $answer;
        }

        public function getUsernamePassword($username){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT N_PASSWORD FROM USER WHERE N_USERNAME = '".$username."';";
          if ($session != "false"){
            $result = $session->query($sql);
            $row = $result->fetch_assoc();
            $answer = $row;
          } else {
            $answer = "Error de BD";
          }
          return $answer;
        }

        public function getUserById($idUser){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT * FROM user WHERE K_IDUSER = ".$idUser.";";
          if ($session != "false"){
            $result = $session->query($sql);
             if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();  
                $user = new user_model;
                $user->createUser($row['K_IDUSER'], $row['N_NAME'], $row['N_LASTNAME'], $row['N_PHONE'], $row['N_CELPHONE'], $row['N_MAIL']);
                $answer = $user;              
             }
          } else {
            $answer = "Error de BD";
          }
          return $answer;
        }

        public function getUserByName($nameUser){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT * FROM user WHERE N_NAME = ".$nameUser.";";
          if ($session != "false"){
            $result = $session->query($sql);
             if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();  
                $user = new user_model;
                $user->createUser($row['K_IDUSER'], $row['N_NAME'], $row['N_LASTNAME'], $row['N_PHONE'], $row['N_CELPHONE'], $row['N_MAIL']);
                $answer = $user;              
             }
          } else {
            $answer = "Error de BD";
          }
          return $answer;
        }
    }
?>
