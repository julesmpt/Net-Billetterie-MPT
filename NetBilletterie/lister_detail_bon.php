
 <style type="text/css">

table {width:800pt;}
table, td { color: #0000AA; }
td.col1   { color: #00AA00; }
table.liste         { border: solid 3px #FF0000; }
table.liste td      { background: #fefefe; border:1px solid;}
table.liste th      { background: #cecece; }
table.liste td.col1 { color: #FF0000;border: solid 2px ; }
</style>
<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/

$date_debut=isset($_GET['date_debut'])?$_GET['date_debut']:"";
$date_fin=isset($_GET['date_fin'])?$_GET['date_fin']:"";

include_once("include/config/common.php");
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
      WHERE ".$tblpref."bon_comm.attente ='0' ";
if ( $date_debut != '')
{
    $sql.= "AND date BETWEEN '$date_debut' AND '$date_fin'";
}
else{
	$sql.= "AND date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";

}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());


?> 
<page>
    <a href="lister_detail_commandes.php">Revenir à la liste détaillée des commandes</a>
				<br>
				<br><h1>Liste des ventes d&#233;taill&#233;es pour la saison culturelle <?php echo $annee_2; ?>-<?php echo $annee_1; ?> </h1>
                                <br>
                                <?php
                                list($annee, $mois, $jour) = explode("-", $date_debut);
                                $datedebut = "$jour-$mois-$annee";
                                list($annee, $mois, $jour) = explode("-", $date_fin);
                                $datefin = "$jour-$mois-$annee";

                                ?>
                                <h2>Réservations et billetterie faites entre le <?php echo $datedebut; ?> et le <?php echo $datefin; ?> </h2>
                                <br>
                                
				<table class="liste">
					

						<tr>
							<th>N°</th>
							<th>Nom</th>
							<th>Date</th>
							<th>Réglé ?</th>
							<th WIDTH=5%>Total versement</th>
							<th WIDTH=5%>Pointé</th>
							<th>Billets</th>
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
								$date = $data["date"];
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
							<td class="td"><?php echo "$tva &euro;"; ?></td>
							 <td class="td"><?php echo $fact; ?></td>
							 <td colspan="6"></td>
						</tr>
								<?php
							//on recupère les infos de chaque enregistrement
							$sql11 = "SELECT article, quanti, ". $tblpref."tarif.id_tarif, ". $tblpref."tarif.prix_tarif, nom_tarif, to_tva_art FROM `". $tblpref."cont_bon`, ". $tblpref."article, ". $tblpref."tarif 
								WHERE ". $tblpref."tarif.id_tarif=". $tblpref."cont_bon.id_tarif
								AND ". $tblpref."article.num=". $tblpref."cont_bon.article_num
								And ". $tblpref."cont_bon.bon_num=$num_bon";
							$req11 = mysql_query($sql11) or die('Erreur SQL11 !<br>'.$sql11.'<br>'.mysql_error());
							//on boucles sur les cont_bon en fonction du numero du bon_comm
								while($data = mysql_fetch_array($req11))
								{
								  $article = $data['article'];
								  $quanti = $data['quanti'];
								  $nom_tarif = $data['nom_tarif'];
								  $prix_tarif = $data['prix_tarif'];
								  $to_tva_art = $data['to_tva_art'];
								$id_tarif = $data['id_tarif'];
							//on recupère infos du carnet au depart de la saison et la quantité vendu depuis jusqu'à ce bon en filtrant par tarif
								$sql10 = "
								SELECT CB.id_tarif, SUM( to_tva_art ) AS total, T.nom_tarif, T.prix_tarif, SUM(quanti) AS quanti, T.carnet
								FROM ". $tblpref."cont_bon CB, ". $tblpref."bon_comm BC, ". $tblpref."tarif T, ". $tblpref."article ART
								WHERE CB.bon_num = BC.num_bon
								AND BC.attente=0
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
							<tr>
								<td colspan="6" class="td"></td>
								<td  WIDTH=15% class="td">
									<?php 
									 
											 $t='';
											 
										 //Pour chaque enregistrement le N° du premier billet vendu
										 if ($t!='$id_tarif'){
											 $q='';
											 }
										 if ($q==''){$q=$quanti;}
										 else {$q=$q+$quanti;}
										$du=$carnet+$quanti01-intval($q);
										 //Pour chaque enregistrement le N° du dernier billet vendu
										$au=$carnet+$quanti01-1;
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
							} ?>
					</table>

</page>
