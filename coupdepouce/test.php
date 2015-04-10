<?php
   define('__COUPDEPOUCE__', '');
   
   require_once 'framework/application.php';
   //Application::useHelper('test');
   $application = Application::getInstance('application/configuration.ini');
   $application->utiliserAuthentification();
   $application->setControleurParDefaut('index');
   $application->executer();
   
   //$configuration = Configuration::getInstance();
   $utilisateur = Authentification::getInstance('utilisateurs', '17');
   $utilisateur->chargerUtilisateur();
   //$controller = HTTPHelper::get('controller','utilisateurs') ;
   //print_r($_SESSION);
   print_r($utilisateur);
   //echo $application->getcheminAbsolu();
   echo $configuration->db_hostname;
   //echo '<pre>'.  printf($config, TRUE). '</pre>';
   