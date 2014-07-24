<?php

/**
 * Classe che rappresenta un generico utente del sistema
 */
class User {

    const Amministratore = 0;
    const Dipendente = 1;

    private $id;
    private $username;
    private $password;
    private $nome;
    private $cognome;
    private $email;
    private $ruolo;

    public function __construct() {}

    /**
     * Verifica se l'utente esista per il sistema
     * @return boolean true se l'utente esiste, false altrimenti
     */
    public function esiste() {
        // implementazione di comodo, va fatto con il db
        return isset($this->ruolo);
    }

    public function getUsername() {
        return $this->username;
    }

    /**
     * Imposta lo username per l'autenticazione dell'utente. 
     * I nomi che si ritengono validi contengono solo lettere maiuscole e minuscole.
     * La lunghezza del nome deve essere superiore a 5
     * @param string $username
     * @return boolean true se lo username e' ammissibile ed e' stato impostato,
     * false altrimenti
     */
    public function setUsername($username) {
        // utilizzo la funzione filter var specificando un'espressione regolare
        // che implementa la validazione personalizzata
        if (!filter_var($username, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/[a-zA-Z]{5,}/')))) {
            return false;
        }
        $this->username = $username;
        return true;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
        return true;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return true;
    }

    public function getCognome() {
        return $this->cognome;
    }

    public function setCognome($cognome) {
        $this->cognome = $cognome;
        return true;
    }

    public function getRuolo() {
        return $this->ruolo;
    }

    public function setRuolo($ruolo) {
            $this->ruolo = $ruolo;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $this->email = $email;
        return true;
    }

    public function getId(){
        return $this->id;
    }
    
    public function setId($id){
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if(!isset($intVal)){
            return false;
        }
        $this->id = $intVal;
    }
    
    /**
     * Compara due utenti, verificandone l'uguaglianza logica
     * @param User $user l'utente con cui comparare $this
     * @return boolean true se i due oggetti sono logicamente uguali, 
     * false altrimenti
     */
    public function equals(User $user) {

        return  $this->id == $user->id &&
                $this->nome == $user->nome &&
                $this->cognome == $user->cognome &&
                $this->ruolo == $user->ruolo;
    }
}
?>
