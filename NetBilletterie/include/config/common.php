<?php
//common.php créé grace à l'installeur de Net-Billetterie, soyez prudent si vous l'éditez
$user= "root";//l'utilisateur de la base de données mysql
$pwd= "5m@mbo24";//le mot de passe à la base de données mysql
$db= "net_billetterie_bdd";//le nom de la base de données mysql
$host= "localhost";//l'adresse de la base de données mysql 
$default_lang= "fr";//la langue de l'interface et des factures créées par Net-Billetterie : voir la doc pour les abbréviations
$tblpref= "";//prefixe des tables 
mysql_connect($host,$user,$pwd) or die ("serveur de base de données injoignable, verifiez dans /Net-Billetterie/include/config/common.php si $host est correct.");
mysql_select_db($db) or die ("La base de données est injoignable, verifiez dans /Net-Billetterie/include/config/common.php si $user, $pwd, $db sont exacts.");
?>