<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/

require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
include_once("include/configav.php");
?>
<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">

</td>
</tr>
<tr>
<td  class="page" align="center">
<?php
$client=isset($_POST['listeville'])?$_POST['listeville']:"";
$date=isset($_POST['date'])?$_POST['date']:"";
$id_tarif=isset($_POST['id_tarif'])?$_POST['id_tarif']:"";



list($jour, $mois,$annee) = preg_split('/\//', $date, 3);

include_once("include/language/$lang.php");
if($client=='0')
    {
    $message="<h1> $lang_choix_client</h1>";
    /* include('form_commande.php'); */
    exit;
    }
//pour la 1er ligne de la page
$sql_nom = "SELECT  nom, nom2 FROM " . $tblpref ."client WHERE num_client = $client";
$req = mysql_query($sql_nom) or die('Erreur SQL  !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$nom = $data['nom'];
		$nom2 = $data['nom2'];
		$phrase = "$lang_bon_cree";
                ?>
		<h1><?php echo "$phrase: $nom - $nom2 $lang_bon_cree2 $date<br>";?></h1><br>
                <?PHP
		}
		
// on créer un bon de commmande
$sql1 = "INSERT INTO " . $tblpref ."bon_comm(client_num, date, id_tarif, paiement, attente) VALUES ('$client', '$annee-$mois-$jour', '$id_tarif', 'non', '1')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
// on affiche les infos du bon de commande
$sql_num = "SELECT  num_bon FROM " . $tblpref ."bon_comm WHERE client_num = $client order by num_bon desc limit 1 ";
$req = mysql_query($sql_num) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$num_bon = $data['num_bon'];
                ?>
		<h3><?php echo "Inscription sur liste d'attente N $num_bon";?></h3><br>
                <?PHP
		}
?>
<center>
<form name='formu2' method='post' action='bon_suite_attente.php'>
    <table class="boiteaction">
      <caption><? echo "$lang_donne_bon"; ?></caption>
      <tr>
        <td class="texte0">Choisir le nombre de places </td>
        <td class="texte0" colspan="3">
	  <input  type="text" name="quanti" value="1" SIZE="1"></td>
	</tr>
	<tr>
	<td class="texte0">Choisir le  <?php echo "$lang_article";
				 include_once("include/configav.php");
				 

//=============================================
//pour que les articles soit classés par saison
$mois=date("n");
if ($mois=="10"||$mois=="11"||$mois=="12") {
 $mois=date("n");
}
else{
  $mois =date("0n");
}
$jour =date("d");
$date_ref="$mois-$jour";
$annee = date("Y");
//pour le formulaire
$annee_1=isset($_POST['annee_1'])?$_POST['annee_1']:"";
if ($annee_1=='') 
{
  $annee_1= $annee ;
  if ($mois.'-'.$jour <= $fin_saison)
  {
  $annee_1=$annee_1;
  }
  if ($mois.'-'.$jour >= $fin_saison)
  {
  $annee_1=$annee_1+1;
  }  
}
$annee_2= $annee_1 -1;
//=============================================

	// pour ne montrer que les articles dont le stock est "0" ou inf.
				 $rqSql = "SELECT uni, num, article, DATE_FORMAT( date_spectacle, '%d/%m/%Y' ) AS date, prix_htva, stock, stomin, stomax
                                            FROM " . $tblpref ."article
                                            WHERE stock < '1'
                                            AND date_spectacle
                                            BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
                                            ORDER BY date_spectacle";
			 $result = mysql_query( $rqSql )
             or die( "Exécution requète impossible.");?>
        <td class="texte0">
            <SELECT NAME='article'>
            <OPTION VALUE=0><?php echo $lang_choisissez; ?></OPTION>
            <?php

						while ( $row = mysql_fetch_array( $result)) {
    							$num = $row["num"];
    							$article = $row["article"];
								$date = $row["date"];
								$stock = $row['stock'];
								$min = $row['stomin'];
								if ($stock<=0 ) 
								{
                                                                    $stock="Liste d'attente est de $stock places";
                                                                    $style= 'style="color:red; background:#cccccc;"';
                                                                    $option="".$article." ---". $date." ---".$stock."";
                                                        }
                                                        
    							?>
            <OPTION <?php echo"$style"; ?> VALUE='<?php echo $num; ?>'><?php echo" $option"; ?></OPTION>
            <?php
                                                        }
						?>
           </SELECT>
	   </td>
	   </tr>
	   		<tr>
		   <td class="texte0">Choisir le<?php echo "$lang_tarif";?>

		   <?php


                   $rqSql3= "SELECT id_tarif, nom_tarif, prix_tarif FROM " . $tblpref ."tarif WHERE id_tarif=$id_tarif ";
				 $result3 = mysql_query( $rqSql3 )
             or die( "Exécution requête impossible.");
						while ( $row = mysql_fetch_array( $result3)) 
						{
    							$id_tarif = $row["id_tarif"];
    							$nom_tarif = $row["nom_tarif"];
							$prix_tarif = $row["prix_tarif"];
    							?>
		   </td>
		   <td class="texte_left">
                <SELECT NAME='id_tarif'>
					<OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
					<?php } 
		//on recupère les tarif pour la selection du form
						$rqSql4= "SELECT id_tarif, nom_tarif, prix_tarif, DATE_FORMAT(saison, '%d/%m/%Y' ) AS date 								
								FROM " . $tblpref ."tarif
								WHERE saison BETWEEN '$annee_2-08-01' AND '$annee_1-07-01'
								AND selection='1'
							ORDER BY nom_tarif ASC";
						$result4 = mysql_query( $rqSql4 ) or die( "Exécution requête impossible.");
							while ( $row = mysql_fetch_array( $result4)) 
							{
									$id_tarif = $row["id_tarif"];
									$nom_tarif = $row["nom_tarif"];
									$prix_tarif = $row["prix_tarif"];
									?>
				<OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
							<?php 
							} ?>
			   </SELECT>
					 </td>
                                         

      </tr>

	  <tr>
			<td class="submit" colspan="4">
				<input type="hidden" name="nom" id="nom" value='<?php echo $nom ?>'>
				<input type="hidden" name="bon_num"  value='<?php echo $num_bon ?>'>
				<input type="hidden" name="num_client" value='<?php echo $client ?>'>
                                        
				<input type="submit" name="Submit" value='Enregistrer le spectacle'>
			</td>
	  </tr>


  </table></form></center>
</td></tr><tr><td>
<br><br><br><br>


<?php
include("help.php");
echo"</td></tr><tr><td>";
include_once("include/bas.php");
?></td></tr></table>
</body>
</html>
