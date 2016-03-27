<?php
setlocale(LC_TIME, 'fr_CA');
session_start();
/**
 * @author Laurence Fiset-Grenier<laurence.fg@live.fr>
 * @copyright © 2016 Cégep-Ste-Foy.
 * Date: 2016-02-29
 * Page des vins du site
 */

$strNiveau="../";
// Inclu la page de configuration, les fonctions
include($strNiveau."inc/scripts/config.inc.php");

$actif = "boire-vins";
$erreur = "";

//Pour affichage les rouges
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLRouges = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu    
                        WHERE etat_plat = 'actif' AND id_type=3";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultRouges = $objConnMySQLi->query($strSQLRouges)) {
        while ($objLigneRouges = $objResultRouges->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrRouges[]=
                array(
                    "nom_plat" => $objLigneRouges->nom_plat,
                    "description_plat" => $objLigneRouges->description_plat,
                    "description" => $objLigneRouges->description,
                    "prix" => $objLigneRouges->prix
                );
        }
        $objResultRouges->free_result();
    }
    if($objResultRouges == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour affichage les blancs
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLBlancs = " SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu     
                        WHERE etat_plat = 'actif' AND id_type=4";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultBlancs = $objConnMySQLi->query($strSQLBlancs)) {
        while ($objLigneBlancs = $objResultBlancs->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrBlancs[]=
                array(
                    "nom_plat" => $objLigneBlancs->nom_plat,
                    "description_plat" => $objLigneBlancs->description_plat,
                    "description" => $objLigneBlancs->description,
                    "prix" => $objLigneBlancs->prix
                );
        }
        $objResultBlancs->free_result();
    }
    if($objResultBlancs == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour affichage les rosés
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLRoses = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu     
                        WHERE etat_plat = 'actif' AND id_type=6";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultRoses = $objConnMySQLi->query($strSQLRoses)) {
        while ($objLigneRoses = $objResultRoses->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrRoses[]=
                array(
                    "nom_plat" => $objLigneRoses->nom_plat,
                    "description_plat" => $objLigneRoses->description_plat,
                    "description" => $objLigneRoses->description,
                    "prix" => $objLigneRoses->prix
                );
        }
        $objResultRoses->free_result();
    }
    if($objResultRoses == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour affichage des mélanges celtiques
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLMaisons = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu     
                        WHERE etat_plat = 'actif' AND id_type=18";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultMaisons = $objConnMySQLi->query($strSQLMaisons)) {
        while ($objLigneMaisons = $objResultMaisons->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrMaisons[]=
                array(
                    "nom_plat" => $objLigneMaisons->nom_plat,
                    "description_plat" => $objLigneMaisons->description_plat,
                    "description" => $objLigneMaisons->description,
                    "prix" => $objLigneMaisons->prix
                );
        }
        $objResultMaisons->free_result();
    }
    if($objResultMaisons == false){
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

$template = $twig->loadTemplate('vins.html.twig');

echo $template->render(array(
    "niveau" => $strNiveau,
    "actif" => $actif,
    "erreur" => $erreur,
    "rouges" => $arrRouges,
    "blancs" => $arrBlancs,
    "roses" => $arrRoses,
    "maisons" => $arrMaisons
     ));

//Fermeture de la base de donnée
$objConnMySQLi->close();
?>