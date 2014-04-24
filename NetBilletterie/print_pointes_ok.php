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

include_once("include/config/common.php");
include_once("include/config/var.php");
require_once("include/utils.php");
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
$sql="SELECT * FROM `".$tblpref."bon_comm`
      RIGHT JOIN ".$tblpref."client on ".$tblpref."bon_comm.client_num = num_client
      WHERE date_fact BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
      AND ".$tblpref."bon_comm.attente ='0' 
      AND ".$tblpref."bon_comm.fact ='ok'";
if ($date01!='')
{
    $sql.= "AND date_fact BETWEEN '$date01' AND '$date02'
    ORDER BY " . $tblpref ."bon_comm.`date_fact` DESC ";
}
else{
$sql.="ORDER BY ".$tblpref."bon_comm.`date_fact` DESC ";
}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());


?> 
<page>
<a href="impression.php" class="noImpr"><img src="image/retour.png">Revenir aux statistiques</a><br/>
<div><img src="<?php echo $logo;?>"  width="200" align="left" >
<?php echo "<h4>$slogan $annee_2-$annee_1</h4>$c_postal $ville <br/>$tel <br/> $mail";?></div>
<br/><br/><br/>
				<h1>Liste des réservations encaissées</h1>
					<h2><?php if ( $date_debut == ''){
								echo "Saison culturelle $annee_2 - $annee_1.  Liste de tous les enregistrements. ";
								}
								if ( $date_debut != ''){
								echo "Pour la pèriode du $date_debut au $date_fin";
								}
								?>
					</h2>
				<table class="liste">
						<tr>
							<th>N°</th>
							<th>Spectateurs</th>
							<th>Date encaissement</th>
							<th>Réglé ?</th>
							<th WIDTH=5%>Total versement</th>
							<th WIDTH=5%>Encaissé</th>
							<th>N° des billets</th>
							<th WIDTH=3%>Quantité</th>
							<th>Spectacle</th>
							<th>Tarif</th>
							<th WIDTH=3%>Total sur le spectacle</th>
						</tr>
							<?php
							//on boucle sur les bons de commandes
							while($data = mysql_fetch_assoc($req))
							{ 
								$num_bon = $data['num_bon'];
								$num_bon = $data['num_bon'];
								$paiement = $data['paiement'];
									$paiement = htmlentities($paiement, ENT_QUOTES);
									$paiement_html = htmlentities (urlencode ($paiement));
								$tva = $data["tot_tva"];
								$date = $data["date_fact"];
								list($annee, $mois, $jour) = explode("-", $date);
                                $date = "$jour-$mois-$annee";
								$id_tarif = $data["id_tarif"];
								$nom = $data['nom'];
									$nom = htmlentities($nom, ENT_QUOTES);
								$num_client = $data['num_client'];
								$mail = $data['mail'];
								$login = $data['login'];
								$fact = $data['fact'];
							?>
						<tr>
							<td class="td"><?php echo $num_bon; ?></td>
							<td class="td"><?php echo $nom; ?></td>
							<td class="td"><?php echo $date; ?></td>
							<td class="td"><?php echo $paiement; ?></td>
							<td class="td"><?php echo "$tva $devise"; ?></td>
							 <td class="td"><?php echo $fact; ?></td>
							 <td colspan="6"></td>
						</tr>
								<?php
	//on recupère les infos de chaque enregistrement
						$sql11 = "SELECT article, quanti, ". $tblpref."tarif.id_tarif, ". $tblpref."tarif.prix_tarif, nom_tarif, to_tva_art FROM `". $tblpref."cont_bon`, ". $tblpref."article, ". $tblpref."tarif 
									WHERE ". $tblpref."tarif.id_tarif=". $tblpref."cont_bon.id_tarif
									AND ". $tblpref."article.num=". $tblpref."cont_bon.article_num
									And ". $tblpref."cont_bon.bon_num=$num_bon
									ORDER BY ".$tblpref."tarif.nom_tarif,  ".$tblpref."article.date_spectacle ASC ";
						$req11 = mysql_query($sql11) or die('Erreur SQL11 !<br>'.$sql11.'<br>'.mysql_error());
	//on boucles sur les cont_bon en fonction du numero du bon_comm
						while($data = mysql_fetch_array($req11))
						{
						  $article = $data['article'];
							$article=stripslashes($article);
						  $quanti = $data['quanti'];
						  $nom_tarif = $data['nom_tarif'];
							$nom_tarif=stripslashes($nom_tarif);
						  $prix_tarif = $data['prix_tarif'];
						  $to_tva_art = $data['to_tva_art'];
						  $id_tarif = $data['id_tarif'];
	//on recupère infos du carnet au depart de la saison et la quantité vendu depuis jusqu'à ce bon en filtrant par tarif
						$sql10 = "
						SELECT CB.id_tarif, SUM( to_tva_art ) AS total, T.nom_tarif, T.prix_tarif, SUM(quanti) AS quanti, T.carnet
						FROM ". $tblpref."cont_bon CB, ". $tblpref."bon_comm BC, ". $tblpref."tarif T, ". $tblpref."article ART
						WHERE CB.bon_num = BC.num_bon
						AND BC.attente=0
						AND BC.fact='ok'
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
						?>
					</tr>
					<tr class="texte0" onmouseover="this.className='highlight'" onmouseout="this.className='texte0'">
						<td colspan="6" class="highlight"></td>
						<td  WIDTH=20% class="highlight">
							<?php 
							 
								 //Pour chaque enregistrement le N° du premier billet vendu
								 if ($t!=$id_tarif){
									 $q='';
									 }
								 if ($q==''){$q=$quanti;}
								 else {$q=$q+$quanti;}
								$du=$carnet+$quanti01-intval($q);
	 
								 //Pour chaque enregistrement le N° du dernier billet vendu
								 $au=$carnet+$quanti01-1;
	//							 echo "carnet=$carnet- quanti01 =$quanti01-quanti_q=$q- quanti_boucle$quanti-au=$au<br>";


	//							echo " Billet(s) vendu. ";
								$billet=$du;
								for($i=0; $i<$quanti; $i++)
								 {
								 echo "".sprintf('%1$04d',$billet).", ";
								 $billet++;
								}
								 echo "<br/>";


								 $t=$id_tarif;
								 $quanti01 = $du-1;
					} 
											?>
								</td>
							<td class="td"><?php echo $quanti; ?>
							</td>
						
							<td class="td"><?php echo $article; ?>
							</td>
							
							<td class="td"><?php echo "$nom_tarif &aacute; $prix_tarif &euro;"; ?>
							</td>
							   
							<td class="td"><?php echo "$to_tva_art &euro;"; ?>
							</td>
						</tr>
								
								<?php 
								}  
								$q="0";
							} ?>
					</table>
