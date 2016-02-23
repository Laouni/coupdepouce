<?php
    session_start();
    
    define('__FRAMEWORK3IL__', '');

    require_once 'framework/configuration.php';
    require_once 'framework/helpers/http.helper.php';
    require_once 'framework/controller.php';
    require_once 'framework/erreur.php';
    require_once 'framework/page.php';
    require_once 'framework/model.php';
    require_once 'framework/helpers/html.helper.php';
    require_once 'framework/authentification.php';
    require_once 'framework/helpers/form.helper.php';
    require_once 'framework/message.php';
    require_once 'framework/datagrid.php';
    require_once 'framework/dataset.php';
    
    class Application {
        private static $_instance = null;
        private $configuration = null;
        private $base = null;
        protected $controleurParDefaut = null;
        private $controleurCourant;
        private $actionCourante;
        private $cheminAbsolu;
        
        /**
         * 
         * @param string $fichierIni
         */
        private function __construct($fichierIni) { 
            $this->configuration = Configuration::getInstance($fichierIni);
            $this->base = new PDO('mysql:host=localhost;dbname=coupdepouce', 'root', '');
            $this->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->cheminAbsolu = realpath('.');
        }
        /**
         * Retourne l'instance de l'application
         * @param string $fichierIni
         * @return Application
         */
        public static function getInstance($fichierIni = "") {
            if(is_null(self::$_instance)){
                self::$_instance = new Application($fichierIni);
            }
            return self::$_instance;
        }
        /**
         * 
         * @return Configuration
         */
        public static function getConfig() {
            return self::$_instance->configuration;
        }
        /** Exécute le lien controller/action afin de renvoyer dans la bonne page
         * 
         * @throws Erreur
         */
        public function executer() {
            $this->controleurCourant = HTTPHelper::get('controller', $this->controleurParDefaut); //recuperation ds GET le nom du controlleur
            $fichierController = 'application/controllers/'.$this->controleurCourant.'.controller.php'; //générer le nom du fichier controleur
            if(!is_readable($fichierController)){
                throw new Erreur('Ficher de contrôleur introuvable: '.$fichierController);
            }
            else{
                require_once ($fichierController);
            }
            $classeController = $this->controleurCourant.'Controller'; //générer le nom de la classe utilisateurs
            if(!class_exists($classeController)){
                throw new Erreur('Classe introuvable: '.$classeController);
            }
            else{
                $objClasse = new $classeController; // creer un objet de nom de la classe
                $this->actionCourante = HTTPHelper::get('action', $objClasse->getActionParDefaut()); // recupération ds GET du nom de l'action a exécuter
                $objClasse->executer($this->actionCourante);
              
            }
            Page::afficher();
        }
        /**Retourne la page approprié
         * 
         * @return Page
         */
        public static function getPage() {
            return Page::getInstance();
        }
        /**Retourne la base spécifié
         * 
         * @return base
         */
        public static function getDB() {
            return self::$_instance->base;
        }
        /**Vérifie que le modèle demander existe
         * 
         * @param string $nomModel
         * @throws Erreur
         */
        public static function useModele($nomModel) {
            $nomFichier = 'application/models/'.$nomModel.'.model.php';
            if(!is_readable($nomFichier)){
                throw new Erreur('Fichier modèle introuvable');
            }
            else{
                require_once ($nomFichier);
            }
        }
        /**Vérifie que le controleur spécifié existe
         * 
         * @param string $controleurDefaut
         * @throws Erreur
         */
        public function setControleurParDefaut($controleurDefaut) {
            $fichierControleurDefaut = 'application/controllers/'.$controleurDefaut.'.controller.php';
            if(!is_readable($fichierControleurDefaut)){
                throw new Erreur('Fichier de contrôleur par défaut introuvable: '.$fichierControleurDefaut);
            }
            else{
                require_once ($fichierControleurDefaut);
            }
            $controleur = $controleurDefaut.'Controller';
            if(!class_exists($controleur)){
                throw new Erreur('Controleur introuvable: '.$controleur);
            }
            else{
                $this->controleurParDefaut = $controleurDefaut;
            }
        }
        /**Renvoie le controleur courant
         * 
         * @return string controleurCourant
         */
        public static function getControleurCourant() {
            return self::$_instance->controleurCourant;
        }
        /**Renvoie l'action courante
         * 
         * @return string $actionCourante
         */
        public static function getActionCourante() {
            return self::$_instance->actionCourante;
        }
        /**Renvoie le chemin
         * 
         * @return string $cheminAbsolu
         */
        public static function getCheminAbsolu() {
            return self::$_instance->cheminAbsolu;
        }
        /**Vérifie et renvoie le fichierHelper demander
         * 
         * @param string $nomHelper
         * @throws Erreur
         */
        public static function useHelper($nomHelper) {
            $fichierHelper = 'application/helpers/'.$nomHelper.'.helper.php';
            if(!file_exists($fichierHelper)){
                throw new Erreur('Helper manquant: '.$fichierHelper);
            }
            else{
                require_once ($fichierHelper);
            }
        }
        /**Charge les données pour l'authentification
         * 
         * @throws Erreur
         */
        public function utiliserAuthentification() {
            try {
                $auth = Authentification::getInstance("utilisateurs", "id", "login", "mot_de_passe", "creation"); //crétion de l'instance de la class Authentification
            } catch (Exception $exc) {
                throw new Erreur("Authentification non configurée: ".$exc->getMessage());
            }
                }
    }
    

