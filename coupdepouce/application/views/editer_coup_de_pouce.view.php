<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    $formation = array_merge(array('---'), $this->listeFormations);
    $nbPlaces = 10;
    //print_r($this);
 ?>
<section id="editer-coup_de_pouce">
    <div class="conteneur">
        <fieldset>
            <legend>
                <?php if($this->action == 'ajouter'){ ?>
                <h2 class="titre">Ajouter un coup de pouce</h2>
                <?php }
                else{ ?>
                <h2 class="titre">Editer un coup de pouce</h2>
                <?php } ?>
            </legend>
            <form method="POST" action="?controller=coups_de_pouce&action=<?php echo $this->action;?>">
                <?php FormHelper::cleCSRF(); ?>
                <p class="erreur-form"> 
                <?php echo $this->formMessage;?>
                </p>
                <input type="hidden" name="id" value="<?php echo $this->id;?>" />    
                <dl>
                    <dt>
                       <label for="titre">Titre :</label>
                    </dt>
                    <dd>
                        <input id="titre" name="titre" type="text" value="<?php echo $this->titre;?>"/>
                    </dd>
        
                    <dt>
                        <label for="accroche">Accroche :</label>
                    </dt>
                    <dd>
                       <input id="accroche" name="accroche" type="text" value="<?php echo $this->accroche;?>"/>
                    </dd>
        
                    <dt>
                       <label for="description">Description :</label>
                    </dt>
                    <dd>
                        <textarea id="description" name="description" type="text" rows="12" cols="45" <?php if($this->action == 'ajouter'){ ?>placeholder="Mettre la description de votre coup de pouce ici..."<?php } ?>><?php echo $this->description;?></textarea>
                    </dd>
        
                    <dt>
                        <label for="date">Date :</label>
                    </dt>
                    <dd>
                        <input id="date" name="date" type="text" value="<?php echo $this->date;?>" placeholder="jj/mm/aaaa hh:mm"/>
                    </dd>
        
                    <dt>
                        <label for="salle">Salle :</label>
                    </dt>
                    <dd>
                        <input id="salle" name="salle" type="text" value="<?php echo $this->salle;?>"/>
                    </dd>
        
                    <dt>
                        <label for="places">Places :</label>
                    </dt>
                    <dd>
                        <select id="places" name="places" type="select">
                            <?php
                            for($i=1; $i<=$nbPlaces; $i++):
                                HTMLHelper::option($i, $i, $this->places);
                            endfor;
                            ?>
                        </select>
                    </dd>
        
                    <dt>
                         <label for="formation">Formation : </label>
                    </dt>
                    <dd>
                        <select id="formation" name="formation">
                            <?php 
                            foreach ($formation as $libelle){
                                HTMLHelper::option($libelle, null, $this->formation);
                            } ?>
                        </select>
                    </dd>
                    <dt></dt>
                    <dd>
                        <button id="envoyer" name="envoyer" type="submit" value="1">Envoyer</button>
                    </dd>
               </dl>
           </form>
        </fieldset>
    </div>
</section>


