<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SpecialServices extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('data/configdb_model');
    $this->load->model('data/dao_service_model');
    $this->load->model('service_spec_model');
    $this->load->model('order_model');
    $this->load->model('data/Dao_service_model');
  }
  //funcion que retorna todas las actividades no ejecutadas ni canceladas
  //para el control de tiempo de envio de evidencias dependiendo el tipo de trabajo
  public function getProximas(){
    // header('Content-Type: text/plain');
      //trae todas las actividades != ejecutado o cancelado y que tengan null link1 o link2
      $all = $this->dao_service_model->getAllProximas();
      
          //creo los arreglo proximas, hoy y vencidas q voy a llenar al final segun validacion
          $respuesta['proximas'] = []; $respuesta['hoy'] = []; $respuesta['vencidas'] = [];
    
      foreach ($all as $value) {
          // Creé la fecha envio 1 y fecha envio 2 que son la fechas limites para enviar evidencias
          // fecha de envio 1 y 2 es = fecha asignacion + los dias depende el tipo
          $value->fEnvio1 = "";
          $value->fEnvio2 = "";
          // tipo T4 son 4 dias en f1 y 7 en f2
          if ($value->tipo == "T4") {
            //uso funcion para sumarle dias a una fecha añado 4 dias a la fecha de asignacion y 7 a Fenvio2
            $value->fEnvio1 = $this->sumarORestarDiasAFecha($value->asignacion, 4, '+');
            $value->fEnvio2 = $this->sumarORestarDiasAFecha($value->asignacion, 7, '+');

            //valida si es sabado o domingo, si lo es, retorna proximo lunes
            $value->fEnvio1 = $this->habilPostFinSemana($value->fEnvio1);
            $value->fEnvio2 = $this->habilPostFinSemana($value->fEnvio2);

            //si es festivo retorno el siguiente dia habil de fenvio1
            $value->fEnvio1 = $this->habilPostFestivo($value->fEnvio1);
            //si es festivo retorno el siguiente dia habil de fenvio2
            $value->fEnvio2 = $this->habilPostFestivo($value->fEnvio2);

          }

          //tipo C1 y C" son 3 dias en f1 y 7 en f2
          else if ($value->tipo == "C1" || $value->tipo == "C2") {
            $value->fEnvio1 = $this->sumarORestarDiasAFecha($value->asignacion, 3, '+');
            $value->fEnvio2 = $this->sumarORestarDiasAFecha($value->asignacion, 7, '+');

            $value->fEnvio1 = $this->habilPostFinSemana($value->fEnvio1);
            $value->fEnvio2 = $this->habilPostFinSemana($value->fEnvio2);

            $value->fEnvio1 = $this->habilPostFestivo($value->fEnvio1);
            $value->fEnvio2 = $this->habilPostFestivo($value->fEnvio2);
          }

          //tipo c3 t1 t2 t3 t6 son 2 dias en f1 y 7 en f2
          else if ($value->tipo == "C3" || $value->tipo == "T1" || $value->tipo == "T2" || $value->tipo == "T3" || $value->tipo == "T6") {
            $value->fEnvio1 = $this->sumarORestarDiasAFecha($value->asignacion, 2, '+');
            $value->fEnvio2 = $this->sumarORestarDiasAFecha($value->asignacion, 7, '+');

            $value->fEnvio1 = $this->habilPostFinSemana($value->fEnvio1);
            $value->fEnvio2 = $this->habilPostFinSemana($value->fEnvio2);

            $value->fEnvio1 = $this->habilPostFestivo($value->fEnvio1);
            $value->fEnvio2 = $this->habilPostFestivo($value->fEnvio2);
          }

          // tipo t5  son 1 dia en F1 y 2 en F2
          else if ($value->tipo == "T5") {
            $value->fEnvio1 = $this->sumarORestarDiasAFecha($value->asignacion, 1, '+');
            $value->fEnvio2 = $this->sumarORestarDiasAFecha($value->asignacion, 2, '+');

            $value->fEnvio1 = $this->habilPostFinSemana($value->fEnvio1);
            $value->fEnvio2 = $this->habilPostFinSemana($value->fEnvio2);

            $value->fEnvio1 = $this->habilPostFestivo($value->fEnvio1);
            $value->fEnvio2 = $this->habilPostFestivo($value->fEnvio2);
          }
          // seteamos la fecha local
          date_default_timezone_set("America/Bogota");
          $fActual = date('Y-m-d');
          // creamos fecha ayer con respecto  a la actual
          $fMañana = $this->sumarORestarDiasAFecha($fActual, 1, '+');


          //comparo si las fechas de envio son igual a ayer para llenar arreglo proximas
          if ($value->fEnvio1 == $fMañana || $value->fEnvio2 == $fMañana) {
            array_push($respuesta['proximas'], $value);
          }
          //comparo si las fechas de envio son igual a fecha actual para llenar arreglo hoy
          if ($value->fEnvio1 == $fActual || $value->fEnvio2 == $fActual) {
            array_push($respuesta['hoy'], $value);
          }
          //comparo si las fechas de envio son mayor a fecha actual para llenar arreglo vencidas
          if ($fActual > $value->fEnvio1 || $fActual > $value->fEnvio2) {
            array_push($respuesta['vencidas'], $value);
            // echo "string";
            // print_r($value->fEnvio1);
          }

      }

      echo json_encode($respuesta);
  }
  //Funcion para sumar o restar dias a una fecha dada
  public function sumarORestarDiasAFecha($fechaBase, $dias, $operador){
    if ($operador == '+') {
      $operacion = 'add';
    }else {
      $operacion = 'sub';
    }
      $fecha = new DateTime($fechaBase);
      $fecha->$operacion(new DateInterval('P'.$dias.'D'));
      return $fecha->format('Y-m-d');
  }



  // Funcion para validar una fecha es sabado o domingo, si lo es retorna siguiente lunes
  public function habilPostFinSemana($fecha){
    $fecha = new DateTime($fecha);
    //cambio formato para obtener el dia de la semana y compararlo
    switch ($fecha->format('D')) {
      // si es sabado le sumo dos dias
      case 'Sat':
        $fecha = $this->sumarORestarDiasAFecha($fecha->format('Y-m-d'), 2, '+');
        $fecha = new DateTime($fecha);
        break;
      //si es domingo sumo un dia
      case 'Sun':
        $fecha = $this->sumarORestarDiasAFecha($fecha->format('Y-m-d'), 1, '+');
        $fecha = new DateTime($fecha);
        break;
    }
    return $fecha->format('Y-m-d');
  }

  // Funcion para validar si una fecha es festivo
  public function validarFestivo($fecha){
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
  // si es festivo retorna proxima fecha habil
  public function habilPostFestivo($fecha){    
      //valido si la fecha  es festivo, si lo es, retorna 1 sino 0
      $festivo = $this->validarFestivo($fecha);
      //si retorno 1 (festivo) le sumo 1 y la vuelvo a comparar
      if ($festivo == 1) {
        return $this->habilPostFestivo($this->sumarORestarDiasAFecha($fecha, 1, '+'));
      // si es 0 retorna la fecha
      } else {
        return $fecha;
      }
  }
  



}
?>