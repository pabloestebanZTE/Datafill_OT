<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class dao_order_model extends CI_Model{

        public function __construct(){
            $this->load->model('data/configdb_model');
            $this->load->model('order_model');
            $this->load->model('data/dao_service_model');
        }

        public function getOrderById($orderId){
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT * FROM ot WHERE K_IDORDER = '".$orderId."';";
            $order = new order_model;
            $result = $session->query($sql);
            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $order->createOrder($row['K_IDORDER'], $row['N_NAME'], $row['D_DATE_CREATION']);
            } else {
              $order->createOrder("","","");
            }
            return $order;
        }

        //==============RETORNA TODAS LAS ORDENES CON SUS ACTIVIDADES... SI ROLL ES ING SOLO LAS DE EL=============
        public function getAllOrders(){
          //SI EL ROLL ES DE INGENIER SOLO LO FILTRA POR LAS OT DEL ING LOGUEADO
          if ($_SESSION["role"] == 1 || $_SESSION["role"] == 2 || $_SESSION["role"] == 3) {
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            //VERIFICAMOS LAS  ACTIVIDADES ASIGNADAS AL ING
            $sql = "SELECT * FROM specific_service WHERE K_IDUSER = ".$_SESSION['id'].";";
            if ($session != "false"){
              $result = $session->query($sql);
                if ($result->num_rows >0) {
                  $i = 0;
                  while ($row = $result->fetch_assoc()) {
                    //TRAEMOS LAS ORDENES DEL ING DEPENDIENDO EL KIDORDER DE TODAS SUS ACTIVIDADES
                    $sql2 = "SELECT * FROM ot WHERE K_IDORDER = ".$row['K_IDORDER'].";";
                    $result2 = $session->query($sql2);
                    $row2 = $result2->fetch_assoc();
                        //CREAMOS EL OBJETO Y AÑADIDAMOS A LAS OT CADA UNA DE LAS ACTIVIDADES ASIGNADAS
                        $order = new order_model;
                        $order->createOrder($row['K_IDORDER'], $row['N_NAME'], $row['D_DATE_CREATION']);
                        $sercicios = $this->dao_service_model->getServiceByIdOrder($row['K_IDORDER']);
                        $order->services = $sercicios;
                        $answer[$i] = $order;
                  $i++;
                  }
                  //PUEDEN EXISTIR ORDENES DUPLICADAS... ELIMINAMOS TODAS LAS DUPLICADAS
                  $duplicates = array_values(array_map("unserialize", array_unique(array_map("serialize", $answer))));
                  return $duplicates;
                }
            }
            //SI EL ROL ES DISTINTO A INGENIERO RETORNAMOS TODAS LAS ORDENES CO N SUS ACTIVIDADES
          }else{            
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql = "SELECT * FROM ot;";
            if ($session != "false"){
              $result = $session->query($sql);
              if ($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                  //CREAMOS EL OBJETO Y LE AÑADIMOS SUS RESPECTIVAS ACTIVIDADES
                  $order = new order_model;
                  $order->createOrder($row['K_IDORDER'], $row['N_NAME'], $row['D_DATE_CREATION']);
                  $sercicios = $this->dao_service_model->getServiceByIdOrder($row['K_IDORDER']);
                  $order->services = $sercicios;
                  $answer[$i] = $order;
                  $i++;
                }
              }
            }
          return $answer;
          }
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

        public function link($link, $orden){
           $dbConnection = new configdb_model();
           $session = $dbConnection->openSession();
           $sql = "UPDATE ot SET N_DRIVE = '".$link."' WHERE K_IDORDER = ".$orden.";";
           $session->query($sql);
        }
    }
?>
