<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
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
		<td class="page" align="center">
			<h3>Chiffre d'affaires par date de représentation pour la saison culturelle <?php echo "$annee_2-$annee_1"; ?>
				 <?php if ($user_admin!='n'||$user_dev!='n'){?>
				<SCRIPT LANGUAGE="JavaScript">
				if(window.print)
					{
					document.write('<A HREF="javascript:window.print()"><img border=0 src= image/printer.gif ></A>');
					}
				</SCRIPT>
				<?php } ?>
			</h3> <br>
		</td>
    </tr>
    <tr>
        <td  class="page" align="center">
            <?php
            if ($user_stat== n)
            {
                echo"<h1>$lang_statistique_droit";
                exit;
            }?>
                  <!--formulaire du choix de saison-->
                 <center>
                     <form action="ca_articles.php" method="post">
                        <table >
                            <tr>
                             <td width="27%" class="texte0">
                                	<select name="annee_1">
									<option value="<?php echo"$annee_1"; ?>"><?php $date_1=$annee_1-1;echo"$date_1 -$annee_1"; ?></option>
									<option value="<?php $date=(date("Y")+1);echo"$date"; ?>"><?php $date=(date("Y")+1);$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									<option value="<?php $date=date("Y");echo"$date"; ?>"><?php $date=date("Y");$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									<option value="<?php $date=(date("Y")-1);echo"$date"; ?>"><?php $date=(date("Y")-1);$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									<option value="<?php $date=(date("Y")-2);echo"$date"; ?>"><?php $date=(date("Y")-2);$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									<option value="<?php $date=(date("Y")-3);echo"$date"; ?>"><?php $date=(date("Y")-3);$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									<option value="<?php $date=(date("Y")-4);echo"$date"; ?>"><?php $date=(date("Y")-4);$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									<option value="<?php $date=(date("Y")-5);echo"$date"; ?>"><?php $date=(date("Y")-5);$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									<option value="<?php $date=(date("Y")-6);echo"$date"; ?>"><?php $date=(date("Y")-6);$date_2=$date-1;echo"$date_2 - $date"; ?></option>
									</select>
                             </td>
                             <td class="submit" colspan="4"><input type="submit" value='Choisir la saison culturelle'></td>
						 </tr>
					   </table>
					 </form>
				 </center>
				  <!--fin du formulaire du choix de saison-->

				  <table class="boiteaction">

					<tr>
						<th><?php echo $lang_article; ?></th>
						<th><?php echo $lang_date; ?></th>
						<th><?php echo $lang_quantite; ?></th>
						<th><?php echo $lang_total; ?></th>
						<th><?php echo $lang_pourcentage; ?></th>
						<th>Type de tarif</th>
						<th>Prix unitaire</th>
						<th>NBR</th>
						<th>Total sur le tarif</th>
						<th>Poucentage</th>
					</tr>
						<?php
						//on recupère la sommes des commandes passées dans la periode de la saison
						$sql = "SELECT SUM( to_tva_art ) as total
								FROM ".$tblpref ."cont_bon CB, ".$tblpref."bon_comm BC
								WHERE CB.bon_num = BC.num_bon
								AND BC.attente='0'
								AND BC.fact='ok'
								AND	BC.date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison' ";
						$req = mysql_query($sql);
						$data = mysql_fetch_array($req);
						$total = $data ["total"];
						$sql = "SELECT CB.article_num, SUM(to_tva_art) total, article, SUM(quanti) nombre, date_spectacle
								FROM ".$tblpref."cont_bon CB, ".$tblpref."article ART, ".$tblpref."bon_comm BC
								WHERE CB.article_num = ART.num
								AND BC.num_bon=CB.bon_num
								AND BC.attente='0'
								AND BC.fact='ok'
								AND	BC.date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
								GROUP BY ART.num
								ORDER BY ART.date_spectacle";
						$req = mysql_query($sql)or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());;
						while ($data = mysql_fetch_array($req)){
						$tot = $data['total'];
						$date_spectacle = $data['date_spectacle'];
						list($annee, $mois, $jour) = explode("-", $date_spectacle);
                        $date_spectacle = "$jour-$mois";
						$num=$data['article_num'];
						$art = $data['article'];
						$arti= stripslashes($art);
						$quanti = $data['nombre'];
						$pourcentage = avec_virgule ($tot / $total * 100.0, 1);
						?>
					<tr class="titre">
						<td ><b><?php echo $arti; ?></b></td>
						<td><?php echo $date_spectacle; ?></td>
						<td><?php echo $quanti; ?></td>
						<td style="width:60px;"><?php echo montant_financier ($tot); ?></td>
						<td><?php echo stat_baton_horizontal("$pourcentage%", 1); ?></td>
							 <?php $sql3 = "SELECT SUM( to_tva_art) total
									FROM ".$tblpref."cont_bon CB,".$tblpref."bon_comm BC
									WHERE CB.article_num=$num
									AND CB.bon_num=BC.num_bon
									AND BC.attente='0'
									AND BC.fact='ok'
									AND	BC.date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
									$req3 = mysql_query($sql3);
									$data = mysql_fetch_array($req3);
									$total3 = $data ["total"];

									$sql4 = "SELECT CB.id_tarif, article_num, SUM(to_tva_art), SUM(quanti), T.nom_tarif, T.prix_tarif
									FROM ".$tblpref."cont_bon CB, ".$tblpref."tarif T, ".$tblpref."bon_comm BC
									WHERE CB.article_num=$num
									AND CB.id_tarif=T.id_tarif
									AND CB.bon_num=BC.num_bon
									AND BC.attente='0'
									AND BC.fact='ok'
									AND	BC.date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
									group by CB.id_tarif";
									$req4 = mysql_query($sql4)or die('Erreur SQL4 !<br>'.$sql4.'<br>'.mysql_error());

									while ($data = mysql_fetch_array($req4)){
									$tot4 = $data['SUM(to_tva_art)'];
									$art4 = $data['article'];
									$nom_tarif4= $data['nom_tarif'];
									$quanti4 = $data['SUM(quanti)'];
									$prix4 = $data['prix_tarif'];
									$pourcentage4 = avec_virgule ($tot4 / $total3 * 100.0, 1);
									?>
						<td colspan=5></td>
					</tr>
					<tr>
						<td colspan=5></td>
						<td class='<?php echo couleur_alternee (); ?>'><?php echo $nom_tarif4; ?></td>
						<td class='<?php echo couleur_alternee (FALSE, "nombre"); ?>'><?php echo montant_financier ($prix4); ?></td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'><?php echo "$quanti4"; ?></td>
						<td class='<?php echo couleur_alternee (FALSE, "nombre"); ?>'><?php echo montant_financier ($tot4); ?></td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'><?php echo stat_baton_horizontal("$pourcentage4 %", 1); ?></td>
					</tr>
						<?php
								}
							}
						?>
					</table>
		</td>
	</tr>
	<tr>
			<?php
				$sql5="SELECT SUM( tot_tva ) total FROM `".$tblpref."bon_comm`
						WHERE attente='0'
						AND fact='ok'
						AND	date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
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
		<h1> Chiffre d'affaires de la saison culturel est actuellement de <?php echo montant_financier ($tot5); ?></h1>	<br>	
			<h3>Réparti de la manière suivante 
				<?php if ($user_admin != 'n'||$user_dev!='n'){?>
				<SCRIPT LANGUAGE="JavaScript">
				if(window.print)
					{
					document.write('<A HREF="javascript:window.print()"><img border=0 src= image/printer.gif ></A>');
					}
				</SCRIPT>
				<?php } ?>
			</h3>
					<table class="boiteaction">
						<tr>
							<th>Tarifs</th>
							<th> Prix</th>
							<th> Nombre</th>
							<th>Chiffre d'affaire</th>
							<th>Pourcentage</th>
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
									$pourcentage = avec_virgule ($tot6 / $tot5 * 100.0, 1);
									?>
						<tr>
							<td> <?php echo $nom_tarif6 ; ?></td>
							<td> <?php echo montant_financier ($prix_tarif6) ; ?></td>
							<td> <?php echo $quanti6 ; ?></td>
							<td> <?php echo montant_financier ($tot6) ; ?></td>
							<td><?php echo stat_baton_horizontal("$pourcentage%", 1); ?></td>
							<td> <?php echo "du billet: $du  au billet :$au" ; ?></td>
						</tr>
						<?php } ?>
					</table>
				</td>	
			</tr>
		</td>
    </tr>
</table>
<?php
include("help.php");
include_once("include/bas.php");
?>
