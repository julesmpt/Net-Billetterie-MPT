<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");

$libelle=isset($_POST['libelle'])?$_POST['libelle']:"";
$commentaire=isset($_POST['commentaire'])?$_POST['commentaire']:"";
$commentaire=addslashes($commentaire);
$id_enregistrement_caisse=isset($_POST['id_enregistrement_caisse'])?$_POST['id_enregistrement_caisse']:"";
$total=isset($_POST['total'])?$_POST['total']:"";

//on recupère le total de l'enregistrement de caisse
$p10=isset($_POST['p10'])?$_POST['p10']:"";

If($id_enregistrement_caisse!=""){
	if($p10=="")
		{$p10="0";
		}
	//ici on incremente le total de l'enregistrement et on modifie le commentaire
$sql12 = "UPDATE `".$tblpref."enregistrement_caisse` 
SET 
total = ( total+$p10), 
commentaire='".$commentaire."'
WHERE id_enregistrement_caisse = '".$id_enregistrement_caisse."'";
mysql_query($sql12) or die('Erreur SQL12 !<br>'.$sql12.'<br>'.mysql_error()); 

	//recupère libelle
$sql5 = "SELECT libelle FROM ".$tblpref."enregistrement_caisse
		WHERE id_enregistrement_caisse = '".$id_enregistrement_caisse."'";
$req5 = mysql_query($sql5) or die('Erreur SQL5 !<br>'.$sql5.'<br>'.mysql_error());
while($data = mysql_fetch_array($req5))
{
	$libelle= $data['libelle'];
}
}

else {
//création de l'enregistrement de caisse'.
$sql = "INSERT INTO ".$tblpref."enregistrement_caisse(libelle, total, commentaire, user)
VALUES ('$libelle', '$p10', '$commentaire','$user_nom')";
mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());


//recupère id_ enregistrement_caisse
$sql3 = "SELECT id_enregistrement_caisse, libelle FROM " . $tblpref ."enregistrement_caisse
		ORDER BY  id_enregistrement_caisse DESC 
		LIMIT 1";
$req3 = mysql_query($sql3) or die('Erreur SQL3 !<br>'.$sql3.'<br>'.mysql_error());
while($data = mysql_fetch_array($req3))
{
	$id_enregistrement_caisse= $data['id_enregistrement_caisse'];
	$libelle= $data['libelle'];
}
}

//On boucle sur tous les posts
for ($i = 0; $i < count($_POST["nbr"]); $i++)
  {
	$esp=$_POST["esp"][$i]."" ;
	$nbr=$_POST["nbr"][$i]."" ;
	$p=$_POST["p"][$i]."" ;
	//inserer les données dans la table de caisse s'il y a qlq chose seulement'.
	if($nbr!="0")
		{
		$sql1 = "INSERT INTO ".$tblpref."caisse(id_enregistrement_caisse, espece, nbr, total)
		VALUES ('$id_enregistrement_caisse', '$esp', '$nbr', '$p')";
		mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
		}
	}

if ($libelle=="bar") {include("lister_caisse_bar.php");}
if ($libelle=="billetterie") {include("lister_caisse_billetterie.php");}
?>
