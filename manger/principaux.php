<?php
setlocale(LC_TIME, 'fr_CA');
session_start();
/**
 * @author Laurence Fiset-Grenier<laurence.fg@live.fr>
 * @copyright © 2016 Cégep-Ste-Foy.
 * Date: 2016-02-29
 * Page des plats principaux du site
 */

$strNiveau="../";
// Inclu la page de configuration, les fonctions
include($strNiveau."inc/scripts/config.inc.php");

$actif = "manger-principaux";
$erreur = "";

//function pour retourner les prix
function getPrix($idMenu) {

    $arrPrix = array();

    $strSQLPrix = "SELECT prix, description
                    FROM t_prix 
                    INNER JOIN t_repas ON t_prix.id_menu=t_repas.id_menu    
                        WHERE t_repas.id_menu = " . $idMenu;

    $objResultPrix = $GLOBALS["objConnMySQLi"]->query($strSQLPrix);

    while ($objLignePrix = $objResultPrix->fetch_object()) {
        $arrPrix[] = 
            array(
                "description"=> $objLignePrix->description,
                "prix"=> $objLignePrix->prix,

            );
    }
    $objResultPrix->free_result();
    return $arrPrix;
}

//Pour affichage des plats principaux
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLPrincipaux = "  SELECT DISTINCT nom_plat, description_plat,prix,description,t_repas.id_menu 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu    
                        WHERE etat_plat = 'actif' AND id_type=0";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultPrincipaux = $objConnMySQLi->query($strSQLPrincipaux)) {
        while ($objLignePrincipaux = $objResultPrincipaux->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrPrincipaux[$objLignePrincipaux->id_menu]=
                array(
                    "nom_plat" => $objLignePrincipaux->nom_plat,
                    "description_plat" => $objLignePrincipaux->description_plat,
                    "id_principaux" => $objLignePrincipaux->id_menu,
                    "prix" => getPrix($objLignePrincipaux->id_menu)
                );
        }
        $objResultPrincipaux->free_result();
    }
    if($objResultPrincipaux == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour affichage des salades
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLSalades = "  SELECT DISTINCT nom_plat, description_plat,prix,description,t_repas.id_menu 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu    
                        WHERE etat_plat = 'actif' AND id_type=8";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultSalades = $objConnMySQLi->query($strSQLSalades)) {
        while ($objLigneSalades = $objResultSalades->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrSalades[$objLigneSalades->id_menu]=
                array(
                    "nom_plat" => $objLigneSalades->nom_plat,
                    "description_plat" => $objLigneSalades->description_plat,
                    "id_salade" => $objLigneSalades->id_menu,
                    "prix" => getPrix($objLigneSalades->id_menu)
                );
        }
        $objResultSalades->free_result();
    }
    if($objResultSalades == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour affichage des paninis
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLPaninis = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu    
                        WHERE etat_plat = 'actif' AND id_type=9";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultPaninis = $objConnMySQLi->query($strSQLPaninis)) {
        while ($objLignePaninis = $objResultPaninis->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrPaninis[]=
                array(
                    "nom_plat" => $objLignePaninis->nom_plat,
                    "description_plat" => $objLignePaninis->description_plat,
                    "description" => $objLignePaninis->description,
                    "prix" => $objLignePaninis->prix
                );
        }
        $objResultPaninis->free_result();
    }
    if($objResultPaninis == false){
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
    "principaux" => $arrPrincipaux,
    "salades" => $arrSalades,
    "paninis" => $arrPaninis
    ));

//Fermeture de la base de donnée
$objConnMySQLi->close();
?>