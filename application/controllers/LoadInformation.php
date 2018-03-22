<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LoadInformation extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('data/Dao_rf_model');
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
                $idTicket = 0;
                $imported = 0;
                $inconsistencies = 0;
                $inconsistenciesFull = [];
                $cellInconsistencies = [];
               

                //Inicializamos un objeto de PHPExcel para escritura...
//                $objPHPWriter = $this->createErrorsFileExcel();

                // print_r($this->getDatePHPExcel($sheet, 'A' . $row));
                // echo "<br>";
                // print_r($row);
                // echo "<br>";
                // print_r($limit);
                // echo "<br>";
                // print_r($row);
                // $rowWriter = 1;
                // $letras = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V"];
                //while para recorrer filas del excel...
                while ($this->getValueCell($sheet, 'L' . $row) > 0 && ($row < $limit)) {
                    $data = array();
                    //valido si el id del excel existe en la base de datos
                    $exist = $this->Dao_rf_model->getExistIdRF($this->getValueCell($sheet, 'L' . $row));
                    // si existe...
                    if ($exist) {
                    //si no existe lo inserto en la db tabla rf
                    }else {
                        //LLENO EL ARRAY LETRAS CON LOS VARORES DE LA FILA DEL EXCEL EN LA QUE VA EL WHILE
                        $data = array(
                            'D_DATE_S' => $this->getDatePHPExcel($sheet, 'A' . $row),
                            'N_REQUESTED_BY' => $this->getValueCell($sheet, 'B' . $row),
                            'N_STATUS' => $this->getValueCell($sheet, 'C' . $row),
                            'N_TYPE' => $this->getValueCell($sheet, 'D' . $row),
                            'N_ELEMENT' => $this->getValueCell($sheet, 'E' . $row),
                            'D_DATE_ASSGINED' => $this->getDatePHPExcel($sheet, 'F' . $row),
                            'K_ASSIGNED_TO' => $this->getValueCell($sheet, 'G' . $row),
                            'D_DATE_SENT' => $this->getDatePHPExcel($sheet, 'H' . $row),
                            'N_FILE' => $this->getValueCell($sheet, 'I' . $row),
                            'N_OBSERVATIONS' => $this->getValueCell($sheet, 'J' . $row),
                            'N_MODULE' => $this->getValueCell($sheet, 'K' . $row),
                            'K_ID' => $this->getValueCell($sheet, 'L' . $row),
                            'N_REMEDY' => $this->getValueCell($sheet, 'M' . $row),
                            'N_ORDER_W' => $this->getValueCell($sheet, 'N' . $row),
                            'D_BILL' => $this->getDatePHPExcel($sheet, 'O' . $row),
                            'N_MONTH_B' => $this->getValueCell($sheet, 'P' . $row),
                            'D_REVIEW' => $this->getDatePHPExcel($sheet, 'Q' . $row),
                            'D_RAW' => $this->getDatePHPExcel($sheet, 'R' . $row),
                            'D_OTGDRT' => $this->getDatePHPExcel($sheet, 'S' . $row),
                            'N_idBSS' => $this->getValueCell($sheet, 'U' . $row),
                            'N_TIPO' => $this->getValueCell($sheet, 'V' . $row)
                                  );

                        $this->Dao_rf_model->insertRfRow($data);



                    }














                    $row++;
                }

                if (($limit - $row) >= 2) {
                    $response->setCode(2);
                }

                $filename = null;

                $response->setData([
                    "id" => $idTicket,
                    "imported" => $imported,
                    "inconsistencies" => $inconsistencies,
                    "inconsistenciesFull" => $inconsistenciesFull,
                    "data" => $this->objs,
                    "errors_filename" => $filename,
                    "row" => ($row - $request->index)
                ]);
            } catch (DeplynException $ex) {
                $response = new Response(EMessages::ERROR, "Error al procesar el archivo.");
            }
        } else {
            $response = new Response(EMessages::ERROR, "No se encontró el archivo " . $file);
        }

        $this->json($response);
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
        return $date;
    }

   

}
