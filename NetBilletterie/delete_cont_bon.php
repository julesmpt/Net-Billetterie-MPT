<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");

$num_cont=isset($_GET['num_cont'])?$_GET['num_cont']:"";
$num_bon=isset($_GET['num_bon'])?$_GET['num_bon']:"";
$id_tarif=isset($_GET['id_tarif'])?$_GET['id_tarif']:"";

$nom=isset($_POST['nom'])?$_POST['nom']:"";

$sql2= "SELECT * FROM " . $tblpref ."cont_bon WHERE `num` = '".$num_cont."'";
$req = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$quanti = $data['quanti'];
		$article_num = $data['article_num'];
	}



//ici on decremnte le stock
$sql12 = "UPDATE `" . $tblpref ."article` SET `stock` = (stock + ".$quanti.") WHERE `num`='".$article_num."'";
mysql_query($sql12) or die('Erreur SQL12 !<br>'.$sql12.'<br>'.mysql_error());


mysql_select_db($db) or die ("Could not select $db database");
$sql1 = "DELETE FROM " . $tblpref ."cont_bon WHERE num = '".$num_cont."'";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());




header("Location: form_editer_bon.php?num_bon=$num_bon&id_tarif=$id_tarif"); 
 ?> 
