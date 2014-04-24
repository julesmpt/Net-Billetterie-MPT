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

	//on recupère les infos par post
$quanti=isset($_POST['quanti'])?$_POST['quanti']:"";
$bon_num=isset($_POST['bon_num'])?$_POST['bon_num']:"";
$num_client=isset($_POST['num_client'])?$_POST['num_client']:"";
$id_tarif=isset($_POST['id_tarif'])?$_POST['id_tarif']:"";
$num=isset($_POST['num'])?$_POST['num']:"";
$del=isset($_POST['del'])?$_POST['del']:"";



if($bon_num==""){
$bon_num=isset($_GET['num_bon'])?$_GET['num_bon']:"";
$num_client=isset($_GET['nom'])?$_GET['nom']:"";
$id_tarif=isset($_GET['id_tarif'])?$_GET['id_tarif']:"";
$num=isset($_GET['num'])?$_GET['num']:"";
}

// on affiche les infos du bon de commande
$sql_num = "SELECT num_bon FROM " . $tblpref ."bon_comm WHERE client_num = 1 order by num_bon desc limit 1 ";
$req_num = mysql_query($sql_num) or die('Erreur SQL !<br>'.$sql_num.'<br>'.mysql_error());
  
  
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

//on recupere l'prix_tarif
$rqSql33= "SELECT id_tarif, nom_tarif, prix_tarif FROM " . $tblpref ."tarif WHERE id_tarif=$id_tarif ";
	$result33 = mysql_query( $rqSql33 )
	or die( "Exécution requête impossible33.");
	while ( $row = mysql_fetch_array( $result33)) {
		$id_tarif = $row["id_tarif"];
		$nom_tarif = $row["nom_tarif"];
		$prix_tarif = $row["prix_tarif"];}
		$mont_tva = $prix_tarif * $quanti ;

//inserer les données dans la table du compte des bons.
$sql1 = "INSERT INTO ".$tblpref."cont_bon(bon_num, article_num, quanti, prix_tarif, id_tarif, to_tva_art)
VALUES ('$bon_num', '$num', '$quanti', '$prix_tarif', '$id_tarif', '$mont_tva')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

//ici on decremnte le stock
$sql12 = "UPDATE `" . $tblpref ."article` SET `stock` = (stock - ".$quanti.") WHERE `num` = '".$num."'";
mysql_query($sql12) or die('Erreur SQL12 !<br>'.$sql12.'<br>'.mysql_error());

//on recupère les info du spectacle
$rqSql_article = "SELECT article, DATE_FORMAT( date_spectacle, '%d/%m/%Y' ) AS date FROM " . $tblpref ."article WHERE num=$num";
$result_article = mysql_query( $rqSql_article )or die( "Exécution requête impossible_article.");
while ( $row = mysql_fetch_array( $result_article)) 
	{ $article = $row["article"]; $date = $row["date"]; }

	// infos des differents tarifs
$rqSql4= "SELECT id_tarif, nom_tarif, prix_tarif, DATE_FORMAT(saison, '%d/%m/%Y' ) AS date FROM " . $tblpref ."tarif
	WHERE saison
	BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
	AND nom_tarif<>'gratuit'
	AND selection='1'
	ORDER BY nom_tarif ASC";
	 $result4 = mysql_query( $rqSql4 ) or die( "Exécution requête impossible.");
?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<script language="javascript"> 
function CheckPoll(formu){ 

var res = false; 
var n = formu.id_tarif.length; 
for (i=0;i<n;i++){ 
if (formu.id_tarif[i].checked){ 
res = true; 
} 
} 
if (!res){ 
alert("Vous n'avez pas renseigné le Tarif"); 
return res; // Je sors de la fonction avec le résultat "false" 
} 
} 
</script>

<script type="text/javascript">
function edition()
    {
    options = "Width=700,Height=700" ;
    window.open( "print_tickets.php?num_bon=<?php echo $num_bon; ?>", "edition", options ) ;
    }
	</script>
	
