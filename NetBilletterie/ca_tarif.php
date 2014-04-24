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
include_once("include/head.php");
include_once("include/finhead.php");


//===================================================
//pour que les tarifs soit classés dans une tranche de temps defini
$date_today= date("Y-m-d");
list($annee, $mois, $jour) = explode("-", $date_today);
$date_today = "$jour-$mois-$annee";

$date_debut=isset($_GET['date_debut'])?$_GET['date_debut']:"";
	list($jour, $mois, $annee) = explode("-", $date_debut);
$date01 = "$annee-$mois-$jour";
$date_fin=isset($_GET['date_fin'])?$_GET['date_fin']:"";
	list($jour, $mois, $annee) = explode("-", $date_fin);
$date02 = "$annee-$mois-$jour";

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

<table  border="0" class="page" align="center">
	<tr>
			<?php
			//on recupère le total ->$tot5 des commandes encaissé ->fact=0k
				$sql5="SELECT SUM(tot_tva) total, date FROM `".$tblpref."bon_comm`
						WHERE attente=0
						AND fact='ok'";
			if ( $date_debut == ''){
			$sql5.= " AND	date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison' ";
			}
			
			else {
			$sql5.= " AND date BETWEEN '$date01' AND '$date02'";
			}
				$req5 = mysql_query($sql5)or die('Erreur SQL5 !<br>'.$sql5.'<br>'.mysql_error());
				$data = mysql_fetch_array($req5);
				$tot5 = $data['total'];
			?>
		<td class="highlight"><?php
			if ($user_stat== n)
			{
				echo"<h1>$lang_statistique_droit";
				exit;
			}?><br>
			<?php
			if($date_debut!=""){?>
		<h1> Chiffre d'affaires de la saison culturel pour la pèriode du <?php echo"$date_debut au $date_fin";?> est de <?php echo montant_financier ($tot5); ?></h1>
			<?php }
			else{?>
		<h1> Chiffre d'affaires de la saison culturel <?php echo"$annee_2-$annee_1";?> est de <?php echo montant_financier ($tot5); ?></h1>
			<?php }?>
			<br>
			
			                  <!--formulaire du choix de saison-->
                 <center>
                     <form action="ca_tarif.php" method="post">
                        <table >
                            <tr>
                             <td class="highlight">
                                <select name="annee_1">
                                    <option value="<?php echo"$annee_1"; ?>"><?php $date_1=$annee_1-1;echo"$date_1 -$annee_1"; ?></option>
                                    <option value="<?php $date=date("Y");echo"$date"; ?>"><?php $date=date("Y");$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                                    <option value="<?php $date=(date("Y")-1);echo"$date"; ?>"><?php $date=(date("Y")-1);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                                    <option value="<?php $date=(date("Y")-2);echo"$date"; ?>"><?php $date=(date("Y")-2);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                                    <option value="<?php $date=(date("Y")-3);echo"$date"; ?>"><?php $date=(date("Y")-3);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                                    <option value="<?php $date=(date("Y")-4);echo"$date"; ?>"><?php $date=(date("Y")-4);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                                    <option value="<?php $date=(date("Y")-5);echo"$date"; ?>"><?php $date=(date("Y")-5);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                                    <option value="<?php $date=(date("Y")-6);echo"$date"; ?>"><?php $date=(date("Y")-6);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                                </select>
                             </td>
                             <td class="highlight"><input type="submit" value='Choisir la saison culturelle'></td>
						 </tr>
					   </table>
					 </form>
					 <br/>
					<form action="ca_tarif.php" method="get">
						<center>
							<table>
								<b>Afficher le chiffre d'affaire par tarif et par paiement</b>
								<tr>
									<td class="highlight"><b>Choisir les dates entre le (jj-mm-aaaa)</b> </td>
									<td class="highlight"> <input name="date_debut" type="text" size="10" maxlength="40"  value="<?php echo $date_today;?>" ></td>
									<td class="highlight"><b> et le </b></td>
									<td class="highlight"> <input name="date_fin" type="hidden"  value="<?php echo $date_today;?>"><?php echo $date_today;?></td>
									<td class="highlight"> <input type="submit" name="Submit" value="Afficher la liste"></td>
								</tr>
		                    </table>
		                </center>
		              </form>
				</center>
				 

					
				</td>	
			</tr>
		</td>
	</tr>
	<!--tableau tarifs-->
	<tr>
		<td>
			<h2>Répartition suivant les tarifs</h2>
			<center>
				<table class="boiteaction">
					<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
						<th width="25%">Tarifs</th>
						<th width="10%"> Prix</th>
						<th width="10%"> Nombre</th>
						<th width="15%">Chiffre d'affaire</th>
						<th>N° des tickets</th>
					</tr>
					<?php
					$sql6="SELECT CB.id_tarif, SUM( to_tva_art ) AS total, T.nom_tarif, T.prix_tarif, SUM(quanti) AS quanti, T.carnet
						FROM ".$tblpref."cont_bon CB, ".$tblpref."bon_comm BC, ".$tblpref."tarif T, ".$tblpref."article ART
						WHERE CB.bon_num = BC.num_bon
						AND BC.attente ='0' 
						AND BC.fact ='ok'
						AND CB.id_tarif=T.id_tarif
						AND ART.num=CB.article_num
						AND	ART.date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
						if ( $date_debut == ''){
							$sql6.= " AND	date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
										GROUP BY CB.id_tarif";
						}
							
						else {
							$sql6.= " AND date BETWEEN '$date01' AND '$date02'
										GROUP BY CB.id_tarif";
						}
					$req6 = mysql_query($sql6)or die('Erreur SQL6 !<br>'.$sql6.'<br>'.mysql_error());
								while ($data = mysql_fetch_array($req6))
								{
								$tot6 = $data['total'];

								$nom_tarif6 = $data['nom_tarif'];
								$prix_tarif6 = $data['prix_tarif'];
								$quanti6 = $data['quanti'];
								$id_tarif = $data['id_tarif'];
								$carnet = $data['carnet'];
								$sql7="SELECT CB.id_tarif, SUM( to_tva_art ) AS total, T.nom_tarif, T.prix_tarif, SUM(quanti) AS quanti, T.carnet
									FROM ".$tblpref."cont_bon CB, ".$tblpref."bon_comm BC, ".$tblpref."tarif T, ".$tblpref."article ART
									WHERE CB.bon_num = BC.num_bon
									AND BC.attente ='0' 
									AND BC.fact ='ok'
									AND CB.id_tarif=T.id_tarif
									AND ART.num=CB.article_num
									AND	ART.date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
									AND	date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
									AND CB.id_tarif= $id_tarif";
									$req7 = mysql_query($sql7)or die('Erreur SQL7!<br>'.$sql7.'<br>'.mysql_error());
									while ($data = mysql_fetch_array($req7))
									{
									$quanti7= $data['quanti'];
									}
								
								
								$au=$quanti7+$carnet-1;
								$du= $au- $quanti6+1;
								$du= substr_replace("0000",$du, -strlen($du));
								$au= substr_replace("0000",$au, -strlen($au));
								?>
					<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
						<td class="highlight" class="highlight"> <?php echo $nom_tarif6 ; ?></td>
						<td class="highlight" class="highlight"> <?php echo montant_financier ($prix_tarif6) ; ?></td>
						<td class="highlight" class="highlight"> <?php echo $quanti6 ; ?></td>
						<td class="highlight" class="highlight"> <?php echo montant_financier ($tot6) ; ?></td>
						<td class="highlight" class="highlight"> <?php 
						if ($du!=$au){echo "du billet: $du  au billet :$au" ;}
						else {echo "billet: $du " ;} ?></td>
					</tr>
					<?php } ?>
				</table>
			</center>	
		</td>	
	</tr>
	<tr>
		<td><h2> Récapitulatifs des paiements</h2>
			<center>
				<table width="50%">
					
					<tr>
						<th width="70%">Paiement</th>
						<th width="30%">Total</th>
						
					</tr>
					
						<?php
							$sql8="SELECT  SUM( tot_tva ) AS total, paiement 
									FROM factux_bon_comm BC
									WHERE attente='0'
									AND BC.fact ='ok'";
								if ( $date_debut == ''){
								$sql8.= " AND date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
									GROUP BY BC.paiement";
								}
								else {
									$sql8.=" AND date BETWEEN '$date01' AND '$date02'
									GROUP BY BC.paiement";
								}
							$req8 = mysql_query($sql8)or die('Erreur SQL8!<br>'.$sql8.'<br>'.mysql_error());
							while ($data = mysql_fetch_array($req8))
							{
							$total= $data['total'];
							$paiement= $data['paiement'];
							$nombre = $nombre +1;
							if($nombre & 1){
							$line="0";
							}else{
							$line="1";
							}
							?>
					<tr>
						<td class="highlight"> <?php echo $paiement;?></td>
						<td class="highlight"><?php echo montant_financier ($total);?></td>
						
					</tr>
					<?php	} ?>
				</table>
			</center>
		</td>	
	</tr>
	
</table>
<?php
include_once("include/bas.php");
?>