</table width='600'>
<?php
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
?>
<?php
if ($user_stat== n)
{
echo"<h1>$lang_statistique_droit";
exit;
}?><br>
<h1> Le total de l'encaissement est de <?php echo montant_financier ($tot5); ?></h1>
	<table >
		<tr>
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
						while ($data2 = mysql_fetch_array($req7))
						{
						$quanti7= $data2['quanti7'];
						}
					
					
					$au=$quanti7+$carnet-1;
					$du= $au- $quanti6+1;
					$du= substr_replace("0000",$du, -strlen($du));
					$au= substr_replace("0000",$au, -strlen($au));
					?>
		<tr>
			<td> <?php echo $nom_tarif6 ; ?></td>
			<td> <?php echo montant_financier ($prix_tarif6) ; ?></td>
			<td> <?php echo $quanti6; ?></td>
			<td> <?php echo montant_financier ($tot6) ; ?></td>
			<td> <?php 
			if ($du!=$au){echo "du billet: $du  au billet :$au" ;}
			else {echo "billet: $du " ;} ?></td>
		</tr>
		<?php } ?>
	</table>
<br/>
<h1> Récapitulatifs des paiements</h1>
<table width="200">
	<tr>
		<th width="50%">Total</th>
		<th width="50%">Paiement</th>
	</tr>
	
		<?php
			$sql8="SELECT  SUM( tot_tva ) AS total, paiement 
					FROM factux_bon_comm BC
					WHERE attente='0'
					AND BC.fact ='ok'";
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
		<td><?php echo montant_financier ($total);?></td>
		<td> <?php echo $paiement;?></td>
	</tr>
	<?php	} ?>
</table>

</page>
