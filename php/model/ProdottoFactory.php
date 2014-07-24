<?php

class ProdottoFactory{

    private function __constructor() {}
    
    public function &prodottiPerCategoria(Categoria $categoria) {
        $prodotti = array();
        $query = "select 
                  prodotto.id esami_id,
                  prodotto.nome esami_voto,
                  prodotto.descrizione esami_data,
                  prodotto.costo insegnamenti_id,
                  prodotto.iva insegnamenti_titolo,
                  prodotto.prezzo_vendita insegnamenti_cfu,
                  prodotto.quantita insegnamenti_codice,
                  studenti.id studenti_id,
                  studenti.nome studenti_nome,
                  studenti.cognome studenti_cognome,
                  studenti.matricola studenti_matricola,
                  studenti.email studenti_email,
                  studenti.citta studenti_citta,
                  studenti.via studenti_via,
                  studenti.cap studenti_cap,
                  studenti.provincia studenti_provincia,
                  studenti.numero_civico studenti_numero_civico,
                  studenti.username studenti_username,
                  studenti.password studenti_password,
                  CdL.id CdL_id,
                  CdL.nome CdL_nome,
                  CdL.codice CdL_codice,
                  dipartimenti.id dipartimenti_id,
                  dipartimenti.nome dipartimenti_nome,
                  docenti.id docenti_id,
                  docenti.nome docenti_nome,
                  docenti.cognome docenti_cognome,
                  docenti.email docenti_email,
                  docenti.citta docenti_citta,
                  docenti.cap docenti_cap,
                  docenti.via docenti_via,
                  docenti.provincia docenti_provincia,
                  docenti.numero_civico docenti_numero_civico,
                  docenti.ricevimento docenti_ricevimento,
                  docenti.username docenti_username,
                  docenti.password docenti_password
                  


                  from esami 
                  join studenti on esami.studente_id = studenti.id
                  join insegnamenti on esami.insegnamento_id = insegnamenti.id
                  join CdL on studenti.cdl_id = CdL.id
                  join dipartimenti on CdL.dipartimento_id = dipartimenti.id
                  join docenti on insegnamenti.docente_id = docenti.id
                  where esami.studente_id = ?
                  ";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[esamiPerStudente] impossibile inizializzare il database");
            $mysqli->close();
            return $esami;
        }

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[esamiPerStudente] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $esami;
        }

        if (!$stmt->bind_param('i', $user->getId())) {
            error_log("[esamiPerStudente] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return $esami;
        }

        $esami = self::caricaEsamiDaStmt($stmt);
        foreach ($esami as $esame) {
            $this->caricaCommissione($esame);
        }
        $mysqli->close();
        return $esami;
    }

}