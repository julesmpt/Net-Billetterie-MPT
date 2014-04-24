<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");

$num_cont=isset($_GET['num_cont'])?$_GET['num_cont']:"";
$num_bon=isset($_GET['num_bon'])?$_GET['num_bon']:"";
$id_tarif=isset($_GET['id_tarif'])?$_GET['id_tarif']:"";
$nom=isset($_GET['nom'])?$_GET['nom']:"";
$num=isset($_GET['num'])?$_GET['num']:"";

$sql2= "SELECT quanti, article_num FROM " . $tblpref ."cont_bon WHERE `num` = '".$num_cont."'";
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


echo "num_cont $num_cont <br> ";
echo "quanti $quanti <br> ";
echo "article_num $article_num <br> ";
echo "id_tarif $id_tarif <br> ";
echo "num_bon $num_bon <br> ";



header("Location: form_editer_bon_soir.php?num_bon=$num_bon&nom=$nom&num=$num&id_tarif=$id_tarif&del=1"); 

 ?> 
