<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
include_once("include/config/common.php");
$id_banque=isset($_GET['id_banque'])?$_GET['id_banque']:"";
$sql2 = "DELETE FROM ". $tblpref ."banque  WHERE id_banque = '".$id_banque."'";
mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
$message="La banque a bien été supprimée de la liste";
include_once("lister_banque.php");

 ?>     
