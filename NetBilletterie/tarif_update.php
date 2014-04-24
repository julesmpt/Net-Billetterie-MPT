<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");

include_once("include/language/$lang.php");
$id_tarif=isset($_POST['id_tarif'])?$_POST['id_tarif']:"";
$nom_tarif=isset($_POST['nom_tarif'])?$_POST['nom_tarif']:"";
$nom_tarif= AddSlashes($nom_tarif);
$prix_tarif=isset($_POST['prix_tarif'])?$_POST['prix_tarif']:"";
$carnet=isset($_POST['carnet'])?$_POST['carnet']:"";
$selection=isset($_POST['selection'])?$_POST['selection']:"";


mysql_select_db($db) or die ("Could not select $db database");
$sql2 = "UPDATE ".$tblpref."tarif 
		SET `id_tarif`='".$id_tarif."',`nom_tarif`='".$nom_tarif."',`prix_tarif`='".$prix_tarif."',`carnet`='".$carnet."', `selection`='".$selection."'
		WHERE id_tarif ='".$id_tarif."' LIMIT 1 ";

mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
$message= "<h2>Tarif mise &agrave; jour</h2><br><hr>";
include_once("lister_tarif.php");
 ?> 
