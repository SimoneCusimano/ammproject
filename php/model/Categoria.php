<?php

class Categoria{
    private $id;
    private $nome;
    private $descrizione;
    
    
    public function __construct() {}
    
    
    public function getId(){
        return $this->id;
    }
    
    public function getNome(){
        return $this->nome;
    }
    
    public function getDescrizione(){
        return $this->descrizione;
    }
    
    public function setId($id){
        $this->id = $id;
        return TRUE;
    }
    
    public function setNome($nome){
        $this->nome = $nome;
        return TRUE;
    }
    
    public function setDescrizione($descrizione){
        $this->descrizione = $descrizione;
        return TRUE;
    }
}

?>
