<?php
setlocale(LC_TIME, 'fr_CA');
session_start();
/**
 * @author Laurence Fiset-Grenier<laurence.fg@live.fr>
 * @copyright © 2016 Cégep-Ste-Foy.
 * Date: 2016-02-02
 * Cette page est la page nous joindre du site
 */

$strNiveau="../";

// Inclu la page de configuration, les fonctions
include($strNiveau."inc/scripts/config.inc.php");

//Initialisation variables
$actif = "joindre";
$erreur = "";
$erreurFormulaire = "";
$strNom="";
$strErreurNom="";
$strCourriel="";
$strErreurCourriel="";
$strSujet="";
$strErreurSujet="";
$strMessage="";
$strErreurMessage="";
$intDestinataire="";
$strMessageSucces = "";
$idContactRecu="";
$destinataire="";
$courrielDestinataire="";

//Validation de formulaire
$strDonnesJSON = file_get_contents("../json/messages.json");
$arrMsgErreurs = json_decode($strDonnesJSON,true);

$erreurGenerale="Il y a une ou plusieurs erreurs dans le formulaire, veuillez les corriger.";
if(isset($_POST["bt-envoyer"])){

    //Validation Nom Complet
    $strNom = $_POST["nom"];
    if($strNom == ""){
        $erreurFormulaire=true;
        $strErreurNom=$arrMsgErreurs["nomUsager"]["errors"]["empty"];
    }else{
        if (preg_match('/^[a-zA-Z -]{2,}$/', $strNom)==0){
                $erreurFormulaire=true;
                $strErreurNom=$arrMsgErreurs["nomUsager"]["errors"]["pattern"];
            }
            else{
                $strErreurNom="";
                $erreurFormulaire=false;
            }
    }

    //Validation Courriel
    $strCourriel = $_POST["courriel"];
    if($strCourriel == ""){
        $erreurFormulaire=true;
        $strErreurCourriel=$arrMsgErreurs["courriel"]["errors"]["empty"];
    }else{
        if (preg_match("/^[a-zA-Z][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-z]{2,4}$/", $strCourriel)==0){
            $erreurFormulaire=true;
            $strErreurCourriel=$arrMsgErreurs["courriel"]["errors"]["pattern"];
        }else{
            $strErreurCourriel="";
            $erreurFormulaire=true; 
        }
    }

    //Validation Nom Complet
    $strSujet = $_POST["sujet"];
    if($strSujet == ""){
        $erreurFormulaire=true;
        $strErreurSujet=$arrMsgErreurs["sujet"]["errors"]["empty"];
    }else{
        if (preg_match('/^[a-zA-Z0-9 -]{4,}$/', $strNom)==0){
                $erreurFormulaire=true;
                $strErreurSujet= $arrMsgErreurs["sujet"]["errors"]["pattern"];
            }
            else{
                $strErreurSujet="";
                $erreurFormulaire=false;
            }
    }

    //Validation Message
    $strMessage = $_POST["message"];
    if($strMessage == ""){
        $erreurFormulaire=true;
        $strErreurMessage=$arrMsgErreurs["message"]["errors"]["empty"];
    }else{
        if (preg_match('/^[a-zA-Z0-9 -]{10,}$/', $strMessage)==0){
                $erreurFormulaire=true;
                $strErreurMessage= $arrMsgErreurs["message"]["errors"]["pattern"];
            }
            else{
                $strErreurMessage="";
                $erreurFormulaire=false;
            }
    }


    if($erreurFormulaire==false){

        $strMessageSucces="Votre message a été envoyé avec succès! Vous recevrez une réponse dans les 24h.";

        header('Location:index.php');
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
    "erreurFormulaire" => $erreurFormulaire,
    "nom" => $strNom,
    "erreurNom" => $strErreurNom,
    "courriel" => $strCourriel,
    "erreurCourriel" => $strErreurCourriel,
    "sujet" => $strSujet,
    "erreurSujet" => $strErreurSujet,
    "message" => $strMessage,
    "erreurMessage" => $strErreurMessage,
    "erreurGenerale" => $erreurGenerale,
    "intDestinataire" => $intDestinataire,
    "strMessageSucces" => $strMessageSucces,
    "idContactRecu" => $idContactRecu,
    "destinataire" => $destinataire,
    "courrielDestinataire" => $courrielDestinataire
    ));

//Fermeture de la base de donnée
$objConnMySQLi->close();
?>