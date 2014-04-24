<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors: José Das Neves pitu69@hotmail.fr*/

//url de la racine de net-billetterie
$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url_list = explode('/', $url);
$url1="http://$url_list[2]"; 
if ($url_list[3]!="include")
{$url2= "/$url_list[3]";
 }
$url_root="$url1$url2";


$sql="SELECT * FROM ".$tblpref."admin ";
$result=mysql_query($sql) or die('Erreur SQL !<br/>'.$sql.'<br/>'.mysql_error()); 
while ($data=mysql_fetch_array($result)){
	$nom=$data['nom'];
	$designation=$data['designation'];
	if ($nom=="entrep_nom"){$entrep_nom=$designation;}
	if ($nom=="social"){$social=$designation;}
	if ($nom=="tel"){$tel=$designation; }
	if ($nom=="slogan"){$slogan=$designation; }
	if ($nom=="mail"){$mail=$designation;}
	if ($nom=="devise"){$devise=$designation; }
	if ($nom=="logo"){$logo=$designation; }
	if ($nom=="lang"){$lang=$designation; }
	if ($nom=="site"){$site=$designation; }
	if ($nom=="c_postal"){$c_postal=$designation; }
	if ($nom=="ville"){$ville=$designation; }
	if ($nom=="indicatif_tel"){$indicatif_tel=$designation; }
	if ($nom=="smtp"){$smtp=$designation; }
	if ($nom=="port"){$port=$designation; }
	if ($nom=="username_smtp"){$port=$designation;}
	if ($nom=="password_smtp"){$password_smtp=$designation;}
	if ($nom=="impression"){$impression=$designation;}
	if ($nom=="debut_saison"){$debut_saison=$designation;}
	if ($nom=="fin_saison"){$fin_saison=$designation;}
}

?>
