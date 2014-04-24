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
echo '<link rel="stylesheet" type="text/css" href="include/style.css">';
echo'<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" >';

$num_bon=isset($_GET['num_bon'])?$_GET['num_bon']:"";
$nom=isset($_GET['nom'])?$_GET['nom']:"";
$billetterie=isset($_GET['billetterie'])?$_GET['billetterie']:"";

$sql = "SELECT sum(quanti)as quanti FROM ".$tblpref."bon_comm BC, ".$tblpref."cont_bon CB 
		WHERE  CB.bon_num=BC.num_bon
		AND num_bon = $num_bon";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$quanti = $data['quanti'];
		}

if ($quanti==NULL)
{
	mysql_select_db($db) or die ("Could not select $db database");
	$sql1 = "DELETE FROM " . $tblpref ."bon_comm WHERE num_bon = '".$num_bon."'";
	mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
	$message= "<center><h1>$lang_bon_effa";
	if ($billetterie !=""){
		include("lister_billetterie.php");
		echo topto;
	}
	else {
		include("lister_commandes.php");
		echo "tata $billetterie";
	}
}
 else {
	 if ($billetterie!=""){
		$message = "<center><h1>$lang_err_vider_bon2";
	 }
	 else {
		$message = "<center><h1>$lang_err_vider_bon";
	 }
include('delete_message.php');
exit;
}


 ?> 
