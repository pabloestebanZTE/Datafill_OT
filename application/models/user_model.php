<?php
	//require_once 'Profesor_model.php';

	class user_model extends CI_Model{

		protected $id;
		protected $name;
		protected $lastname;
    protected $mail;
    protected $phone;
    protected $cellphone;
    protected $permissions;
    protected $skill;
    protected $role;
		protected $schedule;

		public function __construct(){

		}

		public function getId(){return $this->id;}

		public function setId($id){$this->id = $id;}

    public function getName(){return $this->name;}

    public function setName($name){$this->name = $name;}

    public function getLastname(){return $this->lastname;}

    public function setLastname($lastname){$this->lastname = $lastname;}

    public function getMail(){return $this->mail;}

    public function setMail($mail){$this->mail = $mail;}

    public function getPhone(){return $this->phone;}

    public function setPhone($phone){$this->phone = $phone;}

    public function getCellphone(){return $this->cellphone;}

    public function setCellphone($cellphone){$this->cellphone = $cellphone;}

    public function getSkill(){return $this->skill;}

    public function setSkill($skill){$this->skill = $skill;}

    public function getRole(){return $this->role;}

    public function setRole($role){$this->role = $role;}

    public function getPermissions(){return $this->permissions;}

    public function setPermissions($permissions){$this->permissions = $permissions;}

    public function getSchedule(){return $this->schedule;}

    public function setSchedule($schedule){$this->schedule = $schedule;}

		public function createUser($id, $name, $lastname, $phone, $cellphone, $mail){
			$this->setId($id);
			$this->setName($name);
			$this->setPhone($phone);
      $this->setLastname($lastname);
      $this->setCellphone($cellphone);
      $this->setMail($mail);
			return $this;
    }
	}
?>
