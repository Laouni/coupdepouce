<?php
    defined('__FRAMEWORK3IL__') or die('Acces interdit');
    
    class Authentification {
        protected $authTable;
        protected $authColId;
        protected $authColLogin;
        protected $authColMotDePasse;
        protected $authColSel;        
        protected $utilisateur = null;
        
        private static $_instance = null;
        
        const SESSION_KEY = 'framework3il.authentification';
                
        
        private function __construct($authTable,$authColId,$authColLogin,$authColMotDePasse,$authColSel){
            $this->authTable            = $authTable;
            $this->authColId            = $authColId;
            $this->authColLogin         = $authColLogin;
            $this->authColMotDePasse    = $authColMotDePasse;
            $this->authColSel           = $authColSel;
        }
        
        /**Crée une instance d'authentification
         * 
         * @param string $authTable
         * @param int $authColId
         * @param string $authColLogin
         * @param string $authColMotDePasse
         * @param type $authColSel
         * @return type
         */
        public static function getInstance($authTable=null,$authColId=null,$authColLogin=null,$authColMotDePasse=null,$authColSel=null){
            if(is_null(self::$_instance)){                
                self::$_instance = new Authentification($authTable, $authColId, $authColLogin, $authColMotDePasse,$authColSel);                
            }
            return self::$_instance;
        }
        /**Vérifie le login et mot de passe lors de l'authentification
         * 
         * @param string $login
         * @param string $motDePasse
         * @return boolean
         * @throws Erreur
         */
        public static function authentifier($login,$motDePasse){
         
            $db = Application::getDB();
            //$config = Application::getConfig();
            $req = $db->prepare('SELECT '.self::$_instance->authColId.' AS id,
                                        '.self::$_instance->authColMotDePasse.' AS mot_de_passe,
                                        '.self::$_instance->authColSel.' AS creation
                                 FROM '.self::$_instance->authTable.' WHERE '.self::$_instance->authColLogin.' = :login');
            $req->bindValue(':login', $login, PDO::PARAM_STR);
            try {
                $req->execute();
            } catch (PDOException $exc) {
                throw new Erreur("Erreur SQL: " .$exc->getMessage());
            }
            
            $utilisateur = $req->fetch(PDO::FETCH_ASSOC); //recupération du résultat de la requête
            
            if(is_null($utilisateur)){
                return FALSE;
            }
            
            if(Authentification::encoder($motDePasse, $utilisateur["creation"]) != $utilisateur["mot_de_passe"]){
                return FALSE;
            }
            else{
                $_SESSION[self::SESSION_KEY] = $utilisateur["id"];
                return TRUE;
            }
        }
        /**Charge le nom et prenom de l'utilisateur connecté et l'affiche sur l'écran
         * 
         * @throws Erreur
         */
        public function chargerUtilisateur() {
            if(!isset($_SESSION[self::SESSION_KEY])){
                throw new Erreur("Utilisateur non connecté");
            }
            
            $db = Application::getDB();
            $req = $db->prepare('SELECT * FROM '.$this->authTable.' WHERE '.$this->authColId.'= :id');
            $req->bindValue(':id', $_SESSION[self::SESSION_KEY], PDO::PARAM_STR);
            try {
                $req->execute();
            } catch (PDOException $exc) {
                throw new Erreur("Erreur SQL: " .$exc->getMessage());
            }
            
            $this->utilisateur = $req->fetch(PDO::FETCH_ASSOC);
            unset($this->utilisateur["mot_de_passe"]); // detruit le mot de passe
        }
        /**
         * Déconnecte l'utilisateur qui était connecté et détruit sa session
         */
        public static function deconnecter() {
            self::$_instance->utilisateur = NULL;
            unset($_SESSION[self::SESSION_KEY]);
            session_destroy();
        }
        /**Vérifie si un utilisateur est connecté ou non
         * 
         * @return boolean
         */
        public static function estConnecte() {
            if(isset($_SESSION[self::SESSION_KEY])){
                return TRUE;
            }
        }
        /**
         * 
         * @return array $utilisateur
         */
        public static function getUtilisateur() {
            if(is_null(self::$_instance->utilisateur)){
                self::$_instance->chargerUtilisateur();
            }
            return self::$_instance->utilisateur;
        }
        /**Retourne l'id de l'utilisateur connecté
         * 
         * @return type $_SESSION
         * @throws Erreur
         */
        public static function getUtilisateurId() {
            if(!isset($_SESSION[self::SESSION_KEY])){
                throw new Erreur("Utilisateur non conecté");
            }
            return $_SESSION[self::SESSION_KEY];
        }
        /**Encode le mot de passe saisi par l'utilisateur
         * 
         * @param string $motDePasse
         * @param type $sel
         * @return string $hash
         */
        public static function encoder($motDePasse,$sel) {
            $salt = hash('sha256', $sel); //encodage du sel avec la fonction hash() et l'algo sha256
            $hash = hash('sha256', $motDePasse.$sh1);
            return $hash;
        }
        
    }
