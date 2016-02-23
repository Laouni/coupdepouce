<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    class INSCRITS_DatagridHelper extends Datagrid{
        
        public function dateRenderer($data){
            $dateInscrit = DateTime::createFromFormat('Y-m-d H:i:s', $data['date']);
            $dateRendu = $dateInscrit->format('d/m/Y H:i');
            return $dateRendu;
        }
        
        public function formationRenderer($data){
            $formation = $data['formation'];
            return $formation;
        }
        
        public function nomRenderer($data){
            $nom = $data['nom'];
            return $nom;
        }
        
        public function prenomRenderer($data){
            $prenom = $data['prenom'];
            return $prenom;
        }
        
        public function idRenderer($data){
            $id = $data['id'];
            return $id;
        }

    }
    
    
