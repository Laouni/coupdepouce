<?php
    defined('__FRAMEWORK3IL__') or die('Acces interdit');
    
    abstract class Model {
        protected $db = null;

        /**
         * Constructeur de Model
         */
        public function __construct() {
            $this->db = Application::getDB();
        }
    }


