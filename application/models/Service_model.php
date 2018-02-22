<?php

class Service_model extends CI_Model {

    public $id;
    public $gerency;
    public $type;
    public $description;
    public $scope;
    public $duration;

    public function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getGerency() {
        return $this->gerency;
    }

    public function setGerency($gerency) {
        $this->gerency = $gerency;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getScope() {
        return $this->scope;
    }

    public function setScope($scope) {
        $this->scope = $scope;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function setDuration($duration) {
        $this->duration = $duration;
    }

    public function createService($id, $gerency, $type, $description, $scope, $duration) {
        $this->setId($id);
        $this->setGerency($gerency);
        $this->setType($type);
        $this->setDescription($description);
        $this->setScope($scope);
        $this->setDuration($duration);
    }

}

?>
