<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
$id_caisse=isset($_GET['id_caisse'])?$_GET['id_caisse']:"";
$id_enregistrement_caisse=isset($_GET['id_enregistrement_caisse'])?$_GET['id_enregistrement_caisse']:"";
if($id_enregistrement_caisse!="")
	{
	$sql = "SELECT pointe, total, libelle FROM " . $tblpref ."enregistrement_caisse WHERE id_enregistrement_caisse = '".$id_enregistrement_caisse."'";
	$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	while($data = mysql_fetch_array($req))
		{
			$pointe = $data['pointe'];
			$total = $data['total'];
			$libelle = $data['libelle'];
			}
	if($pointe=='ok')
		{
		$message= "Impossible d\'effacer l\'enregistrement car il est pointé = OK";
		include("lister_caisse.php");
		exit;
		}
	if($total!='0.00')
		{
		$message= "Impossible d\'effacer l\'enregistrement car le total n\'est pas à 0.00";
		include("lister_caisse.php");
		exit;
		}
	$sql1 = "DELETE FROM ".$tblpref."enregistrement_caisse WHERE id_enregistrement_caisse = '".$id_enregistrement_caisse."'";
	mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
	$message= "Enregistrement effacé";
	if ($libelle=="bar") {include("lister_caisse_bar.php");}
	if ($libelle=="billetterie") {include("lister_caisse_billetterie.php");}
	}
	
if($id_caisse!="")
	{
	$sql2 = "SELECT id_enregistrement_caisse, total FROM ".$tblpref."caisse WHERE id_caisse = $id_caisse ";
	$req2 = mysql_query($sql2) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());
	while($data = mysql_fetch_array($req2))
		{
			$id_enregistrement_caisse = $data['id_enregistrement_caisse'];
			$total_caisse = $data['total'];
			}
			
	$sql3 = "SELECT pointe, total, libelle FROM " . $tblpref ."enregistrement_caisse WHERE id_enregistrement_caisse = $id_enregistrement_caisse";
	$req3 = mysql_query($sql3) or die('Erreur SQL3 !<br>'.$sql3.'<br>'.mysql_error());
	while($data = mysql_fetch_array($req3))
		{
			$pointe = $data['pointe'];
			$total_enregistrement = $data['total'];
			$libelle = $data['libelle'];
			}
	if($pointe=='ok')
		{
		$message= "Impossible d\'effacer l\'enregistrement car il est pointé = OK";
		if ($libelle=="bar") {include("lister_caisse_bar.php");}
		if ($libelle=="billetterie") {include("lister_caisse_billetterie.php");}
		exit;
		}

	$sql4= "DELETE FROM ".$tblpref."caisse WHERE id_caisse = $id_caisse";
	mysql_query($sql4) or die('Erreur SQL4 !<br>'.$sql4.'<br>'.mysql_error());
	$message= "Ligne effacée";
	
	$sql5= "UPDATE ".$tblpref."enregistrement_caisse SET total=(total-$total_caisse) WHERE id_enregistrement_caisse =$id_enregistrement_caisse";
	mysql_query($sql5) or die('Erreur SQL5 !<br>'.$sql5.'<br>'.mysql_error());
	if ($libelle=="bar") {include("lister_caisse_bar.php");}
	if ($libelle=="billetterie") {include("lister_caisse_billetterie.php");}
	}
?>
