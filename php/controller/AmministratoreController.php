<?php

include_once 'BaseController.php';

class AdminController extends BaseController {
    
    
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

            if (isset($request["subpage"])) {
                switch ($request["subpage"]) {
                    case 'registro':
                        $vd->setSottoPagina('registro');
                        break;
                    case 'Abbigliamento':
                        $vd->setSottoPagina('Abbigliamento');
                        break;
                    case 'scarpe':
                        $vd->setSottoPagina('scarpe');
                        break;
                    case 'elettronica':
                        $vd->setSottoPagina('elettronica');
                        break;
                    case 'integratori':
                        $vd->setSottoPagina('integratori');
                        break;
                    case 'borse':
                        $vd->setSottoPagina('borse');
                        break;

                    default:
                        $vd->setSottoPagina('home');
                        break;
                }
            }
            // gestione dei comandi inviati dall'utente
            if (isset($request["cmd"])) {

                switch ($request["cmd"]) {

                    // logout
                    case 'logout':
                        $this->logout($vd);
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
