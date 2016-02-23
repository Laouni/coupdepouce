<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    class IndexController extends Controller{
        
        /**
         * Constructeur de IndexController
         */
        public function __construct() {
            $this->setActionParDefaut('index');
        }
        /**
         * Charge la page index
         */
        public function indexAction() {
            $page = Application::getPage();
            $page->ajouterCSS('index');
            $page->setTemplate('index');
            $page->setVue('index');
        }
    }

