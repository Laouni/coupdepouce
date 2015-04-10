<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    abstract class NavigationHelper {
        
        const VISIBILITE_CONSTANTE = 0;
        const VISIBILITE_CONNECTE = 1;
        const VISIBILITE_NONCONNECTE = 2;
        
        static $menu = array(
            array("titre"=>"Acceuil", "controller"=>"index", "action"=>"index", "visibilite"=>self::VISIBILITE_CONSTANTE), 
            array("titre"=>"Prochaines Sessions", "controller"=>"coups_de_pouce", "action"=>"lister", "visibilite"=>self::VISIBILITE_CONSTANTE),
            array("titre"=>"S'identifier", "controller"=>"utilisateurs", "action"=>"seconnecter", "visibilite"=>self::VISIBILITE_NONCONNECTE),
            array("titre"=>"Se déconnecter", "controller"=>"utilisateurs", "action"=>"deconnecter", "visibilite"=>self::VISIBILITE_CONNECTE)
            );
        
        public static function menuItem($M, $controleur, $action) {
              $nav_current = ""; 
                if(Application::getControleurCourant()==$controleur && Application::getActionCourante()==$action){
                $nav_current = "nav-current";
                }
?>
            <li class="nav-item <?php echo $nav_current; ?>">
        <a href="?controller=<?php echo $controleur;?>&action=<?php echo $action;?>"><?php echo $M;?></a>
        </li>  
        <?php }

        public static function afficher() {                     
?>      <ul> <?php        
            foreach (self::$menu as $item) { 
                switch ($item['visibilite']) {
                    case 0:
                        self::menuItem($item['titre'], $item['controller'], $item['action']);
                        break;
                    case 1:
                        if(Authentification::estConnecte()){
                            self::menuItem($item['titre'], $item['controller'], $item['action']);
                        }
                        break;
                    case 2:
                        if(!Authentification::estConnecte()){
                            self::menuItem($item['titre'], $item['controller'], $item['action']);
                        }
                        break;
                }   
            } ?>
        </ul>
  <?php }
}
    /*<ul>
        <li class="nav-item nav-current"><a href="#">Acceuil</a></li>
    </ul>*/

