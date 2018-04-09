<?php

class Order_model extends CI_Model {

    public $id;
    public $name;
    public $creationDate;
    public $link;
    public $prioridad;

    public function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function getPrioridad() {
        return $this->prioridad;
    }

    public function setPrioridad($prioridad) {
        $this->prioridad = $prioridad;
    }

    public function createOrder($id, $name, $creationDate) {
        $this->setId($id);
        $this->setName($name);
        $this->setCreationDate($creationDate);
        $this->setPrioridad($prioridad);
    }

}

?>