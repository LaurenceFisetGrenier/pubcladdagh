<?php
setlocale(LC_TIME, 'fr_CA');
session_start();
/**
 * @author Laurence Fiset-Grenier<laurence.fg@live.fr>
 * @copyright © 2016 Cégep-Ste-Foy.
 * Date: 2016-02-29
 * Page des whiskey du site
 */

$strNiveau="../";
// Inclu la page de configuration, les fonctions
include($strNiveau."inc/scripts/config.inc.php");

$actif = "boire-whiskey";
$erreur = "";

//Pour affichage irlande
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLIrlande = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu     
                        WHERE etat_plat = 'actif' AND id_type=5";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultIrlande = $objConnMySQLi->query($strSQLIrlande)) {
        while ($objLigneIrlande = $objResultIrlande->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrIrlande[]=
                array(
                    "nom_plat" => $objLigneIrlande->nom_plat,
                    "description_plat" => $objLigneIrlande->description_plat,
                    "description" => $objLigneIrlande->description,
                    "prix" => $objLigneIrlande->prix
                );
        }
        $objResultIrlande->free_result();
    }
    if($objResultIrlande == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour affichage États-Unis
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLEtat = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu     
                        WHERE etat_plat = 'actif' AND id_type=20";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultEtat = $objConnMySQLi->query($strSQLEtat)) {
        while ($objLigneEtat = $objResultEtat->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrEtat[]=
                array(
                    "nom_plat" => $objLigneEtat->nom_plat,
                    "description_plat" => $objLigneEtat->description_plat,
                    "description" => $objLigneEtat->description,
                    "prix" => $objLigneEtat->prix
                );
        }
        $objResultEtat->free_result();
    }
    if($objResultEtat == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour affichage Écosse
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLEcosse = "  SELECT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu     
                        WHERE etat_plat = 'actif' AND id_type=21";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultEcosse = $objConnMySQLi->query($strSQLEcosse)) {
        while ($objLigneEcosse = $objResultEcosse->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrEcosse[]=
                array(
                    "nom_plat" => $objLigneEcosse->nom_plat,
                    "description_plat" => $objLigneEcosse->description_plat,
                    "description" => $objLigneEcosse->description,
                    "prix" => $objLigneEcosse->prix
                );
        }
        $objResultEcosse->free_result();
    }
    if($objResultEcosse == false){
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

$template = $twig->loadTemplate('whiskey.html.twig');

echo $template->render(array(
    "niveau" => $strNiveau,
    "actif" => $actif,
    "erreur" => $erreur,
    "irlandes" => $arrIrlande,
    "etats" => $arrEtat,
    "ecosses" => $arrEcosse
    ));

//Fermeture de la base de donnée
$objConnMySQLi->close();
?>