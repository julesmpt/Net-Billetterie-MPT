<?php
//common.php cr�� grace � l'installeur de Net-Billetterie, soyez prudent si vous l'�ditez
$user= "root";//l'utilisateur de la base de donn�es mysql
$pwd= "5m@mbo24";//le mot de passe � la base de donn�es mysql
$db= "net_billetterie_bdd";//le nom de la base de donn�es mysql
$host= "localhost";//l'adresse de la base de donn�es mysql 
$default_lang= "fr";//la langue de l'interface et des factures cr��es par Net-Billetterie : voir la doc pour les abbr�viations
$tblpref= "";//prefixe des tables 
mysql_connect($host,$user,$pwd) or die ("serveur de base de donn�es injoignable, verifiez dans /Net-Billetterie/include/config/common.php si $host est correct.");
mysql_select_db($db) or die ("La base de donn�es est injoignable, verifiez dans /Net-Billetterie/include/config/common.php si $user, $pwd, $db sont exacts.");
?>