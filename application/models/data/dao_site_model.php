<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class dao_site_model extends CI_Model{

        public function __construct(){
            $this->load->model('data/configdb_model');
            $this->load->model('site_model');
        }

        public function getAllSites(){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT * FROM site;";
            if ($session != "false"){
              $result = $session->query($sql);
              if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                  $site = new site_model;
                  $site->createSite($row['K_IDSITE'], $row['N_NAME']);
                  $answer[$i] = $site;
                  $i++;
                }
              }
            } else {
              $answer = "Error de informacion";
            }
            return $answer;
          }

        public function getSitePerId($siteId){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT * FROM site WHERE K_IDSITE = ".$siteId.";";
          $result = $session->query($sql);
          $row = $result->fetch_assoc();
          $site = new site_model;
          $site->createSite($row['K_IDSITE'], $row['N_NAME']);
          return $site;
        }
    }
?>
