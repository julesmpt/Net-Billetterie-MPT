<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
echo '<link rel="stylesheet" type="text/css" href="include/style.css">';
echo'<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" >';
$nom_tarif=isset($_POST['nom_tarif'])?$_POST['nom_tarif']:"";
$prix_tarif=isset($_POST['prix_tarif'])?$_POST['prix_tarif']:"";
$carnet=isset($_POST['carnet'])?$_POST['carnet']:"";
$jour=isset($_POST['jour'])?$_POST['jour']:"";
$mois=isset($_POST['mois'])?$_POST['mois']:"";
$annee=isset($_POST['annee'])?$_POST['annee']:"";
$nom_tarif= AddSlashes($nom_tarif);
$nom_tarif= ucfirst($nom_tarif);

if($nom_tarif=='' || $prix_tarif==''||$annee=='')
{
echo "<center><h1>$lang_oubli_champ";
include('form_tarif.php');
exit;
}
$date= "$annee-$mois-$jour";

mysql_select_db($db) or die ("Could not select $db database");
$sql1 = "INSERT INTO ".$tblpref."tarif (nom_tarif, prix_tarif,saison, carnet) VALUES ('$nom_tarif', '$prix_tarif','$date','$carnet')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
$message= "<center><h2>$lang_nouv_tarif</h2>";
include("form_tarif.php");
include_once("include/bas.php");
?>
