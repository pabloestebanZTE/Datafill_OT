<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Dao_order_model extends CI_Model{

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
              $order->setLink($row['N_DRIVE']);
            } else {
              $order->createOrder("","","");
            }
            return $order;
        }

        //==============RETORNA TODAS LAS ORDENES CON SUS ACTIVIDADES... SI ROLL ES ING SOLO LAS DE EL=============
        public function getAllOrders(){
          //SI EL ROLL ES DE INGENIER SOLO LO FILTRA POR LAS OT DEL ING LOGUEADO
       /*   if ($_SESSION["role"] == 1 || $_SESSION["role"] == 2 || $_SESSION["role"] == 3) {
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
                            $order->setLink($row['N_DRIVE']);
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
            //SI EL ROL ES DISTINTO A INGENIERO RETORNAMOS TODAS LAS ORDENES CON SUS ACTIVIDADES
          }
*/
          // else{    
            $dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $start = $_GET['start'];
            $length = $_GET['length'];
            $search = $_GET['search'];
            $search = $search["value"];
            $answer = [];

            //Parametrizando el ordenamiento:
            $columns = ["K_IDORDER", "D_DATE_CREATION", "N_ING_SOL", "D_FORECAST", "D_DATE_START_P", "N_PROYECTO", "n_region", "N_NAME", "N_LASTNAME", "N_CLARO_DESCRIPTION"];

            //Algoritmo para obtener la consulta de ordenamiento...
            $orderBy = null;
            //Verificamos si viene ordenamiento.
            $orderSQL = $_GET["order"];
            if ($orderSQL) {
              $col = $columns[$orderSQL[0]["column"]];
              $orderBy["col"] = $col;
              $dir = $orderSQL[0]["dir"];
              $orderBy["dir"] = $dir;
            }

            $orderSQL = "";
            $listOrders = ["D_FORECAST" => "desc"];
            if ($orderBy) {
                $listOrders = [];
                //Se agregan los orders adicionales...
                $flag = true;
                foreach ($listOrders as $key => $val) {
                    if ($orderBy["col"] == $key) {
                        $flag = false;
                    }
                }
                if ($flag) {
                    $listOrders[$orderBy["col"]] = $orderBy["dir"];
                }
            }

            //Armamos la sentencia de ordenamiento.
            $i = 0;
            $max = count($listOrders);
            foreach ($listOrders as $key => $value) {
                $orderSQL .= $key . " " . $value;
                $orderSQL .= ($i < ($max - 1)) ? ", " : " ";
                $i++;
            }
            //Fin algoritmo para hacer la consulta de ordenamieto...

            //Se compruba si se está filtrando...
            $typeSQL = isset($_GET['typeSQL']) ? (($_GET["typeSQL"] == "GDATOS") ? "se.N_PROYECTO LIKE '%GDATOS%'" : "se.N_PROYECTO NOT LIKE '%GDATOS%'") : "se.N_PROYECTO NOT LIKE '%GDATOS%'";

             $whereIngeniero = "";
                if ($_SESSION["role"] == 1 || $_SESSION["role"] == 2 || $_SESSION["role"] == 3) {
                  $whereIngeniero = " and u.K_IDUSER = ".$_SESSION['id']; 
                }

            if ($search){               

               //Se obtienen los registros por límite de x a 10...
                $sqlIni = "select ot.K_IDORDER, ot.N_DRIVE, ot.D_DATE_CREATION, se.N_ING_SOL, se.D_FORECAST, se.D_DATE_START_P, se.N_PROYECTO, se.n_region, u.N_NAME, u.N_LASTNAME, se.N_CLARO_DESCRIPTION, se.D_CLARO_F 
                  from ot inner join specific_service se
                  on ot.K_IDORDER = se.K_IDORDER  
                  inner join user u 
                  on u.K_IDUSER = se.K_IDUSER 
                  WHERE ".$typeSQL.$whereIngeniero." AND (ot.K_IDORDER LIKE '%".$search."%' 
                  OR ot.D_DATE_CREATION LIKE '%".$search."%' 
                  OR se.N_ING_SOL LIKE '%".$search."%' 
                  OR se.D_FORECAST LIKE '%".$search."%' 
                  OR se.D_DATE_START_P LIKE '%".$search."%' 
                  OR se.N_PROYECTO LIKE '%".$search."%' 
                  OR se.n_region LIKE '%".$search."%' 
                  OR u.N_NAME LIKE '%".$search."%' 
                  OR u.N_LASTNAME LIKE '%".$search."%' 
                  OR se.N_CLARO_DESCRIPTION LIKE '%".$search."%') group by ot.K_IDORDER order by ". $orderSQL." ";

                $sql = $sqlIni." limit ".$start.", ".$length.";";
                // echo $sql;

                //Se hace un conteo de las coincidencias filtradas sin ningún límite.
                $q = $this->db->query($sqlIni)->result();          
                $count = count($q);

                if ($session != "false"){
                  $result = $session->query($sql);
                  if ($result->num_rows > 0) {
                    $i = 0;
                    while($row = $result->fetch_assoc()) {

                      //CREAMOS EL OBJETO Y LE AÑADIMOS SUS RESPECTIVAS ACTIVIDADES
                      $order = new order_model;
                      $order->createOrder($row['K_IDORDER'], $row['N_NAME'], $row['D_DATE_CREATION']);
                      $order->setLink($row['N_DRIVE']);

                      $sercicios = $this->dao_service_model->getServiceByIdOrder($row['K_IDORDER']);
                      $order->services = $sercicios; 
                      $answer[$i] = $order;
                      $i++;
                    }
                  }
                }
              }

              else {              
                //Si no se está filtrando se realiza la consulta normalmnete limitada de x a 10...        
                $sqlIni = "select ot.K_IDORDER, ot.N_DRIVE, ot.D_DATE_CREATION, se.N_ING_SOL, se.D_FORECAST, se.D_DATE_START_P, se.N_PROYECTO, se.n_region, u.N_NAME, u.N_LASTNAME, se.N_CLARO_DESCRIPTION, se.D_CLARO_F 
                  from ot inner join specific_service se
                  on ot.K_IDORDER = se.K_IDORDER 
                  inner join user u 
                  on u.K_IDUSER = se.K_IDUSER WHERE ".$typeSQL.$whereIngeniero." group by ot.K_IDORDER";

                $sql = $sqlIni." order by ". $orderSQL." limit ".$start.", ".$length.";";
                                
                // echo $sql;
                $count = count($this->db->query($sqlIni)->result());
                if ($session != "false"){
                    $result = $session->query($sql);
                    if ($result->num_rows > 0) {
                        $i = 0;
                        while($row = $result->fetch_assoc()) {
                          //CREAMOS EL OBJETO Y LE AÑADIMOS SUS RESPECTIVAS ACTIVIDADES
                          $order = new order_model;
                          $order->createOrder($row['K_IDORDER'], $row['N_NAME'], $row['D_DATE_CREATION']);
                          $order->setLink($row['N_DRIVE']);
                          
                          $sercicios = $this->dao_service_model->getServiceByIdOrder($row['K_IDORDER']);
                          $order->services = $sercicios; 
                          $answer[$i] = $order;
                          $i++;
                        }
                    }
                }
              }

          return [
              "services" => $answer,
              "count" => $count
            ];
          // }
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
