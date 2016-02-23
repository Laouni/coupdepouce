<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit'); 
    
    Application::useHelper('inscrits_datagrid');
    
    $colInscrits = array(
                    array("titre" => "#",            "data" => "titre",     "rendu" => "idRenderer"),
                    array("titre" => "Prénom",       "data" => "prenom",    "rendu" => "prenomRenderer"),
                    array("titre" => "Nom",          "data" => "prenom",    "rendu" => "nomRenderer"),
                    array("titre" => "Formation",    "data" => "formation", "rendu" => "formationRenderer"),
                    array("titre" => "Date",         "data" => "date",      "rendu" => "dateRenderer"),
                );
    
    // Si il y a un message on le récupère
    $message = '';       
    if(Message::hasMessage()){
        $message = Message::retirer();
    }
    
    $dataInscrits = new INSCRITS_DatagridHelper($this->inscrits, $colInscrits);
    
    // Par défaut aucun bouton M'Inscrire ou Me Desinscrire n'est présent
    $afficherBouton = false;
    
    // Si l'utilisateur connecté n'est pas l'auteur du coup de pouce
    if($this->utilisateur_id != $this->cdp['utilisateur_id'] && $this->utilisateur_id != 0){
        $afficherBouton = true;
        if($this->dejaInscrit){
            $texteBouton = "Me désinscrire";    
            $actionBouton = "supprimer";
        } else {
            $texteBouton = "M'inscrire";
            $actionBouton = "ajouter";
        }
    }
    $dateCdp = DateTime::createFromFormat('Y-m-d H:i:s', $this->cdp['date']);
 ?>
<div id="coup-de-pouce">
    <!-- Gestion du bouton M'inscrire / Me Désinscrire -->
    <?php if($afficherBouton):?>
    <form action="?controller=inscriptions&action=<?php echo $actionBouton;?>" method="POST"> <br>       
        <input type="hidden" id="coup_de_pouce_id" name="coup_de_pouce_id" value="<?php echo $this->cdp['id'];?>" />
        <button type="submit" class="btn">
            <?php echo $texteBouton;?>
        </button>
    </form>
    <?php endif;?>    
    
    
    <h2><?php echo $this->cdp['titre'];?></h2>  
    
    <!-- Gestion du message -->
    <?php if($message != ''):?>  
    <div class="message">
        <p><?php echo $message;?></p>
    </div>
    <?php endif; ?>
    
    <!-- Affichage des informations du coup de pouce -->
    <dl>
        <dt>Date : </dt>
        <dd><?php echo $dateCdp->format('d/m/Y H:i'); //$this->cdp['date'];?></dd>
        <dt>Proposé par : </dt>
        <dd><?php echo $this->cdp['prenom'].' '.$this->cdp['nom'];?></dd>
        <dt>Description : </dt>
        <dd><?php echo $this->cdp['description'];?></dd>
        <dt>Salle : </dt>
        <dd><?php echo $this->cdp['salle'];?></dd>
        <dt>Places : </dt>
        <dd><?php echo $this->cdp['places']-$this->cdp['inscrits'].'/'.$this->cdp['places'];?></dd>
        <dt>Inscrits : </dt>
        <dd></dd>       
    </dl> 
    <!-- Emplacement du Datagrid des inscrits -->
    <div id="inscrits">
        <?php $dataInscrits->afficher(); ?>
    </div>
    
</div>