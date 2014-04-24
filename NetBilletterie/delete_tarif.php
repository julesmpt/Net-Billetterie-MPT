<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
include_once("include/config/common.php");
$id_tarif=isset($_GET['id_tarif'])?$_GET['id_tarif']:"";
$sql2 = "DELETE FROM ". $tblpref ."tarif  WHERE id_tarif = '".$id_tarif."'";
mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
//echo "<center><font size = 4 color = red >facture $num reglée</font>";
include_once("lister_tarif.php");

 ?>     
