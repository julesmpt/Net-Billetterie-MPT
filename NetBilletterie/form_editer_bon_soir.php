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

$num_bon=isset($_POST['num_bon'])?$_POST['num_bon']:"";
$attente=isset($_POST['attente'])?$_POST['attente']:"";
$id_tarif=isset($_POST['id_tarif'])?$_POST['id_tarif']:"";
$voir=isset($_POST['voir'])?$_POST['voir']:"";

//on change le bon s'il vient de la liste d'attente en modifant le champ attente à 0
if($attente=='1'){
$sql22 = "UPDATE `".$tblpref."bon_comm` SET `attente` = '0' WHERE `num_bon` = '$num_bon'";
mysql_query($sql22) or die('Erreur SQL22 !<br>'.$sql22.'<br>'.mysql_error());
}

if($num_bon=='')
    {
        $num_bon=isset($_GET['num_bon'])?$_GET['num_bon']:"";
        $id_tarif=isset($_GET['id_tarif'])?$_GET['id_tarif']:"";
        $voir=isset($_GET['voir'])?$_GET['voir']:"";
    }
    



		//on recupére les info du bon de commande
$sql = "SELECT  coment, client_num, nom, paiement, fact, user 
		FROM ".$tblpref."bon_comm 
		RIGHT JOIN ".$tblpref."client on ".$tblpref."bon_comm.client_num = ".$tblpref."client.num_client
		WHERE num_bon = $num_bon";
