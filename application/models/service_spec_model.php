<?php
	class order_model extends CI_Model{

		protected $id;
		protected $duration;
		protected $idClaro;
    protected $description;
    protected $dateStartP;
    protected $dateFinishP;
    protected $dateStartR;
    protected $dateFinishR;
    protected $dateCreation;
    protected $dateForecast;
    protected $order;
    protected $site;
    protected $service;
    protected $user;

		public function __construct(){

		}

		public function getId(){return $this->id;}

		public function setId($id){$this->id = $id;}

    public function getDuration(){return $this->duration;}

    public function setDuration($duration){$this->duration = $duration;}

    public function getIdClaro(){return $this->idClaro;}

    public function setIdClaro($idClaro){$this->idClaro = $idClaro;}

    public function getDescription(){return $this->description;}

    public function setDescription($description){$this->description = $description;}

    public function getDateStartP(){return $this->dateStartP;}

    public function setDateStartP($dateStartP){$this->dateStartP = $dateStartP;}

    public function getDateStartR(){return $this->dateStartR;}

    public function setDateStartR($dateStartR){$this->dateStartR = $dateStartR;}

    public function getDateFinishP(){return $this->dateFinishP;}

    public function setDateFinishP($dateFinishtP){$this->dateFinishP = $dateFinishP;}

    public function getDateFinishR(){return $this->dateFinishR;}

    public function setDateFinishR($dateFinishR){$this->dateFinishR = $dateFinishR;}

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

		public function createService($id, $duration, $idClaro, $description, $dateStartP, $dateFinishP, $dateCreation, $dateForecast, $order, $site, $service, $user){
			$this->setId($id);
			$this->setDuration($duration);
			$this->setIdClaro($idClaro);
      $this->setDescription($description);
      $this->setDateStartP($dateStartP);
      $this->setDateFinishP($dateFinishP);
      $this->setDateCreation($dateCreation);
      $this->setDateForecast($dateForecast);
      $this->setOrder($order);
      $this->setSite($site);
      $this->setService($service);
      $this->setUser($user);
    }
	}
?>
