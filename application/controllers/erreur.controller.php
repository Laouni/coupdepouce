<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    class ErreurController extends Controller{
        
        /**
         * Constructeur de ErreurController
         */
        public function __construct() {
            $this->setActionParDefaut('erreur');
        }
        /**
         * Renvoie le message d'erreur sur la page
         */
        public function erreurAction() {
            $page = Application::getPage();
            $page->setTemplate('application');
            $page->setVue('erreur');
            //die(var_dump(Message::retirer()));
            $page->erreur = Message::retirer();
            
        }
    }