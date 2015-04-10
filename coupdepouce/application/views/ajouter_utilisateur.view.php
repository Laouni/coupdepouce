<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    $formation = array_merge(array('---'), $this->listeFormations); //ajoute a la listeFormations '---' en tout premier
 ?>
<section id="ajouter-utilisateur">
    <div class="conteneur">
        <fieldset>
            <legend>
                <h2 class="titre">S'inscrire</h2>
            </legend>
            <form method="POST" action="?controller=utilisateurs&action=ajouter">
                <?php FormHelper::cleCSRF(); ?>
                <p class="erreur-form"> 
                    <?php echo $this->formMessage ?>
                </p>        
                <dl>
                    <dt>
                        <label for="nom">Nom : </label>
                    </dt>
                    <dd>
                        <input type="text" id="nom" name="nom" value="<?php echo $this->nom ?>" maxlength="256" placeholder="Entrer votre nom"/>
                    </dd>

                    <dt>
                        <label for="prenom">Prénom : </label>
                    </dt>
                    <dd>
                        <input type="text" id="prenom" name="prenom" value="<?php echo $this->prenom ?>" maxlength="256" placeholder="Entrer votre prénom"/>
                    </dd>
                    
                    <dt>
                        <label for="login">Login : </label>
                    </dt>
                    <dd>
                        <input type="text" id="login" name="login" value="<?php echo $this->login ?>" placeholder="Votre login"/>
                    </dd>
                    
                    <dt>
                        <label for="email">Email : </label>
                    </dt>
                    <dd>
                        <input type="text" id="email" name="email" value="<?php echo $this->email ?>" placeholder="Votre email"/>
                    </dd>
                    
                    <dt>
                        <label for="mot_de_passe">Mot de passe : </label>
                    </dt>
                    <dd>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" value="<?php echo $this->mot_de_passe ?>" placeholder="Votre mot de passe"/>
                    </dd>
                    
                    <dt>
                        <label for="verification">Confirmation : </label>
                    </dt>
                    <dd>
                        <input type="password" id="verification" name="verification" value="<?php echo $this->verification ?>" placeholder="Entrer de nouveau votre mot de passe"/>
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
                        <button class="btn" type="submit">Envoyer</button>
                    </dd>
                </dl>    
            </form>
        </fieldset>
    </div>
</section>                    
    
