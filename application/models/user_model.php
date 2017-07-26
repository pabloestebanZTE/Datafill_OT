<?php
	//require_once 'Profesor_model.php';

	class user_model extends CI_Model{

		protected $id;
		protected $pass;
		protected $name;
		protected $lastname;
    protected $permissions;

		public function __construct(){

		}

		public function getId(){return $this->id;}

		public function setId($id){$this->id = $id;}

    public function getName(){return $this->name;}

    public function setName($name){$this->name = $name;}

    public function getPass(){return $this->pass;}

    public function setPass($pass){$this->pass = $pass;}

    public function getLastname(){return $this->lastname;}

    public function setLastname($lastname){$this->lastname = $lastname;}

    public function getPermissions(){return $this->permissions;}

    public function setPermissions($permissions){$this->permissions = $permissions;}

		public function createUser($id, $pass, $name, $lastname){
			$newUsuario= new user_model();
			$newUsuario->setId($id);
			$newUsuario->setPass($pass);
			$newUsuario->setName($name);
			$newUsuario->setLastname($lastname);

			return $newUsuario;
    }
	}
?>
