<?php
setlocale(LC_TIME, 'fr_CA');
session_start();
/**
 * @author Laurence Fiset-Grenier<laurence.fg@live.fr>
 * @copyright © 2016 Cégep-Ste-Foy.
 * Date: 2016-02-29
 * Page des plats principaux du site
 */

//POUR AJOUTER UNE TABLE DANS LA TABLE SQL: ALTER TABLE `t_accueil` ADD `titre_accueil` TINYTEXT NOT NULL AFTER `texte_accueil`;
//POUR MODIFIER LE TITRE DANS L'ACCUEIL : UPDATE `bdCravates`.`t_accueil` SET `titre_accueil` = 'Accueil' WHERE `t_accueil`.`id_accueil` = 1;
//POUR AJOUTER UNE VALEUR DANS LA TABLE : INSERT INTO `bdCravates`.`t_login` (`id_login`, `usager`, `mot_de_passe`) VALUES (NULL, 'ulmus123', 'chachacha');

$strNiveau="../";
// Inclu la page de configuration, les fonctions
include($strNiveau."inc/scripts/config.inc.php");

$actif = "stages-international";
$erreur = "";

//Pour texte descriptif
/*try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLInter = "SELECT * FROM t_texte WHERE id_texte = 58";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultInter = $objConnMySQLi->query($strSQLInter)) {
        while ($objLigneInter = $objResultInter->fetch_object()) {
            //Assigner des données comme attributs du template
            $texteInter = $objLigneInter->texte;
        }
        $objResultInter->free_result();
    }
    if($objResultInter == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}


// Instancier, configurer et afficher le template
include_once($strNiveau.'inc/lib/Twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem($strNiveau.'templates');

$twig = new Twig_Environment($loader, array(
    'cache' => false,
    'debug' => true
    ));

$template = $twig->loadTemplate('principaux.html.twig');

echo $template->render(array(
    "niveau" => $strNiveau,
    "actif" => $actif,
    "erreur" => $erreur,
    "texteInter" => $texteInter

    ));

//Fermeture de la base de donnée
$objConnMySQLi->close();*/
?>