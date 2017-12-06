<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class dao_rf_model extends CI_Model{

        public function __construct(){
            $this->load->model('data/configdb_model');
            $this->load->model('rf_model');
        }

        public function updateRF($rf){
        	$dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql ="SELECT * FROM rf WHERE N_ID = '".$rf->getId()."';";
            if ($session != "false"){
            	$result = $session->query($sql); //Se hace la consulta a la base de datos, puede venir vacio
             	if ($result->num_rows > 0) {
             		//SI EXITSTE
             		$row = $result->fetch_assoc(); //Esto es un arreglo que viene de la BD
                //creacion objeto con datos de bd "antiguo rf"
             		$oldRF = new rf_model;
             		$oldRF->createRF("", $row['D_DATE_S'], $row['N_REQUESTED_BY'], $row['N_STATUS'], $row['N_TYPE'], $row['N_ELEMENT'], $row['D_DATE_ASSGINED'], $row['K_ASSIGNED_TO'], $row['D_DATE_SENT'], $row['N_FILE'], $row['N_OBSERVATIONS'], $row['N_MODULE'], $row['N_ID'], $row['N_REMEDY'], $row['N_ORDER_W'], $row['D_BILL'], $row['N_MONTH_B'], $row['D_REVIEW'], $row['D_RAW'], $row['D_OTGDRT'], $row['N_idBSS'], $row['N_CODE']);
                $oldRF->setColor($row['N_COLOR']);
                //fin creacion objeto
                $flag = 0;
                //comparacion campo x campo rf con bd
             		if($rf->getDateRequested() != $oldRF->getDateRequested()){
             			$flag = 1;
             		}
                if($rf->getRequestedBy() != $oldRF->getRequestedBy()){
             			$flag = 1;
             		}
                if($rf->getStatus() != $oldRF->getStatus()){
             			$flag = 1;
             		}
                if($rf->getType() != $oldRF->getType()){
             			$flag = 1;
             		}
                if($rf->getElement() != $oldRF->getElement()){
             			$flag = 1;
             		}
                if($rf->getDateAssigned() != $oldRF->getDateAssigned()){
             			$flag = 1;
             		}
                if($rf->getAssignedTo() != $oldRF->getAssignedTo()){
             			$flag = 1;
             		}
                if($rf->getDateSent() != $oldRF->getDateSent()){
             			$flag = 1;
             		}
                if($rf->getFile() != $oldRF->getFile()){
             			$flag = 1;
             		}
                if($rf->getObs() != $oldRF->getObs()){
             			$flag = 1;
             		}
                if($rf->getModule() != $oldRF->getModule()){
             			$flag = 1;
             		}
                if($rf->getId() != $oldRF->getId()){
             			$flag = 1;
             		}
                if($rf->getRemedy() != $oldRF->getRemedy()){
             			$flag = 1;
             		}
                if($rf->getWeightOrder() != $oldRF->getWeightOrder()){
             			$flag = 1;
             		}
                if($rf->getDateBilling() != $oldRF->getDateBilling()){
             			$flag = 1;
             		}
                if($rf->getMonthBilling() != $oldRF->getMonthBilling()){
             			$flag = 1;
             		}
                if($rf->getDateReview() != $oldRF->getDateReview()){
             			$flag = 1;
             		}
                if($rf->getDateRaw() != $oldRF->getDateRaw()){
             			$flag = 1;
             		}
                if($rf->getDateOTGDRT() != $oldRF->getDateOTGDRT()){
             			$flag = 1;
             		}
                if($rf->getIdBSS() != $oldRF->getIdBSS()){
             			$flag = 1;
             		}
                if($rf->getCode() != $oldRF->getCode()){
             			$sqlN = "UPDATE rf SET N_CODE = '".$rf->getCode()."' WHERE N_ID = '".$rf->getId()."';";
             			$session->query($sqlN);
             			$flag = 1;
             		}
                //----------fin comparacion-------------------
                //-------------cambio de color---------------------------
               		if($flag == 0){
                    if ($oldRF->getColor() != '#aaaaaa') {
                    $sqlC = "UPDATE rf SET N_COLOR = '#aaaaaa'  WHERE N_ID = '".$rf->getId()."';";
                    $session->query($sqlC);
                    }
               		} else {
                    $sqlC = "UPDATE rf SET N_COLOR = '#e87408'  WHERE N_ID = '".$rf->getId()."';";
                    $session->query($sqlC);
                //-----fin cambio de color------------
                //-----------insercion filas modificadas-----------
                    $sql3 = "UPDATE rf SET D_DATE_S = STR_TO_DATE('".$rf->getDateRequested()."', '%Y-%m-%d'),
                    					   N_REQUESTED_BY = '".$rf->getRequestedBy()."',
                    					   N_STATUS = '".$rf->getStatus()."',
                    					   N_TYPE = '".$rf->getType()."',
                    					   N_ELEMENT = '".$rf->getElement()."',
                    					   D_DATE_ASSGINED = STR_TO_DATE('".$rf->getDateAssigned()."', '%Y-%m-%d'),
                    					   D_DATE_SENT = STR_TO_DATE('".$rf->getDateSent()."', '%Y-%m-%d'),
                    					   N_FILE = '".$rf->getFile()."',
                    					   N_OBSERVATIONS = '".$rf->getObs()."',
                    					   N_MODULE = '".$rf->getModule()."',
                    					   N_REMEDY = '".$rf->getRemedy()."',
                    					   N_ORDER_W = '".$rf->getWeightOrder()."',
                    					   D_BILL = STR_TO_DATE('".$rf->getDateBilling()."', '%Y-%m-%d'),
                    					   N_MONTH_B = '".$rf->getMonthBilling()."',
                    					   D_RAW = STR_TO_DATE('".$rf->getDateRaw()."', '%Y-%m-%d'),
                    					   D_REVIEW = STR_TO_DATE('".$rf->getDateReview()."', '%Y-%m-%d'),
                    					   D_OTGDRT = STR_TO_DATE('".$rf->getDateOTGDRT()."', '%Y-%m-%d'),
                    					   N_idBSS = '".$rf->getIdBSS()."',
                    					   N_CODE = '".$rf->getCode()."' WHERE N_ID = '".$oldRF->getId()."';";
                                 $session->query($sql3);                    }
             	} else {//SI NO EXISTE

                    if ($rf->getAssignedTo() == ""){
                      $sql2 = "INSERT INTO rf (D_DATE_S, N_REQUESTED_BY, N_STATUS, N_TYPE, N_ELEMENT, D_DATE_ASSGINED, D_DATE_SENT, N_FILE, N_OBSERVATIONS, N_MODULE, N_ID, N_REMEDY, N_ORDER_W, D_BILL, N_MONTH_B, D_RAW, D_REVIEW, D_OTGDRT, N_idBSS, N_CODE, N_COLOR) values ( STR_TO_DATE('".$rf->getDateRequested()."', '%Y-%m-%d'), '".$rf->getRequestedBy()."', '".$rf->getStatus()."', '".$rf->getType()."', '".$rf->getElement()."',  STR_TO_DATE('".$rf->getDateAssigned()."', '%Y-%m-%d'), STR_TO_DATE('".$rf->getDateSent()."', '%Y-%m-%d'), '".$rf->getFile()."', '".$rf->getObs()."', '".$rf->getModule()."', '".$rf->getId()."', '".$rf->getRemedy()."', '".$rf->getWeightOrder()."', STR_TO_DATE('".$rf->getDateBilling()."', '%Y-%m-%d'), '".$rf->getMonthBilling()."', STR_TO_DATE('".$rf->getDateRaw()."', '%Y-%m-%d'), STR_TO_DATE('".$rf->getDateReview()."', '%Y-%m-%d'), STR_TO_DATE('".$rf->getDateOTGDRT()."', '%Y-%m-%d'), '".$rf->getIdBSS()."', '".$rf->getCode()."', '#20c000');";
                      $session->query($sql2);
                    } else {

                     		$sql2 = "INSERT INTO rf (D_DATE_S, N_REQUESTED_BY, N_STATUS, N_TYPE, N_ELEMENT, D_DATE_ASSGINED, K_ASSIGNED_TO, D_DATE_SENT, N_FILE, N_OBSERVATIONS, N_MODULE, N_ID, N_REMEDY, N_ORDER_W, D_BILL, N_MONTH_B, D_RAW, D_REVIEW, D_OTGDRT, N_idBSS, N_CODE, N_COLOR) values ( STR_TO_DATE('".$rf->getDateRequested()."', '%Y-%m-%d'), '".$rf->getRequestedBy()."', '".$rf->getStatus()."', '".$rf->getType()."', '".$rf->getElement()."',  STR_TO_DATE('".$rf->getDateAssigned()."', '%Y-%m-%d'), '".$rf->getAssignedTo()."', STR_TO_DATE('".$rf->getDateSent()."', '%Y-%m-%d'), '".$rf->getFile()."', '".$rf->getObs()."', '".$rf->getModule()."', '".$rf->getId()."', '".$rf->getRemedy()."', '".$rf->getWeightOrder()."', STR_TO_DATE('".$rf->getDateBilling()."', '%Y-%m-%d'), '".$rf->getMonthBilling()."', STR_TO_DATE('".$rf->getDateRaw()."', '%Y-%m-%d'), STR_TO_DATE('".$rf->getDateReview()."', '%Y-%m-%d'), STR_TO_DATE('".$rf->getDateOTGDRT()."', '%Y-%m-%d'), '".$rf->getIdBSS()."', '".$rf->getCode()."', '#20c000');";
                        $session->query($sql2);
                      }
             	}
            } else {
              $answer = "Error de informacion";
              }
        }

        public function getAllRF(){
          $dbConnection = new configdb_model();
          $session = $dbConnection->openSession();
          $sql = "SELECT * FROM rf;";
          if ($session != "false"){
            $result = $session->query($sql);
            if ($result->num_rows > 0) {
              $i = 0;
              while($row = $result->fetch_assoc()) {
                $rf = new rf_model;
                $rf->createRF($row['K_ID_RF'], $row['D_DATE_S'], $row['N_REQUESTED_BY'], $row['N_STATUS'], $row['N_TYPE'], $row['N_ELEMEN'], $row['D_DATE_ASSGINED'], $row['K_ASSIGNED_TO'], $row['D_DATE_SENT'], $row['N_FILE'], $row['N_OBSERVATIONS'], $row['N_MODULE'], $row['N_ID'], $row['N_REMEDY'], $row['N_ORDER_W'], $row['D_BILL'], $row['N_MONTH_B'], $row['D_REVIEW'], $row['D_RAW'], $row['D_OTGDRT'], $row['N_idBSS'], $row['N_CODE']);
                $rf->setColor($row['N_COLOR']);
                $answer[$i] = $rf;
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
