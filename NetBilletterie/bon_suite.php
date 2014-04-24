<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
//include('eviterMessageAvertissement.php');

include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
include_once("include/configav.php");


$quanti=isset($_POST['quanti'])?$_POST['quanti']:"";
$num_bon=isset($_POST['bon_num'])?$_POST['bon_num']:"";
$num_client=isset($_POST['num_client'])?$_POST['num_client']:"";
$id_tarif=isset($_POST['id_tarif'])?$_POST['id_tarif']:"";


if($num_bon==''){
$num_bon=isset($_GET['num_bon'])?$_GET['num_bon']:"";
$num_client=isset($_GET['nom'])?$_GET['nom']:"";
$id_tarif=isset($_GET['id_tarif'])?$_GET['id_tarif']:""; 
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
<script type="text/javascript" src="javascripts/confdel.js"></script>
<SCRIPT language="JavaScript" type="text/javascript">
	function confirmDelete(num)
	{
	var agree=confirm('confirmer l\'effacement'+num);
	if (agree)
	 return true ;
	else
	 return false ;
	}

	function verif_formulaire()
		{
	if(document.formu2.article.value == "0")  {
	alert("Veuillez Choisir un spectacle!");
	document.formu2.article.focus();
	return false;
			}
		}

	function edition()
		{
		options = "Width=700,Height=700" ;
		window.open( "print_tickets.php?num_bon=<?php echo $num_bon; ?>", "edition", options ) ;
		}
</script>
<?php


if($quanti=='' )
    {
    $message= "<h1>$lang_champ_oubli </h1>";
include('bon_suite.php'); 
    exit;
    }

    //on recupere l'prix_tarif
$rqSql33= "SELECT id_tarif, nom_tarif, prix_tarif FROM ".$tblpref."tarif WHERE id_tarif=$id_tarif ";
				 $result33 = mysql_query( $rqSql33 )
             or die( "Exécution requête33 impossible.");
						while ( $row = mysql_fetch_array( $result33)) {
    							$id_tarif = $row["id_tarif"];
    							$nom_tarif = $row["nom_tarif"];
							$prix_tarif = $row["prix_tarif"];}
                            $mont_tva = $prix_tarif * $quanti ;


//////////////////////////////////ARTICLE  ///////////////////////////////////////////////////
  for ($i = 0; $i < count($_POST["article"]); $i++)
  {
      $article=$_POST["article"][$i]."" ;

  //on contrôle s'il y a assez de stock pour article
 if ($article!="") 
	{
$rqSql11= "SELECT stock, article FROM ".$tblpref."article WHERE num=$article ";
$result11 = mysql_query( $rqSql11 )
             or die( "Exécution requête rqsql11 impossible.");
                    while ( $row = mysql_fetch_array( $result11)) {
                            $stock = $row["stock"];
                            $nom_article= stripslashes($row["article"]);}
                            $tre=$stock-$quanti;
                if($tre<0){
				$message1= "<h1>Impossibilité d'enregister <font color=red>$nom_article</font> <br> Car vous avez demandé <font color=red>$quanti</font> place(s) et il n'en reste que <font color=red>$stock</font></h1>";
				continue;
					}
//inserer les données dans la table du compte des bons.
$sql1 = "INSERT INTO ".$tblpref."cont_bon(bon_num, article_num, quanti, prix_tarif, id_tarif, to_tva_art)
VALUES ('$num_bon', '$article', '$quanti', '$prix_tarif', '$id_tarif', '$mont_tva')";

mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
//ici on decremnte le stock
$sql12 = "UPDATE `".$tblpref."article` SET `stock` = (stock - ".$quanti.") WHERE `num` = '".$article."'";
mysql_query($sql12) or die('Erreur SQL12 !<br>'.$sql12.'<br>'.mysql_error());

//On change le statut du spectacle par complet si le stock est en <=0

			$result111 = mysql_query( $rqSql11 ) or die( "Exécution requête rqsql111 impossible.");
			while ( $row = mysql_fetch_array( $result111)) {
                            $stock = $row["stock"];}
			if ( $stock <=0){
			$sql121 = "UPDATE `".$tblpref."article` SET `actif` = 'COMPLET' WHERE `num` =$article";
			mysql_query($sql121) or die('Erreur SQL121 !<br>'.$sql121.'<br>'.mysql_error());
			}
			else {
			$sql122 = "UPDATE `".$tblpref."article` SET `actif` = '' WHERE `num` =$article";
			mysql_query($sql122) or die('Erreur SQL122 !<br>'.$sql122.'<br>'.mysql_error());
			}
} 
}

                ?>


<table border="0" class="page" align="center">
	<tr>
		<td>
			<table class='boiteaction'>
				<?php
				//On recupère les info du client
					$sql_nom = "SELECT  nom, nom2 FROM ".$tblpref."client WHERE num_client = $num_client";
					$req = mysql_query($sql_nom) or die('Erreur SQL client!<br>'.$sql.'<br>'.mysql_error());
					while($data = mysql_fetch_array($req))
						{
							$nom = $data['nom'];
							$nom2 = $data['nom2'];
							$phrase = "$lang_bon_cree";
							$date = date("d-m-Y");
				?>
				<h1><?php echo "$phrase: $nom - $nom2 $lang_bon_cree2 $date <br>";?></h1><br>
				<?php 
						} 

				?>
			<caption>Actuellement l'abonnement est composé de</caption>
				<tr>
					<th><?php echo $lang_quantite ;?></th>
					<!-- th>N° billet(s)</th-->
					<th><?php echo $lang_article ;?></th>
					<th><?php echo $lang_montant_htva ;?></th>
					<?php if ($impression=="y") { 
						if ($print_user=="y") { ?>
					<th>Imprimer billet(s)</th>
					<?php } } ?>
					<th><? echo $lang_supprimer ;?></th>
				</tr>
						 <?php
						//on recherche tout les contenus du bon et on les detaille
						$sql = "SELECT ".$tblpref."cont_bon.num, ".$tblpref."cont_bon.id_tarif, uni, DATE_FORMAT(date_spectacle,'%d-%m-%Y') AS date, quanti, article, to_tva_art, actif, ".$tblpref."tarif.nom_tarif
							FROM ".$tblpref."cont_bon
							RIGHT JOIN ".$tblpref."article on ".$tblpref."cont_bon.article_num = ".$tblpref."article.num
							RIGHT JOIN ".$tblpref."tarif on ".$tblpref."cont_bon.id_tarif = ".$tblpref."tarif.id_tarif
							WHERE  bon_num = $num_bon
							ORDER BY ".$tblpref."tarif.nom_tarif, ".$tblpref."article.date_spectacle ASC ";
						$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

						while($data = mysql_fetch_array($req))
							{
								$quanti = $data['quanti'];
								$uni = $data['uni'];
								$actif = $data['actif'];
								$article = stripslashes($data['article']);
								$id_tarif = $data['id_tarif'];
								$date = $data['date'];
								$tot = $data['to_tva_art'];
								$num_cont = $data['num'];//$lang_li_tot2
								$nom_tarif = $data['nom_tarif'];
								$nombre = $nombre +1;
								if($nombre & 1){
								$line="0";
								}else{
								$line="1";
								}
								?>
				<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">				
					<td class ='highlight'><?php echo"$quanti";?></td>
					<?php
					//on recupère infos du carnet au depart de la saison et la quantité vendu depuis jusqu'à ce bon en filtrant par tarif
					$sql10 = "
					SELECT CB.id_tarif, T.nom_tarif, T.prix_tarif, SUM(quanti) AS quanti, T.carnet
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
					?>
					<!-- td  WIDTH=20% class ='highlight'>
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
							 echo "N°".sprintf('%1$04d',$billet).", ";
							 $billet++;
							}
							 echo "<br/>";


							 $t=$id_tarif;
							 $quanti01 = $du-1;
				} 
										?>
					</td-->
					<td class ='highlight'><?php echo"$article | $date| $nom_tarif";?></td>
					<td class ='highlight'><?php echo"$tot $devise"; ?></td>
					<?php if ($impression=="y") { 
						if ($print_user=="y") { ?>
					<td><A HREF="print_ticket_bon.php?num_cont=<?php echo"$num_cont";?>&amp;num_bon=<?php echo"$num_bon"; ?>" onClick="window.open('print_ticket_bon.php?num_cont=<?php echo"$num_cont";?>&amp;num_bon=<?php echo"$num_bon"; ?>','_blank','toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=1, copyhistory=0, menuBar=0, width=600, height=800');return(false)">
						<img border=0 src= image/printer.gif></a>
					</td>
					<?php } } ?>
					<td class ='highlight'><a href="delete_cont_bon.php?num_cont=<?php echo"$num_cont";?>&amp;num_bon=<?php echo"$num_bon"; ?>&amp;id_tarif=<?php echo"$id_tarif"; ?>" onClick='return confirmDelete(<?php echo"$num_cont"; ?>)'><img border="0" src="image/delete.jpg" alt="effacer" ></a>&nbsp;</td>
				</tr>
								<?php 
							}
								//on calcule la somme des contenus du bon
								$sql = " SELECT SUM(to_tva_art) FROM ".$tblpref."cont_bon WHERE bon_num = $num_bon";
								$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
								while($data = mysql_fetch_array($req))
									{
										$total_bon = $data['SUM(to_tva_art)'];
												}
								//on calcule la somme de la tva des contenus du bon
								$sql = " SELECT SUM(to_tva_art) FROM ".$tblpref."cont_bon WHERE bon_num = $num_bon";
								$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
								while($data = mysql_fetch_array($req))
									{
										$total_tva = $data['SUM(to_tva_art)'];
										
								//    $sql5 = "UPDATE ".$tblpref."bon_comm SET `tot_tva`='".$total_tva."'  WHERE `num_bon` = $num_bon";
								//    mysql_query($sql3) OR die("<p>Erreur Mysql5<br/>$sql5<br/>".mysql_error()."</p>");
								?>
				<tr>
					<td class='totalmontant' colspan="3">TOTAL DU BON</td>
					<td class='totaltexte'><?php echo "$total_tva $devise "; ?></td><td colspan='2' class='totalmontant'><?php
									} ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<!-- Formulaire d'enregistrement de nouveaux articles -->
			<form name='formu2' method='post' action='bon_suite.php'>
				<table class="boiteaction">
				<caption> Compléter l'abonnement</caption>
				<?php
					// pour ne montrer que les articles dont le stock est "0" ou inf.
							 $rqSql11 = "SELECT uni, num, article, DATE_FORMAT( date_spectacle, '%d/%m/%Y' ) AS date, prix_htva, actif, stock, stomin, stomax
														FROM ".$tblpref."article
														WHERE stock < '1'
														AND date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
														ORDER BY date_spectacle ASC";
						 $result11 = mysql_query( $rqSql11 )
						 or die( "Exécution requête impossible.");
						 ?> 
					  <?php
									while ( $row = mysql_fetch_array( $result11)) {
											$article = stripslashes($row["article"]);
											$actif = $row["actif"];
											$date = $row["date"];
											$stock = $row['stock'];
											if ($stock<=0 ) {
															$style= 'style="color:red; background:#cccccc; font-weight:bold;"';
															$option1="".$article."---". $date."--".$actif."";
											}
											?>
										<p <?php echo"$style"; ?>><?php echo"$option1"; ?></p>
										<?php } ?>
					<tr>
						<td class="texte0">Choisir la quantité  d'entrée par spectacle </td>
						<td class="texte_left" colspan="3">
							 <input type="text" name="quanti" value="1" SIZE="1"></td>

					</tr>
					<tr>
						<td class="texte0">Choisir le  <?php echo "$lang_article";
							//pour n'affichés que les articles  en stock
							 $rqSql = "SELECT uni, num, article, DATE_FORMAT( date_spectacle, '%d/%m/%Y' ) AS date, prix_htva, stock, stomin, stomax
														FROM ".$tblpref."article
														WHERE stock > '0'
														AND date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
														ORDER BY date_spectacle ASC";
							$result = mysql_query( $rqSql )or die( "Exécution requête impossible.");?>
						<td class="texte_left">
								<?php
								$i=1;
							while ( $row = mysql_fetch_array( $result)) {

											$num = $row["num"];
											$article = stripslashes($row["article"]);
											$date = $row["date"];
											$stock = $row['stock'];
											$min = $row['stomin'];

										if ($stock<=0 ) {
											$option="toto";
										}
										elseif ($stock <= $min && $stock >= 1  ) {
											$stock_txt="Attention plus que $stock places";
											$style= 'style="color:#961a1a; background:#ece9d8;"';
											$option="".$article." ---". $date." ---".$stock_txt."";
										}
										else {
											 $stock_txt= "Le stock est de ".$stock." places";
											 $style= 'style="color:black; background-color:##99fe98;"';
											 $option="".$article." ---". $date." ---".$stock_txt."";
										}
								?>
							<input  type="checkbox" VALUE='<?php echo $num; ?>' name="article[]"  ><b <?php echo$style; ?>><?php echo" $option"; ?><b><br>
							<?php $i++; } ?>
						</td>
					</tr>
							<tr> 
					<!-- choisir le tarif -->
					<td colspan="2" class="texte0">Choisir le<?php echo "$lang_tarif";?>
						<?php $rqSql3= "SELECT id_tarif, nom_tarif, prix_tarif, saison FROM ".$tblpref."tarif
										WHERE saison BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
										AND selection='1'
										ORDER BY nom_tarif ASC" ;
								$result3 = mysql_query( $rqSql3 ) or die( "ExÃ©cution requÃ©tesssss impossible.<br> <a href='lister_commandes.php'>retour à la liste</a>");
						?>		   
					<SELECT NAME='id_tarif'>
						
							<?php
								while ( $row = mysql_fetch_array( $result3)) 
								{
										$id_tarif = $row["id_tarif"];
										$nom_tarif = $row["nom_tarif"];
										$prix_tarif = $row["prix_tarif"];  ?>
										<OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
								<?php 
								}
							?>
					</SELECT>
					</td>
				</tr>
					<tr>
						<td class="submit" colspan="4">
							<input type="hidden" name="bon_num"  value='<?php echo $num_bon ?>'>
							<input type="hidden" name="num_client" value='<?php echo $num_client ?>'>
							<input style="color:#961a1a;background:yellow" type="submit" name="Submit" value="Ajouter à l'abonnement">Compléter l'abonnement par cette nouvelle sélection</td>
						</td>
					</tr>
				</table>
			</form>
			<?php echo $message1; ?> 
		</td>
	</tr>
	<?php if ($impression=="y") { 
		if ($print_user=="y") { ?>
		<tr>
		<td>
			<table>
				<tr>
				<?php 
						if($print!='ok'){ ?>
					<td style="text-align: center;">
					<h3>Imprimer les billets
						<a href="print_tickets.php?num_bon=<?php echo"$num_bon";?>" onclick="edition();return false;"><img border=0 src= image/billetterie.png ></a></h3> 
					</td>
						<?php 
						}
						 else {?>
					<td class='<?php echo couleur_alternee (FALSE); ?>' colspan='7'> </td> 
						  <?php 
						 } ?>
				</tr>
			</table>
		</td>
		</tr>
	<?php } } ?>
	<tr>
		<td>
			<form action="bon_fin.php" id="paiement" method="post" name="paiement">
				<center>
					<table class="boiteaction">
						<caption></caption>
						<tr>
							<td class="submit" ><?php echo $lang_ajo_com_bo ?></td>
						</tr>
						<tr>
							<td class="submit" colspan="2"><textarea name="coment" cols="45" rows="3"></textarea></td>
						</tr>
								<input type="hidden" name="id_tarif" value=<?php echo "$id_tarif"; ?>>
								<input type="hidden" name="tot_tva" value=<?php echo "$total_tva"; ?>>
								<input type="hidden" name="client" value=<?php echo "$num_client"; ?>>
								<input type="hidden" name="bon_num" value=<?php echo "$num_bon"; ?>>
								<input type="hidden" name="pointage" value='non'>
						<tr>
							<td colspan="2" class="submit">
								<?php 
								include_once("include/paiemment.php");
								?><br/>
								<input type="image" name="Submit" src='image/valider.png' value="<?php echo "$lang_ter_enr"; ?>" >
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
