<?php

include_once 'Prodotto.php';

class ProdottoFactory {

    private static $singleton;

    private function __constructor() { }

    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new ProdottoFactory();
        }
        return self::$singleton;
    }
    
    public function &getListaProdotti() {
        $prodotti = array();
        $mysqli = new mysqli();
        $mysqli->connect(Settings::$db_host, Settings::$db_user, Settings::$db_password, Settings::$db_name);
        if (!isset($mysqli)) {
                error_log("[getListaProdotti] Impossibile inizializzare il database");
                $mysqli->close();
                return null;
        }
        if($mysqli->connect_errno != 0) {
            $idErrore = $mysqli->connect_errno;
            $msg = $mysqli->connect_error;
            error_log("[getListaProdotti] Errore nella connessione al server.", 0);
            //echo "Errore nella connessione $msgm, $idErrore";
            return null;
        }
        else {
            $stmt = $mysqli->stmt_init();
            $query = "select 
                        prodotto.id prodotto_id,
                        prodotto.nome prodotto_nome,
                        prodotto.descrizione prodotto_descrizione,
                        prodotto.costo prodotto_costo,
                        prodotto.iva prodotto_iva,
                        prodotto.prezzo_vendita prodotto_prezzoVendita,
                        prodotto.quantita prodotto_quantita,
                        categoria.nome categoria_nome
                      from prodotto
                      join categoria on prodotto.id_categoria=categoria.id";
            $stmt->prepare($query);
            if (!isset($mysqli)) {
                error_log("[getListaProdotti] Impossibile inizializzare il database");
                $mysqli->close();
                return $prodotti;
            }
            $result = $mysqli->query($query);
            if ($mysqli->errno > 0) {
                error_log("[getListaProdotti] Impossibile eseguire la query");
                $mysqli->close();
                return $prodotti;
            }
            while ($row = $result->fetch_array()) {
                $prodotti[] = self::creaProdottiDaArray($row);
            }
            $mysqli->close();
            return $prodotti;
        }
    }
    
    public function creaProdottiDaArray($row) {
        $prodotto = new Prodotto();
        $prodotto->setId($row['prodotto_id']);
        $prodotto->setNome($row['prodotto_nome']);
        $prodotto->setDescrizione($row['prodotto_descrizione']);
        $prodotto->setCosto($row['prodotto_costo']);
        $prodotto->setIva($row['prodotto_iva']);
        $prodotto->setPrezzoVendita($row['prodotto_prezzoVendita']);
        $prodotto->setQuantita($row['prodotto_quantita']);
        $prodotto->setCategoria($row['categoria_nome']);

        return $prodotto;
    }
    
    public function cercaProdottoPerId($prodottoId){
        $prodotti = array();
        $mysqli = new mysqli();
        $mysqli->connect(Settings::$db_host, Settings::$db_user, Settings::$db_password, Settings::$db_name);
        if (!isset($mysqli)) {
                error_log("[cercaProdottoPerId] Impossibile inizializzare il database");
                $mysqli->close();
                return null;
        }
        if($mysqli->connect_errno != 0) {
            $idErrore = $mysqli->connect_errno;
            $msg = $mysqli->connect_error;
            error_log("[getListaProdotti] Errore nella connessione al server.", 0);
            //echo "Errore nella connessione $msgm, $idErrore";
            return null;
        }
        else {
            $stmt = $mysqli->stmt_init();
            $query = "select 
                        prodotto.id prodotto_id,
                        prodotto.nome prodotto_nome,
                        prodotto.descrizione prodotto_descrizione,
                        prodotto.costo prodotto_costo,
                        prodotto.iva prodotto_iva,
                        prodotto.prezzo_vendita prodotto_prezzoVendita,
                        prodotto.quantita prodotto_quantita,
                        categoria.nome categoria_nome
                      from prodotto
                      join categoria on prodotto.id_categoria=categoria.id
                      where prodotto.id = ?";
            $stmt->prepare($query);
            if (!$stmt) {
                error_log("[caricaUtente] Impossibile inizializzare il prepared statement");
                $mysqli->close();
                return null;
            }
            if (!$stmt->bind_param('i', $prodottoId)) {
                error_log("[cercaProdottoPerId] Impossibile effettuare il binding in input");
                $mysqli->close();
                return $prodotti;
            }
            $prodotti =  self::caricaProdottoDaStmt($stmt);
            if(count($prodotti > 0)){
                $mysqli->close();
                return $prodotti[0];
            }else{
                $mysqli->close();
                return null;
            }
        }
    }
    
    private function &caricaProdottoDaStmt(mysqli_stmt $stmt){
        $prodotti = array();
         if (!$stmt->execute()) {
            error_log("[caricaProdottoDaStmt] Impossibile eseguire lo statement");
            return null;
        }
        $row = array();
        $bind = $stmt->bind_result(
                $row['prodotto_id'],
                $row['prodotto_nome'],
                $row['prodotto_descrizione'],
                $row['prodotto_costo'],
                $row['prodotto_iva'],
                $row['prodotto_prezzoVendita'],
                $row['prodotto_quantita'],
                $row['categoria_nome']);
        if (!$bind) {
            error_log("[caricaProdottoDaStmt] Impossibile effettuare il binding in output");
            return null;
        }
        while ($stmt->fetch()) {
            $prodotti[] = self::creaProdottiDaArray($row);
        }
        $stmt->close();
        return $prodotti;
    }
    
    public function cancella(Prodotto $prodotto){
        $query = "delete from prodotto where id = ?";
        return $this->modificaDB($prodotto, $query);
    }
    
    private function modificaDB(Prodotto $prodotto, $query){
        $mysqli = new mysqli();
        $mysqli->connect(Settings::$db_host, Settings::$db_user,
        Settings::$db_password, Settings::$db_name);
        if($mysqli->errno != 0){
            return null;
        }
        if (!isset($mysqli)) {
            error_log("[modificaDB] Impossibile inizializzare il database");
            return 0;
        }
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[modificaDB] Impossibile inizializzare il prepared statement");
            $mysqli->close();
            return 0;
        }
        if (!$stmt->bind_param('i',$prodotto->getId())) {
            error_log("[modificaDB] Impossibile effettuare il binding in input");
            $mysqli->close();
            return 0;
        }
        if (!$stmt->execute()) {
            error_log("[modificaDB] Impossibile eseguire lo statement");
            $mysqli->close();
            return 0;
        }
        $mysqli->close();
        return $stmt->affected_rows;
    }
}