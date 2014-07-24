<?php

include_once 'User.php';
include_once 'Settings.php';

class UserFactory {

    private static $singleton;

    private function __constructor() { }

    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new UserFactory();
        }
        return self::$singleton;
    }

    public function caricaUtente($username, $password) {
        $mysqli = new mysqli();
        $mysqli->connect(Settings::$db_host, Settings::$db_user, Settings::$db_password, Settings::$db_name);
        if (!isset($mysqli)) {
                error_log("[caricaUtente] Impossibile inizializzare il database");
                $mysqli->close();
                return null;
        }
        if($mysqli->connect_errno != 0) {
            $idErrore = $mysqli->connect_errno;
            $msg = $mysqli->connect_error;
            error_log("[caricaUtente] Errore nella connessione al server.", 0);
            //echo "Errore nella connessione $msgm, $idErrore";
            return null;
        }
        else {
            $stmt = $mysqli->stmt_init();
            $query = "  select
                            utente.id utente_id,
                            utente.username utente_username,
                            utente.password utente_password,
                            utente.nome utente_nome,
                            utente.cognome utente_cognome,
                            utente.email utente_email,
                            utente.ruolo utente_ruolo
                        from utente
                        where utente.username = ? and utente.password = ?";
            $stmt->prepare($query);
            if (!$stmt) {
                error_log("[caricaUtente] Impossibile inizializzare il prepared statement");
                $mysqli->close();
                return null;
            }
            if (!$stmt->bind_param('ss', $username, $password)) {
                error_log("[caricaUtente] Impossibile effettuare il binding in input");
                $mysqli->close();
                return null;
            }

            $utente = self::caricaUtenteDaStmt($stmt);
            if (isset($utente)) {
                // ho trovato uno studente
                $mysqli->close();
                return $utente;
            }
        }
    }

    private function caricaUtenteDaStmt(mysqli_stmt $stmt) {

        if (!$stmt->execute()) {
            error_log("[caricaDocenteDaStmt] Impossibile eseguire lo statement");
            return null;
        }

        $row = array();
        $bind = $stmt->bind_result(
                $row['utente_id'], 
                $row['utente_username'], 
                $row['utente_password'], 
                $row['utente_nome'], 
                $row['utente_cognome'],
                $row['utente_email'],
                $row['utente_ruolo']);
        if (!$bind) {
            error_log("[caricaUtenteDaStmt] Impossibile effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();

        return self::creaUtenteDaArray($row);
    }
    
    public function creaUtenteDaArray($row) {
        $user = new User();
        $user->setId($row['utente_id']);
        $user->setUsername($row['utente_username']);
        $user->setPassword($row['utente_password']);
        $user->setNome($row['utente_nome']);
        $user->setCognome($row['utente_cognome']);
        $user->setEmail($row['utente_email']);
        $user->setRuolo($row['utente_ruolo']);
        
        return $user;
    }
    
    public function cercaUtentePerId($id, $role) {
        $intval = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intval)) {
            return null;
        }
        $mysqli = new mysqli();
        $mysqli->connect(Settings::$db_host, Settings::$db_user, Settings::$db_password, Settings::$db_name);
        if (!isset($mysqli)) {
                error_log("[cercaUtentePerId] Impossibile inizializzare il database");
                $mysqli->close();
                return null;
        }
        if($mysqli->connect_errno != 0) {
            $idErrore = $mysqli->connect_errno;
            $msg = $mysqli->connect_error;
            error_log("[cercaUtentePerId] Errore nella connessione al server.", 0);
            //echo "Errore nella connessione $msgm, $idErrore";
            return null;
        }
        else {
            $stmt = $mysqli->stmt_init();
            $query = "  select
                            utente.id utente_id,
                            utente.username utente_username,
                            utente.password utente_password,
                            utente.nome utente_nome,
                            utente.cognome utente_cognome,
                            utente.email utente_email,
                            utente.ruolo utente_ruolo
                        from utente
                        where utente.id = ?";
            $stmt->prepare($query);
            if (!$stmt) {
                error_log("[cercaUtentePerId] Impossibile inizializzare il prepared statement");
                $mysqli->close();
                return null;
            }
            if (!$stmt->bind_param('i', $intval)) {
                error_log("[cercaUtentePerId] Impossibile effettuare il binding in input");
                $mysqli->close();
                return null;
            }
            return self::caricaUtenteDaStmt($stmt);
        }
    }
}
?>
