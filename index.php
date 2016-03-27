

<?php
setlocale(LC_TIME, 'fr_CA');
session_start();
/**
 * @author Laurence Fiset-Grenier<laurence.fg@live.fr>
 * @copyright © 2016 Cégep-Ste-Foy.
 * Date: 2016-02-29
 * Page index du site
 */

$strNiveau="";
// Inclu la page de configuration, les fonctions
include($strNiveau."inc/scripts/config.inc.php");
//include($strNiveau."inc/scripts/script_facebook.php");
//include($strNiveau."inc/scripts/script_twitter.php");

$actif = "index";
$erreur = "";

//Pour affichage des promotions
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLPromos = "SELECT nom_promotion,description_promotion FROM t_promotions WHERE etat_promotion='actif' AND id_promotion=0";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultPromos = $objConnMySQLi->query($strSQLPromos)) {
        while ($objLignePromos = $objResultPromos->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrPromos[]=
                array(
                    "nom_promotion" => $objLignePromos->nom_promotion,
                    "description_promotion" => $objLignePromos->description_promotion
                );
        }
        $objResultPromos->free_result();
    }
    if($objResultPromos == false){
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

$template = $twig->loadTemplate('index.html.twig');

echo $template->render(array(
    "niveau" => $strNiveau,
    "actif" => $actif,
    "erreur" => $erreur,
    //"promos" => $arrPromos
    ));

//Fermeture de la base de donnée
$objConnMySQLi->close();
?>