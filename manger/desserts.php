<?php
setlocale(LC_TIME, 'fr_CA');
session_start();
/**
 * @author Laurence Fiset-Grenier<laurence.fg@live.fr>
 * @copyright © 2016 Cégep-Ste-Foy.
 * Date: 2016-02-29
 * Page des desserts du site
 */

//POUR AJOUTER UNE TABLE DANS LA TABLE SQL: ALTER TABLE `t_accueil` ADD `titre_accueil` TINYTEXT NOT NULL AFTER `texte_accueil`;
//POUR MODIFIER LE TITRE DANS L'ACCUEIL : UPDATE `bdCravates`.`t_accueil` SET `titre_accueil` = 'Accueil' WHERE `t_accueil`.`id_accueil` = 1;
//POUR AJOUTER UNE VALEUR DANS LA TABLE : INSERT INTO `bdCravates`.`t_login` (`id_login`, `usager`, `mot_de_passe`) VALUES (NULL, 'ulmus123', 'chachacha');

$strNiveau="../";
// Inclu la page de configuration, les fonctions
include($strNiveau."inc/scripts/config.inc.php");

$actif = "manger-desserts";
$erreur = "";

//Pour affichage des desserts
try{
    // Requete pour aller chercher le texte associé aux stages
    $strSQLDesserts = "  SELECT DISTINCT nom_plat, description_plat,prix,description 
                        FROM t_repas INNER JOIN t_prix ON t_repas.id_repas=t_prix.id_repas    
                        WHERE etat_plat = 'actif' AND id_type=2";


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultDesserts = $objConnMySQLi->query($strSQLDesserts)) {
        while ($objLigneDesserts = $objResultDesserts->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrDesserts[]=
                array(
                    "nom_plat" => $objLigneDesserts->nom_plat,
                    "description_plat" => $objLigneDesserts->description_plat,
                    "description" => $objLigneDesserts->description,
                    "prix" => $objLigneDesserts->prix
                );
        }
        $objResultDesserts->free_result();
    }
    if($objResultDesserts == false){
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

$template = $twig->loadTemplate('desserts.html.twig');

echo $template->render(array(
    "niveau" => $strNiveau,
    "actif" => $actif,
    "erreur" => $erreur,
    "desserts" => $arrDesserts
    ));

//Fermeture de la base de donnée
$objConnMySQLi->close();
?>