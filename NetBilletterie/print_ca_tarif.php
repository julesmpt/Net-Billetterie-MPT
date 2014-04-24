<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/utils.php");
include_once("include/themes/default/style_print.css");

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

if ($user_stat== n){
echo"<h1>$lang_statistique_droit";
exit;
}

?>
<script type="text/javascript">
window.print() ;
</script>

<page >
<a href="impression_stat.php" class="noImpr"><img src="image/retour.png">Revenir aux statistiques</a><br/>
<div><img src="<?php echo $logo;?>"  width="200" align="left" >
<?php echo "<h4>$slogan $annee_2-$annee_1</h4>$c_postal $ville <br/>$tel <br/> $mail";?></div>
<br/><br/>
	<h2>Chiffre d'affaires par tarif de la saison culturelle <?php if ( $date_debut == ''){
																		echo "$annee_2 - $annee_1";
																		}
																		if ( $date_debut != ''){
																		echo "entre le $date_debut - $date_fin";
																		}
																		?></h2>
<br/>
 <table  class="liste">
	<tr>
			<?php
				$sql5="SELECT SUM( tot_tva ) total FROM `".$tblpref."bon_comm`
				WHERE attente='0'
				AND fact='ok'";
			if ( $date_debut == ''){
			$sql5.= " AND	date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
			}
			
			else {
			$sql5.= " AND date BETWEEN '$date01' AND '$date02'";
			}
				$req5 = mysql_query($sql5)or die('Erreur SQL5 !<br>'.$sql5.'<br>'.mysql_error());
				$data = mysql_fetch_array($req5);
				$tot5 = $data['total'];
			?>
		<td><?php
			if ($user_stat== n)
			{
				echo"<h1>$lang_statistique_droit";
				exit;
			}?><br>
		<h1> Chiffre d'affaires est  de <?php echo montant_financier ($tot5); ?></h1>
					<table class="boiteaction">
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
										AND BC.attente='0'
										AND BC.fact='ok'
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
						<tr>
							<td> <?php echo $nom_tarif6 ; ?></td>
							<td> <?php echo montant_financier ($prix_tarif6) ; ?></td>
							<td> <?php echo $quanti6 ; ?></td>
							<td> <?php echo montant_financier ($tot6) ; ?></td>
							<td> <?php 
							if ($du!=$au){echo "du billet: $du  au billet :$au" ;}
							else {echo "billet: $du " ;} ?></td>
						</tr>
						<?php } ?>
					</table>
				</td>	
			</tr>
		</td>
	</tr>
</table>
<br/>
<h1> Récapitulatifs des paiements</h1>
<table WIDTH="300px">
	<tr>
		<th align="left">Total</th>
		<th align="left">Paiement</th>
	</tr>
	
		<?php
			$sql8="SELECT  SUM( tot_tva ) AS total, paiement 
					FROM factux_bon_comm BC
					WHERE attente='0'
					AND fact='ok'";
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
		<td><?php echo montant_financier ($total);?></td>
		<td> <?php echo $paiement;?></td>
	</tr>
	<?php	} ?>
</table>
</page>

