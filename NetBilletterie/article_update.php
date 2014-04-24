<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");

include_once("include/language/$lang.php");
$article=isset($_POST['article'])?$_POST['article']:"";
$article = AddSlashes($article);
$num=isset($_POST['num'])?$_POST['num']:"";
$lieu=isset($_POST['lieu'])?$_POST['lieu']:"";
$lieu = AddSlashes($lieu);
$horaire=isset($_POST['horaire'])?$_POST['horaire']:"";
$date=isset($_POST['date'])?$_POST['date']:"";
$prix=isset($_POST['prix'])?$_POST['prix']:"";
$stock=isset($_POST['stock'])?$_POST['stock']:"";
$max=isset($_POST['max'])?$_POST['max']:"";
$min=isset($_POST['min'])?$_POST['min']:"";
$commentaire=isset($_POST['commentaire'])?$_POST['commentaire']:"";
$image=isset($_POST['image'])?$_POST['image']:"";


mysql_select_db($db) or die ("Could not select $db database");
$sql2 = "UPDATE `" . $tblpref ."article` SET `article`='".$article."', `lieu`='".$lieu."', `horaire`='".$horaire."', `date_spectacle`='".$date."',`stock`='".$stock."',`stomin`='".$min."',`stomax`='".$max."', `commentaire`='".$commentaire."', `image_article`='".$image."' 
WHERE `num` ='".$num."' LIMIT 1 ";

mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
$message= "<h2>$lang_stock_jour</h2><br><hr>";
include_once("lister_articles.php");
 ?> 
