<?php
    defined('__FRAMEWORK3IL__') or die('Acces interdit');

    abstract class Controller {
        protected $actionParDefaut = null;
        
        /**Charge l'action par défaut
         * 
         * @param string $actionParDefaut
         * @throws Erreur
         */
        public function setActionParDefaut($actionParDefaut) {
            $methode = $actionParDefaut.'Action';
            if(!method_exists($this, $methode)){
                throw new Erreur('Méthode inexistante: '.$methode);
            }
            else{
                $this->actionParDefaut = $actionParDefaut;
            }
        }
        /** Renvoie l'action par defaut
         * 
         * @return string $actionParDefaut
         */
        public function getActionParDefaut() {
            return $this->actionParDefaut;
        }
        /**Exécute l'action demandée
         * 
         * @param string $nomAction
         * @throws Erreur
         */
        public function executer($nomAction) {
            $methode = $nomAction.'Action';
            if(!method_exists($this, $methode)){
                throw new Erreur('Méthode inexistante: '.$methode);
            }
            else{ $this->$methode();}
        }
    }

