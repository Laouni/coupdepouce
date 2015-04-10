<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    Application::useHelper('navigation');
    Application::useHelper('utilisateur');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Coup de pouce</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="styles/reset.css" media="all">
        <link rel="stylesheet" type="text/css" href="styles/coupdepouce.css" media="all">
        <link rel="stylesheet" type="text/css" href="styles/application.css" media="all">
        <?php Page::enteteCSS(); ?>
        <script  type="text/javascript" src="javascript/jquery-2.1.1.js"></script>
    </head>
         
    <body>
        <header id="page-header">
            <div class="conteneur">
                <div id="bloc-logo">
                    <a href="?controller=index&action=index"><img alt="logo coup de pouce" src="images/coupdepouce_logo.png"></a>
                </div>
                <nav id="bloc-navigation">
                    <?php NavigationHelper::afficher(); ?>
                </nav>
            </div>
        </header>
        <main>
            <div class="conteneur">
                <section id="application">
                    <?php Page::afficherVue();?>
                </section>
                <aside id="subnav"> 
                    <?php UtilisateurHelper::afficher(); ?>
                </aside>
            </div>
        </main>
        <footer id="page-footer" class="clear">
            <div class="conteneur">
                <ul>
                    <li class="footer-links">
                        <h2>Plan du site</h2>
                        <ul>
                            <li><a href="?controller=index&action=index">Acceuil</a></li>
                            <li><a href="?controller=coups_de_pouce&action=lister">Prochaines Sessions</a></li>
                            <li><a href="?controller=utilisateurs&action=seconnecter">S'identifier</a></li>
                        </ul>
                    </li>
                    <li class="footer-links">
                        <h2>Liens externes</h2>
                        <ul>
                            <li><a href="http://www.3il-ingenieurs.fr/">3iL Ecole d'Ingénieurs</a></li>
                            <li><a href="http://www.cs2i-limoges.fr/">CS2i</a></li>
                            <li><a href="http://eleves.3il-ingenieurs.fr/">Espace Elèves</a></li>
                        </ul>
                    </li>
                    <li class="footer-links">
                        <h2>Inspiration</h2>
                        <ul>
                            <li><a href="http://www.rockettheme.com/joomla/templates/anacron">Template Anacron de RocketThemes</a></li>
                            <li><a href="http://www.joomla.fr/">Joomla</a></li>
                            <li><a href="http://framework.zend.com/">Zend Framework</a></li>
                            <li><a href="http://kudakurage.com/ligature_symbols/">Ligature Symboles(icônes)</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
             <div class="clear"></div>
        </footer>
        <?php Page::inclureJS(); ?>
    </body>
</html>

