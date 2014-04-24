<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/

error_reporting(0);
require_once("include/config/common.php"); 
if (empty($host)) {
echo '<link rel="stylesheet" type="text/css" href="include/style.css">';
echo'<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" >';
echo '<h1>Le logiciel ne semble pas encore avoir ete configuré. Cliquez <a href="installeur/index.php">ici</a> pour le configurer dès maintenant.</h1>';

}
else{
header('location:logout.php');
}

 ?> 