$req = mysql_query($sql) or die('Erreur SQL form_edit_bon !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_array($req);
$paiement = $data["paiement"];
$paiement=stripslashes($paiement);
$num_client = htmlentities($data['client_num'], ENT_QUOTES);
$coment = $data['coment'];
$coment=stripslashes($coment);
$nom=$data['nom'];
$nom=stripslashes($nom);
$pointage=$data['fact'];
$user = $data['user'];

		//on recupére les enregistrements du bon de commande
$sql = "SELECT ".$tblpref."cont_bon.num, ".$tblpref."cont_bon.id_tarif, print, quanti, uni, article, tot_art_htva, to_tva_art, actif, DATE_FORMAT(date_spectacle,'%d-%m-%Y') AS date, stock, ".$tblpref."tarif.nom_tarif
        FROM ".$tblpref."cont_bon 
		RIGHT JOIN ".$tblpref."article on ".$tblpref."cont_bon.article_num = ".$tblpref."article.num
	    RIGHT JOIN ".$tblpref."tarif on ".$tblpref."cont_bon.id_tarif = ".$tblpref."tarif.id_tarif
		WHERE  bon_num = $num_bon
		ORDER BY date_spectacle";
$req5 = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

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
//on recupère les infos des spectacles
$rqSql1 = "SELECT uni, num, article, DATE_FORMAT( date_spectacle, '%d/%m/%Y' ) AS date, prix_htva, stock, stomin, stomax
			FROM ".$tblpref."article
			WHERE stock > '0'
			AND date_spectacle
			BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
			ORDER BY date_spectacle";
$result = mysql_query( $rqSql1 )
             or die( "Exécution requêtes impossible.");

	//on recupère les infos du spectateur	pas utile a cvoir si on meu supprimer??????
/* $rqSql = "SELECT num_client, nom FROM ".$tblpref."client WHERE actif != 'non'";
if ($user_com == r) { 
$rqSql = "SELECT num_client, nom FROM ".$tblpref."client WHERE actif != 'non'
	 and (".$tblpref."client.permi LIKE '$user_num,' 
	 or  ".$tblpref."client.permi LIKE '%,$user_num,' 
	 or  ".$tblpref."client.permi LIKE '%,$user_num,%' 
	 or  ".$tblpref."client.permi LIKE '$user_num,%')  
	";  }
$result2 = mysql_query( $rqSql )
             or die('Erreur SQL !<br>'.$rqSql2.'<br>'.mysql_error()); */
			 
//on recupère les differents tarifs 
$rqSql33= "SELECT id_tarif, nom_tarif, prix_tarif 
			FROM ".$tblpref."tarif 
			WHERE id_tarif=$id_tarif";
$result33 = mysql_query( $rqSql33 )
 or die( "ExÃ©cution requÃ©tess impossible.");
while ( $row = mysql_fetch_array( $result33)) {
		$id_tarif = $row["id_tarif"];
		$nom_tarif = $row["nom_tarif"];
		$prix_tarif = $row["prix_tarif"];
}

?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<script type="text/javascript">
function edition()
    {
    options = "Width=700,Height=700" ;
    window.open( "print_tickets.php?num_bon=<?php echo $num_bon; ?>", "edition", options ) ;
    }
	</script>
	
	
<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center"></td>
	</tr>
	<tr>
		<td  class="page" align="center">
			<?php
			//les infos du bon => nom du spectateur
			$sql_nom = "SELECT  nom, nom2 FROM ".$tblpref."client WHERE num_client = $num_client";
			$req = mysql_query($sql_nom) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
			while($data = mysql_fetch_array($req))
				{
					$nom = $data['nom'];
					$phrase = "$lang_bon_cree";
							$date = date("d-m-Y");
							?>
					<h1><?php echo "$phrase: $nom $lang_bon_cree2 $date <br>par: $user<br>";?></h1><br>
					<?php 
				} ?>
			<?php
			if ($voir!=''){
			?>
			<h3><a href="lister_billetterie.php"><img src="image/retour.png" alt= "Retour à la liste des commandes">Revenir à la liste des abonnements</a></h3>
			<?php
			}
			?>
		</td>
	</tr>
	<tr>
		<td>
			<table class="boiteaction">
				 <tr> 	
					<th><? echo $lang_quantite ;?></th>
					<th>N° billet(s)</th>
					<th><? echo $lang_article ;?></th>
					<th>Montant total</th>
					<?php
						if( $impression=='y'){ 
							if( $print_user=='y'){?>
					<th>Imprimer billet(s)</th>
						<?php
					}}
						if( $pointage!='ok'){ 
							if( $voir!='ok'){?>
					<th><? echo $lang_supprimer ;?></th>
						 <?php 
						 }}
						  else {?>
					<th> </th> 
						  <?php 
						  } 
						  ?>
				</tr>
				<tr>
					<?php
							//boucle sur les infos des enregistrement du bon de commande
							while($data = mysql_fetch_array($req5))
							{
								$quanti = $data['quanti'];
								$print = $data['print'];
								$uni = $data['uni'];
								$stock = $data['stock'];
								$article = $data['article'];
								$article=stripslashes($article);
								$date = $data['date'];
								$tot = $data['to_tva_art'];
								$tva = $data['tva'];
								$id_tarif = $data['id_tarif'];
								$nom_tarif = $data['nom_tarif'];
								$nom_tarif=stripslashes($nom_tarif);
								$num_cont = $data['num'];
								$total_bon += $tot;
								$total_tva += $tva;		
							?>
					<td class='<?php echo couleur_alternee (TRUE,"nombre"); ?>'><?php echo $quanti; ?></td>
					<?php
					//on recupère infos du carnet au depart de la saison et la quantité vendu depuis jusqu'à ce bon en filtrant par tarif
					$sql10 = "	SELECT CB.id_tarif, SUM( to_tva_art ) AS total, T.nom_tarif, T.prix_tarif, SUM(quanti) AS quanti, T.carnet
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
					?>
					<td  WIDTH=20% class='<?php echo couleur_alternee (FALSE); ?>'>
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
					</td>
					<td class='<?php echo couleur_alternee (FALSE); ?>'><?php if ($stock>-1){echo  "$article || $date|| $nom_tarif";} else {echo  "$article || $date||<h1>spectacle $actif ne peut être inclu dans la commande</h1>";} ?></td>
					<td  class='<?php echo couleur_alternee (FALSE,"nombre"); ?>'><?php echo montant_financier ($tot); ?></td>
					<?php
						if( $impression=='y'){ 
							if( $print_user=='y'){?>
					<td><A HREF="print_ticket_bon.php?num_cont=<?php echo"$num_cont";?>&amp;num_bon=<?php echo"$num_bon"; ?>" onClick="window.open('print_ticket_bon.php?num_cont=<?php echo"$num_cont";?>&amp;num_bon=<?php echo"$num_bon"; ?>','_blank','toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=1, copyhistory=0, menuBar=0, width=600, height=800');return(false)">
						<img border=0 src= image/printer.gif></a>
					</td>
					 <?php 
						}}
						if( $pointage!='ok'){ 
							if( $voir!='ok'){?>
					<td class='<?php echo couleur_alternee (FALSE); ?>'>
						<?php echo "<a href=delete_cont_bon.php?num_cont=$num_cont&amp;num_bon=$num_bon&amp;id_tarif=$id_tarif onClick='return confirm('Etes-vous sur de vouloir supprimer ce spectacle?')'><img border=0 src= image/delete.jpg ></a>"  ?>
					</td>
						<?php 
						}}
						 else {?>
					<td> </td> 
						  <?php 
						 } ?>
				</tr>
							<?php	 
							$total += $tot;
							} ?>
			  
				  
				<tr>
					<td class='totalmontant' colspan="3"><?php echo $lang_total; ?></td>
					<td  class='totalmontant'><?php echo montant_financier ($total); ?></td>
					<td class='totaltexte'></td>
					<td colspan='2' class='totaltexte'></td>
				</tr>
					<?php
					//on calcule la somme des contenus du bon ?????????????
					//$sql = " SELECT SUM(tot_art_htva) FROM ".$tblpref."cont_bon WHERE bon_num = $num_bon";
					//$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

					//on change le total sur bon de commande
					if($total==""){$total="0";}
					$sql7 = "UPDATE ".$tblpref."bon_comm SET tot_tva = $total WHERE num_bon = $num_bon";
					  mysql_query($sql7) OR die("<p>Erreur Mysql7 <br/>$total<br>$sql7<br/>".mysql_error()."</p>");
					?>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table class="boiteaction">	
				<!-- formulaire d'edition du bon de commande -->
				<form name="formu2" method="post" action="edit_bon_suite.php">
					<?php
					if( $pointage!='ok'){ 
						if( $voir!='ok'){?>
				<caption>
					<?php echo "$lang_bon_ajouter $lang_numero $num_bon"; ?> 
				</caption>
				<tr> 
					<td colspan="2"class="texte0"><?php echo $lang_quantite; ?><class="texte0" colspan="8">
						<input type="text" name="quanti" value="1" SIZE="1">
					</td>
				</tr>
				<tr> 
					<!-- choisir le spectateur -->
					<td class="texte0"><br>choisir le ou les <?php echo $lang_article; ?>(s)    
							<?php
						include_once("include/configav.php");
							$rqSql = "	SELECT uni, num, article, DATE_FORMAT( date_spectacle, '%d/%m/%Y' ) AS date, prix_htva, stock, stomin, stomax
										FROM ".$tblpref."article
										WHERE stock > '0'
										AND date_spectacle
										BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
										ORDER BY date_spectacle";
						$result = mysql_query( $rqSql )or die( "ExÃ©cution requÃªte impossible.");
						?>
					</td>
					<td class="texte_left">
						<?php                                                    
							$i=1;
							while ( $row = mysql_fetch_array( $result)) 
							{
								$num = $row["num"];
								$article = $row["article"];
								$date = $row["date"];
								$stock = $row['stock'];
								$min = $row['stomin'];
																	
								if ($stock <= $min && $stock >= 1  ){
									$stock="Attention plus que $stock places";
									$style= 'style="color:#961a1a; background:#ece9d8;"';
									$option="".$article." ---". $date." ---".$stock."";
								}
								else{
									 $stock= "Le stock est de ".$stock." places";
									 $style= 'style="color:black; background-color:##99fe98;"';
									 $option="".$article." ---". $date." ---".$stock."";
								}
						?>
						<input  type="checkbox" VALUE='<?php echo $num; ?>' name="article[]"  ><b <?php echo$style; ?>><?php echo" $option"; ?><b><br>
						<?php $i++; 
							}
						?>
					</td>
				</tr>
						
				<tr> 
					<!-- choisir le tarif -->
					<td colspan="2" class="texte0">Choisir le<?php echo "$lang_tarif";?>
						<?php $rqSql3= "SELECT id_tarif, nom_tarif, prix_tarif, DATE_FORMAT(saison, '%d/%m/%Y' ) AS date 
										FROM ".$tblpref."tarif
										WHERE saison
										BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
										AND nom_tarif<>'gratuit'
										AND selection='1'
										ORDER BY nom_tarif ASC" ;
								$result3 = mysql_query( $rqSql3 ) or die( "ExÃ©cution requÃ©tesssss impossible.");
						?>		   
					<SELECT NAME='id_tarif'>
						<OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
							<?php
								while ( $row = mysql_fetch_array( $result3)) {
										$id_tarif = $row["id_tarif"];
										$nom_tarif = $row["nom_tarif"];
										$prix_tarif = $row["prix_tarif"];
							?>
						<OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
							<?php
								}
								if ($user_admin != 'n'){
									//tarif gratuit pour admin 
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
						<OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
							<?php
									}
								}
							?>
					</SELECT>
					</td>
				</tr>
				<tr> 
					<td class="submit" colspan="9"> 
						<input name="nom" type="hidden"  value='<?php echo $nom; ?>'> 
						<input name="num_bon" type="hidden"  value='<?php echo $num_bon; ?>'>
						<input style="color:#961a1a;background:yellow" type="submit" name="Submit" value="Ajouter à l'abonnement">Compléter l'abonnement par cette nouvelle selection</td>
							<?php 
							} }
							else {
								$message = "<center><h1>Cette commande a &#233t&#233 point&#233e OK et ne peut &#234tre modifi&#233e</h1>";
								echo $message;
							}
							?>
					</td>
				</tr> 
				</form>
			</table>
		</td>
	</tr>
		<?php
	if( $impression=='y'){ 
	if( $print_user=='y'){ ?>
	<tr>
		<td>
			<table>
				<tr>
				<?php 
						if($print!='ok'){ ?>
					<td >
					<h3 >Imprimer les billets
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
	<?php }} 
	if ($voir!='ok'){
		?>?>
	<tr>
		<td>
			<table class="boiteaction">
				<form action="bon_fin.php" method="post" name="fin_bon">
				<caption><?php echo "$lang_bon_enregistrer $lang_numero $num_bon"; ?></caption>
				<tr>
					<td class="submit" ><?php echo $lang_ajo_com_bo ?><br> 
						<textarea name="coment" cols="45" rows="3"><?php echo $coment; ?></textarea><br> 

							<?php
								if($pointage!='ok'){ 
									if ($user_dev != 'n'){ 
									?>
							<input type="radio" name="pointage" value="ok">Pointé
							<input type="radio" name="pointage" value="non" checked="checked">Non pointé
								<?php 
									} 
									else {
									?>
									
							<input type="hidden" name="pointage" value="non">
									<?php
									} 
									include_once("include/paiemment.php");
								}
								else { ?>

							<input type="hidden" name="pointage" value="ok">
							<input type="hidden" name="paiement" value="<?php echo $paiement;?>">
								<?php 
								} ?>
							<input type="hidden" name="tot_tva" value='<?php echo $total; ?>'>
							<input type="hidden" name="bon_num" value='<?php echo $num_bon; ?>'>
							<input type="hidden" name="id_tarif" value=<?php echo $id_tarif ?>>
							<input type="hidden" name="client" value=<?php echo $num_client ?>>					
							<input type="image" name="Submit" src="image/valider.png" value="Démarrer"  border="0" >
								

				  </td>    
				</tr>
				</form>
			</table>
		</td>
	</tr>
	<?php
	}
	?>
</table>
	
<?php 
include_once("include/bas.php");
 ?> 			


