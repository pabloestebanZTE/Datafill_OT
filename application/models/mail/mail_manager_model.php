<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Mail_manager_model extends CI_Model{

        public function __construct(){
            $this->load->model('data/configdb_model');
            $this->load->model('order_model');
        }

      	public function mailAssign($engs){
      		header('Content-Type: text/plain');
      		print_r($engs[3]);
      		$engC = $_SESSION['excel'][0][2][1];
      		$engC = "Johann Orozco";
      		print_r((explode(" ", $engC)));
      		
      		for ($i=0; $i <count($engs) ; $i++) { 
      			
	      		if ((explode(" ", $engC))[0] == explode(" ", $engs[$i]->getName())[0]) {
	      			echo "\nprimer filtro";
	      			if (explode(" ", $engs[$i]->getLastname())[0] == explode(" ", $engC)[1] || explode(" ", $engs[$i]->getLastname())[0] == explode(" ", $engC)[2] || explode(" ", $engs[$i]->getLastname())[0] == explode(" ", $engC)[3]) {
	      				echo "\nsegundo filtro\n";
	      				$mailEngC = $engs[$i]->getMail();
	      				echo $mailEngC;
	      			}
	      		} 
      		}

      	
      		
      		//print_r((explode(" ", $e)));

      	

				/*
       	 		$destinatario = "bredybuitrago@gmail.com,pablo.esteban@zte.com.cn"; 
                $asunto = "Este mensaje es de prueba"; 
                $hearder = 'MIME-Version: 1.0' . "\r\n";
                $hearder .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $hearder .= "From: desarrolladores_ZTE";
                $cuerpo = "
                <html> 
                <head> 
                   <title>Prueba de correo</title> 
                </head> 
                <body> 
                <h1>Hola prueba</h1> 
                <p> 
                <b>Este es el correo  electrónico de prueba</b>. Esta es una prueba de envio de correo . Este es el cuerpo del mensaje, es una prueba sin envio de ninguna variable y pruebo enviando a dos destinatarios, ya no se que mas escrbirle al cuerpo para quede mas largo y lo pueda visualizar mejor.
                </p> 
                </body> 
                </html> 
                "; 
                echo "<br><br><br>";
                echo "correo enviado";
                mail($destinatario,$asunto,$cuerpo,$hearder);*/
       }
    }
?>

