<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Grafics extends CI_Controller {

      function __construct() {
        parent::__construct();
        $this->load->model('data/configdb_model');
        $this->load->model('data/Dao_service_model');
        // $this->load->model('data/Dao_report_model');
      }

      public function getGrafics(){
      	 $this->load->view('grafics');

      }
      //*****************parametros para mostrar primera grafica*****************
      public function getParams() {
        header('Content-Type: text/plain');
        $param = $this->dao_service_model->getCatMonthStatusTotal();
        $param['mesesTrab'] = [];
        $param['Asignadas'] = [];
        $param['canceladas'] = [];
        $param['enviadas'] = [];
        $param['ejecutadas'] = [];

         for ($i = 0; $i < count($param)-1 ; $i++) {
           $param['mesesTrab'][$param[$i]->meses] = $param[$i]->meses;
           $param['Asignadas'][$param[$i]->meses] = 0;
           $param['canceladas'][$param[$i]->meses] = 0;
           $param['enviadas'][$param[$i]->meses] = 0;
           $param['ejecutadas'][$param[$i]->meses] = 0;
        }       
        
        $param['mesesTrab'] = array_unique($param['mesesTrab']);
        
        for ($i = 0; $i < count($param)-1 ; $i++) {
            if($param[$i]->estado == "Asignada" &&  $param['mesesTrab'][$param[$i]->meses] == $param[$i]->meses){
                $param['Asignadas'][$param[$i]->meses] = $param[$i]->cantidad;
            }      
            if($param[$i]->estado == "Cancelado" &&  $param['mesesTrab'][$param[$i]->meses] == $param[$i]->meses){
                $param['canceladas'][$param[$i]->meses] = $param[$i]->cantidad;
            }
            if($param[$i]->estado == "Enviado" &&  $param['mesesTrab'][$param[$i]->meses] == $param[$i]->meses){
                $param['enviadas'][$param[$i]->meses] = $param[$i]->cantidad;
            }
            if($param[$i]->estado == "Ejecutado" &&  $param['mesesTrab'][$param[$i]->meses] == $param[$i]->meses){
                $param['ejecutadas'][$param[$i]->meses] = $param[$i]->cantidad;
            }
          
        }
        $mes = [];
        $respuesta['meses'] = [];
        $respuesta['asignadas'] = [];
        $respuesta['canceladas'] = [];
        $respuesta['enviadas'] = [];
        $respuesta['ejecutadas'] = [];

        foreach ($param['mesesTrab'] as $key => $value) {
          if ($key != 0 || $key != "") {
             array_push($mes, $value);
          }
        }
        foreach ($param['Asignadas'] as $key => $value) {
          if ($key != 0 || $key != "") {
             array_push($respuesta['asignadas'], $value);
          }
        }
        foreach ($param['canceladas'] as $key => $value) {
          if ($key != 0 || $key != "") {
             array_push($respuesta['canceladas'], $value);
          }
        }
        foreach ($param['enviadas'] as $key => $value) {
          if ($key != 0 || $key != "") {
             array_push($respuesta['enviadas'], $value);
          }
        }
        foreach ($param['ejecutadas'] as $key => $value) {
          if ($key != 0 || $key != "") {
             array_push($respuesta['ejecutadas'], $value);
          }
        }


        $meses = ["", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
           $indice = 0;
           for ($i=0; $i < count($mes) ; $i++) { 
             $indice = substr($mes[$i], -2);
             array_push($respuesta['meses'], $meses[intval($indice)]);
           }
        
       echo json_encode($respuesta);
    }


    //*************** Parametros para pintar diagramas por mes***************
    public function getParamsMonth(){
      header('Content-Type: text/plain');
      //capturo el mes al que le dio clic
      $mes = $this->input->post("mes");
      //arreglo para capturar el indice del mes
       $meses = ["", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
       //devuelve el indice del mes seleccionado
       $indiceMes = array_keys($meses, $mes)[0];       
       $param = $this->dao_service_model->getParamsBymonth($indiceMes);
       $response['asignadas'] = [];
       $response['canceladas'] = [];
       $response['enviadas'] = [];
       $response['ejecutadas'] = [];
       $response['tipo'] = [];
       //creo el objeto y le asigno a cada campo el valor 0
       for ($i = 0; $i <= 8 ; $i++) {
          $respuesta[$i]['asignadas']=0;
          $respuesta[$i]['canceladas']=0;
          $respuesta[$i]['enviadas']=0;
          $respuesta[$i]['ejecutadas']=0;
        }
        // lleno los campos, si no hay valor sigue predeterminado el valor 0
        for ($i=0; $i < count($param) ; $i++) { 

          array_push($response['tipo'], $param[$i]->tipo);
          //asignadas c1
          if($param[$i]->estado == 'Asignada' && $param[$i]->tipo == 'C1' ){
            $respuesta[0]['asignadas']=$param[$i]->cantidad;
          }
          //canceladas c1
          if($param[$i]->estado == 'Cancelado' && $param[$i]->tipo == 'C1' ){
            $respuesta[0]['canceladas']=$param[$i]->cantidad;
          }
          //enviadas c1
          if($param[$i]->estado == 'Enviado' && $param[$i]->tipo == 'C1' ){
            $respuesta[0]['enviadas']=$param[$i]->cantidad;
          }
          //ejecutadas c1
          if($param[$i]->estado == 'Ejecutado' && $param[$i]->tipo == 'C1' ){
            $respuesta[0]['ejecutadas']=$param[$i]->cantidad;
          }

          //asignadas c2
          if($param[$i]->estado == 'Asignada' && $param[$i]->tipo == 'C2' ){
            $respuesta[1]['asignadas']=$param[$i]->cantidad;
          }
          //canceladas C2
          if($param[$i]->estado == 'Cancelado' && $param[$i]->tipo == 'C2' ){
            $respuesta[1]['canceladas']=$param[$i]->cantidad;
          }
          //enviadas C2
          if($param[$i]->estado == 'Enviado' && $param[$i]->tipo == 'C2' ){
            $respuesta[1]['enviadas']=$param[$i]->cantidad;
          }
          //ejecutadas C2
          if($param[$i]->estado == 'Ejecutado' && $param[$i]->tipo == 'C2' ){
            $respuesta[1]['ejecutadas']=$param[$i]->cantidad;
          }


          //asignadas C3
          if($param[$i]->estado == 'Asignada' && $param[$i]->tipo == 'C3' ){
            $respuesta[2]['asignadas']=$param[$i]->cantidad;
          }
          //canceladas C3
          if($param[$i]->estado == 'Cancelado' && $param[$i]->tipo == 'C3' ){
            $respuesta[2]['canceladas']=$param[$i]->cantidad;
          }
          //enviadas C3
          if($param[$i]->estado == 'Enviado' && $param[$i]->tipo == 'C3' ){
            $respuesta[2]['enviadas']=$param[$i]->cantidad;
          }
          //ejecutadas C3
          if($param[$i]->estado == 'Ejecutado' && $param[$i]->tipo == 'C3' ){
            $respuesta[2]['ejecutadas']=$param[$i]->cantidad;
          }


          //asignadas T1
          if($param[$i]->estado == 'Asignada' && $param[$i]->tipo == 'T1' ){
            $respuesta[3]['asignadas']=$param[$i]->cantidad;
          }
          //canceladas T1
          if($param[$i]->estado == 'Cancelado' && $param[$i]->tipo == 'T1' ){
            $respuesta[3]['canceladas']=$param[$i]->cantidad;
          }
          //enviadas T1
          if($param[$i]->estado == 'Enviado' && $param[$i]->tipo == 'T1' ){
            $respuesta[3]['enviadas']=$param[$i]->cantidad;
          }
          //ejecutadas T1
          if($param[$i]->estado == 'Ejecutado' && $param[$i]->tipo == 'T1' ){
            $respuesta[3]['ejecutadas']=$param[$i]->cantidad;
          }


          //asignadas T2
          if($param[$i]->estado == 'Asignada' && $param[$i]->tipo == 'T2' ){
            $respuesta[4]['asignadas']=$param[$i]->cantidad;
          }
          //canceladas T2
          if($param[$i]->estado == 'Cancelado' && $param[$i]->tipo == 'T2' ){
            $respuesta[4]['canceladas']=$param[$i]->cantidad;
          }
          //enviadas T2
          if($param[$i]->estado == 'Enviado' && $param[$i]->tipo == 'T2' ){
            $respuesta[4]['enviadas']=$param[$i]->cantidad;
          }
          //ejecutadas T2
          if($param[$i]->estado == 'Ejecutado' && $param[$i]->tipo == 'T2' ){
            $respuesta[4]['ejecutadas']=$param[$i]->cantidad;
          }


          //asignadas T3
          if($param[$i]->estado == 'Asignada' && $param[$i]->tipo == 'T3' ){
            $respuesta[5]['asignadas']=$param[$i]->cantidad;
          }
          //canceladas T3
          if($param[$i]->estado == 'Cancelado' && $param[$i]->tipo == 'T3' ){
            $respuesta[5]['canceladas']=$param[$i]->cantidad;
          }
          //enviadas T3
          if($param[$i]->estado == 'Enviado' && $param[$i]->tipo == 'T3' ){
            $respuesta[5]['enviadas']=$param[$i]->cantidad;
          }
          //ejecutadas T3
          if($param[$i]->estado == 'Ejecutado' && $param[$i]->tipo == 'T3' ){
            $respuesta[5]['ejecutadas']=$param[$i]->cantidad;
          }

          //asignadas T4
          if($param[$i]->estado == 'Asignada' && $param[$i]->tipo == 'T4' ){
            $respuesta[6]['asignadas']=$param[$i]->cantidad;
          }
          //canceladas T4
          if($param[$i]->estado == 'Cancelado' && $param[$i]->tipo == 'T4' ){
            $respuesta[6]['canceladas']=$param[$i]->cantidad;
          }
          //enviadas T4
          if($param[$i]->estado == 'Enviado' && $param[$i]->tipo == 'T4' ){
            $respuesta[6]['enviadas']=$param[$i]->cantidad;
          }
          //ejecutadas T4
          if($param[$i]->estado == 'Ejecutado' && $param[$i]->tipo == 'T4' ){
            $respuesta[6]['ejecutadas']=$param[$i]->cantidad;
          }

          //asignadas T5
          if($param[$i]->estado == 'Asignada' && $param[$i]->tipo == 'T5' ){
            $respuesta[7]['asignadas']=$param[$i]->cantidad;
          }
          //canceladas T5
          if($param[$i]->estado == 'Cancelado' && $param[$i]->tipo == 'T5' ){
            $respuesta[7]['canceladas']=$param[$i]->cantidad;
          }
          //enviadas T5
          if($param[$i]->estado == 'Enviado' && $param[$i]->tipo == 'T5' ){
            $respuesta[7]['enviadas']=$param[$i]->cantidad;
          }
          //ejecutadas T5
          if($param[$i]->estado == 'Ejecutado' && $param[$i]->tipo == 'T5' ){
            $respuesta[7]['ejecutadas']=$param[$i]->cantidad;
          }

          //asignadas T6
          if($param[$i]->estado == 'Asignada' && $param[$i]->tipo == 'T6' ){
            $respuesta[8]['asignadas']=$param[$i]->cantidad;
          }
          //canceladas T6
          if($param[$i]->estado == 'Cancelado' && $param[$i]->tipo == 'T6' ){
            $respuesta[8]['canceladas']=$param[$i]->cantidad;
          }
          //enviadas T6
          if($param[$i]->estado == 'Enviado' && $param[$i]->tipo == 'T6' ){
            $respuesta[8]['enviadas']=$param[$i]->cantidad;
          }
          //ejecutadas T6
          if($param[$i]->estado == 'Ejecutado' && $param[$i]->tipo == 'T6' ){
            $respuesta[8]['ejecutadas']=$param[$i]->cantidad;
          }
        }
        //el arreglo tipo, trae los tipos de actividades q han sido asignados
        //pero no lo uso porque deje predeteminado en las graficas c1 c2 c3 t1 t2 t3...
        $response['tipo'] = array_values(array_unique($response['tipo']));
        //creo los arreglos finales separandolos en asignados, cancelados etc en el orden espacifico
        // 9 valores por arreglos c1 c2 c3 t1 t2 t3 .......
        foreach ($respuesta as $key => $value) {
          array_push($response['asignadas'], $value['asignadas']);
          array_push($response['canceladas'], $value['canceladas']);
          array_push($response['enviadas'], $value['enviadas']);
          array_push($response['ejecutadas'], $value['ejecutadas']);
        }
        echo json_encode($response);

    }

    public function getActivitiesDetails(){
      //capturo los parametros enviados por post
      $mes = $this->input->post("mes");
      $tipo = $this->input->post("tipo");
      //arreglo para capturar el indice del mes
       $meses = ["", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
       //devuelve el indice del mes seleccionado
       $indiceMes = array_keys($meses, $mes)[0];

       $param = $this->dao_service_model->getActivitiesByTipe($tipo, $indiceMes);
       echo json_encode($param);
    }

 }

?>