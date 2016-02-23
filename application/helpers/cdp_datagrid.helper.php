<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    class CDP_DatagridHelper extends Datagrid {
        
        public function titreRenderer($data){
            $titreRendu = $data['titre'];
            
?>          <a href="?controller=coups_de_pouce&action=afficher&id=<?php echo $data['id']; ?>" id="<?php echo 'cdp'.$data['id']?> "><?php return $titreRendu; ?></a>
<?php       }
        
        public function dateRenderer($data){
            $datecdp = DateTime::createFromFormat('Y-m-d H:i:s', $data['date']);
            $dateRendu = $datecdp->format('d/m/Y H:i');
            return $dateRendu;

        }
        
        public function nomRenderer($data){
            $prenom_nom = $data['nomprenom'];
            return $prenom_nom;
        }
        
        public function formationRenderer($data){
            $formationRendu = $data['formation'];
            return $formationRendu;
        }
        
        public function commandesRenderer($data){ 
            
            if(!Authentification::estConnecte()){ 
                return;
            }
            $visible = "disabled";
            if($data['utilisateur_id'] == Authentification::getUtilisateurId()){
                $visible = "";
            }
?>
            <button class="cmd_button cmd_editer" title="Editer" <?php echo $visible; ?>><img src="images/icone_edit.png" /></button>
            <button class="cmd_button orange cmd_supprimer" title="Supprimer" <?php echo $visible; ?>><img src="images/icone_delete.png" /></button> 
            <input type="hidden" name="id" value="<?php echo $data["id"]; ?>"/><?php
                
        }
    }

