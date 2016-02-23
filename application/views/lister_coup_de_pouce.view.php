<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    Application::useHelper('cdp_datagrid');
    
    $colonnes = array(
                    array("titre" => "Titre",       "data" => "titre",       "rendu" => "titreRenderer",       "triable" => true),
                    array("titre" => "Proposé par", "data" => "nomprenom",   "rendu" => "nomRenderer",         "triable" => true),
                    array("titre" => "Date",        "data" => "date",        "rendu" => "dateRenderer",        "triable" => true),
                    array("titre" => "Formation",   "data" => "formation",   "rendu" => "formationRenderer",   "triable" => true),
                    array("titre" => "Commandes",   "data" => "id",          "rendu" => "commandesRenderer"),
                );
    
    if(Message::hasMessage()): ?>
        <div class="message">
            <p><?php echo Message::retirer(); ?></p>  
        </div> <?php
    endif;
    
    $cdpdata = new CDP_DatagridHelper($this->data, $colonnes);
    $cdpdata->afficher();
?>
    <form id="commande-form" method="POST">
        <input type="hidden" id="id" name="id" />
    </form>
    



