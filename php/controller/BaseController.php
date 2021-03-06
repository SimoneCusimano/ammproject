<?php

include_once basename(__DIR__) . '/../view/ViewDescriptor.php';
include_once basename(__DIR__) . '/../model/User.php';
include_once basename(__DIR__) . '/../model/UserFactory.php';
include_once basename(__DIR__) . '/../model/Categoria.php';
include_once basename(__DIR__) . '/../model/CategoriaFactory.php';
include_once basename(__DIR__) . '/../model/Prodotto.php';
include_once basename(__DIR__) . '/../model/ProdottoFactory.php';

class BaseController {

    const user = 'user';
    const role = 'role';

    public function __construct() { }

    /**
     * Metodo per gestire l'input dell'utente. Le sottoclassi lo sovrascrivono
     * @param type $request la richiesta da gestire
     */
    public function handleInput(&$request) {
        // creo il descrittore della vista
        $vd = new ViewDescriptor();


        // imposto la pagina
        $vd->setPagina($request['page']);

        // gestion dei comandi
        // tutte le variabili che vengono create senza essere utilizzate 
        // direttamente in questo switch, sono quelle che vengono poi lette
        // dalla vista, ed utilizzano le classi del modello

        if (isset($request["cmd"])) {
            // abbiamo ricevuto un comando
            switch ($request["cmd"]) {
                case 'login':
                    $username = isset($request['user']) ? $request['user'] : '';
                    $password = isset($request['password']) ? $request['password'] : '';
                    $this->login($vd, $username, $password);
                    // questa variabile viene poi utilizzata dalla vista
                    if ($this->loggedIn()) {
                        $user = UserFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::role]);
                    }
                    break;
                default : $this->showLoginPage();
            }
        } else {
            if ($this->loggedIn()) {
                //utente autenticato
                // questa variabile viene poi utilizzata dalla vista
                $user = UserFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::role]);

                $this->showHomeUtente($vd);
            } else {
                // utente non autenticato
                $this->showLoginPage($vd);
            }
        }

        // richiamo la vista
        require basename(__DIR__) . '/../view/master.php';
    }

    /**
     * Verifica se l'utente sia correttamente autenticato
     * @return boolean true se l'utente era gia' autenticato, false altrimenti
     */
    protected function loggedIn() {
        return isset($_SESSION) && array_key_exists(self::user, $_SESSION);
    }

    /**
     * Imposta la vista master.php per visualizzare la pagina di login
     * @param ViewDescriptor $vd il descrittore della vista
     */
    protected function showLoginPage($vd) {
        $vd->setTitolo("AMM Project - Login");
        $vd->setMenuFile(basename(__DIR__) . '/../view/login/menu.php');
        $vd->setLogoFile(basename(__DIR__) . '/../view/login/logo.php');
        $vd->setContentFile(basename(__DIR__) . '/../view/login/content.php');
    }

    /**
     * Imposta la vista master.php per visualizzare la pagina di gestione
     * dello studente
     * @param ViewDescriptor $vd il descrittore della vista
     */
    protected function showHomeDipendente($vd) {
        $categorie = CategoriaFactory::instance()->getListaCategorie();
        $prodotti = ProdottoFactory::instance()->getListaProdotti();
        
        $vd->setTitolo("Amm Project - Dipendente");
        $vd->setMenuCategorie($categorie);
        $vd->setProdotti($prodotti);
        $vd->setMenuFile(basename(__DIR__) . '/../view/dipendente/menu.php');
        $vd->setLogoFile(basename(__DIR__) . '/../view/dipendente/logo.php');
        $vd->setContentFile(basename(__DIR__) . '/../view/dipendente/content.php');
    }

    /**
     * Imposta la vista master.php per visualizzare la pagina di gestione
     * dell'amministratore
     * @param ViewDescriptor $vd il descrittore della vista
     */
    protected function showHomeAmministratore($vd) {
        $categorie = CategoriaFactory::instance()->getListaCategorie();
        $prodotti = ProdottoFactory::instance()->getListaProdotti();
            
        $vd->setTitolo("Amm Project - Amministratore");
        $vd->setMenuCategorie($categorie);
        $vd->setProdotti($prodotti);
        $vd->setMenuFile(basename(__DIR__) . '/../view/amministratore/menu.php');
        $vd->setLogoFile(basename(__DIR__) . '/../view/amministratore/logo.php');
        $vd->setContentFile(basename(__DIR__) . '/../view/amministratore/content.php');
    }

    /**
     * Seleziona quale pagina mostrare in base al ruolo dell'utente corrente
     * @param ViewDescriptor $vd il descrittore della vista
     */
    protected function showHomeUtente($vd) {
        $user = UserFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::role]);
        switch ($user->getRuolo()) {
            case User::Dipendente:
                $this->showHomeDipendente($vd);
                break;

            case User::Amministratore:
                $this->showHomeAmministratore($vd);
                break;
        }
    }

    /**
     * Procedura di autenticazione 
     * @param ViewDescriptor $vd descrittore della vista
     * @param string $username lo username specificato
     * @param string $password la password specificata
     */
    protected function login($vd, $username, $password) {
        // carichiamo i dati dell'utente

        $user = UserFactory::instance()->caricaUtente($username, $password);
        if (isset($user) && $user->esiste()) {
            // utente autenticato
            $_SESSION[self::user] = $user->getId();
            $_SESSION[self::role] = $user->getRuolo();
            $this->showHomeUtente($vd);
        } else {
            $vd->setMessaggioErrore("Utente sconosciuto o password errata");
            $this->showLoginPage($vd);
        }
    }

    /**
     * Procedura di logout dal sistema 
     * @param type $vd il descrittore della pagina
     */
    protected function logout($vd) {
        // reset array $_SESSION
        $_SESSION = array();
        // termino la validita' del cookie di sessione
        if (session_id() != '' || isset($_COOKIE[session_name()])) {
            // imposto il termine di validita' al mese scorso
            setcookie(session_name(), '', time() - 2592000, '/');
        }
        // distruggo il file di sessione
        session_destroy();
        $this->showLoginPage($vd);
    }

    /**
     * Crea un messaggio di feedback per l'utente 
     * @param array $msg lista di messaggi di errore
     * @param ViewDescriptor $vd il descrittore della pagina
     * @param string $okMsg il messaggio da mostrare nel caso non ci siano errori
     */
    protected function creaFeedbackUtente(&$msg, $vd, $okMsg) {
        if (count($msg) > 0) {
            // ci sono messaggi di errore nell'array,
            // qualcosa e' andato storto...
            $error = "Si sono verificati i seguenti errori \n<ul>\n";
            foreach ($msg as $m) {
                $error = $error . $m . "\n";
            }
            // imposto il messaggio di errore
            $vd->setMessaggioErrore($error);
        } else {
            // non ci sono messaggi di errore, la procedura e' andata
            // quindi a buon fine, mostro un messaggio di conferma
            $vd->setMessaggioConferma($okMsg);
        }
    }
}