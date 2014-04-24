
 <style type="text/css">
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
include_once("include/config/var.php");
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
		WHERE ".$tblpref."bon_comm.attente ='0'
		AND ".$tblpref."bon_comm.fact ='ok'	  ";
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
				<br><h1>Liste des ventes point&#233;e "ok", pour la saison culturelle <?php echo $annee_2; ?>-<?php echo $annee_1; ?> </h1>
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
							<th>R&eacute;gl&eacute;?</th>
							<th>Total versement</th>
							<th>Point&eacute;</th>
							<th>Quantit&eacute;</th>
							<th>Spectacle</th>
							<th>Tarif</th>
							<th>Total sur le spectacle</th>
						</tr>
	<?php
	$nombre = 1;
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

								$nombre = $nombre +1;
									if($nombre & 1){
									$line="0";
									}else{
									$line="1";
									}
	?>
						<tr>
							<td><?php echo $num_bon; ?>
							</td>
							
							<td><?php echo $nom; ?>
							</td>
						
							<td><?php echo $date; ?>
							</td>
						
							<td><?php echo $paiement; ?>
							</td>
							   
							<td><?php echo "$tva &euro;"; ?>
							</td>
							
							 <td><?php echo $fact; ?>
							</td>
                                                </tr>
							
									<?php
				$sql11 = "SELECT article, quanti, ". $tblpref."tarif.prix_tarif, nom_tarif, to_tva_art FROM `". $tblpref."cont_bon`, ". $tblpref."article, ". $tblpref."tarif 
					WHERE ". $tblpref."tarif.id_tarif=". $tblpref."cont_bon.id_tarif
					AND ". $tblpref."article.num=". $tblpref."cont_bon.article_num
					And ". $tblpref."cont_bon.bon_num=$num_bon";
		$req11 = mysql_query($sql11) or die('Erreur SQL11 !<br>'.$sql11.'<br>'.mysql_error());
		while($data = mysql_fetch_array($req11))
		{
		  $article = $data['article'];
		  $quanti = $data['quanti'];
		  $nom_tarif = $data['nom_tarif'];
		  $prix_tarif = $data['prix_tarif'];
		  $to_tva_art = $data['to_tva_art'];
		  ?>



					
					  <tr>
					  <td class=tdvide></td><td class=tdvide></td><td class=tdvide></td><td class=tdvide></td><td class=tdvide></td><td class=tdvide></td>
							<td class=td><?php echo $quanti; ?>
							</td>
						
							<td class=td><?php echo $article; ?>
							</td>
							
							<td class=td><?php echo "$nom_tarif &aacute; $prix_tarif &euro;"; ?>
							</td>
							   
							<td class=td><?php echo "$to_tva_art &euro;"; ?>
							</td>
						</tr>
<?php } ?>
						
						
				
                                                
		<?php  }
		
?>						
				</table>

</page>
