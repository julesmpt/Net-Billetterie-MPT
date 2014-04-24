<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
include_once("include/config/common.php");
include 'include/lib/Zebra_Session.php';
// instantiate the class
// this also calls session_start()
$session = new Zebra_Session;

//$_SESSION=array();
session_destroy();
//$session->stop();

foreach (glob("fpdf/*.pdf") as $filename)
{
	unlink($filename); 
}

header ('location:login.inc.php');
?>