<?php
    defined('__FRAMEWORK3IL__') or die('Acces interdit');
    
    class DataSet implements Iterator {
        
        protected $data = null;
        protected $ordre = null;
        protected $direction = null;
        
        /**Constructeur du DataSet
         * 
         * @param array $data
         * @param sting $ordre
         * @param string $direction
         */
        public function __construct($data, $ordre, $direction) {
            $this->data = $data;
            $this->ordre = $ordre;
            $this->direction = $direction;
        }
        /**
         * 
         * @return mixed
         */
        public function current() {
            return current($this->data);
        
        }
        /**
         * 
         * @return mixed
         */
        public function key() {
            return $this->data->key();
        
        }
        /**
         * 
         * @return mixed
         */
        public function next() {
            return next($this->data);
        
        }
        /**
         * 
         * @return mixed
         */
        public function rewind() {
            return reset($this->data);
        
        }
        /**
         * 
         * @return boolean
         */
        public function valid() {
            return key($this->data) !== null;
        }
        /**
         * 
         * @return mixed
         */
        public function getOrdre() {
            return $this->ordre;
        }
        /**
         * 
         * @return mixed
         */
        public function getDirection() {
            return $this->direction;
        }

    }
