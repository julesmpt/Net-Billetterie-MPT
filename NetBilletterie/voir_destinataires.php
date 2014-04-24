<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/var.php");
//afficher le message
$id_mail=isset($_GET['id_mail'])?$_GET['id_mail']:"";
$rqSql30= "SELECT * FROM ".$tblpref."mail WHERE id_mail=$id_mail ";
$result30 = mysql_query( $rqSql30 )or die( "Exécution requête rqsql30_mailing impossible.");
while ( $row = mysql_fetch_array( $result30)) {
$mail_client = stripslashes($row["mail_client"]);
echo $mail_client;
}
?>
