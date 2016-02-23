<?php
    defined('__FRAMEWORK3IL__') or die('Acces interdit');
    
    abstract class FormHelper {
        
        const SESSION_KEY = 'framework3il.csrfToken';
        
        /**Génère une clé unique
         * 
         * @return type $_SESSION
         */        
        private static function getCle() {
            if(!isset($_SESSION[self::SESSION_KEY])){
                $_SESSION[self::SESSION_KEY] = hash("sha256", uniqid()); // generer la clé avec un numero unique encodé en SHA256
            }
            return $_SESSION[self::SESSION_KEY];
        }
        /**
         * Mets la clé générée dans un champs caché
         */
        public static function cleCSRF() {
            $maCle = FormHelper::getCle();
?>          <input type="hidden" name="<?php echo $maCle; ?>" value="0"/> <?php
        }
        /**Valide la cleCSRF
         * 
         * @return boolean
         */
        public static function validerCleCSRF() {
            if(!isset($_SESSION[self::SESSION_KEY])){
                return FALSE;
            }
            $postCle = HTTPHelper::post($_SESSION[self::SESSION_KEY], '');
            if($postCle !== '0'){
                return FALSE;
            }
            return TRUE;
        }
        
    }

