<?php
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Jos� Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
$nom_banque=isset($_POST['nom_banque'])?$_POST['nom_banque']:"";
$nom_banque= AddSlashes($nom_banque);
$nom_banque= ucfirst($nom_banque);

if($nom_banque=='' )
{
echo "<center><h1>$lang_oubli_champ";
include('form_banque.php');
exit;
}

$sql1 = "INSERT INTO ".$tblpref."banque (nom) VALUES ('$nom_banque')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
$message= "<center><h2>Banque $nom_banque a �t� ajout�e � la liste</h2>";
include("lister_banque.php");
include_once("include/bas.php");
?>
