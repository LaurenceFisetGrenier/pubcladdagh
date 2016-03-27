<?php
setlocale(LC_TIME, 'fr_CA');
session_start();
/**
 * @author Laurence Fiset-Grenier<laurence.fg@live.fr>
 * @copyright © 2016 Cégep-Ste-Foy.
 * Date: 2016-02-29
 * Page des bières du site
 */

$strNiveau="../";
// Inclu la page de configuration, les fonctions
include($strNiveau."inc/scripts/config.inc.php");

$actif = "boire-biere";
$erreur = "";

//Pour affichage des Ales
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLAles = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu    
                        WHERE etat_plat = 'actif' AND id_type=11";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultAles = $objConnMySQLi->query($strSQLAles)) {
        while ($objLigneAles = $objResultAles->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrAles[]=
                array(
                    "nom_plat" => $objLigneAles->nom_plat,
                    "description_plat" => $objLigneAles->description_plat,
                    "description" => $objLigneAles->description,
                    "prix" => $objLigneAles->prix
                );
        }
        $objResultAles->free_result();
    }
    if($objResultAles == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour affichage des Blanches
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLBlanches = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu    
                        WHERE etat_plat = 'actif' AND id_type=12";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultBlanches = $objConnMySQLi->query($strSQLBlanches)) {
        while ($objLigneBlanches = $objResultBlanches->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrBlanches[]=
                array(
                    "nom_plat" => $objLigneBlanches->nom_plat,
                    "description_plat" => $objLigneBlanches->description_plat,
                    "description" => $objLigneBlanches->description,
                    "prix" => $objLigneBlanches->prix
                );
        }
        $objResultBlanches->free_result();
    }
    if($objResultBlanches == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour affichage du cidre
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLCidre = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu    
                        WHERE etat_plat = 'actif' AND id_type=13";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultCidre = $objConnMySQLi->query($strSQLCidre)) {
        while ($objLigneCidre = $objResultCidre->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrCidre[]=
                array(
                    "nom_plat" => $objLigneCidre->nom_plat,
                    "description_plat" => $objLigneCidre->description_plat,
                    "description" => $objLigneCidre->description,
                    "prix" => $objLigneCidre->prix
                );
        }
        $objResultCidre->free_result();
    }
    if($objResultCidre == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour affichage de I.P.A
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLIPA = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu    
                        WHERE etat_plat = 'actif' AND id_type=14";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultIPA = $objConnMySQLi->query($strSQLIPA)) {
        while ($objLigneIPA = $objResultIPA->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrIPA[]=
                array(
                    "nom_plat" => $objLigneIPA->nom_plat,
                    "description_plat" => $objLigneIPA->description_plat,
                    "description" => $objLigneIPA->description,
                    "prix" => $objLigneIPA->prix
                );
        }
        $objResultIPA->free_result();
    }
    if($objResultIPA == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour affichage des lagers
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLLagers = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu     
                        WHERE etat_plat = 'actif' AND id_type=15";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultLagers = $objConnMySQLi->query($strSQLLagers)) {
        while ($objLigneLagers = $objResultLagers->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrLagers[]=
                array(
                    "nom_plat" => $objLigneLagers->nom_plat,
                    "description_plat" => $objLigneLagers->description_plat,
                    "description" => $objLigneLagers->description,
                    "prix" => $objLigneLagers->prix
                );
        }
        $objResultLagers->free_result();
    }
    if($objResultLagers == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour affichage de la stout
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLStout = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu     
                        WHERE etat_plat = 'actif' AND id_type=16";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultStout = $objConnMySQLi->query($strSQLStout)) {
        while ($objLigneStout = $objResultStout->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrStout[]=
                array(
                    "nom_plat" => $objLigneStout->nom_plat,
                    "description_plat" => $objLigneStout->description_plat,
                    "description" => $objLigneStout->description,
                    "prix" => $objLigneStout->prix
                );
        }
        $objResultStout->free_result();
    }
    if($objResultStout == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour affichage des bières en bouteille
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLBouteille = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu     
                        WHERE etat_plat = 'actif' AND id_type=19";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultBouteille = $objConnMySQLi->query($strSQLBouteille)) {
        while ($objLigneBouteille = $objResultBouteille->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrBouteille[]=
                array(
                    "nom_plat" => $objLigneBouteille->nom_plat,
                    "description_plat" => $objLigneBouteille->description_plat,
                    "description" => $objLigneBouteille->description,
                    "prix" => $objLigneBouteille->prix
                );
        }
        $objResultBouteille->free_result();
    }
    if($objResultBouteille == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Pour affichage des mélanges celtiques
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLMelange = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_menu=t_prix.id_menu     
                        WHERE etat_plat = 'actif' AND id_type=17";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultMelange = $objConnMySQLi->query($strSQLMelange)) {
        while ($objLigneMelange = $objResultMelange->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrMelange[]=
                array(
                    "nom_plat" => $objLigneMelange->nom_plat,
                    "description_plat" => $objLigneMelange->description_plat,
                    "description" => $objLigneMelange->description,
                    "prix" => $objLigneMelange->prix
                );
        }
        $objResultMelange->free_result();
    }
    if($objResultMelange == false){
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

$template = $twig->loadTemplate('bieres.html.twig');

echo $template->render(array(
    "niveau" => $strNiveau,
    "actif" => $actif,
    "erreur" => $erreur,
    "ales" => $arrAles,
    "blanches" => $arrBlanches,
    "cidres" => $arrCidre,
    "ipas" => $arrIPA,
    "lagers" => $arrLagers,
    "stouts" => $arrStout,
    "bouteilles" => $arrBouteille,
    "melanges" => $arrMelange
    ));

//Fermeture de la base de donnée
$objConnMySQLi->close();
?>