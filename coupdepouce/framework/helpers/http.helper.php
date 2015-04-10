<?php
    abstract class HTTPHelper{
        
        /**
         * 
         * @param string $source
         * @param string $cle
         * @param string $defaut
         * @return type $defaut
         */
        private static function fetch($source, $cle, $defaut=NULL) {
            if(isset($source[$cle])){
                return $source[$cle];
            }
            
            return $defaut;
        }
        /**Permet d'exécuter la méthode $_GET
         * 
         * @param string $cle
         * @param string $defaut
         * @return type
         */
        public static function get($cle, $defaut=NULL) {
            return self::fetch($_GET, $cle, $defaut);
        }
        /**Permet d'éxécuter la méthode $_POST
         * 
         * @param string $cle
         * @param string $defaut
         * @return type
         */
        public static function post($cle, $defaut=NULL) {
            return self::fetch($_POST, $cle, $defaut);
        }
        /**Fait une redirection vers un lien avec ou sans message
         * 
         * @param string $url
         * @param string $message
         */
        public static function rediriger($url, $message=NULL) {  
            if($message != NULL){
                Message::deposer($message);
            }
            if(!headers_sent()) {                        
                header('Location:'.$url);  
                die();
            } 
            else {                
?>              <script type="text/javascript">
                    window.location = "<?php echo $url;?>";
                </script>
<?php
            }
        }
        /**Renvoie les paramètres saisies dans url
         * 
         * @return string $url
         */
        public static function getParametresURL() {
            $url = parse_str($_SERVER['QUERY_STRING']);
            
            if(!isset($url['controller'])){
                $url['controller'] = Application::getControleurCourant();
            }
            
            if(!isset($url['action'])){
                $url['action'] = Application::getActionCourante();
            }
            
            return $url;
            
        }
    }
