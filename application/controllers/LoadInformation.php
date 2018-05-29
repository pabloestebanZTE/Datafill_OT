<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LoadInformation extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('data/Dao_rf_model');
        $this->load->model('data/Dao_service_model');
        $this->load->helper('camilo');
    }

    public function uploadfile() {
        $request = $this->request;
        $storage = new Storage();
        
            //Se activa la asignación de un prefijo para nuestro archivo...
            $storage->setPrefix(true);
            //Seteamos las extenciones válidas...
            $storage->setValidExtensions("xlsx", "xls");
            //Subimos el archivo...
            $storage->process($request);
            //Obtenemos el log de los archivos subidos...
            $files = $storage->getFiles();
            $response = null;
            if (count($files) > 0) {
                $project = $files[0];
                $response = new Response(EMessages::SUCCESS, "Se ha subido el archivo correctamente", $project);
            } else {
                $response = new Response(EMessages::ERROR_ACTION, "Lo sentimos, no se pudo subir el archivo, recuerde que el tamaño máximo permitido es de 100MB");
            }
        


        $this->json($response);
    }

    public function countLinesFile() {
        error_reporting(E_ERROR);
        $request = $this->request;
        $file = $request->file;
        $response = new Response(EMessages::SUCCESS);
        if (file_exists($file)) {
            try {
                //Se procesa el archivo de comentarios...
                set_time_limit(-1);
                ini_set('memory_limit', '1500M');
                require_once APPPATH . 'models/bin/PHPExcel-1.8.1/Classes/PHPExcel/Settings.php';
                $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
                $cacheSettings = array(' memoryCacheSize ' => '15MB');
                PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
                PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
                $this->load->model('bin/PHPExcel-1.8.1/Classes/PHPExcel');

                $inputFileType = PHPExcel_IOFactory::identify($file);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($file);

                //Obtenemos la página.
                $sheet = $objPHPExcel->getSheet(0);
                $row = 1;
                $validator = new Validator();
                while ($validator->required("", $this->getValueCell($sheet, "A" . $row))) {
                    $row++;
                }
                $highestRowSheet1 = $row;

                $lines = [
                    "sheet1" => $highestRowSheet1
                ];

                $response->setData($lines);
                $this->json($response);
            } catch (DeplynException $ex) {
                $this->json($ex);
            }
        }
    }

    public function processData() {
        error_reporting(E_ERROR);
        $request = $this->request;
        $response = new Response(EMessages::SUCCESS);
        $file = $request->file;

        //Verificamos si el archivo existe...
        if (file_exists($file)) {
            //Iniciamos el procedimiento de carga de datos...
            set_time_limit(-1);
            ini_set('memory_limit', '1500M');
            require_once APPPATH . 'models/bin/PHPExcel-1.8.1/Classes/PHPExcel/Settings.php';
            require_once APPPATH . 'models/bin/PHPExcel-1.8.1/Classes/PHPExcel/IOFactory.php';
            $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
            $cacheSettings = array(' memoryCacheSize ' => '15MB');
//            if (intval(phpversion()) <= 5) {
            PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
//            }
            PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
//            include_once('PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');
//            $this->load->model('bin/PHPExcel-1.8.1/Classes/PHPExcel/IOFactory.php');

            try {                

                $inputFileType = PHPExcel_IOFactory::identify($file);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                //Leer el archivo...
                $objPHPExcel = $objReader->load($file);

                //Cambiar el archivo...
//                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExce, $inputFileTypel);
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

                //Obtenemos la página.
                $sheet = $objPHPExcel->getSheet(0);
                //Obtenemos el highestRow...
                $highestRow = 0;
                $row = $request->index;
                $limit = $row + $request->limit;
                $inserts = 0;
                $errorInsert = [];
                $errorUpdate = [];
                $errorNoChange = [];
                $actualizar = 0;
                $actualizados = 0;
               

                //fecha Actual
                date_default_timezone_set("America/Bogota");
                 $fActual = date('Y-m-d');
                //Inicializamos un objeto de PHPExcel para escritura...

                //while para recorrer filas del excel...
                while ($this->getValueCell($sheet, 'L' . $row) > 0 && ($row < $limit)) {
                    $data = array();
                    //valido si el id del excel existe en la base de datos
                    $exist = $this->Dao_rf_model->getExistIdRF($this->getValueCell($sheet, 'L' . $row));
                    // si existe...
                    if ($exist) {
                        // header('Content-Type: text/plain');
                        $arrayBD = (array) $exist;
                        $dataExcel = array(
                            'D_DATE_S'        =>    $this->getDatePHPExcel  ($sheet, 'A' . $row),
                            'N_REQUESTED_BY'  =>    $this->getValueCell     ($sheet, 'B' . $row),
                            'N_STATUS'        =>    $this->getValueCell     ($sheet, 'C' . $row),
                            'N_TYPE'          =>    $this->getValueCell     ($sheet, 'D' . $row),
                            'N_ELEMENT'       =>    $this->getValueCell     ($sheet, 'E' . $row),
                            'D_DATE_ASSGINED' =>    $this->getDatePHPExcel  ($sheet, 'F' . $row),
/*retorna el id  del asig*/ 'K_ASSIGNED_TO'   =>    $this->getIdByNameRF($this->getValueCell($sheet,'B'.$row)),
                            'D_DATE_SENT'     =>    $this->getDatePHPExcel  ($sheet, 'H' . $row),
                            'N_FILE'          =>    $this->getValueCell     ($sheet, 'I' . $row),
                            'N_OBSERVATIONS'  =>    $this->getValueCell     ($sheet, 'J' . $row),
                            'N_MODULE'        =>    $this->getValueCell     ($sheet, 'K' . $row),
                            'K_ID'            =>    $this->getValueCell     ($sheet, 'L' . $row),
                            'N_REMEDY'        =>    $this->getValueCell     ($sheet, 'M' . $row),
                            'N_ORDER_W'       =>    $this->getValueCell     ($sheet, 'N' . $row),
                            'D_BILL'          =>    $this->getDatePHPExcel  ($sheet, 'O' . $row),
                            'N_MONTH_B'       =>    $this->getValueCell     ($sheet, 'P' . $row),
                            'D_REVIEW'        =>    $this->getDatePHPExcel  ($sheet, 'Q' . $row),
                            'D_RAW'           =>    $this->getDatePHPExcel  ($sheet, 'R' . $row),
                            'D_OTGDRT'        =>    $this->getDatePHPExcel  ($sheet, 'S' . $row),
                            'N_idBSS'         =>    $this->getValueCell     ($sheet, 'U' . $row),
                            'N_TIPO'          =>    $this->getTypeEmpty($this->getValueCell     ($sheet, 'D' . $row) ,$this->getValueCell($sheet, 'V' . $row))
                            );
                        $cambioStatusMod = [];
                        $updates = [];
                        // Recorro el array de lo q viene en excel
                        foreach ($dataExcel as $key => $value) {
                            // si la celda de db es != a la celda de excel
                            if ($arrayBD[$key] != $dataExcel[$key]) {
                                
                                $insert = array(
                                    'K_IDORDER' => $arrayBD['K_ID'],
                                    'N_OLD'     => $arrayBD[$key],
                                    'N_NEW'     => $dataExcel[$key],
                                    'N_COLUMN'  => $key,
                                    'D_DATE_MOD'=> $fActual
                                    );

                            $this->Dao_rf_model->insertLogRow($insert);
                            //voy creando el arreglo con las modificaciones que hayan
                            $updates[$key] = $dataExcel[$key];                              
                            } 
                           
                            // Si en la comparacion hubo alguna modificacion
                            if (count($updates) >0)  {
                                $updates['N_STATUS_MOD'] = 1;
                                $updates['K_ID'] = $arrayBD['K_ID'];
                                // print_r("cambios");
                            }
                            // si son iguales
                             else {
                                if ($arrayBD['N_STATUS_MOD'] != 2) {
                                    $cambioStatusMod['N_STATUS_MOD'] = 2;
                                    $cambioStatusMod['K_ID'] = $arrayBD['K_ID'];
                                }
                            }
                        }
                        // si no hay ningun cambio
                        if ($cambioStatusMod) {
                            $sinCambios = $this->Dao_rf_model->updateRfStatusMod($cambioStatusMod);
                            // capturo el error si no se actualizo + el id
                            if ($sinCambios != 1) {
                                array_push($errorNoChange, array($sinCambios, $this->getValueCell     ($sheet, 'L' . $row) ));
                            }
                        }
                        if ($updates) {

                            $actualizar = $this->Dao_rf_model->updateRfMod($updates);
                            // Si se actualizó  el estado a sin cambios retorna 1 
                            if ($actualizar === 1) {
                                $actualizados++;
                            }
                            // si retorna error lo captura, + el id 
                            else {
                                 array_push($errorUpdate, array($actualizar, $this->getValueCell     ($sheet, 'L' . $row) ));
                            }


                        }
                    }
                    //si no existe lo inserto en la db tabla rf
                    else {
                        //LLENO EL ARRAY LETRAS CON LOS VARORES DE LA FILA DEL EXCEL EN LA QUE VA EL WHILE
                        $data = array(
                            'D_DATE_S'        =>    $this->getDatePHPExcel  ($sheet, 'A' . $row),
                            'N_REQUESTED_BY'  =>    $this->getValueCell     ($sheet, 'B' . $row),
                            'N_STATUS'        =>    $this->getValueCell     ($sheet, 'C' . $row),
                            'N_TYPE'          =>    $this->getValueCell     ($sheet, 'D' . $row),
                            'N_ELEMENT'       =>    $this->getValueCell     ($sheet, 'E' . $row),
                            'D_DATE_ASSGINED' =>    $this->getDatePHPExcel  ($sheet, 'F' . $row),
/*retorna el id  del asig*/ 'K_ASSIGNED_TO'   =>    $this->getIdByNameRF($this->getValueCell($sheet,'B'.$row)),
                            'D_DATE_SENT'     =>    $this->getDatePHPExcel  ($sheet, 'H' . $row),
                            'N_FILE'          =>    $this->getValueCell     ($sheet, 'I' . $row),
                            'N_OBSERVATIONS'  =>    $this->getValueCell     ($sheet, 'J' . $row),
                            'N_MODULE'        =>    $this->getValueCell     ($sheet, 'K' . $row),
                            'K_ID'            =>    $this->getValueCell     ($sheet, 'L' . $row),
                            'N_REMEDY'        =>    $this->getValueCell     ($sheet, 'M' . $row),
                            'N_ORDER_W'       =>    $this->getValueCell     ($sheet, 'N' . $row),
                            'D_BILL'          =>    $this->getDatePHPExcel  ($sheet, 'O' . $row),
                            'N_MONTH_B'       =>    $this->getValueCell     ($sheet, 'P' . $row),
                            'D_REVIEW'        =>    $this->getDatePHPExcel  ($sheet, 'Q' . $row),
                            'D_RAW'           =>    $this->getDatePHPExcel  ($sheet, 'R' . $row),
                            'D_OTGDRT'        =>    $this->getDatePHPExcel  ($sheet, 'S' . $row),
                            'N_idBSS'         =>    $this->getValueCell     ($sheet, 'U' . $row),
                            'N_TIPO'          =>    $this->getTypeEmpty($this->getValueCell     ($sheet, 'D' . $row) ,$this->getValueCell($sheet, 'V' . $row)),
                            'N_STATUS_MOD'    =>    0
                            );
                        //inserto la fila en la base de datos
                        $insert = $this->Dao_rf_model->insertRfRow($data);

                        //si retorna 1 se insertó bien y lo sumo en contador
                        if ($insert === 1) {
                            $inserts ++;
                        }
                        // si no se insertó retotno el error y lo guardo en un array multidimencional + el id de la orden
                        else{
                            array_push($errorInsert, array($insert, $this->getValueCell     ($sheet, 'L' . $row) ));
                        }
                    }

                    $row++;
                }

                if (($limit - $row) >= 2) {
                    $response->setCode(2);
                }


                $response->setData([
                    "nuevos"                   => $inserts,
                    "Actualizados"             => $actualizados,
                    "No hay cambio"            => ($row - $request->index) - $actualizados - $inserts,
                    "error de insercion"       => $errorInsert,
                    "error al Actualizar"      => $errorUpdate,
                    "error act a sin cambios"  => $errorNoChange,
                    "row"                      => ($row - $request->index),
                    "data"                     => $this->objs
                ]);
            } catch (DeplynException $ex) {
                $response = new Response(EMessages::ERROR, "Error al procesar el archivo.");
            }
        } else {
            $response = new Response(EMessages::ERROR, "No se encontró el archivo " . $file);
        }

        $this->json($response);
        // $this->load->view('viewRF');
     }

    /**
     * @param $sheet
     * @param $cell
     * getValueCell($sheet, $cell)
     */
    private function getValueCell(&$sheet, $cell) {
        $string = str_replace(array("\n", "\r", "\t"), '', $sheet->getCell($cell)->getValue());
        $string = str_replace(array("_x000D_"), "<br/>", $sheet->getCell($cell)->getValue());
        return $string;
    }

    private function getDatePHPExcel($sheet, $colum) {
        $cell = $sheet->getCell($colum);
        $validator = new Validator();
        $date = DB::NULLED;
        if ($validator->required("", $cell->getValue())) {
            $date = $cell->getValue();
            $date = date("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($date));
            $date = Hash::addHours($date, 5);
        }
        if ($date == "NULLED") {
            $date = "0000-00-00 00:00:00";
        }
        return $date;
    }

    //retorna el id del ing asignado envio nombre de ing solicitante
    private function getIdByNameRF($nombre){
        $solicitantes = ["Juan Carlos Leon Sanchez",
                         "Carlos Alberto Cordoba Gaviria",
                         "Carlos Felipe Velasquez",
                         "Deissy Bibiana Rosero"
        ];
        $asignado = comparationsNames($solicitantes, $nombre);  

        switch ($asignado) {
            case 'Juan Carlos Leon Sanchez':
                $id = "1016028754";
                break;

            case 'Carlos Alberto Cordoba Gaviria':
                $id = "1016028754";
                break;

            case 'Carlos Felipe Velasquez':
                $id = "1016028754";
                break;

            case 'Deissy Bibiana Rosero':
                $id = "1016028754";
                break;

            default:
                $id = "1030565500";
                break;
        }

        return $id;
    }

    // si viene el tipo vacio lo calcula
    private function getTypeEmpty($calculo, $type){
        if ($type == "") {
           if (substr_count($calculo, "1900") == 1) {
                $type = "D3";
           }
           else if (substr_count($calculo, "850") == 1) {
               $type = "D4";
            }
        }
        return $type;
    }

   

}
