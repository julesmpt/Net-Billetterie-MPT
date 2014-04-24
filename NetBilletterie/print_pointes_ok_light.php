<script type="text/javascript">
window.print() ;
</script>
	
<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/

require_once("include/verif.php");
$date_debut=isset($_GET['date_debut'])?$_GET['date_debut']:"";
	list($jour, $mois, $annee) = explode("-", $date_debut);
	$date01 = "$annee-$mois-$jour";
$date_fin=isset($_GET['date_fin'])?$_GET['date_fin']:"";
	list($jour, $mois, $annee) = explode("-", $date_fin);
	$date02 = "$annee-$mois-$jour";
$regie=isset($_GET['regie'])?$_GET['regie']:"";
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/utils.php");
include_once("include/themes/default/style_print.css");

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

<page >
<a href="impression.php" class="noImpr"><img src="image/retour.png">Revenir aux statistiques</a><br/>
<div><img src="<?php echo $logo;?>"  width="200" align="left" >
<?php echo "<h4>$slogan $annee_2-$annee_1</h4>$c_postal $ville <br/>$tel <br/> $mail";?></div>
<br/><br/><br/>
				<h1>Régie de spectacle Commune de Lentilly 217</h1>
				 <h2><?php if ( $regie != ''){
								echo "N° régie: $regie";
								}
								?>
				</h2>
                 <h2><?php if ( $date_debut == ''){
								echo "Saison culturelle $annee_2 - $annee_1.  Liste de tous les enregistrements. ";
								}
								if ( $date_debut != ''){
								echo "Pour la période du $date_debut au $date_fin";
								}
								?>
				</h2>
<table class="liste" cellspacing="0"  cellpadding="0">
<tr>

	<th>Montant <br/>Chèques</th>
	<th>Montant <br/>Espèces</th>
	<th>Montant <br/>M ra</th>
	<th>Montant <br/>Site billet réduc</th>
	<?php 
	//on recupère les infos des tarifs
	$sql = "SELECT * 
			FROM " . $tblpref ."tarif
			WHERE saison BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
			AND prix_tarif!='0.00' ";
	$resultat_tarif = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	$nombre_tarif = mysql_num_rows($resultat_tarif);
	while($data = mysql_fetch_array($resultat_tarif)){
		$nom_tarif=$data['nom_tarif'];
		$prix_tarif= $data['prix_tarif'];
	?>
	<th width='10%'><?php echo "$nom_tarif <br/> à $prix_tarif"; ?> </th>
	<?php  
	} 
	?>
	<th width='10%'>Titulaire <br/> Chèque</th>
	<th width='10%'>Etablissement <br/>bancaire</th>
	
</tr>
	<?php
//======================================================================================
	//on boucle sur les bons de commandes paiement par cheque et puis Espèces
