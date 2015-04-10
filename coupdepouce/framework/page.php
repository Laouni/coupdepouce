<?php
    defined('__FRAMEWORK3IL__') or die('Acces interdit');
    
    class Page {
        private static $_instance = null;
        private $vue = null;
        private $template = null;
        protected $CSS = array();
        protected $JS = array();
        public $formMessage = "";

        private function __construct() {
               
        }
        /**Crée l'instance de Page
         * 
         * @return type $_instance
         */
        public static function getInstance() {
            if(is_null(self::$_instance)){
                self::$_instance = new Page();
            }
            return self::$_instance;
        }
        /**Vérifie si la vue demandée existe
         * 
         * @param string $vue
         * @throws Erreur
         */
        public function setVue($vue) {
            $this->vue = 'application/views/'.$vue.'.view.php';
            if(!file_exists($this->vue)){
                throw new Erreur('Fichier de vue inexistant'.$this->vue);
            }
               
        }
        /**Vérifie si le template demandé existe
         * 
         * @param string $template
         * @throws Erreur
         */
        public function setTemplate($template) {
            $this->template = 'application/templates/'.$template.'.template.php';
            if(!file_exists($this->template)){
                throw new Erreur('Fichier de template inexistant'.$this->template);
            }
        }
        /**Affiche le template
         * 
         * @throws Erreur
         */
        public static function afficher() {
            if(empty(self::$_instance->template)){
                throw new Erreur('Template non renseigné'.self::$_instance->template);
            }
            require_once (self::$_instance->template);
        }
        /**
         * Insère la vue
         */
        private function insererVue() {
            require_once ($this->vue);
        }
        /**Affiche la vue
         * 
         * @throws Erreur
         */
        public static function afficherVue() {
            if(is_null(self::$_instance->vue)){
                throw new Erreur('Vue non renseigné'.self::$_instance->vue);
            }
            else{
                self::$_instance->insererVue();
            }
        }
        /**Ajoute un nouveau fichier CSS
         * 
         * @param string $nomFichierCSS
         * @throws Erreur
         */
        public function ajouterCSS($nomFichierCSS) {
            $fichierCSS = 'styles/'.$nomFichierCSS.'.css';
            if(!file_exists($fichierCSS)){
                throw new Erreur('Fichier CSS inexistant: '.$fichierCSS);
            }
            else{
                array_push(self::$_instance->CSS, $fichierCSS); //permet d'ajouter le fichier $fichierCSS dans le tableau $CSS
            }
        }
        /**
         * Charge le fichier CSS sur le navigateur
         */
        public static function enteteCSS() {
            
            foreach (self::$_instance->CSS as $fichierCSS) {
                ?><link rel="stylesheet" type="text/css" href="<?php echo $fichierCSS ?>" media="all"> <?php
            } 
        }
        /**Ajoute un nouveau fichier javascript
         * 
         * @param string $nomFichierJS
         * @throws Erreur
         */
        public function ajouterJS($nomFichierJS) {
            $fichierJS = 'javascript/'.$nomFichierJS.'.js';
            if(!file_exists($fichierJS)){
                throw new Erreur('Fichier javascript inexistant: '.$fichierJS);
            }
            else{
                array_push(self::$_instance->JS, $fichierJS); //permet d'ajouter le fichier $fichierCSS dans le tableau $CSS
            }
        }
        /**
         * Inclut le fichier javasript sur la page du navigateur
         */
        public static function inclureJS() {
            
            foreach (self::$_instance->JS as $fichierJS) {
                ?><script  type="text/javascript" src="<?php echo $fichierJS ?>"></script> <?php
            } 
        }
    }

/*<link rel="stylesheet" type="text/css" href="styles/reset.css" media="all">
<link rel="stylesheet" type="text/css" href="styles/coupdepouce.css" media="all">*/