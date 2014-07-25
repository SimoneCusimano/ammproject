<?php

include_once 'BaseController.php';

class AmministratoreController extends BaseController {
    
    
    public function __construct() {
        parent::__construct();
    }
    
    public function handleInput(&$request) {
        $vd = new ViewDescriptor();
        $vd->setPagina($request['page']);

        if (!$this->loggedIn()) {
            // utente non autenticato, rimando alla home
            $this->showLoginPage($vd);
        } else {
            // utente autenticato
            $user = UserFactory::instance()->cercaUtentePerId(
                    $_SESSION[BaseController::user], $_SESSION[BaseController::role]);

            // gestione dei comandi inviati dall'utente
            if (isset($request["cmd"])) {

                switch ($request["cmd"]) {

                    // logout
                    case 'logout':
                        $this->logout($vd);
                        break;
                    
                    case 'cancella':
                        if (isset($request['prodotto'])) {
                            $intVal = filter_var($request['prodotto'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $mod_prodotto = ProdottoFactory::instance()->cercaProdottoPerId($intVal);
                                if ($mod_prodotto != null) {
                                    if (ProdottoFactory::instance()->cancella($mod_prodotto) != 1) {
                                        $msg[] = '<li> Impossibile cancellare il prodotto </li>';
                                    }
                                }
                                $this->creaFeedbackUtente($msg, $vd, "Prodotto eliminato");
                            }
                        }
                        //$prodotti = ProdottoFactory::instance()->getListaProdotti();
                        $this->showHomeUtente($vd);
                        break;
                    
                    // default
                    default:
                        $this->showHomeUtente($vd);
                        break;
                }
            } else {
                // nessun comando, dobbiamo semplicemente visualizzare 
                // la vista
                // nessun comando
                $user = UserFactory::instance()->cercaUtentePerId(
                        $_SESSION[BaseController::user], $_SESSION[BaseController::role]);
                $this->showHomeUtente($vd);
            }
        }


        // richiamo la vista
        require basename(__DIR__) . '/../view/master.php';
    }
    
}