//==========================================================================================
	$tableau_paiement = array("Chèque", "Espèces", "M ra", "Site billet réduc");
	for($nbr=0;$nbr<sizeof($tableau_paiement);$nbr++)
	{
		$paiement=$tableau_paiement[$nbr];
			$sql="SELECT *  FROM `".$tblpref."bon_comm`
			RIGHT JOIN ".$tblpref."client on ".$tblpref."bon_comm.client_num = num_client
			WHERE ".$tblpref."bon_comm.attente ='0' 
			AND ".$tblpref."bon_comm.fact ='ok'
			AND paiement='$paiement'";

			if ( $date_debut != ''){
			$sql.= "AND date_fact BETWEEN '$date01' AND '$date02'
			ORDER BY " . $tblpref ."bon_comm.`num_bon` DESC ";
			}
			else{
			$sql.="AND date_fact BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
			ORDER BY ".$tblpref."bon_comm.`num_bon` DESC ";
			}
			$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		while($data = mysql_fetch_assoc($req))
		{ 
			$num_bon = $data['num_bon'];
			$tva = $data["tot_tva"];
			$id_tarif = $data["id_tarif"];
			$banque = $data['banque'];
			$titulaire_cheque = $data['titulaire_cheque'];
			$titulaire_cheque = htmlentities($titulaire_cheque, ENT_QUOTES);
			?>
			<tr>
				<?php
				if ($paiement=='Chèque') {
					echo "<td class='top'>$tva $devise</td><td class='top'></td><td class='top'></td><td class='top'></td>";
				} 
				if ($paiement=='Espèces') {
				echo "<td class='top'></td><td class='top'>$tva $devise</td><td class='top'></td><td class='top'></td>";
				}
				if ($paiement=='M ra') {
					echo "<td class='top'></td><td class='top'></td><td class='top'>$tva $devise</td><td class='top'></td>";
				}
				if ($paiement=='Site billet réduc') {
					echo "<td class='top'></td><td class='top'></td><td class='top'></td><td class='top'>$tva $devise</td><td class='top'></td>";
				} ?>
				<td class="top" colspan=" <?php echo "$nombre_tarif"; ?>" style="border-bottom:1px solid;"></td>
				<td class="top" ><?php echo "$titulaire_cheque"; ?> </td>
				<td class="top" ><?php echo $banque; ?></td>
				<td class="left" ></td>
			</tr>
			<tr>

			<?php
					
			//on recupère les infos de chaque enregistrement
			$sql11 = "SELECT article, quanti, ".$tblpref."tarif.id_tarif, ".$tblpref."tarif.prix_tarif, nom_tarif, to_tva_art FROM `".$tblpref."cont_bon`, ".$tblpref."article, ".$tblpref."tarif 
						WHERE ".$tblpref."tarif.id_tarif=".$tblpref."cont_bon.id_tarif
						AND ".$tblpref."article.num=".$tblpref."cont_bon.article_num
						And ".$tblpref."cont_bon.bon_num=$num_bon
						ORDER BY ".$tblpref."tarif.nom_tarif";
			$req11 = mysql_query($sql11) or die('Erreur SQL11 !<br>'.$sql11.'<br>'.mysql_error());
			//on boucles sur les cont_bon en fonction du numero du bon_comm
			while($data = mysql_fetch_array($req11))
			{
				$quanti = $data['quanti'];
				$id_tarif = $data['id_tarif'];
				echo "<td></td><td></td><td></td><td></td>";

				//on boucle sur la liste des differents tarifs
				$sql = "SELECT * FROM " . $tblpref ."tarif
					WHERE saison BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
					AND prix_tarif!='0.00'";
				$resultat_tarif = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
				while($data = mysql_fetch_array($resultat_tarif))
				{
					$nom_tarif_boucle=$data['nom_tarif'];
					$id_tarif_boucle=$data['id_tarif'];
					if ($id_tarif_boucle==$id_tarif) 
					{
						
						//on recupère infos du carnet au depart de la saison et la quantité vendu depuis jusqu'à ce bon en filtrant par tarif
						$sql10 = "
						SELECT CB.id_tarif, SUM( to_tva_art ) AS total, T.nom_tarif, T.prix_tarif, SUM(quanti) AS quanti, T.carnet
						FROM ". $tblpref."cont_bon CB, ". $tblpref."bon_comm BC, ". $tblpref."tarif T, ". $tblpref."article ART
						WHERE CB.bon_num = BC.num_bon
						AND BC.attente=0
						AND BC.fact ='ok'
						AND CB.id_tarif=T.id_tarif
						AND ART.num=CB.article_num
						AND	BC.num_bon <=$num_bon
						AND CB.id_tarif=$id_tarif";
						$req10 = mysql_query($sql10) or die('Erreur SQL10 !<br>'.$sql10.'<br>'.mysql_error());
						while($data = mysql_fetch_array($req10))
						{    
							$carnet = $data['carnet'];
							$quanti01 = $data['quanti'];
							$id_tarif = $data['id_tarif'];
							$nom_tarif = $data['nom_tarif'];

							//Pour chaque enregistrement le N° du premier billet vendu
							if ($t!=$id_tarif){
								 $q='';
							}
							if ($q==''){$q=$quanti;
							}
							else {$q=$q+$quanti;}
							$du=$carnet+$quanti01-intval($q);
							$au=$carnet+$quanti01-1;
							$billet=$du;
							echo "<td>";
							for($i=0; $i<$quanti; $i++)
							{
								 echo "".sprintf('%1$04d',$billet).", ";

								 $billet++;
							}
							echo "<br/>";
							echo "</td>";
							$t=$id_tarif;
							$quanti01 = $du-1;
						}
						
					}
					else
					{
						echo "<td></td>";
					}

				} 
			?>
						</td>
						<td colspan="2"></td>
						<td class="left"></td>
					</tr>
			<?php 
			}  
			$q="0";
		} 
	}

	$sql5="SELECT SUM( tot_tva ) total FROM `".$tblpref."bon_comm`
	WHERE attente=0
	AND ".$tblpref."bon_comm.fact ='ok'";
	if ( $date_debut == ''){
	$sql5.= " AND date_fact BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
	}
	else {
	$sql5.= " AND date_fact BETWEEN '$date01' AND '$date02'";
	}
	$req5 = mysql_query($sql5)or die('Erreur SQL5 !<br>'.$sql5.'<br>'.mysql_error());
	$data = mysql_fetch_array($req5);
	$tot5 = $data['total'];

	if ($user_stat== n)
	{
	echo"<h1>$lang_statistique_droit";
	exit;
	}
		$total_colonne=$nombre_tarif+4;
	?>

