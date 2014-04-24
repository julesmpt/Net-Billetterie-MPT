<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/

include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/utils.php");
include_once("include/themes/default/style_print.css");

function date_francais($date){
						preg_match ('`^(\d{4})-(\d{2})-(\d{2})(.*)$`', $date, $out); 
						if($out[2]<10){$out[2]=substr($out[2],1,1);}
						$i=$out[2];
						$mois = array('','janvier', 'fevrier', 'mars', 'avril', 'mai','juin','juillet', 'aout', 'septembre', 'octobre','novembre', 'decembre');
						return $out[3].' '.$mois[$i].' '.$out[1].' '.$out[4];
						}

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
?>

<script type="text/javascript">
window.print() ;
</script>

<page>
<a href="impression_stat.php"class="noImpr"><img src="image/retour.png">Revenir aux statistiques</a><br/>
<div><img src="<?php echo $logo;?>"  width="150" align="left">
<?php echo "$slogan $annee_2-$annee_1<br/>$c_postal $ville <br/>$tel <br/> $mail";?></div>
<br/><br/><br/>
        <h2>Chiffre d'affaires par représentation de la saison <?php echo "$annee_2 - $annee_1"; ?></h2>

 
                      <table class="liste">

                        <tr>
                          <th>Spectacle</th>
                          <th>Date</th>
                          <th>NBR</th>
                          <th>Total</th>
                          <th>Type de tarif</th>
                          <th>Prix unitaire</th>
                          <th>NBR</th>
                          <th>Total sur le tarif</th>
                        </tr>

                                   
<?php      
//==================================================
                        //on recupère la sommes des commandes passées dans la periode de la saison

                        $sql = "SELECT CB.article_num, SUM(to_tva_art) total, article, SUM(quanti) nombre, date_spectacle
                                FROM ".$tblpref."cont_bon CB, ".$tblpref."article, ".$tblpref."bon_comm BC
								WHERE CB.article_num = ".$tblpref."article.num
								AND BC.num_bon=CB.bon_num
								AND BC.attente='0'
								AND BC.fact='ok'
								AND	date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
								GROUP BY article_num
								ORDER BY date_spectacle
                                 ";
                        $req = mysql_query($sql)or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());;
                        while ($data = mysql_fetch_array($req))
                        {
                        $date = $data['date_spectacle'];
						
                        $tot = $data['total'];
                        $num=$data['article_num'];
                        $art = $data['article'];
                        $quanti = $data['nombre'];

                      ?>    
						<tr> 					  
                            <td><?php echo "$art"; ?></td>
                            <td><?php echo '',date_francais($date);?></td>
                            <td><?php echo "$quanti"; ?></td>
                            <td><?php echo "$tot $devise"; ?></td>

                       </tr>
					   

                                  <?php 

                                    $sql4 = "SELECT CB.id_tarif, article_num, article, SUM(to_tva_art), SUM(quanti), T.nom_tarif, T.prix_tarif
                                    FROM ".$tblpref."cont_bon CB, ".$tblpref."tarif T, ".$tblpref."bon_comm BC, ".$tblpref."article ART
                                    WHERE CB.article_num=$num
									AND CB.article_num=ART.num
                                    AND CB.id_tarif=T.id_tarif
									AND CB.bon_num=BC.num_bon
									AND BC.attente='0'
									AND BC.fact='ok'
                                    group by CB.id_tarif";
                                    $req4 = mysql_query($sql4)or die('Erreur SQL4 !<br>'.$sql4.'<br>'.mysql_error());;

                                    while ($data = mysql_fetch_array($req4))
                                {
                                    $tot4 = $data['SUM(to_tva_art)'];
                                    $art4 = $data['article'];
                                    $nom_tarif4= $data['nom_tarif'];
                                    $quanti4 = $data['SUM(quanti)'];
                                    $prix4 = $data['prix_tarif'];
                                    ?>
						<tr>
						  <td colspan="4"></td>
						  <td><?php echo "$nom_tarif4"; ?></td>
						  <td><?php echo "$prix4 $devise"; ?></td>
						  <td><?php echo "$quanti4"; ?></td>
						  <td><?php echo "$tot4 $devise"; ?></td>
						</tr>
                                    <?php
                                }
								?>  <?php
						}
                            ?>
						
               </table>
			   <?php
						$sql5="SELECT SUM( tot_tva ) total FROM `".$tblpref."bon_comm` 
						WHERE attente='0'
						AND fact='ok'
						AND	date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
						$req5 = mysql_query($sql5)or die('Erreur SQL5 !<br>'.$sql5.'<br>'.mysql_error());
						while ($data = mysql_fetch_array($req5))
											{
												$tot5 = $data['total'];
												}
					?>
					<br><br><br><br><br>
			  <h1> Chiffre d'affaires de la saison culturel <br>est actuellement de <?php echo "$tot5 $devise" ; ?></h1>	
				<br>
			<h2>Reparti de la maniere suivante </h2>
			
					<table class="liste">
						<tr>
							<th>Tarifs</th>
							<th> Prix</th>
							<th> Nombre</th>
							<th>Chiffre d'affaire</th>
							<th>N° des tickets</th>
						</tr>
						<?php
						$sql6="SELECT CB.id_tarif, SUM( to_tva_art ) AS total, T.nom_tarif, T.prix_tarif, SUM(quanti) AS quanti, T.carnet
							FROM ".$tblpref."cont_bon CB, ".$tblpref."bon_comm BC, ".$tblpref."tarif T, ".$tblpref."article ART
							WHERE CB.bon_num = BC.num_bon
							AND BC.attente='0'
							AND BC.fact='ok'
							AND CB.id_tarif=T.id_tarif
							AND ART.num=CB.article_num
							AND	BC.date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
							AND	ART.date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
							GROUP BY CB.id_tarif";
						$req6 = mysql_query($sql6)or die('Erreur SQL6 !<br>'.$sql6.'<br>'.mysql_error());
									while ($data = mysql_fetch_array($req6))
									{
									$tot6 = $data['total'];
									$nom_tarif6 = $data['nom_tarif'];
									$prix_tarif6 = $data['prix_tarif'];
									$quanti6 = $data['quanti'];
									$carnet = $data['carnet'];
									$du= $carnet;
									$au=$quanti6+$carnet-1;
									$du= substr_replace("0000",$du, -strlen($du));
									$au= substr_replace("0000",$au, -strlen($au));
									?>
						<tr>
							<td> <?php echo $nom_tarif6 ; ?></td>
							<td> <?php echo montant_financier ($prix_tarif6) ; ?></td>
							<td> <?php echo $quanti6 ; ?></td>
							<td> <?php echo montant_financier ($tot6) ; ?></td>
							<td> <?php echo "du billet: $du  au billet :$au" ; ?></td>
						</tr>
						<?php } ?>
					</table>
					
			   
        </page>

