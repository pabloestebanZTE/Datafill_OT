<?php
	//require_once 'Profesor_model.php';

	class Site_model extends CI_Model{

		public $id;
		public $name;

		public function __construct(){

		}

		public function getId(){return $this->id;}

		public function setId($id){$this->id = $id;}

    public function getName(){return $this->name;}

    public function setName($name){$this->name = $name;}

		public function createSite($id, $name){
			$this->setName($name);
			$this->setId($id);
    }
	}
?>
