<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
require_once("include/configav.php");

$article=isset($_POST['article'])?$_POST['article']:"";
$nom=isset($_POST['nom'])?$_POST['nom']:"";
$num_bon=isset($_POST['num_bon'])?$_POST['num_bon']:"";
$quanti=isset($_POST['quanti'])?$_POST['quanti']:"";
$id_tarif=isset($_POST['id_tarif'])?$_POST['id_tarif']:"";
$prix_tarif=isset($_POST['prix_tarif'])?$_POST['prix_tarif']:"";





//////////////////////////////////ARTICLE  ///////////////////////////////////////////////////
  for ($i = 0; $i < count($_POST["article"]); $i++)
 {
      $article=$_POST["article"][$i]."" ;
	  
//on controle s'il y a assez de stock
$rqSql11= "SELECT stock, article FROM " . $tblpref ."article WHERE num=$article ";
				 $result11 = mysql_query( $rqSql11 )
             or die( "Exécution requête rqsql11 impossible.");
						while ( $row = mysql_fetch_array( $result11)) {
    							$stock = $row["stock"];
                                                        $nom_article= $row["article"];}
                                                        $tre=$stock-$quanti;
        if($tre<0)
        { 
    echo "<h1>Le nombre de places est insuffisant pour le spectacle -- $nom_article --</h1><br><br><h3>Vous avez demandé $quanti places et il n'en reste plus que $stock </h3>";
    ?><a href="form_editer_bon.php?num_bon=<?php echo"$num_bon";?>&nom=<?php echo"$nom";?>&id_tarif=<?php echo"$id_tarif";?>">recommencez la saisie</a><!--a href="javascript:history.go(-1)">recommencez la saisie</a--><?php

    exit;
        }

        
//on recupere le prix des differents tarifs 

 $sql30 = "SELECT prix_tarif FROM " . $tblpref ."tarif WHERE id_tarif = $id_tarif";
 $result30 = mysql_query($sql30) or die('Erreur SQL30 !<br>'.$sql30.'<br>'.mysql_error());
while ( $row = mysql_fetch_array( $result30)) {
$prix_tarif= $row["prix_tarif"];
}

$mont_tva = $prix_tarif * $quanti ;  


//inserer les données dans la table du contenu des bons.

mysql_select_db($db) or die ("Could not select $db database");
$sql1 = "INSERT INTO " . $tblpref ."cont_bon(quanti, prix_tarif, article_num, bon_num, tot_art_htva, to_tva_art, p_u_jour, id_tarif) 
VALUES ('$quanti', '$prix_tarif', '$article', '$num_bon', '$total_htva', '$mont_tva', '$prix_article', '$id_tarif')";
mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());

//ici on decremnte le stock
$sql12 = "UPDATE `" . $tblpref ."article` SET `stock` = (stock - ".$quanti.") WHERE `num` = '$article'";
mysql_query($sql12) or die('Erreur SQL12 !<br>'.$sql12.'<br>'.mysql_error()); 
}


include_once("edit_bon.php");
?>
