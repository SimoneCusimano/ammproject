<?php

include_once 'Categoria.php';

class CategoriaFactory {
    
    private static $singleton;

    private function __constructor() { }

    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new CategoriaFactory();
        }
        return self::$singleton;
    }
    
    public function &getListaCategorie() {
        $categorie = array();
        $mysqli = new mysqli();
        $mysqli->connect(Settings::$db_host, Settings::$db_user, Settings::$db_password, Settings::$db_name);
        if (!isset($mysqli)) {
                error_log("[getListaCategorie] Impossibile inizializzare il database");
                $mysqli->close();
                return null;
        }
        if($mysqli->connect_errno != 0) {
            $idErrore = $mysqli->connect_errno;
            $msg = $mysqli->connect_error;
            error_log("[getListaCategorie] Errore nella connessione al server.", 0);
            //echo "Errore nella connessione $msgm, $idErrore";
            return null;
        }
        else {
            $stmt = $mysqli->stmt_init();
            $query = "  select 
                            categoria.id categoria_id,
                            categoria.nome categoria_nome,
                            categoria.descrizione categoria_descrizione
                        from categoria";
            $stmt->prepare($query);
            if (!isset($mysqli)) {
                error_log("[getListaCategorie] Impossibile inizializzare il database");
                $mysqli->close();
                return $categorie;
            }
            $result = $mysqli->query($query);
            if ($mysqli->errno > 0) {
                error_log("[getListaCategorie] Impossibile eseguire la query");
                $mysqli->close();
                return $categorie;
            }
            while ($row = $result->fetch_array()) {
                $categorie[] = self::creaCategorieDaArray($row);
            }
            $mysqli->close();
            return $categorie;
        }
    }
    
    public function creaCategorieDaArray($row) {
        $categoria = new Categoria();
        $categoria->setId($row['categoria_id']);
        $categoria->setNome($row['categoria_nome']);
        $categoria->setDescrizione($row['categoria_descrizione']);
        
        return $categoria;
    }
}

