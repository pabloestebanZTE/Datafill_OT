<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class dao_rf_model extends CI_Model{

        public function __construct(){
            $this->load->model('data/configdb_model');
            $this->load->model('rf_model');
        }

        public function updateRF($rf){
            //print_r($rf);

        	$dbConnection = new configdb_model();
            $session = $dbConnection->openSession();
            $sql ="SELECT * FROM rf WHERE N_ID = '".$rf->getId()."';";
            if ($session != "false"){
            	$result = $session->query($sql); //Se hace la consulta a la base de datos, puede venir vacio
             	if ($result->num_rows > 0) {
             		//SI EXITSTE
             		$row = $result->fetch_assoc(); //Esto es un arreglo que viene de la BD
             		$oldRF = new rf_model;
             		//$up->createRF($_ROW[''], ,,,,,,)






             		if($rf->dateRequest() != $oldRF->dateRequest()){
             			$sqlN = "UPDATE rf SET D_DATE_S = ".$rf->dateRequest().";";
             			$session->query($sqlN);
             			$flag = 1;
             		}

             		// Y ASI CON TODOS

             		if($flag == 0){
             			//PINTA DE BLANCO
             		} else {
             			//CAMBIA DE COLOR

             		}

             	} else {
             		//SI NO EXISTE
             		$sql2 = "INSERT INTO rf (D_DATE_S, N_REQUESTED_BY, N_STATUS, N_TYPE, N_ELEMENT, D_DATE_ASSGINED, K_ASSIGNED_TO, D_DATE_SENT, N_FILE, N_OBSERVATIONS, N_MODULE, N_ID, N_REMEDY, N_ORDER_W, D_BILL, N_MONTH_B, D_RAW, D_REVIEW, D_OTGDRT, N_idBSS, N_CODE, N_COLOR) values ( STR_TO_DATE('".$rf->getDateRequested()."', '%m-%d-%Y'), '".$rf->getRequestedBy()."', '".$rf->getStatus()."', '".$rf->getType()."', '".$rf->getElement()."',  STR_TO_DATE('".$rf->getDateAssigned()."', '%m-%d-%Y'), '".$rf->getAssignedTo()."', STR_TO_DATE('".$rf->getDateSent()."', '%m-%d-%Y'), '".$rf->getFile()."', '".$rf->getObs()."', '".$rf->getModule()."', '".$rf->getId()."', '".$rf->getRemedy()."', '".$rf->getWeightOrder()."', STR_TO_DATE('".$rf->getDateBilling()."', '%m-%d-%Y'), '".$rf->getMonthBilling()."', STR_TO_DATE('".$rf->getDateRaw()."', '%m-%d-%Y'), STR_TO_DATE('".$rf->getDateReview()."', '%m-%d-%Y'), STR_TO_DATE('".$rf->getDateOTGDRT()."', '%m-%d-%Y'), '".$rf->getIdBSS()."', '".$rf->getCode()."', '#20c000');"; 
             	}
             	//echo "<br><br>".$sql2;



            } else {
              $answer = "Error de informacion";
             }
        }//$rf->getDateRequested()


        

        
    }
?>
