<?php

class ViewDescriptor {
    
    const get = 'get';
    const post = 'post';
    
    private $titolo;
    private $logo_file;
    private $menu_file;
    private $menu_categorie;
    private $content_file;
    private $messaggioErrore;
    private $messaggioConferma;
    private $pagina;
    private $sottoPagina;
    private $prodotti;
    
    public function setProdotti($prodotti) {
        $this->prodotti = $prodotti;
    }
    
    public function getProdotti() {
        return $this->prodotti;
    }
    
    public function getTitolo() {
        return $this->titolo;
    }

    public function setTitolo($titolo) {
        $this->titolo = $titolo;
    }
    
    public function setLogoFile($logoFile) {
        $this->logo_file = $logoFile;
    }

    public function getLogoFile() {
        return $this->logo_file;
    }

    public function getMenuFile() {
        return $this->menu_file;
    }

    public function setMenuFile($menuFile) {
        $this->menu_file = $menuFile;
    }
    
    public function getMenuCategorie() {
        return $this->menu_categorie;
    }

    public function setMenuCategorie($menuCategorie) {
        $this->menu_categorie = $menuCategorie;
    }

    public function getLeftBarFile() {
        return $this->leftBar_file;
    }

    public function setLeftBarFile($leftBar) {
        $this->leftBar_file = $leftBar;
    }
    
    public function setContentFile($contentFile) {
        $this->content_file = $contentFile;
    }

    public function getContentFile() {
        return $this->content_file;
    }
    
    public function getMessaggioErrore() {
        return $this->messaggioErrore;
    }

    public function setMessaggioErrore($msg) {
        $this->messaggioErrore = $msg;
    }
    
    public function getMessaggioConferma() {
        return $this->messaggioConferma;
    }

    public function setMessaggioConferma($msg) {
        $this->messaggioConferma = $msg;
    }

    public function getPagina() {
        return $this->pagina;
    }

    public function setPagina($pagina) {
        $this->pagina = $pagina;
    }
    
    public function getSottoPagina() {
        return $this->sottoPagina;
    }

    public function setSottoPagina($sottoPagina) {
        $this->sottoPagina = $sottoPagina;
    }
}

