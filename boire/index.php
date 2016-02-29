<?php
setlocale(LC_TIME, 'fr_CA');
session_start();
/**
 * @author Laurence Fiset-Grenier<laurence.fg@live.fr>
 * @copyright © 2016 Cégep-Ste-Foy.
 * Date: 2016-02-29
 * Page de index boire du site
 */

//POUR AJOUTER UNE TABLE DANS LA TABLE SQL: ALTER TABLE `t_accueil` ADD `titre_accueil` TINYTEXT NOT NULL AFTER `texte_accueil`;
//POUR MODIFIER LE TITRE DANS L'ACCUEIL : UPDATE `bdCravates`.`t_accueil` SET `titre_accueil` = 'Accueil' WHERE `t_accueil`.`id_accueil` = 1;
//POUR AJOUTER UNE VALEUR DANS LA TABLE : INSERT INTO `bdCravates`.`t_login` (`id_login`, `usager`, `mot_de_passe`) VALUES (NULL, 'ulmus123', 'chachacha');

$strNiveau="../";
// Inclu la page de configuration, les fonctions
include($strNiveau."inc/scripts/config.inc.php");

$actif = "stages";
$erreur = "";

//Pour texte descriptif
/*try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLStages = "SELECT * FROM t_texte WHERE id_texte = 16";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultStages = $objConnMySQLi->query($strSQLStages)) {
        while ($objLigneStages = $objResultStages->fetch_object()) {
            //Assigner des données comme attributs du template
            $texteStages = $objLigneStages->texte;
        }
        $objResultStages->free_result();
    }
    if($objResultStages == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour texte responsable
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLRespo = "SELECT * FROM t_texte WHERE id_texte = 29";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultRespo = $objConnMySQLi->query($strSQLRespo)) {
        while ($objLigneRespo = $objResultRespo->fetch_object()) {
            //Assigner des données comme attributs du template
            $texteRespo = $objLigneRespo->texte;
        }
        $objResultRespo->free_result();
    }
    if($objResultRespo == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour texte stage détaillé
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLTexte = "SELECT * FROM t_texte WHERE id_texte = 27";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultTexte = $objConnMySQLi->query($strSQLTexte)) {
        while ($objLigneTexte = $objResultTexte->fetch_object()) {
            //Assigner des données comme attributs du template
            $texteTexte = $objLigneTexte->texte;
        }
        $objResultTexte->free_result();
    }
    if($objResultTexte == false){
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

$template = $twig->loadTemplate('indexBoire.html.twig');

echo $template->render(array(
    "niveau" => $strNiveau,
    "actif" => $actif,
    "erreur" => $erreur,
    "texteStages" => $texteStages,
    "texteRespo" => $texteRespo,
    "texteTexte" => $texteTexte

    ));

//Fermeture de la base de donnée
$objConnMySQLi->close();*/
?>