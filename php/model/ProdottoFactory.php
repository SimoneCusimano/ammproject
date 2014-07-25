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
            echo "Errore nella connessione $msgm, $idErrore";
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
}