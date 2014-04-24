<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
include_once("include/config/common.php");
$num=isset($_GET['num'])?$_GET['num']:"";
$sql2 = "DELETE  FROM ".$tblpref."client WHERE num_client = '".$num."'";
mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
include_once("lister_clients.php");
 ?> 
