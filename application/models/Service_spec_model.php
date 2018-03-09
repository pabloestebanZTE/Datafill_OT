<?php
	class Service_spec_model extends CI_Model{

		public $id;
		public $duration;
		public $idClaro;
    public $description;
		public $claroDescription;
    public $dateStartP;
    public $dateFinishP;
    public $dateStartR;
    public $dateFinishR;
    public $dateCreation;
    public $dateForecast;
    public $dateFinishClaro;
    public $order;
    public $site;
    public $service;
    public $user;
		public $ingSol;
		public $proyecto;
		public $estado;
        public $CRQ;
        public $quantity;
        public $region;
        public $link1;
        public $link2;

		public function __construct(){

		}

		public function getId(){return $this->id;}

		public function setId($id){$this->id = $id;}

    public function getDuration(){return $this->duration;}

    public function setDuration($duration){$this->duration = $duration;}

    public function getIdClaro(){return $this->idClaro;}

    public function setIdClaro($idClaro){$this->idClaro = $idClaro;}

    public function getQuantity(){return $this->quantity;}

    public function setQuantity($quantity){$this->quantity = $quantity;}

    public function getRegion(){return $this->region;}

    public function setRegion($region){$this->region = $region;}

    public function getDescription(){return $this->description;}

    public function setDescription($description){$this->description = $description;}

		public function getClaroDescription(){return $this->claroDescription;}

    public function setClaroDescription($claroDescription){$this->claroDescription = $claroDescription;}

    public function getCierreDescription(){return $this->cierreDescription;}//CAMILO

    public function setCierreDescription($cierreDescription){$this->cierreDescription = $cierreDescription;}//CAMILO

    public function getDateStartP(){return $this->dateStartP;}

    public function setDateStartP($dateStartP){$this->dateStartP = $dateStartP;}

    public function getDateStartR(){return $this->dateStartR;}

    public function setDateStartR($dateStartR){$this->dateStartR = $dateStartR;}

    public function getDateFinishP(){return $this->dateFinishP;}

    public function setDateFinishP($dateFinishP){$this->dateFinishP = $dateFinishP;}

    public function getDateFinishR(){return $this->dateFinishR;}

    public function setDateFinishR($dateFinishR){$this->dateFinishR = $dateFinishR;}

    public function getDateFinishClaro(){return $this->dateFinishClaro;}

    public function setDateFinishClaro($dateFinishClaro){$this->dateFinishClaro = $dateFinishClaro;}

    public function getDateCreation(){return $this->dateCreation;}

    public function setDateCreation($dateCreation){$this->dateCreation = $dateCreation;}

    public function getDateForecast(){return $this->dateForecast;}

    public function setDateForecast($dateForecast){$this->dateForecast = $dateForecast;}

    public function getOrder(){return $this->order;}

    public function setOrder($order){$this->order = $order;}

    public function getSite(){return $this->site;}

    public function setSite($site){$this->site = $site;}

    public function getService(){return $this->service;}

    public function setService($service){$this->service = $service;}

    public function getUser(){return $this->user;}

    public function setUser($user){$this->user = $user;}

		public function getIngSol(){return $this->ingSol;}

    public function setIngSol($ingSol){$this->ingSol = $ingSol;}

		public function getProyecto(){return $this->proyecto;}

    public function setProyecto($proyecto){$this->proyecto = $proyecto;}

		public function getEstado(){return $this->estado;}

    public function setEstado($estado){$this->estado = $estado;}

		public function getCRQ(){return $this->CRQ;}

    public function setCRQ($CRQ){$this->CRQ = $CRQ;}

    public function getLink1(){return $this->link1;}

    public function setLink1($link1){$this->link1 = $link1;}

    public function getLink2(){return $this->link2;}

    public function setLink2($link2){$this->link2 = $link2;}

		public function createServiceS($id, $duration, $idClaro, $description, $dateStartP, $dateFinishP, $dateCreation, $dateForecast, $order, $site, $service, $user, $claroDescription, $ingSol, $proyecto, $estado, $CRQ){
			$this->setId($id);
			$this->setDuration($duration);
			$this->setIdClaro($idClaro);
            $this->setDescription($description);
			$this->setClaroDescription($claroDescription);
            $this->setDateStartP($dateStartP);
            $this->setDateFinishP($dateFinishP);
            $this->setDateCreation($dateCreation);
            $this->setDateForecast($dateForecast);
            $this->setOrder($order);
            $this->setSite($site);
            $this->setService($service);
            $this->setUser($user);
			$this->setIngSol($ingSol);
			$this->setProyecto($proyecto);
			$this->setEstado($estado);
			$this->setCRQ($CRQ);
        }
//camilo--------------------------------------------------------------------------------------
        public function closeService($dateStartR, $dateFinishR, $CRQ, $estado, $cierreDescription, $link1, $link2){
            $this->setDateStartR($dateStartR);
            $this->setDateFinishR($dateFinishR);
            $this->setCRQ($CRQ);
            $this->setEstado($estado);
            $this->setCierreDescription($cierreDescription);
            $this->setLink1($link1);
            $this->setLink2($link2);
        }
//-----------------------------------------------------------------------------------------------


	}
?>
