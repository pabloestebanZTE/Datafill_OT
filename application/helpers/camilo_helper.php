<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


    //Nos aseguramos de que no haya conflictos con otras funciones
    if(!function_exists('comparationsNames')){
    	// Funcion que compara dos nombres por lo general de fuentes distintas que humanamente es facil
    	// Pero computacional es mas complejo por temas de mayusculas y cambios ortograficos o segundo 
    	// nombre omitido. Ejemplo comparar nombres de un excel con relacion con nombres de db
    	// recibe 2 parametros, un array con los nombres deseados... por lo general de db y el nombre a comparar
    	// Retorna "false" si no encontro similitud importante o retorna el nombre del array 
    	// con el que hay mayor similitud
    	// IMPORTANTE.. PASAR NOMBREBASE CON MINIMO DOS PALABRAS
        function comparationsNames($arrayNames, $nameBase){
        		// Declaracion de variables a usar
	        	$pLastname1 = 0;
	        	$pLastname2 = 0;
	        	$pLastname3 = 0;
	        	$nameResult = "false";
	        	$contador = 0;
	        	$similares= [];
	        	// secciono en partes el nombre base para comparacion
	        	$name = explode(" ", $nameBase);
	        	// ciclo hasta la cantidad de nombres q existe en el array
	        	for ($i=0; $i < count($arrayNames) ; $i++) { 
	        		//comparo su nombre Base con el primer y segundo nombre del nombre del array
	        		similar_text(explode(" ", $arrayNames[$i])[0] , $name[0], $percentName);
	        		similar_text(explode(" ", $arrayNames[$i])[1] , $name[0], $percentSecontName);
	        		//si la similitud es mayor al 70%
	        		if ($percentName > 70 || $percentSecontName > 70) {
	        			//Si apellido del nombre de su array existe
	        			if (explode(" ", $arrayNames[$i])[2]) {
	        				similar_text(explode(" ", $arrayNames[$i])[2], $name[1], $pLastname1);
		   		    		similar_text(explode(" ", $arrayNames[$i])[2] ,$name[2], $pLastname2);
   							similar_text(explode(" ", $arrayNames[$i])[2] , $name[3], $pLastname3);
	        			}
	        			// si segundo apellido existe
	        			if (explode(" ", $arrayNames[$i])[3]) {
	        				similar_text(explode(" ", $arrayNames[$i])[3], $name[1], $pLastname1B);
		   		    		similar_text(explode(" ", $arrayNames[$i])[3] ,$name[2], $pLastname2B);
   							similar_text(explode(" ", $arrayNames[$i])[3] , $name[3], $pLastname3B);
	        			}		       
	        			// si en alguna de las comparaciones con respecto al nombrebase es mayor al 69%
				         if ($pLastname1 > 69 || $pLastname2 > 69 || $pLastname3 > 69 || $pLastname1B > 69 || $pLastname2B > 69 || $pLastname3B > 69) {
				         	//lo capturo en una variables y lo agrego a arreglo de similares	
				           $nameResult = $arrayNames[$i];
				           array_push($similares, $nameResult);
				           //uso el contador por si hay mas de un registro q cumple las condiciones
				           $contador++;
				         }
				    		  
	        		}
	            }
	            //si hay mas de 1 registro que cumple....
	            if ($contador > 1) {
	            	// ciclo hasta la cantidad de registros que cumple...
	            	for ($j=0; $j < count($similares) ; $j++) {
	            		// los comparo directamente con el nombre base completo sin seccionarlo y 
	            		// guardo la similitud en una variable
	            		$sim[$j] = similar_text($nameBase, $similares[$j]);
	            	}
	            	//retorno el nombre que tubo mayor similitud con respecto al nombre base
	            	return $similares[array_keys($sim, max($sim))[0]];
	            } 
	            // si solo hay una similitud que cumple (contador = 1) retorno ese nombre
	            // si no hay ninguna similitud que cumpla retorna "false"
	            return $nameResult;
	            
  		}
    }
    

    if(!function_exists('sumarORestarDiasAFecha')){
		    //Funcion para sumar o restar dias a una fecha dada
    		//recibe 3 parametros; la fecha, los dias a sumar o restar, y el operador "+" o "-"
    		//Retorna la fecha exacta con los dias sumados o restados
		  function sumarORestarDiasAFecha($fechaBase, $dias, $operador){
		    if ($operador == '+') {
		      $operacion = 'add';
		    }else {
		      $operacion = 'sub';
		    }
		      $fecha = new DateTime($fechaBase);
		      $fecha->$operacion(new DateInterval('P'.$dias.'D'));
		      return $fecha->format('Y-m-d');
		  }
    	
    }

    if(!function_exists('sumarORestarDiasAFecha')){
		    //Funcion para sumar o restar dias a una fecha dada
    		//recibe 3 parametros; la fecha, los dias a sumar o restar, y el operador "+" o "-"
    		//Retorna la fecha exacta con los dias sumados o restados
		  function sumarORestarDiasAFecha($fechaBase, $dias, $operador){
		    if ($operador == '+') {
		      $operacion = 'add';
		    }else {
		      $operacion = 'sub';
		    }
		      $fecha = new DateTime($fechaBase);
		      $fecha->$operacion(new DateInterval('P'.$dias.'D'));
		      return $fecha->format('Y-m-d');
		  }
    	
    }

    if(!function_exists('habilPostFinSemana')){
		    //Funcion para validar si una fecha es sabado o domingo
    		//recibe 1 parametro; la fecha a calvular
    		//Retorna la fecha del lunes proximo
		  function habilPostFinSemana($fecha){
		    $fecha = new DateTime($fecha);
		    //cambio formato para obtener el dia de la semana y compararlo
		    switch ($fecha->format('D')) {
		      // si es sabado le sumo dos dias
		      case 'Sat':
		        $fecha = sumarORestarDiasAFecha($fecha->format('Y-m-d'), 2, '+');
		        $fecha = new DateTime($fecha);
		        break;
		      //si es domingo sumo un dia
		      case 'Sun':
		        $fecha = sumarORestarDiasAFecha($fecha->format('Y-m-d'), 1, '+');
		        $fecha = new DateTime($fecha);
		        break;
		    }
		    return $fecha->format('Y-m-d');
		  }
    	
    }

    if(!function_exists('validarFestivo')){
		    //Funcion para validar si una fecha es Festivo
    		//recibe 1 parametro; la fecha a calcular
    		//Retorna '1' si es festivo o '0' si no lo es 
			function validarFestivo($fecha){
				$festivos = array(
				          '2018-01-01' => '2018-01-01',// Año Nuevo
				          '2018-01-08' => '2018-01-08',// Reyes magos
				          '2018-03-19' => '2018-03-19',// San jose
				          '2018-03-29' => '2018-03-29',// Jueves santo(semana santa)
				          '2018-03-30' => '2018-03-30',// Viernes santo(semana santa)
				          '2018-05-01' => '2018-05-01',// Dia del trabajo
				          '2018-05-14' => '2018-05-14',// Dia de la ascencion
				          '2018-06-04' => '2018-06-04',// Corpus Christi
				          '2018-06-11' => '2018-06-11',// Sagrado corazon
				          '2018-07-02' => '2018-07-02',// San pedro y san Pablo
				          '2018-07-20' => '2018-07-20',// Dia de la Independencia
				          '2018-08-07' => '2018-08-07',// Batalla de Boyaca
				          '2018-08-20' => '2018-08-20',// La Asuncion de la Virgen
				          '2018-10-15' => '2018-10-15',// Dia de la Raza
				          '2018-11-05' => '2018-11-05',// Dia de todos los santos
				          '2018-11-12' => '2018-11-12',// Independencia de Cartagena
				          '2018-12-08' => '2018-12-08',// Dia de la inmaculada concepcion
				          '2018-12-25' => '2018-12-25',// Navidad
				          //2019
				          '2019-01-01' => '2019-01-01',// Año Nuevo
				          '2019-01-07' => '2019-01-07',// Reyes magos
				          '2019-03-25' => '2019-03-25',//
				        );
				if ($festivos[$fecha]) {
				return 1;
				} else {
				return 0;
				}
 			}
    	
    }

    if(!function_exists('habilPostFestivo')){
		    //Funcion para dar proxima fecha habil si la fecha dada es festivo
    		//recibe 1 parametro; la fecha a calcular
    		//Retorna la proxima fecha habil proxima si es festivo
		function habilPostFestivo($fecha){
		    //valido si la fecha  es festivo, si lo es, retorna 1 sino 0
			$festivo = validarFestivo($fecha);
			//si retorno 1 (festivo) le sumo 1 y la vuelvo a comparar
			if ($festivo == 1) {
			return habilPostFestivo(sumarORestarDiasAFecha($fecha, 1, '+'));
			// si es 0 retorna la fecha
			} else {
			return $fecha;
			}
  		}
    	
    }










?>