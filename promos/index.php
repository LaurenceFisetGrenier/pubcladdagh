<?php
setlocale(LC_TIME, 'fr_CA');
session_start();
/**
 * @author Laurence Fiset-Grenier<laurence.fg@live.fr>
 * @copyright © 2016 Cégep-Ste-Foy.
 * Date: 2016-02-29
 * Page des promos du site
 */

//POUR AJOUTER UNE TABLE DANS LA TABLE SQL: ALTER TABLE `t_accueil` ADD `titre_accueil` TINYTEXT NOT NULL AFTER `texte_accueil`;
//POUR MODIFIER LE TITRE DANS L'ACCUEIL : UPDATE `bdCravates`.`t_accueil` SET `titre_accueil` = 'Accueil' WHERE `t_accueil`.`id_accueil` = 1;
//POUR AJOUTER UNE VALEUR DANS LA TABLE : INSERT INTO `bdCravates`.`t_login` (`id_login`, `usager`, `mot_de_passe`) VALUES (NULL, 'ulmus123', 'chachacha');

$strNiveau="../";
// Inclu la page de configuration, les fonctions
include($strNiveau."inc/scripts/config.inc.php");

$actif = "promotions";
$erreur = "";
$arrContenu = "";


/*try{
    // Requete pour aller chercher le texte associé
    $strSQLProgramme = 'SELECT * FROM `t_texte` WHERE `section_et_page` = "Programme - Page d\'entrée de la section"';


    // Transférer les résultats de la requête dans des valeurs
    if ($objResultProgramme = $objConnMySQLi->query($strSQLProgramme)) {
        while ($objLigneProgramme = $objResultProgramme->fetch_object()) {
            //Assigner des données comme attributs du template
            $arrContenu[] = array(
                "titre" => $objLigneProgramme->titre_texte,
                "texte" => $objLigneProgramme->texte
            );
        }
        $objResultProgramme->free_result();
    }
    if($objResultProgramme == false){ #"Il y a un problème, veuillez nous excuser pour les inconvénients."
        throw new Exception($objConnMySQLi->error);
    }
} catch(Exception $e){
    $erreur = $e->getMessage();
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

$template = $twig->loadTemplate('promos.html.twig');

echo $template->render(array(
    "niveau" => $strNiveau,
    "actif" => $actif,
    "erreur" => $erreur,
    
    //"contenu" => $arrContenu
    
    ));

//Fermeture de la base de donnée
//$objConnMySQLi->close();
?>