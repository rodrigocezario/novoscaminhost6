<?php 

class Curtida {
    private $id;
    private $amigo;

    public function __construct($amigo)
    {
        $this->amigo = $amigo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getAmigo()
    {
        return $this->amigo;
    }

}