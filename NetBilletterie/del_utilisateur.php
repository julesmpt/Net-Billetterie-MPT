<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
$num_user=isset($_GET['num_user'])?$_GET['num_user']:"";
$sql = " SELECT * FROM " . $tblpref ."user WHERE num = $num_user ";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
    $admin = $data['admin'];
    }
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

if ($admin == 'y') { 
echo "<h1>$lang_impo_del_util</h1>";
include_once("lister_utilisateurs.php");
exit;
}
$sql ="DELETE FROM " . $tblpref ."user WHERE num = $num_user";
mysql_query($sql) OR die("<p>Erreur Mysql<br/>$sql<br/>".mysql_error()."</p>");

include_once("lister_utilisateurs.php");
?>
