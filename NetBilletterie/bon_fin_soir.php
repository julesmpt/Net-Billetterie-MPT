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
$id_tarif=isset($_POST['id_tarif'])?$_POST['id_tarif']:"";
$pointage=isset($_POST['pointage'])?$_POST['pointage']:"";
$tot_tva=isset($_POST['tot_tva'])?$_POST['tot_tva']:"";
$bon_num=isset($_POST['bon_num'])?$_POST['bon_num']:"";
$coment=isset($_POST['coment'])?$_POST['coment']:"";
$paiement= addslashes($paiement);
$coment= addslashes($coment);
mysql_select_db($db) or die ("Could not select $db database");

$sql3 = "UPDATE ".$tblpref."bon_comm SET `tot_tva`='".$tot_tva."', fact='".$pointage."'  WHERE `num_bon` = $bon_num";
mysql_query($sql3) OR die("<p><br/>L'erreur suivante est survenue!!!<br/><br/>$sql3<br/>".mysql_error()."<hr><br><br>Veuillez recommencer<br> <a href=lister_commandes.php><h3>RETOUR A LA LISTE DES COMMANDES</h3></a></p>");

$sql4 = "UPDATE ".$tblpref."bon_comm SET `coment`='".$coment."'  WHERE `num_bon` = $bon_num";
mysql_query($sql4) OR die("<p>Erreur Mysql4<br/>$sql4<br/>".mysql_error()."</p>");
mysql_select_db($db) or die ("Could not select $db database");

$sql2 = "UPDATE ".$tblpref."bon_comm SET `paiement`='".$paiement."'  WHERE `num_bon` = $bon_num";
mysql_query($sql2) OR die("<p> petit message Erreur Mysql2<br/>$sql2<br/>".mysql_error()."</p>");

$sql1 = "UPDATE ".$tblpref."bon_comm SET `user`='".$user_nom."'  WHERE `num_bon` = $bon_num";
mysql_query($sql1) OR die("<p> petit message Erreur Mysql1<br/>$sql1<br/>".mysql_error()."</p>");

if ($id_tarif!=""){
$sql5 = "UPDATE ".$tblpref."bon_comm SET `id_tarif`='".$id_tarif."'  WHERE `num_bon` = $bon_num";
mysql_query($sql5) OR die("<p> petit message Erreur Mysql5<br/>$sql1<br/>".mysql_error()."</p>");
}

$sql5 ="SELECT nom FROM ".$tblpref."bon_comm
RIGHT JOIN ".$tblpref."client ON ".$tblpref."bon_comm.client_num=".$tblpref."client.num_client
WHERE  ".$tblpref."bon_comm.num_bon= $bon_num";
$req5=mysql_query($sql5) OR die("<p> petit message Erreur Mysql5<br/>$sql5<br/>".mysql_error()."</p>");
while($data = mysql_fetch_array($req5))
    {
        $nom = $data['nom'];
    }

$message= "<center><h2>La commande <font color=red> $bon_num </font> du (des) billet(s) pour <font color=red> $nom </font>a bien &#233;t&#233; effectu&#233;e. </h2></center>";

include("form_commande_soir.php");
 ?> 
