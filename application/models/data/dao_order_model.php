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
    }
?>
