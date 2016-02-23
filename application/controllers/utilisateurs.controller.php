<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    Application::useModele('utilisateurs');  //pour pouvoir faire appel aux methodes du modèle utilisateurs
    Application::useModele('formations');
    
    class UtilisateursController extends Controller {
        
        /**Ajoute un nouvel utilisateur
         * 
         * @return type
         * @throws Erreur
         */
        public function ajouterAction() {
            
            $page = Application::getPage();
            $page->setTemplate('index');
            $page->setVue('ajouter_utilisateur');
            $page->ajouterCSS('form');
            $page->ajouterCSS('ajouter_utilisateur');
            $page->ajouterJS('ajouter_utilisateur');
            
            $formModel = new FormationsModel(); //création d'une instance de FormationsModel()
            $page->listeFormations = $formModel->lister();
            
            
            $page->nom = filter_var(HTTPHelper::post('nom', ''),FILTER_SANITIZE_STRING);//supprime tout code HTML dans le nom
            $page->nom = trim($page->nom);//trim élimine tout espace au debut ou a la fin de la chaine
            
            $page->prenom = filter_var(HTTPHelper::post('prenom', ''),FILTER_SANITIZE_STRING);
            $page->prenom = trim($page->prenom);
            
            $page->login = filter_var(HTTPHelper::post('login', ''),FILTER_SANITIZE_STRING);
            $page->login = trim($page->login);
            
            $page->mot_de_passe = filter_var(HTTPHelper::post('mot_de_passe', ''),FILTER_UNSAFE_RAW);
            
            $page->verification = filter_var(HTTPHelper::post('verification', ''),FILTER_UNSAFE_RAW);
            
            $page->email = filter_var(HTTPHelper::post('email', ''),FILTER_SANITIZE_STRING);
            $page->email = trim($page->email);
            
            $page->formation = filter_var(HTTPHelper::post('formation', ''),FILTER_SANITIZE_STRING);
            
            if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') == "GET"){ //permet de dire o programme ke s'il recoit une requete
                return;                                                //de type GET il doit sortir de la méthode ajouterAction()
            }                                                          // sans procéder aux vérifications
            
            if(!FormHelper::validerCleCSRF()){
                throw new Erreur("Session invalide");
            }
            
            if(empty($page->nom)){
                $page->formMessage = "Veuillez entrer un nom";
                return;         //==> si on a une erreur ne plus verifier le reste et sortir de la méthode ajouterAction()
            }
            if(strlen($page->nom) > 256){
                $page->formMessage = "Votre nom doit contenir 256 caractères max";
                return;
            }
            
            if(empty($page->prenom)){
                $page->formMessage = "Veuillez entrer un prénom";
                return;
            }
            if(strlen($page->prenom) > 256){
                $page->formMessage = "Votre prénom doit contenir 256 caractères max";
                return;
            }
            
            if(empty($page->login)){
                $page->formMessage = "Veuillez entrer un login";
                return;
            }
            if(strlen($page->login) < 4){
                $page->formMessage = "Votre login doit contenir 4 caractères minimum";
                return;
            }
            if(strlen($page->login) > 32){
                $page->formMessage = "Votre login doit contenir 32 caractères max";
                return;
            }
            if(strpos($page->login, ' ')){
                $page->formMessage = "Les espaces sont interdits dans la definition de votre login";
                return;
            }
            $log = new UtilisateursModel();
            if($log->loginExiste($page->login)){ // verfifie si le login existe déja
                $page->formMessage = "Ce login existe déja! Veuillez saisir un autre";
                return;
            }
            
            if(empty($page->email)){
                $page->formMessage = "Veuillez entrer votre email";
                return;
            }
            if(strlen($page->email) > 256){
                $page->formMessage = "Votre email doit contenir 256 caractères max";
                return;
            }
            if(!filter_var($page->email, FILTER_VALIDATE_EMAIL)){
                $page->formMessage = "Adresse mail invalide";
                return;
            }
            
            if(empty($page->mot_de_passe)){
                $page->formMessage = "Veuillez entrer votre mot de passe";
                return;
            }
            if(strlen($page->mot_de_passe) < 5){
                $page->formMessage = "Votre mot de passe doit contenir 5 caractères minimum";
                return;
            }
            
            if(empty($page->verification)){
                $page->formMessage = "Veuillez entrer de nouveau votre mot de passe";
                return;
            }
            if(strlen($page->verification) < 5){
                $page->formMessage = "Votre mot de passe doit contenir 5 caractères minimum";
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
            
            $model = new UtilisateursModel();   //création d'une instance de modèle utilisateurs
            $model->enregistrer($page->nom, $page->prenom, $page->login, $page->email, $page->mot_de_passe, $page->formation); //enregistrer le nom et prenom saisis dans la BD
            
            HTTPHelper::rediriger('index.php?controller=utilisateurs&action=enregistrer'); //permet de faire une redirection vers la méthode enregistrerAction() 
        }
        
        /**
         * renvoie sur la page de confirmation d'enregistrement d'un nouvel utilisateur
         */
        public function enregistrerAction() {
            $page = Application::getPage();
            $page->setTemplate('index');
            $page->setVue('utilisateur_enregistre');
            $page->ajouterCSS('enregistrer');
        }
        
        /**Vérifie les données entrées par un utilisateur lors de sa connexion 
         * 
         * @return type
         */
        public function seconnecterAction() {
            
            if(Authentification::estConnecte()){
                HTTPHelper::rediriger('index.php?controller=index&action=index');
            }
            
            $page = Application::getPage();
            $page->setTemplate('index');
            $page->setVue('seconnecter');
            $page->ajouterCSS('form');
            $page->ajouterCSS('seconnecter');
            $page->ajouterJS('seconnecter');
            
            $page->login = filter_var(HTTPHelper::post('login', ''),FILTER_SANITIZE_STRING);
            $page->login = trim($page->login);
            
            $page->mot_de_passe = filter_var(HTTPHelper::post('mot_de_passe', ''),FILTER_UNSAFE_RAW);
            
            
            if(empty($page->login)){
                $page->formMessage = "Veuillez entrer un login";
                return;
            }
            
            if(empty($page->mot_de_passe)){
                $page->formMessage = "Veuillez entrer votre mot de passe";
                return;
            }
            
            if(!Authentification::authentifier($page->login, $page->mot_de_passe)){
                $page->formMessage = "Login et Mot de passe incorrects";
            }
            else{ 
                HTTPHelper::rediriger('index.php?controller=coups_de_pouce&action=lister', '');// redirection vers l'affichage des prochaines sessions
                //$page->formMessage = "OK";
            }
            
        }
        /**
         * Déconnecte un utilisateur 
         */
        public function deconnecterAction() {
            Authentification::deconnecter();
            HTTPHelper::rediriger('index.php?controller=index&action=index');
        }


    }

