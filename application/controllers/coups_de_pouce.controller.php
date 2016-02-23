<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    Application::useModele('coups_de_pouce');
    Application::useModele('formations');
    Application::useModele('inscriptions');

    class Coups_De_PouceController extends Controller {
        
        /**
         * Constructeur du Coups_De_Pouce
         */
        public function __construct() {
            $this->setActionParDefaut('lister');
            
        }
        /**
         * Liste les coups de pouce se trouvant dans la base de donnée
         */
        public function listerAction() {
            $page = Application::getPage();
            $page->setTemplate('application');
            $page->setVue('lister_coup_de_pouce');
            $page->ajouterCSS('datagrid');
            $page->ajouterJS('cdp_datagrid');
            
            // Récupérer les paramètres $ordre et $direction depuis l'URL
            $page->ordre = HTTPHelper::get('ordre', 'date');
            $page->direction = HTTPHelper::get('direction', 'desc');
            
            $model = new Coups_De_PouceModel();
            $page->data = $model->lister($page->ordre, $page->direction);
        }
        /**
         * Ajoute un nouveau coups de pouce dans la base
         */
        public function ajouterAction() {
        // A - Si non authentifié, rediriger vers Erreur avec le message "Vous devez être connecté"
            if(!Authentification::estConnecte()){
                HTTPHelper::rediriger('?controller=erreur', "Vous devez être connecté!");
            }
        
        // B - Appeler la méthode de récupération des données
            $this->_recuperation();
        
        // C - Appeler la méthode du formulaire avec pour paramètre 'ajouter'
            $this->_formulaire('ajouter');
        }
        /**
         * Récupère les données saisies dans le formulaire
         */
        private function _recuperation() {
        // D - Charger la Page
            $page = Application::getPage();
        
        // E - Récupérer l'id dans POST avec 0 comme valeur par défaut
            $page->id = HTTPHelper::post('id', '0');    
        
        // F - Récupérer le titre dans POST avec '' comme valeur par défaut, en faire un filter_var() + trim()
            $page->titre = filter_var(HTTPHelper::post('titre', ''),FILTER_SANITIZE_STRING);
            $page->titre = trim($page->titre);
            
            $page->accroche = filter_var(HTTPHelper::post('accroche', ''),FILTER_SANITIZE_STRING);
            $page->accroche = trim($page->accroche);
            
            $page->description = filter_var(HTTPHelper::post('description', ''),FILTER_SANITIZE_STRING);
            $page->description = trim($page->description);
            
            $page->date = filter_var(HTTPHelper::post('date', ''),FILTER_SANITIZE_STRING);
            $page->date = trim($page->date);
            
            $page->salle = filter_var(HTTPHelper::post('salle', ''),FILTER_SANITIZE_STRING);
            $page->salle = trim($page->salle);
            
            $page->places = filter_var(HTTPHelper::post('places', ''),FILTER_SANITIZE_NUMBER_INT);
            
            $page->formation = filter_var(HTTPHelper::post('formation', ''),FILTER_SANITIZE_STRING);    
            
        }
        /**Vérifie les données saisies lors de la création d'un coup de pouce en ajout ou en édition
         * 
         * @param string $action
         * @return type
         * @throws Erreur
         */
        private function _formulaire($action) {
        // G - Charger la Page
        //   - Réglages template + vue
        //   - Ajouter le paramètre $action dans Page
            $page = Application::getPage();
            $page->setTemplate('application');
            $page->setVue('editer_coup_de_pouce');
            $page->ajouterCSS('form');
            $page->ajouterCSS('editer_coup_de_pouce');
            $page->action = $action;
            
            $formModel = new FormationsModel(); //création d'une instance de FormationsModel()
            $page->listeFormations = $formModel->lister();
            
        // H - Si "envoyer" ne figure pas dans POST, return
            if(is_null(HTTPHelper::post('envoyer'))){
                return;
            }
            
            if(!FormHelper::validerCleCSRF()){
                throw new Erreur("Session invalide");
            }
        
        // I - Si le titre est vide, l'indiquer dans formMessage + return
            if(empty($page->titre)){
                $page->formMessage = "Veuillez saisir un titre";
                return;
            }
            
            if(strlen($page->titre) > 256){
                $page->formMessage = "Votre titre doit contenir 256 caractères max";
                return;
            }
            
            if(empty($page->accroche)){
                $page->formMessage = "Veuillez saisir une accroche";
                return;
            }
            
            if(strlen($page->accroche) > 256){
                $page->formMessage = "Votre accroche doit contenir 256 caractères max";
                return;
            }
            
            if(empty($page->description)){
                $page->formMessage = "Veuillez mettre une description de votre coup de pouce!";
                return;
            }
            
            if(strlen($page->description) > 2048){
                $page->formMessage = "Votre description doit contenir 2048 caractères max";
                return;
            }
            
            if(empty($page->date)){
                $page->formMessage = "Veuillez mettre une date!";
                return;
            }
            
            if(empty($page->salle)){
                $page->formMessage = "Veuillez mettre le numéro d'une salle";
                return;
            }
            
            if(strlen($page->salle) > 32){
                $page->formMessage = "Votre salle doit contenir 32 caractères max";
                return;
            }
            
            if($page->places < 1 && $page->places > 10){
                $page->formMessage = "Votre nombre de places max doit être compris entre 1 et 10";
                return;
            }
            
            if($page->formation == '---'){
                $page->formMessage = "Veuillez choisir une formation";
                return;
            }
            $formation = new FormationsModel();
            if($formation->estvalide($page->formation)){ //verifie si la formation saisi existe dans la liste
                $page->formMessage = "Cette formation est inconnue";
            }
        
        // J - Suivant le paramètre $action exécuter sur le modèle sauver() ou modifier()
        //   - Adapter le message à envoyer à la redirection
            $model = new Coups_De_PouceModel();
            if($action == "ajouter"){
                $model->sauver($page->titre, $page->accroche, $page->description, $page->date, $page->salle, $page->places, $page->formation);
                HTTPHelper::rediriger('?controller=coups_de_pouce&action=lister', "Coup de pouce bien enregistré");
            }
            
            if($action == "editer"){
                $model->modifier($page->id, $page->titre, $page->accroche, $page->description, $page->date, $page->salle, $page->places, $page->formation);
                HTTPHelper::rediriger('?controller=coups_de_pouce&action=lister', "Coup de pouce modifié!");
            }
        
        // K - Rediriger vers la liste des coups de pouce
            HTTPHelper::rediriger('?controller=coups_de_pouce&action=lister');
        }
        /**
         * Edite un coup de pouce existant
         */
        public function editerAction() {
        // L - Si non authentifié, rediriger vers Erreur avec le message "Vous devez être connecté"
            if(!Authentification::estConnecte()){
                HTTPHelper::rediriger('?controller=erreur', "Vous devez être connecté!");
            }
        
        // M - Récupérer dans le POST l'id du coup pouce à éditer, valeur par défaut 0
        //   - Si l'id == 0, rediriger vers Erreur avec le message "Erreur édition coup de pouce"
            $cdpid = HTTPHelper::post('id', '0');
            if($cdpid == 0){
                HTTPHelper::rediriger('?controller=erreur', "Erreur édition coup de pouce!");
            }
        
        // N - Charger le coup de pouce depuis le modèle
        //   - Si le modèle est null, rediriger vers Erreur avec le message "Erreur édition coup de pouce"
            $model = new Coups_De_PouceModel();
            $cdp = $model->detail($cdpid);
            //print_r($cdp);
            
            if($cdp == NULL){
                HTTPHelper::rediriger('?controller=erreur', "Erreur édition coup de pouce!");
            }
            
        // O - Si l'utilisateur connecté n'est pas le propriétaire, rediriger vers Erreur avec le message "Vous n'êtes pas le propriétaire du coup de pouce"
            if(Authentification::getUtilisateurId() != $cdp["utilisateur_id"]){
                HTTPHelper::rediriger('?controller=erreur', "Vous n'êtes pas le propriétaire de ce coup de pouce!");
            }
   
        // P - Si "envoyer" ne figure pas dans POST
        //   - Transférer les données du coup de pouce chargé dans la Page
        //   - Sinon lancer la récupération des données
            if(is_null(HTTPHelper::post('envoyer'))){
                $page = Application::getPage();
                $dateCdp = DateTime::createFromFormat('Y-m-d H:i:s', $cdp['date']);
                $page->id = $cdp['id'];
                $page->titre = $cdp['titre'];
                $page->accroche = $cdp['accroche'];
                $page->description = $cdp['description'];
                $page->date = $dateCdp->format('d/m/Y H:i');
                $page->salle = $cdp['salle'];
                $page->places = $cdp['places'];
                $page->formation = $cdp['formation'];
            }
            else {
                $this->_recuperation();
            }
        
        // Q - Lancer le formulaire avec pour paramètre 'editer'
            $this->_formulaire('editer');
        }
        /**
         * Supprime un coup de pouce
         */
        public function supprimerAction() {
            
            if($_SERVER['REQUEST_METHOD']=="GET") {
                HTTPHelper::rediriger('?controller=erreur','Action non autorisée');
            }
        
            if(!Authentification::estConnecte()){
                HTTPHelper::rediriger('?contoller=erreur','Vous devez être authentifié');
            }
        
            $cdp_id = filter_var(HTTPHelper::post('id',0),FILTER_SANITIZE_NUMBER_INT);
            if($cdp_id==0 || empty($cdp_id)){
                HTTPHelper::rediriger('?controller=erreur','Suppression impossible');
            }
        
            $model = new Coups_De_PouceModel();
            $cdp = $model->detail($cdp_id);
            if($cdp['utilisateur_id']!=Authentification::getUtilisateurId()){
                HTTPHelper::rediriger('?controller=erreur','Vous ne pouvez pas supprimer ce coup de pouce');
            }
        
            $model->supprimer($cdp_id);
            HTTPHelper::rediriger('?controller=coups_de_pouce&action=lister','Coup de pouce supprimé');
            
        }
        /**Affiche le coup de pouce sélectionné
         * 
         * @throws Erreur
         */
        public function afficherAction() {
            
            $page = Application::getPage();
            $page->setTemplate('application');
            $page->setVue('afficher_coup_de_pouce');
            $page->ajouterCSS('afficher_coup_de_pouce');
            $page->ajouterCSS('datagrid');
            
            $page->utilisateur_id = 0;
            if(Authentification::estConnecte()){
                $page->utilisateur_id = Authentification::getUtilisateurId();
            }
            
            $id = HTTPHelper::get('id');
            $cdpid = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            
            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new Erreur('Id non conforme');
            }
            
            $modelInscrits = new InscriptionsModel();
            $listeInscrits = $modelInscrits->lister($cdpid);
            $page->inscrits = $listeInscrits;
            //print_r($page->inscrits); die;
            
            $modeldejaInscrits = new InscriptionsModel();
            $page->dejaInscrit = $modeldejaInscrits->dejaInscrit($cdpid, $page->utilisateur_id);
            //print_r($page->dejaInscrit); die;
            
            $modelCdp = new Coups_De_PouceModel();
            $cdp = $modelCdp->detail($cdpid);
            if(!$cdp){
                throw new Erreur('Coup de pouce introuvable '.$cdpid);
            }
            $page->cdp = $cdp;
            //print_r($page->cdp); die;
        }
        
        
        
    }

