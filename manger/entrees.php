<?php
setlocale(LC_TIME, 'fr_CA');
session_start();
/**
 * @author Laurence Fiset-Grenier<laurence.fg@live.fr>
 * @copyright © 2016 Cégep-Ste-Foy.
 * Date: 2016-02-29
 * Page des entrées du site
 */

$strNiveau="../";
// Inclu la page de configuration, les fonctions
include($strNiveau."inc/scripts/config.inc.php");

$actif = "manger-entree";
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

//Pour affichage des entrées
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLEntrees = "  SELECT nom_plat, description_plat,prix,description,t_repas.id_menu
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu   
                        WHERE etat_plat = 'actif' AND id_type=1";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultEntrees = $objConnMySQLi->query($strSQLEntrees)) {
        while ($objLigneEntrees = $objResultEntrees->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrEntrees[$objLigneEntrees->id_menu]=
                array(
                    "nom_plat" => $objLigneEntrees->nom_plat,
                    "description_plat" => $objLigneEntrees->description_plat,
                    "id_entree" => $objLigneEntrees->id_menu,
                    "prix" => getPrix($objLigneEntrees->id_menu)

                );


        }
        $objResultEntrees->free_result();
    }
    if($objResultEntrees == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}


//Pour affichage des smoked meat
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLMeats = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu    
                        WHERE etat_plat = 'actif' AND id_type=10";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultMeats = $objConnMySQLi->query($strSQLMeats)) {
        while ($objLigneMeats = $objResultMeats->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrMeats[]=
                array(
                    "nom_plat" => $objLigneMeats->nom_plat,
                    "description_plat" => $objLigneMeats->description_plat,
                    "description" => $objLigneMeats->description,
                    "prix" => $objLigneMeats->prix
                );
        }
        $objResultMeats->free_result();
    }
    if($objResultMeats == false){
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

$template = $twig->loadTemplate('entrees.html.twig');

echo $template->render(array(
    "niveau" => $strNiveau,
    "actif" => $actif,
    "erreur" => $erreur,
    "entrees" => $arrEntrees,
    "meats" => $arrMeats
    ));

//Fermeture de la base de donnée
$objConnMySQLi->close();
?>