<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
			<?php while($data = mysql_fetch_array($req_num)) { $num_bon = $data['num_bon']; ?>
			<h3><?php echo "Enregistrement N&deg;$num_bon de caisse  pour le spectacle \"$article  le $date \"</h3><br> saisi par \"$user_nom\"";?><br>
		<?php } ?>
		</td>
	</tr>
		<td>
		<center>
			<table border="0" class="page" align="center" cellspacing="0">
			<caption>Actuellement le bon est compos&eacute; de</caption>
				<tr>
					<th><?php echo $lang_quantite ;?></th>
					<th><?php echo $lang_article ;?></th>
					<th><?php echo $lang_montant_htva ;?></th>
					<th><? echo $lang_supprimer ;?></th>
				</tr>
						 <?php
						//on recherche tout les contenus du bon et on les detaille
						$sql = "SELECT " . $tblpref ."cont_bon.num, uni, DATE_FORMAT(date_spectacle,'%d-%m-%Y') AS date, quanti, article, to_tva_art, actif, " . $tblpref ."tarif.nom_tarif
							FROM " . $tblpref ."cont_bon
							RIGHT JOIN " . $tblpref ."article on " . $tblpref ."cont_bon.article_num = " . $tblpref ."article.num
							RIGHT JOIN " . $tblpref ."tarif on " . $tblpref ."cont_bon.id_tarif = " . $tblpref ."tarif.id_tarif
							WHERE  bon_num = $bon_num
							ORDER BY date_spectacle";
						$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

						while($data = mysql_fetch_array($req))
							{
								$quanti = $data['quanti'];
								$uni = $data['uni'];
								$actif = $data['actif'];
								$article = $data['article'];
								$date = $data['date'];
								$tot = $data['to_tva_art'];
								$num_cont = $data['num'];
								$num_lot = $data['num_lot'];
								$nom_tarif = $data['nom_tarif'];
								?>
				<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
					<td class ='highlight'><?php echo"$quanti";?></td>
					<td class ='highlight'><?php echo"$article | $date| $nom_tarif ";?></td>
					<td class ='highlight'><?php echo"$tot $devise"; ?></td>
					<td class ='highlight'><a href="delete_cont_bon_soir.php?num_cont=<?php echo"$num_cont";?>&amp;num_bon=<?php echo"$bon_num"; ?>&amp;del=1&amp;id_tarif=<?php echo"$id_tarif"; ?>&amp;num=<?php echo"$num"; ?>" onClick='return confirmDelete(<?php echo"$num_cont"; ?>)'><img border="0" src="image/delete.jpg" alt="effacer" ></a>&nbsp;</td>
				</tr>
					<?php }
						//on calcule la somme des contenus du bon
						$sql = " SELECT SUM(to_tva_art) FROM " . $tblpref ."cont_bon WHERE bon_num = $bon_num";
						$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
						while($data = mysql_fetch_array($req))
							{
								$total_bon = $data['SUM(to_tva_art)'];
										}
						//on calcule la some de la tva des contenus du bon
						$sql = " SELECT SUM(to_tva_art) FROM " . $tblpref ."cont_bon WHERE bon_num = $bon_num";
						$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
						while($data = mysql_fetch_array($req))
							{
								$total_tva = $data['SUM(to_tva_art)'];
						?>
				<tr>
					<td class='totalmontant' colspan="3">TOTAL DU BON</td>
					<td class='totaltexte'><?php echo "$total_tva $devise "; ?></td>
					<?php 
						$sql5 = "UPDATE " . $tblpref ."bon_comm SET tot_tva = $total_tva WHERE num_bon = $bon_num"; 
						mysql_query($sql5) OR die("<p>Erreur Mysql5<br/>$sql5<br/>".mysql_error()."</p>");
							} ?>
				</tr>
				
			</table>
		</center>
	</tr>
	<tr>
		<td  class="page" align="center">
			<center>
				<form name='formu' method='post' action='bon_suite_soir.php'>
					<table class="boiteaction">
						<caption>Completer l'enregistrement par un autre tarif</caption>
						<tr>
							<td class="texte0">Choisir la quantit&eacute;</td>
							<td class="texte_left" colspan="3">
							<input type="text" name="quanti" value="1" SIZE="1"></td>
						</tr>
						<!-- tarif-->
						<tr>
							<td class="texte0">Choisir le<?php echo "$lang_tarif";?>
							</td>
							<td class="texte_left">
									<?php
									while ( $row = mysql_fetch_array( $result4)) {
											$id_tarif = $row["id_tarif"];
											$nom_tarif = $row["nom_tarif"];
											$prix_tarif = $row["prix_tarif"];
											?>
									<input type ="radio" name= "id_tarif" value= '<?php echo $id_tarif; ?>'>  <?php echo "$nom_tarif $prix_tarif $devise "; ?><br>
									<?php }
									if ($user_admin != 'n')
													{
														$sqltarifgratuit = "SELECT nom_tarif, prix_tarif, id_tarif, DATE_FORMAT(saison, '%d/%m/%Y' ) AS date 
																			FROM ".$tblpref."tarif
																			WHERE saison
																			BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
																			AND selection='1'
																			AND nom_tarif='gratuit'";
														$reqtarifgratuit = mysql_query($sqltarifgratuit) or die('Erreur SQLtarifgratuit !<br>'.$sqltarifgratuit.'<br>'.mysql_error());
														while($data = mysql_fetch_array($reqtarifgratuit))
														{
															$nom_tarif = $data['nom_tarif'];
															$prix_tarif = $data['prix_tarif'];
															$id_tarif =$data['id_tarif'];
														 ?>
															<input type ="radio" name= "id_tarif" value= '<?php echo $id_tarif; ?>'>  <?php echo "$nom_tarif $prix_tarif $devise "; ?><br>
														<?php
														}
													} ?>
								
							</td>
						</tr>
						<tr>
									<td class="submit" colspan="4">
									<input type="hidden" name="nom" id="nom" value='<?php echo $nom; ?>'>
									<input type="hidden" name="bon_num"  value='<?php echo $num_bon; ?>'>
									<input type="hidden" name="num_client" value='<?php echo $client; ?>'>
									<input type="hidden" name="num" value='<?php echo $num;?>'>
									<input style="color:#961a1a;background:yellow" type="submit" name="Submit" value='Enregistrer le spectacle' onclick="return(CheckPoll(this.form));"></td>
						</tr>
					</table>
				</form>
			</center>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
				<?php 
					if ($impression=="y") { 
					if ($print_user=="y") { ?>
					<td style="text-align: center;">
					<h3>Imprimer les billets
						<a href="print_tickets.php?num_bon=<?php echo"$num_bon";?>" onclick="edition();return false;"><img border=0 src= image/billetterie.png ></a></h3> 
					</td>
						<?php 
						}}
						 else {?>
					<td class='<?php echo couleur_alternee (FALSE); ?>' colspan='7'> </td> 
						  <?php 
						 } ?>
				</tr>
			</table>
		</td>
	</tr>

	<?php echo $message1; ?> 
			
	
    <tr>
		<td>
			<form action="bon_fin_soir.php" id="paiement" method="post" name="paiement">
				<center>
					<table class="boiteaction">
						<tr>
							<td class="submit" >
							<?php echo $lang_ajo_com_bo ?>
							</td>
						</tr>
						<tr>
							<td class="submit" colspan="2"><textarea name="coment" cols="45" rows="3">
								</textarea>
								<input type="hidden" name="id_tarif" value=<?php echo "$id_tarif"; ?>>
								<input type="hidden" name="tot_tva" value=<?php echo "$total_tva"; ?>>
								<input type="hidden" name="client" value=<?php echo "$num_client"; ?>>
								<input type="hidden" name="bon_num" value=<?php echo "$bon_num"; ?>>
								<input type="hidden" name="pointage" value='non'>
							</td>
						</tr>
						<tr>
							<td colspan="2" class="submit">
								<?php 
								include_once("include/paiemment.php");
								?>
								<input type="image" name="Submit" src='image/valider.png' value="<?php echo "$lang_ter_enr"; ?>"  >
								</td>
						</tr>
					</table>
				</center>
			</form>
		</td>
	</tr>
</table>

<?php
include("include/bas.php");
 ?>

