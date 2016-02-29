

<?php
setlocale(LC_TIME, 'fr_CA');
session_start();
/**
 * @author Laurence Fiset-Grenier<laurence.fg@live.fr>
 * @copyright © 2016 Cégep-Ste-Foy.
 * Date: 2016-02-29
 * Page index du site
 */

//POUR AJOUTER UNE TABLE DANS LA TABLE SQL: ALTER TABLE `t_accueil` ADD `titre_accueil` TINYTEXT NOT NULL AFTER `texte_accueil`;
//POUR MODIFIER LE TITRE DANS L'ACCUEIL : UPDATE `bdCravates`.`t_accueil` SET `titre_accueil` = 'Accueil' WHERE `t_accueil`.`id_accueil` = 1;
//POUR AJOUTER UNE VALEUR DANS LA TABLE : INSERT INTO `bdCravates`.`t_login` (`id_login`, `usager`, `mot_de_passe`) VALUES (NULL, 'ulmus123', 'chachacha');

$strNiveau="";
// Inclu la page de configuration, les fonctions
include($strNiveau."inc/scripts/config.inc.php");
//include($strNiveau."inc/scripts/script_facebook.php");
//include($strNiveau."inc/scripts/script_twitter.php");

$actif = "index";
$erreur = "";

//On va chercher le dernier événement
/*try{
    // Requete pour aller chercher le texte associé aux stages
    $sqlEvent = "SELECT titre_actualite, description_actualite, date_publication FROM t_actualite WHERE actualite_defaut = 1";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultEvent = $objConnMySQLi->query($sqlEvent)) {
        while ($objLigneEvent = $objResultEvent->fetch_object()) {
            $arrEvent[] = array(
                'titre'=>$objLigneEvent->titre_actualite,
                'description'=>$objLigneEvent->description_actualite,
                'date'=>$objLigneEvent->date_publication,
                'date'=>formatDate($objLigneEvent->date_publication)
            );
        }
        $objResultEvent->free_result();
    }
    if($objResultEvent == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    array_push($arrMessagesErreurs, $e->getMessage());
}

//On va chercher les projets
try{
    // Requete pour aller chercher le texte associé aux stages
    $sqlProjet = "SELECT id_projet, titre_projet, id_diplome FROM t_projet_diplome ORDER BY RAND() LIMIT 15";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultProjet = $objConnMySQLi->query($sqlProjet)) {
        while ($objLigneProjet = $objResultProjet->fetch_object()) {
            $arrProjet[] = array(
                'id'=>$objLigneProjet->id_projet,
                'titre'=>$objLigneProjet->titre_projet,
                'id_diplome'=>$objLigneProjet->id_diplome
            );
        }
        $objResultProjet->free_result();
    }
    if($objResultProjet == false){
        throw new Exception("Il y a un problème, veuillez nous excuser pour les inconvénients.");
    }
} catch(Exception $e){
    array_push($arrMessagesErreurs, $e->getMessage());
}

//Fonction de formattage de date
function formatDate($date){

    $dateFormat = strtotime($date);
    $dateFormat = strftime("%e %B %Y", $dateFormat);

    return $dateFormat;
}

//Création d'un tableau de vignettes valides

$arrProjetValide[] = array();

for($i = 0; $i < sizeof($arrProjet); $i++)
{

    if(file_exists($strNiveau."images/projets/vignettes/prj" . $arrProjet[$i]["id"] . "_01.jpg")){
        $arrProjetValide[$i]['id'] = $arrProjet[$i]["id"];
        $arrProjetValide[$i]['titre'] = $arrProjet[$i]["titre"];
        $arrProjetValide[$i]['id_diplome'] = $arrProjet[$i]["id_diplome"];
    }

    sort($arrProjetValide);

}



*/
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
    //"event" => $arrEvent,
    //"projet" => $arrProjetValide
    ));

//Fermeture de la base de donnée
//$objConnMySQLi->close();
?>