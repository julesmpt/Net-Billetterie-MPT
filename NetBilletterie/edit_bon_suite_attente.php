<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
require_once("include/configav.php");
$article_num=isset($_POST['article'])?$_POST['article']:"";
$nom=isset($_POST['nom'])?$_POST['nom']:"";
$num_bon=isset($_POST['num_bon'])?$_POST['num_bon']:"";
$quanti=isset($_POST['quanti'])?$_POST['quanti']:"";
$id_tarif=isset($_POST['id_tarif'])?$_POST['id_tarif']:"";
$prix_tarif=isset($_POST['prix_tarif'])?$_POST['prix_tarif']:"";

//on recupere le prix des differents tarifs
 $sql30 = "SELECT prix_tarif FROM " . $tblpref ."tarif WHERE id_tarif = '$id_tarif'";
 $result30 = mysql_query($sql30) or die('Erreur SQL !<br>'.$sql30.'<br>'.mysql_error());
 $row = mysql_fetch_array($result30); 
 $prix_tarif = $row["prix_tarif"];

$mont_tva = $prix_tarif * $quanti ;


//inserer les données dans la table du contenu des bons.

mysql_select_db($db) or die ("Could not select $db database");
$sql1 = "INSERT INTO ".$tblpref."cont_bon (quanti, prix_tarif, article_num, bon_num, tot_art_htva, to_tva_art, p_u_jour, id_tarif)
                                  VALUES ('$quanti', '$prix_tarif', '$article_num', '$num_bon', '$total_htva', '$mont_tva', '$prix_article', '$id_tarif')";
mysql_query($sql1) or die('Erreur SQL3 !<br>'.$sql1.'<br>'.mysql_error());

//on contrôle si le stock est negatif
$rqSql1 = "SELECT stock, article FROM ".$tblpref."article WHERE  `num` = '$article_num'";
$result = mysql_query( $rqSql1 ) or die( "ExÃ©cution requÃ¨tes impossible.");
while ( $row = mysql_fetch_array( $result)) 
				{ $stock = $row["stock"];
				$article = $row["article"];}
				
				if ($stock<=0){

//ici on decremnte le stock avec la mention complet a l'article
$sql12 = "UPDATE `" . $tblpref ."article` SET `stock` = (stock - ".$quanti."), actif= 'COMPLET' WHERE `num` = '$article_num'";
mysql_query($sql12) or die('Erreur SQL12 !<br>'.$sql12.'<br>'.mysql_error());
}
else {
//sinon on decremnte le stock tout simplement
$sql12 = "UPDATE `" . $tblpref ."article` SET `stock` = (stock - ".$quanti."), actif= '' WHERE `num` = '$article_num'";
mysql_query($sql12) or die('Erreur SQL12 !<br>'.$sql12.'<br>'.mysql_error());
}

include_once("form_editer_bon_attente.php");
?>
