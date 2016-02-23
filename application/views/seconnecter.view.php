<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
?>
<section id="se-connecter">
    <div class="conteneur">
        <fieldset>
            <legend>
                <h2 class="titre">S'identifier</h2>
            </legend>
            <form id="se-connecter-form" method="POST" action="?controller=utilisateurs&action=seconnecter">
                <?php FormHelper::cleCSRF(); ?>
                <p class="erreur-form"> 
                    <?php echo $this->formMessage ?>
                </p>        
                <dl>
                    <dt>
                        <label for="login">Login : </label>
                    </dt>
                    <dd>
                        <input type="text" id="login" name="login" value="<?php echo $this->login ?>" placeholder="Votre login"/>
                    </dd>
                    
                    <dt>
                        <label for="mot_de_passe">Mot de passe : </label>
                    </dt>
                    <dd>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" value="<?php echo $this->mot_de_passe ?>" placeholder="Votre mot de passe"/>
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
    

