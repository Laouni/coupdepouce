<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
?>
<!DOCTYPE html>

<html>
    <head>
        <title>Coup de pouce</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="styles/reset.css" media="all">
        <link rel="stylesheet" type="text/css" href="styles/coupdepouce.css" media="all">
    </head>
         
    <body>
        <section id="concept" class="clear">
            <div class="conteneur">
                <h2>Pour partager<br>bien plus que des cours</h2>
                <div id='gros-liens'>
                    <?php if(!Authentification::estConnecte()){ ?>
                    <a href="?controller=utilisateurs&action=ajouter">S'inscrire</a>
                    <a href="?controller=utilisateurs&action=seconnecter">S'identifier</a>
                    <?php }
                          else{ ?>
                    <br>
                    <br>
                    <a href="?controller=utilisateurs&action=deconnecter">Se déconnecter</a>
                    <?php } ?>
                </div>
            </div>
        </section>
        <section id="informations">
            <div id="description" class="fond-gris">
                <div class="conteneur">
                    <h2 class="titre">Bienvenue sur Coup de Pouce</h2>
                    <p>Coup de Pouce est une plateforme collaborative libre de 
                        l'école d'ingénieurs 3iL.<br/>Elle vise à valoriser l'entraide
                        entre élèves par l'organisation de sessions de tutorat.</p>
                </div>
            </div>
            <div id="etapes">
                <div class="conteneur">
                    <ul>
                        <li class="etape" >
                           <h2>Etape 1</h2>
                               <div>
                                     <img alt="logo créer compte" src="images/pen.png">
                               </div>
                           <h3>Créer un compte</h3> 
                        </li>
                        <li class="etape">
                           <h2>Etape 2</h2>
                                <div>
                                    <img alt="logo s'inscrire" src="images/calendar.png">
                                </div>
                           <h3>S'inscrire à une session</h3> 
                        </li>
                        <li class="etape">
                            <h2>Etape 3</h2>
                                <div>
                                    <img alt="logo assister session" src="images/thumb.png">
                                </div>
                            <h3>Assister à la session</h3>
                        </li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <div id="temoignage" class="fond-gris">
                <div class="conteneur">
                    <h2 class="titre">Un vrai plus dans mon cursus</h2>
                    <p>Grâce à Coup de Pouce j'ai enfin pu comprendre le TP de web.
                        <br/>Les explications des camarades sont souvent bien plus claires que celles du prof!<span class='signature'>Kévin S.</span></p>
                </div>
            </div>
            <div id="en-vedette">
                <div class="conteneur">
                    <div id="la-selection">
                        <div>
                            <img alt="web" src="images/web.jpg">
                            <div>Mieux que tout</div>
                        </div>
                        <div>
                            <div>
                                <h2 class="titre">En vedette</h2>
                                <h3>I2 - Web TP 1</h3>
                                <p>pour tout comprendre du premier de TP de Web, le HTML, le CSS, la mise en page ainsi que les
                                astuces de base à connaître du developpement Web.</p>
                            </div>
                        </div>
                    </div>
                    <div id="prochaines-sessions">
                        <h2 class="titre">Prochaines sessions</h2>
                        <ul>
                            <li>
                                <h3><a href="?controller=coups_de_pouce&action=afficher&id=11">I2 Web - CSS</a></h3>
                                <p>Fonctionnement des sélecteurs</p>
                                <div class="infos">
                                    <p>Date: 17/11/2014 à 17h30</p>
                                    <p>Lieu: Salle 206</p>
                                    <p>Places: 3/5</p>
                                </div>
                            </li>
                            <li>
                                <h3><a href="?controller=coups_de_pouce&action=afficher&id=12">I1 POO - Héritage</a></h3>
                                <p>Pour aller plus loin avec les classes avec l'ajout et/ou redéfinition</p>
                                <div class="infos">
                                    <p>Date: 22/11/2014 à 17h00</p>
                                    <p>Lieu: Salle 202</p>
                                    <p>Places: 3/6</p>
                                </div>
                            </li>
                            <li>
                                <h3><a href="?controller=coups_de_pouce&action=afficher&id=13">I3 Robotique - Faire parler Nao</a></h3>
                                <p>Utiliser la synthèse vocale du robot</p>
                                <div class="infos">
                                    <p>Date: 30/11/2014 à 17h00</p>
                                    <p>Lieu: Salle 202</p>
                                    <p>Places: 3/6</p>
                                </div>
                            </li>
                        </ul>    
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </section>
    </body>
</html>
