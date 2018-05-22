<?php

defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
mysqli_report(MYSQLI_REPORT_STRICT);
session_start();

class Configdb_model extends CI_Model {

    public $dbconn4;

    public function __construct() {

    }

    public function startSession($user) {
        $_SESSION['userName'] = $user->getName();
        $_SESSION['id'] = $user->getId();
        $_SESSION['role'] = $user->getRole();
    }

    /*     * ************************servidor de prueba************************* */

    // public function openSession(){
    //   $user = "AdminZTE";
    //   $pass =  "a4b3c2d1";
    //   $db = "datafill_test";
    //   try {
    //     $connection = new mysqli('zte-col.cws6f2qsxddy.us-west-2.rds.amazonaws.com', $user, $pass, $db);
    //     $connection->set_charset("utf8");
    //   } catch (Exception $e ) {
    //      $connection = "false";
    //   }
    //   return $connection;
    // }
    // /**************************servidor del cliente**************************/
    public function openSession(){
      $user = "AdminZTE";
      $pass =  "a4b3c2d1";
      $db = "datafill_ot";
      try {
        $connection = new mysqli('zte-col.cws6f2qsxddy.us-west-2.rds.amazonaws.com', $user, $pass, $db);
        $connection->set_charset("utf8");
      } catch (Exception $e ) {
         $connection = "false";
      }
      return $connection;
    }


    /*     * ******************************localhost******************************* */
<<<<<<< HEAD
        public function openSession(){
          $user = "root";
          $pass =  "";
          $db = "Datafill_OT";

          try {
            $connection = new mysqli('localhost', $user, $pass, $db);
            $connection->set_charset("utf8");
          } catch (Exception $e ) {
             $connection = "false";
          }
          return $connection;
        }
   /*public function openSession() {
       $user = "root";
       $pass = "";
       $db = "datafill_ot";

       try {
           $connection = new mysqli('localhost', $user, $pass, $db);
           $connection->set_charset("utf8");
       } catch (Exception $e) {
           $connection = "false";
       }
       return $connection;
   }*/
=======
        // public function openSession(){
        //   $user = "root";
        //   $pass =  "a4b3c2d1";
        //   $db = "Datafill_OT";
        
        //   try {
        //     $connection = new mysqli('localhost', $user, $pass, $db);
        //     $connection->set_charset("utf8");
        //   } catch (Exception $e ) {
        //      $connection = "false";
        //   }
        //   return $connection;
        // }
   // public function openSession() {
   //     $user = "root";
   //     $pass = "a4b3c2d1";
   //     $db = "datafill_ot";

   //     try {
   //         $connection = new mysqli('localhost', $user, $pass, $db);
   //         $connection->set_charset("utf8");
   //     } catch (Exception $e) {
   //         $connection = "false";
   //     }
   //     return $connection;
   // }
>>>>>>> 5078c4a28601c48e5d25f7c53ffe14ea452ab9c2

    public function closeSession($session) {
        $session->close();
    }

    public function destroySession() {
        session_destroy();
    }

}

?>
