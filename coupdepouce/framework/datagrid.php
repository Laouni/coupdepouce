<?php
    defined('__FRAMEWORK3IL__') or die('Acces interdit');
    
    abstract class Datagrid {
        protected $data = null;
        protected $colonnes = null;
        protected $id = "";
        protected $classesCSS = array('datagrid'); 
        private   $ligne;
        
        /**
         * Constructeur initialise les propriétés $data et $colonnes
         * 
         * @param array $data
         * @param array $colonne
         */
        public function __construct($data,$colonne) {
            $this->data = $data;
            $this->colonnes = $colonne;
        }
        
        /**
         * Setter pour data : alimente le DataGrid en données
         * 
         * @param array $data
         * 
         */
        public function setData($data){
            $this->data = $data;
        }
        
        /**
         * Setter pour les colonnes : fournit la description des colonnes du DataGrid
         * 
         * @param array $colonne
         */
        public function setColonnes($colonne){
            $this->colonnes = $colonne;
        }
        
        
        /**
         * Setter pour l'id du DataGrid à faire figurer dans le code HTML
         * 
         * @param type $id
         */
        public function setId($id){
            $this->id = $id;
        }
        
        /**
         * Ajoute une classe CSS au tableau classeCSS
         * 
         * @param string $classe
         */
        public function ajouterClasse($classe){
            array_push(self::$_instance->classesCSS, $classe);
        }  
        
        /**
         * Réalise l'affichage de l'attribut id si celui-ci n'est pas null
         */
        public function id() {
            if(!empty($this->id)){
                echo "id = ".$this->id;
            }
        }
        
        /**
         * Réalise l'affichage de l'attribut class à partir du tableau classesCSS
         */
        public function classes() {
            echo implode($this->classesCSS);
        }
        
        /**
         * Réalise l'affichage du titre d'une colonne
         * @param string $col
         */
        public function afficherTitreColonne($col) { 
            // Si pas d'indication triable, ou indication non triable, ou pas de DataSet
            // On affiche le titre sans lien
            if(!isset($col['triable']) 
                    || (isset($col['triable']) && $col['triable']===false) 
                    || !is_a($this->data,'DataSet')) {
                echo $col['titre'];
                return;
            }
            
            $css = array("tri");
            
            $url = HTTPHelper::getParametresURL();            
            $url['direction'] = $this->data->getDirection();
            $url['ordre'] = $col['data'];
            
            // Si c'est la colonne de tri courante
            if($this->data->getOrdre() == $col['data']){
                // Quelle est la direction courante 
                if($this->data->getDirection()=='asc'){
                    $url['direction'] = 'desc';
                    $css[] = 'asc';
                } else {
                    $url['direction'] = 'asc';
                    $css[] = 'desc';
                }
            } else {
                $url['direction'] = 'asc';
            }
            
            $texteURL = '?'.http_build_query($url);
            $classes = implode(' ',$css);
            ?>
            <a href="<?php echo $texteURL;?>" class="<?php echo $classes;?>"><?php echo $col['titre'];?><span></span></a>
            <?php
        }
        
        /**
         * Retourne le numéro de la ligne en cours de rendu
         * @return int
         */
        public function getLigne(){ 
            return $this->ligne;
        }
        
        
        /**
         * Réalise l'affichage du DataGrid
         */
        public function afficher() {

            $this->ligne = 0;
            if(Application::getControleurCourant() == 'coups_de_pouce' && Application::getActionCourante() == 'lister'){
?>          <input type="button" value="Ajouter" onclick="self.location.href='?controller=coups_de_pouce&action=ajouter'"onclick>
            <?php } ?>
            <table <?php $this->id() ?> class="<?php $this->classes(); ?>">
               <thead><?php
                   foreach ($this->colonnes as $value) { ?>
                   <th><?php
                          $this->afficherTitreColonne($value);
                       //echo $value['titre']; ?>
                   </th>
                   <?php } ?>
               </thead>
                <tbody><?php
                    foreach ($this->data as $ligne) { 
                        $this->ligne++; ?> 
                    <tr><?php
                        foreach ($this->colonnes as $col) { ?>
                        <td><?php
                            if(!isset($col['rendu'])){
                                echo $ligne[$col["data"]]; 
                            }
                            else{
                                $method_Renderer = $col['rendu'];
                                
                                if(method_exists($this, $method_Renderer)){
                                    echo $this->$method_Renderer($ligne);
                                }
                                else{
                                    throw new Erreur('Methode de rendu inexistante:'.$method_Renderer);
                                }
                            } ?>                         
                        </td>
                        <?php } ?>
                    </tr> 
                    <?php } ?>
                </tbody>
            </table>
<?php
        }
        
    }
