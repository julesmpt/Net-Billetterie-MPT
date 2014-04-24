<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/

require_once("include/verif.php");
require_once("include/config/common.php");
require_once("include/language/$lang.php");
$paiement=isset($_POST['paiement'])?$_POST['paiement']:"";
$tot_tva=isset($_POST['tot_tva'])?$_POST['tot_tva']:"";
$bon_num=isset($_POST['bon_num'])?$_POST['bon_num']:"";
$id_tarif=isset($_POST['id_tarif'])?$_POST['id_tarif']:"";
$coment=isset($_POST['coment'])?$_POST['coment']:"";
$paiement= addslashes($paiement);
$coment= addslashes($coment);
mysql_select_db($db) or die ("Could not select $db database");

if ($paiement=='non')
{
$sql3 = "UPDATE " . $tblpref ."bon_comm SET `tot_tva`='".$tot_tva."', `coment`='".$coment."', paiement='non' WHERE `num_bon` = ".$bon_num."";
mysql_query($sql3) OR die("<p>Erreur Mysql3<br/>$sql3<br/>".mysql_error()."</p>");

}

if ($paiement!='non')
{
    $sql1 = "UPDATE " . $tblpref ."bon_comm SET attente=0, paiement='".$paiement."'  WHERE num_bon =".$bon_num."";
	mysql_query($sql1) OR die("<p>Errreur Mysql1<br/>$sql1<br/>".mysql_error()."</p>");
}

$sql1 = "UPDATE " . $tblpref ."bon_comm SET `user`='".$user_nom."'  WHERE `num_bon` = $bon_num";
mysql_query($sql1) OR die("<p> petit message Erreur Mysql1<br/>$sql1<br/>".mysql_error()."</p>");

$sql5 ="SELECT nom, num_client FROM " . $tblpref ."bon_comm
RIGHT JOIN " . $tblpref ."client ON " . $tblpref ."bon_comm.client_num=" . $tblpref ."client.num_client
WHERE  " . $tblpref ."bon_comm.num_bon= $bon_num";
$req5=mysql_query($sql5) OR die("<p> petit message Erreur Mysql5<br/>$sql5<br/>".mysql_error()."</p>");
while($data = mysql_fetch_array($req5))
    {
    $nom = $data['nom'];
    $num_client = $data['num_client'];
}

$message= "<center><h2>L'inscription sur liste d'attente <font color=red> N°$bon_num </font> pour <font color=red> $nom </font>a bien été effectué. </h2></center>";

include("lister_commandes_attente.php");
 ?>
