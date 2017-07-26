<?php
	class order_model extends CI_Model{

		protected $id;
		protected $name;
		protected $creationDate;

		public function __construct(){

		}

		public function getId(){return $this->id;}

		public function setId($id){$this->id = $id;}

    public function getName(){return $this->name;}

    public function setName($name){$this->name = $name;}

    public function getCreationDate(){return $this->creationDate;}

    public function setCreationDate($creationDate){$this->creationDate = $creationDate;}

		public function createService($id, $name, $creationDate){
			$this->setId($id);
			$this->setName($name);
			$this->setCreationDate($creationDate);
    }
	}
?>
