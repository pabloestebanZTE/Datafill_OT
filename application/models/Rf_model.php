<?php
    class Rf_model extends CI_Model{

        public $idRF;
        public $dateRequested;
        public $requestedBy;
        public $status;
        public $type;
        public $element;
        public $dateAssigned;
        public $assignedTo;
        public $dateSent;
        public $file;
        public $obs;
        public $module;
        public $id;
        public $remedy;
        public $weightOrder;
        public $dateBilling;
        public $monthBilling;
        public $dateReview;
        public $dateRaw;
        public $dateOTGDRT;
        public $idBSS;
        public $code;
          public $color;


        public function __construct(){

        }
        public function getIdRF(){return $this->idRF;}

        public function setIdRF($idRF){$this->idRF = $idRF;}

        public function getDateRequested(){return $this->dateRequested;}

        public function setDateRequested($dateRequested){$this->dateRequested = $dateRequested;}

    public function getRequestedBy(){return $this->requestedBy;}

    public function setRequestedBy($requestedBy){$this->requestedBy = $requestedBy;}

    public function getStatus(){return $this->status;}

    public function setStatus($status){$this->status = $status;}

    public function getType(){return $this->type;}

    public function setType($type){$this->type = $type;}

    public function getElement(){return $this->element;}

    public function setElement($element){$this->element = $element;}

    public function getDateAssigned(){return $this->dateAssigned;}

    public function setDateAssigned($dateAssigned){$this->dateAssigned = $dateAssigned;}

    public function getAssignedTo(){return $this->assignedTo;}

    public function setAssignedTo($assignedTo){$this->assignedTo = $assignedTo;}

    public function getDateSent(){return $this->dateSent;}

    public function setDateSent($dateSent){$this->dateSent = $dateSent;}

    public function getFile(){return $this->file;}

    public function setFile($file){$this->file = $file;}

    public function getObs(){return $this->obs;}

    public function setObs($obs){$this->obs = $obs;}

    public function getModule(){return $this->module;}

    public function setModule($module){$this->module = $module;}

    public function getId(){return $this->id;}

    public function setId($id){$this->id = $id;}

    public function getRemedy(){return $this->remedy;}

    public function setRemedy($remedy){$this->remedy = $remedy;}

    public function getWeightOrder(){return $this->weightOrder;}

    public function setWeightOrder($weightOrder){$this->weightOrder = $weightOrder;}

    public function getDateBilling(){return $this->dateBilling;}

    public function setDateBilling($dateBilling){$this->dateBilling = $dateBilling;}

    public function getMonthBilling(){return $this->monthBilling;}

    public function setMonthBilling($monthBilling){$this->monthBilling = $monthBilling;}

    public function getDateReview(){return $this->dateReview;}

    public function setDateReview($dateReview){$this->dateReview = $dateReview;}

    public function getDateRaw(){return $this->dateRaw;}

    public function setDateRaw($dateRaw){$this->dateRaw = $dateRaw;}

    public function getDateOTGDRT(){return $this->dateOTGDRT;}

    public function setDateOTGDRT($dateOTGDRT){$this->dateOTGDRT = $dateOTGDRT;}

    public function getIdBSS(){return $this->idBSS;}

    public function setIdBSS($idBSS){$this->idBSS = $idBSS;}

    public function getCode(){return $this->code;}

    public function setCode($code){$this->code = $code;}

        public function getColor(){return $this->color;}

        public function setColor($color){$this->color = $color;}


        public function createRF($idRF, $dateRequested, $requestedBy, $status, $type, $element, $dateAssigned, $assignedTo, $dateSent, $file, $obs, $module, $id, $remedy, $weightOrder, $dateBilling, $monthBilling, $dateReview, $dateRaw, $dateOTGDRT, $idBSS, $code){

            $this->setIdRF($idRF);
            $this->setDateRequested($dateRequested);
            $this->setRequestedBy($requestedBy);
            $this->setStatus($status);
            $this->setType($type);
            $this->setElement($element);
      $this->setDateAssigned($dateAssigned);
      $this->setAssignedTo($assignedTo);
      $this->setDateSent($dateSent);
      $this->setFile($file);
      $this->setObs($obs);
      $this->setModule($module);
      $this->setId($id);
      $this->setRemedy($remedy);
      $this->setWeightOrder($weightOrder);
      $this->setDateBilling($dateBilling);
      $this->setMonthBilling($monthBilling);
      $this->setDateReview($dateReview);
      $this->setDateRaw($dateRaw);
      $this->setDateOTGDRT($dateOTGDRT);
      $this->setIdBSS($idBSS);
      $this->setCode($code);
    }
    }
?>
