<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    class UtilisateursModel extends Model {

        /**
         * 
         * @param string $nom
         * @param string $prenom
         * @param string $login
         * @param string $email
         * @param string $mot_de_passe
         * @param string $formation
         * @throws Erreur
         */
        public function enregistrer($nom,$prenom, $login, $email, $mot_de_passe, $formation) { 
            
            $dateCourante = date('Y-m-d H:i:s');
       
            $sql = "INSERT INTO utilisateurs SET nom = :nom, prenom = :prenom, login = :login, mot_de_passe = :mot_de_passe, email = :email, formation = :formation, creation = :creation";
            
            $req = $this->db->prepare($sql);
            $req->bindValue(':nom',$nom);  
            $req->bindValue(':prenom',$prenom);
            $req->bindValue(':login',$login);
            $req->bindValue(':email',$email);
            $req->bindValue(':mot_de_passe',  Authentification::encoder($mot_de_passe, $dateCourante));
            $req->bindValue(':formation',$formation);
            $req->bindvalue(':creation', $dateCourante);
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur("Erreur SQL: ".$ex->getMessage());
            }
            
        }
        
        /**Vérifie l'existence d'un coup de pouce
         * 
         * @param string $login
         * @return boolean
         * @throws Erreurr
         */
        public function loginExiste($login) {
            $this->login = $login;
            $req = $this->db->prepare("SELECT COUNT(*) FROM utilisateurs WHERE login = :login");
            $req->bindValue(':login', $this->login, PDO::PARAM_STR);
            try {
                $req->execute();
            } catch (PDOException $exc) {
                throw new Erreurr("Erreur SQL: " .$exc->getMessage());
            }

            if($req->fetchColumn() > 0){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
    }
    
    // william';INSERT INTO utilisateurs SET nom='Mechant', prenom='Pirate  :ceci introduit une injection SQL 
