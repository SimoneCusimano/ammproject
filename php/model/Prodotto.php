<?php

class Prodotto {
    
    private $id;
    private $nome;
    private $descrizione;
    private $costo;
    private $iva;
    private $prezzo_vendita;
    private $quantita;
    private $categoria;
    
    private function __constructor() {}
    
    public function getId() {
        return $this->id;
    }
    
    public function getNome() {
        return $this->nome;
    }
    
    public function getDescrizione() {
        return $this->descrizione;
    }
    
    public function getCosto() {
        return $this->costo;
    }
    
    public function getIva() {
        return $this->iva;
    }
    
    public function getPrezzoVendita() {
        return $this->prezzo_vendita;
    }
    
    public function getQuantita() {
        return $this->quantita;
    }
    
    public function getCategoria() {
        return $this->categoria;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setNome($nome) {
        $this->nome = $nome;
        return true;
    }
    
    public function setDescrizione($descrizione) {
        $this->descrizione = $descrizione;
        return true;
    }
    
    public function setCosto($costo) {
        $this->costo = $costo;
        return true;
    }
    
    public function setIva($iva) {
        $this->iva = $iva;
        return true;
    }
    
    public function setPrezzoVendita($prezzo_vendita) {
        $this->prezzo_vendita = $prezzo_vendita;
        return true;
    }
    
    public function setQuantita($quantita) {
        $this->quantita = $quantita;
        return true;
    }
    
    public function setCategoria($categoria) {
        $this->categoria = $categoria;
        return true;
    }
    
    
    
    
}

