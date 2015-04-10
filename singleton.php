<?php
    class Singleton {
        private static $_instance = null;
        
        private function __construct() {
            
        }
        
        /*
         * Crée une instance
         */
        public static function getInstance() {
            if(is_null(self::$_instance)){
                self::$_instance = new Singleton();
            }
            return self::$_instance;
        }
    }


