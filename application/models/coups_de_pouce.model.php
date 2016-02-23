<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    class Coups_De_PouceModel extends Model {

        /**Renvoie les coups de pouces suivant l'id
         * 
         * @param int $id
         * @return array $data
         * @throws Erreur
         */
        public function detail($id) {
            if($id == 0){
                throw new Erreur('Mauvais identifiant');
            }
            $sql = "SELECT cdp.id, cdp.titre, cdp.accroche, cdp.description, cdp.date, cdp.salle, cdp.places, cdp.formation, cdp.utilisateur_id, users.nom, users.prenom, COUNT(*) AS inscrits 
                    FROM coup_de_pouce AS cdp 
                    JOIN utilisateurs AS users 
                    JOIN inscriptions AS inscrip 
                    WHERE cdp.id = :id 
                    AND cdp.id = inscrip.coup_de_pouce_id
                    AND cdp.utilisateur_id = users.id";
            $req = $this->db->prepare($sql);
            $req->bindValue(':id', $id);
            try {
                $req->execute();
            } catch (PDOException $exc) {
                throw new Erreur("Erreur SQL ".$exc->getMessage());
            }
            $data = $req->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
        
        /**Sauvegarde le nouveau coup de pouce dans ma base
         * 
         * @param string $titre
         * @param string $accroche
         * @param string $description
         * @param string $date
         * @param int $salle
         * @param int $places
         * @param string $formation
         * @throws Erreur
         */
        public function sauver($titre, $accroche, $description, $date, $salle, $places, $formation) {
            
            $dateCourante = date('Y-m-d H:i:s');
            $dateCdp = DateTime::createFromFormat('d/m/Y H:i', $date);
            
            $req = $this->db->prepare("INSERT INTO coup_de_pouce  SET titre = :titre, accroche = :accroche, description = :description, utilisateur_id = :utilisateur_id, date = :date, salle = :salle, places = :places, formation = :formation, creation = :creation ");
            $req->bindValue(':titre',$titre); 
            $req->bindValue(':accroche',$accroche);
            $req->bindValue(':description',$description);
            $req->bindValue(':utilisateur_id', Authentification::getUtilisateurId());
            $req->bindValue(':date',  $dateCdp->format('Y-m-d H:i:s'));
            $req->bindValue(':salle',$salle);
            $req->bindValue(':places',$places);
            $req->bindValue(':formation',$formation);
            $req->bindValue(':creation',$dateCourante);
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur("Erreur SQL: ".$ex->getMessage());
            }
        }
        
        /**Modifie le coup de pouce demandé suivant son id
         * 
         * @param int $id
         * @param string $titre
         * @param string $accroche
         * @param string $description
         * @param typestring $date
         * @param int $salle
         * @param int $places
         * @param string $formation
         * @throws Erreur
         */
        public function modifier($id, $titre, $accroche, $description, $date, $salle, $places, $formation) {
            
            $dateCourante = date('Y-m-d H:i:s');
            $dateCdp = DateTime::createFromFormat('d/m/Y H:i', $date);
            
            $req = $this->db->prepare("UPDATE coup_de_pouce  SET titre = :titre, accroche = :accroche, description = :description, date = :date, salle = :salle, places = :places, formation = :formation, creation = :creation WHERE id = :id AND utilisateur_id = :utilisateur_id");
            $req->bindValue(':id',$id); 
            $req->bindValue(':titre',$titre);
            $req->bindValue(':accroche',$accroche);
            $req->bindValue(':description',$description);
            $req->bindValue(':utilisateur_id', Authentification::getUtilisateurId());
            $req->bindValue(':date',$dateCdp->format('Y-m-d H:i:s'));
            $req->bindValue(':salle',$salle);
            $req->bindValue(':places',$places);
            $req->bindValue(':formation',$formation);
            $req->bindValue(':creation',$dateCourante);
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur("Erreur SQL: ".$ex->getMessage());
            }
        }
        
        /**Liste les coups de pouce suivant un ordre et une direction
         * 
         * @param string $ordre
         * @param string $direction
         * @return \DataSet
         * @throws Erreur
         */
        public function lister($ordre="date", $direction="desc") {
            
            $list = array("titre", "formation", "date", "nomprenom");
            if(!in_array($ordre, $list)){
                throw new Erreur("Cette colonne n'ai pas dans la liste ".$ordre);
            }
            
            $sens = array("asc", "desc");
            if(!in_array($direction, $sens)){
                throw new Erreur("Cette direction n'est pas disponible dpour cette colonne ".$sens);
            }
                
            $sql = 'SELECT cdp.id, cdp.titre, cdp.accroche, 
                           cdp.description, cdp.utilisateur_id, 
                           cdp.date, cdp.salle, cdp.places, 
                           cdp.formation, cdp.creation,
                           users.nom, users.prenom,
                           CONCAT(prenom," ", nom) nomprenom
                    FROM coup_de_pouce cdp
                    INNER JOIN utilisateurs users
                    WHERE  cdp.utilisateur_id = users.id
                    ORDER BY '.$ordre.' '.$direction.'';
            $req = $this->db->prepare($sql);
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur("Erreur SQL: ".$ex->getMessage());
            }
            $data =  $req->fetchAll(PDO::FETCH_ASSOC);
            
            $objDataset = new DataSet($data, $ordre, $direction);
            return $objDataset;
        }
        
        /**
         * Suppression d'un coup de pouce
         * @param int $cdp_id
         * @throws Erreur
        */
        public function supprimer($cdp_id){
            $sql = "DELETE FROM coup_de_pouce WHERE id = :id";

            $req = $this->db->prepare($sql);
            $req->bindValue(':id',$cdp_id);
            try {
               $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur('Erreur SQL '.$ex->getMessage());
            }
        }

    }

