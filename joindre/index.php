<?php
setlocale(LC_TIME, 'fr_CA');
session_start();
/**
 * @author Laurence Fiset-Grenier<laurence.fg@live.fr>
 * @copyright © 2016 Cégep-Ste-Foy.
 * Date: 2016-02-02
 * Cette page est la page nous joindre du site
 */

//POUR AJOUTER UNE TABLE DANS LA TABLE SQL: ALTER TABLE `t_accueil` ADD `titre_accueil` TINYTEXT NOT NULL AFTER `texte_accueil`;
//POUR MODIFIER LE TITRE DANS L'ACCUEIL : UPDATE `bdCravates`.`t_accueil` SET `titre_accueil` = 'Accueil' WHERE `t_accueil`.`id_accueil` = 1;
//POUR AJOUTER UNE VALEUR DANS LA TABLE : INSERT INTO `bdCravates`.`t_login` (`id_login`, `usager`, `mot_de_passe`) VALUES (NULL, 'ulmus123', 'chachacha');
$strNiveau="../";
// Inclu la page de configuration, les fonctions
include($strNiveau."inc/scripts/config.inc.php");

//Initialisation variables
$actif = "joindre";
$erreur = "";
$strNom="";
$strErreurNom="";
$strCourriel="";
$strErreurCourriel="";
$strSujet="";
$strErreurSujet="";
$strMessage="";
$strErreurMessage="";

//Pour texte responsable
/*try{
    // Requete pour aller chercher le texte associé au responsable
    $strSQLRespo = "SELECT * FROM t_texte WHERE id_texte = 31";


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

//Pour texte adresse
try{
    // Requete pour aller chercher le texte associé au responsable
    $strSQLAdresse = "SELECT * FROM t_texte WHERE id_texte = 78";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultAdresse = $objConnMySQLi->query($strSQLAdresse)) {
        while ($objLigneAdresse = $objResultAdresse->fetch_object()) {
            //Assigner des données comme attributs du template
            $texteAdresse = $objLigneAdresse->texte;
        }
        $objResultAdresse->free_result();
    }
    if($objResultAdresse == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
}

//Validation de formulaire
$strDonnesJSON = file_get_contents("../json/messages.json");
$arrMsgErreurs = json_decode($strDonnesJSON,true);

$erreurGenerale="Il y a une ou plusieurs erreurs dans le formulaire, veuillez les corriger.";
if(isset($_GET["bt-envoyer"])){

    //Validation Nom Complet
    $strNom = $_GET["nom"];
    if($strNom == ""){
        $erreur=true;
        $strErreurNom=$arrMsgErreurs["nomUsager"]["errors"]["empty"];
    }else{
        if (preg_match('/^[a-zA-Z -]{1,}$/', $strNom)==0){
                $erreur=true;
                $strErreurNom=$arrMsgErreurs["nomUsager"]["errors"]["pattern"];
            }
            else{
                $strErreurNom="";
                $erreur=false;
            }
    }

    //Validation Courriel
    $strCourriel = $_GET["courriel"];
    if($strCourriel == ""){
        $erreur=true;
        $strErreurCourriel=$arrMsgErreurs["courriel"]["errors"]["empty"];
    }else{
        if (preg_match("/^[a-zA-Z][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-z]{2,4}$/", $strCourriel)==0){
            $erreur=true;
            $strErreurCourriel=$arrMsgErreurs["courriel"]["errors"]["pattern"];
        }else{
            $strErreurCourriel="";
            $erreur=true; 
        }
    }

    //Validation Nom Complet
    $strSujet = $_GET["sujet"];
    if($strSujet == ""){
        $erreur=true;
        $strErreurSujet=$arrMsgErreurs["sujet"]["errors"]["empty"];
    }else{
        if (preg_match('/^[a-zA-Z0-9 -]{4,}$/', $strNom)==0){
                $erreur=true;
                $strErreurSujet= $arrMsgErreurs["sujet"]["errors"]["pattern"];
            }
            else{
                $strErreurSujet="";
                $erreur=false;
            }
    }

    //Validation Message
    $strMessage = $_GET["message"];
    if($strMessage == ""){
        $erreur=true;
        $strErreurMessage=$arrMsgErreurs["message"]["errors"]["empty"];
    }else{
        if (preg_match('/^[a-zA-Z0-9 -]{10,}$/', $strMessage)==0){
                $erreur=true;
                $strErreurMessage= $arrMsgErreurs["message"]["errors"]["pattern"];
            }
            else{
                $strErreurMessage="";
                $erreur=false;
            }
    }

}


// Instancier, configurer et afficher le template
include_once($strNiveau.'inc/lib/Twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem($strNiveau.'templates');

$twig = new Twig_Environment($loader, array(
    'cache' => false,
    'debug' => true
    ));

$template = $twig->loadTemplate('joindre.html.twig');

echo $template->render(array(
    "niveau" => $strNiveau,
    "actif" => $actif,
    "erreur" => $erreur,
    "texteRespo" => $texteRespo,
    "texteAdresse" => $texteAdresse,
    "nom" => $strNom,
    "erreurNom" => $strErreurNom,
    "courriel" => $strCourriel,
    "erreurCourriel" => $strErreurCourriel,
    "sujet" => $strSujet,
    "erreurSujet" => $strErreurSujet,
    "message" => $strMessage,
    "erreurMessage" => $strErreurMessage,
    "erreur" => $erreur,
    "erreurGenerale" => $erreurGenerale
    ));

//Fermeture de la base de donnée
$objConnMySQLi->close();*/
?>