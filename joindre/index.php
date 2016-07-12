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

$erreurFormulaire = "";
//$erreur = "";

//Validation de formulaire
$strDonnesJSON = file_get_contents("../json/messages.json");
$arrMsgErreurs = json_decode($strDonnesJSON,true);

$erreurGenerale="Il y a une ou plusieurs erreurs dans le formulaire, veuillez les corriger.";
if(isset($_POST["envoyer"])){
    $strErreurCourriel="";
    $strErreurNom="";
    $strErreurSujet="";
    $strErreurMessage="";

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
        }
    }

    //Validation Sujet
    $strSujet = $_POST["sujet"];
    if($strSujet == ""){
        $erreurFormulaire=true;
        $strErreurSujet=$arrMsgErreurs["sujet"]["errors"]["empty"];
    }else{
        if (strlen($strSujet)<4){
                $erreurFormulaire=true;
                $strErreurSujet= $arrMsgErreurs["sujet"]["errors"]["pattern"];
            }
    }

    //Validation Message
    $strMessage = $_POST["message"];
    if($strMessage == ""){
        $erreurFormulaire=true;
        $strErreurMessage=$arrMsgErreurs["message"]["errors"]["empty"];
    }else{
        if (strlen($strMessage)<10){
                $erreurFormulaire=true;
                $strErreurMessage= $arrMsgErreurs["message"]["errors"]["pattern"];
            }
    }


    if($erreurFormulaire==false){

       $strMessageSucces="Votre message a été envoyé avec succès! Vous recevrez une réponse dans les 24h.";
       $courrielDestinataire="laurence.fg@live.fr";

        //ENVOIS DU COURRIEL
        $receveur = $courrielDestinataire;
        $sujet = "CSF TIM : ".stripslashes($_POST['sujet']);
        $headers= "From: <".$strCourriel.">\n";
        $headers .= "Reply-To: ".$strCourriel."\n";
        $headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"";

        if(!mail($receveur, $sujet, $strMessage, $headers)){
            $erreur = "Il y a eu une erreur, veuillez réessayer plus tard.";
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
    //"erreur" => $erreur,
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
    "courrielDestinataire" => $courrielDestinataire
    ));

//Fermeture de la base de donnée
$objConnMySQLi->close();
?>