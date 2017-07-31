<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class dao_order_model extends CI_Model{

        public function __construct(){
            $this->load->model('data/configdb_model');
            $this->load->model('order_model');
        }

        public function getOrderById($orderId){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT * FROM ot WHERE K_IDORDER = ".$orderId.";";
            $result = $session->query($sql);
            $row = $result->fetch_assoc();
            $order = new order_model;
            $order->createOrder($row['K_IDORDER'], $row['N_NAME'], $row['D_DATE_CREATION']);
            return $order;
        }

        public function getAllOrders(){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT * FROM ot;";
          if ($session != "false"){
            $result = $session->query($sql);
            if ($result->num_rows > 0) {
              $i = 0;
              while($row = $result->fetch_assoc()) {
                $order = new order_model;
                $order->createOrder($row['K_IDORDER'], $row['N_NAME'], $row['D_DATE_CREATION']);
                $answer[$i] = $order;
                $i++;
              }
            }
          }
          return $answer;
        }

        public function insertOrder($order){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "INSERT INTO ot (K_IDORDER, N_NAME, D_DATE_CREATION)
            values (".$order->getId().", '".$order->getName()."', STR_TO_DATE('".$order->getCreationDate()."', '%Y-%m-%d'));";
          if ($session != "false"){
            $result = $session->query($sql);
          }
        }
    }
?>
