<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
echo '<link rel="stylesheet" type="text/css" href="include/style.css">';
echo'<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" >';


$article=isset($_POST['article'])?$_POST['article']:"";
$uni=isset($_POST['uni'])?$_POST['uni']:"";
$prix=isset($_POST['prix'])?$_POST['prix']:"";
$taux_tva=isset($_POST['taux_tva'])?$_POST['taux_tva']:"";
$commentaire=isset($_POST['commentaire'])?$_POST['commentaire']:"";
$stock=isset($_POST['stock'])?$_POST['stock']:"";
$stomin=isset($_POST['stomin'])?$_POST['stomin']:"";
$stomax=isset($_POST['stomax'])?$_POST['stomax']:"";
$lieu=isset($_POST['lieu'])?$_POST['lieu']:"";
$horaire=isset($_POST['horaire'])?$_POST['horaire']:"";
$jour=isset($_POST['jour'])?$_POST['jour']:"";
$annee=isset($_POST['annee'])?$_POST['annee']:"";
$mois=isset($_POST['mois'])?$_POST['mois']:"";
$date="$annee-$mois-$jour";
$image=isset($_POST['image'])?$_POST['image']:"";
$cheminimage=isset($_POST['cheminimage'])?$_POST['cheminimage']:"";
$commentaire=AddSlashes($commentaire);
$article=AddSlashes($article);
$lieu=AddSlashes($lieu);
$article=ucfirst($article);

if($article=='' || $stock==''|| $lieu==''|| $horaire==''|| $jour==''|| $annee==''|| $mois=='')
{
echo "<center><h1>$lang_oubli_champ";
include('form_article.php');
exit;
}


$sql1 = "INSERT INTO ".$tblpref."article(article, lieu, horaire, date_spectacle, commentaire, stock, stomin, stomax, image_article) 
									VALUES ('$article', '$lieu', '$horaire', '$date', '$commentaire', '$stock', '$stomin', '$stomax', '$cheminimage')";
mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
$commentaire=StripSlashes($commentaire);
$message1= "<center><h2>$lang_nouv_art: $article </h2>";
include("lister_articles.php");
include_once("include/bas.php"); 
?>