</table>
<!--table >
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
		AND BC.attente ='0' 
		AND BC.fact ='ok'
		AND CB.id_tarif=T.id_tarif
		AND ART.num=CB.article_num
		AND	ART.date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
		if ( $date_debut == ''){
			$sql6.= " AND	date_fact BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
						GROUP BY CB.id_tarif";
		}
			
		else {
			$sql6.= " AND date_fact BETWEEN '$date01' AND '$date02'
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
				$sql7="SELECT SUM(quanti) AS quanti7
						FROM ".$tblpref."cont_bon CB, ".$tblpref."bon_comm BC, ".$tblpref."tarif T, ".$tblpref."article ART
						WHERE CB.bon_num = BC.num_bon
						AND BC.attente ='0' 
						AND BC.fact ='ok'
						AND CB.id_tarif=T.id_tarif
						AND ART.num=CB.article_num
						AND	ART.date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
						if ( $date_debut == ''){
							$sql7.= " AND	date_fact BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
							AND CB.id_tarif= $id_tarif";
							}
						else {
							$sql7.= " AND date_fact BETWEEN '$annee_2-$debut_saison' AND '$date02'
							AND CB.id_tarif= $id_tarif";
							}
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
</table-->

<table >
	<tr>
		<th align="left">Paiement &nbsp;</th>
		<th align="left">&nbsp; &nbsp; &nbsp;Total</th>
		
	</tr>
	
		<?php
			$sql8="SELECT  SUM( tot_tva ) AS total, paiement
					FROM factux_bon_comm BC
					WHERE attente='0'
					AND BC.fact ='ok'
					AND paiement!='Gratuit'";
				if ( $date_debut == ''){
				$sql8.= " AND date_fact BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
					GROUP BY BC.paiement";
				}
				else {
					$sql8.=" AND date_fact BETWEEN '$date01' AND '$date02'
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
		<td> <?php echo $paiement;?></td>
		<td><?php echo montant_financier ($total);?></td>		
	</tr>
	<?php	} ?>
</table>
<table >
	<tr>
		<th align="left">Total &nbsp;</th>
		<th class="top"><b style="font-size:1.2em;"><?php echo montant_financier ($tot5); ?></b></tH>
	</tr>
	
</table>
</page>
