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

	//on recupère les infos par post
	$date=isset($_POST['date'])?$_POST['date']:"";
	$num=isset($_POST['num'])?$_POST['num']:"";
	list($jour, $mois,$annee) = preg_split('/\//', $date, 3);
	
	//le client1 doit être creer au début dans la base -> "caisse du soir" comme nom les autres champs ->rien
	$client=1;

	//on recupère les info du spectacle
	$rqSql_article = "SELECT article, DATE_FORMAT( date_spectacle, '%d/%m/%Y' ) AS date FROM ".$tblpref."article WHERE num=$num";
	$result_article = mysql_query( $rqSql_article )or die( "Exécution requête impossible_article.");
	$row = mysql_fetch_array( $result_article); 
	$article = $row["article"]; 
	$article= addslashes($article);
	$date = $row["date"]; 
	
	//on recupère les info du client1 (caisse du soir) pour la 1er ligne de la page
	$sql_nom = "SELECT  nom FROM ".$tblpref."client WHERE num_client =$client";
	$req = mysql_query($sql_nom) or die('Erreur SQL_nom !<br>'.$sql.'<br>'.mysql_error());
	$data = mysql_fetch_array($req);
	$nom = $data['nom'];
	

	// on créer un bon de commmande
	$sql1 = "INSERT INTO ".$tblpref."bon_comm(client_num, date, soir, user) VALUES ('$client', '$annee-$mois-$jour', '$article', '$user_nom')";
	mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

	// on affiche les infos du bon de commande
	$sql_num = "SELECT num_bon FROM ".$tblpref."bon_comm WHERE client_num = $client order by num_bon desc limit 1 ";
	$req_num = mysql_query($sql_num) or die('Erreur SQL !<br>'.$sql_num.'<br>'.mysql_error());

	// infos des differents tarifs
	$rqSql4= "SELECT id_tarif, nom_tarif, prix_tarif, DATE_FORMAT(saison, '%d/%m/%Y' ) AS date FROM ".$tblpref."tarif
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


<table border="0" class="page" align="center">
	<tr>
		<td  class="page" align="center">
			<?php
			$article=stripslashes($article);
			$data = mysql_fetch_array($req_num);
			$num_bon = $data['num_bon'];  ?>
			<?php echo "<h3>Enregistrement N° $num_bon pour le spectacle \" $article \"</h3><br> saisi par \"$user_nom\""; ?>
		<td>
	<tr>
		<td  class="page" align="center">
			<center>
				<form name='formu' method='post' action='bon_suite_soir.php' onSubmit="return verif_formulaire()">
					<table class="boiteaction">
						<caption>Composer la commande</caption>
						<tr>
							<td class="texte0">Choisir la quantit&eacute; d'entrées vendu pour ce tarif </td>
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
									if ($user_admin != 'n'){
										$sqltarifgratuit = "SELECT nom_tarif, prix_tarif, id_tarif, DATE_FORMAT(saison, '%d/%m/%Y' ) AS date FROM ".$tblpref."tarif
										WHERE saison
										BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
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
									<input type="image" name="Submit" src='image/valider.png' value='Enregistrer le spectacle' onclick="return(CheckPoll(this.form));"></td>
						</tr>
					</table>
				</form>
			</center>
		</td>
	</tr>
	<tr>
		<td>
			<?php
			include_once("include/bas.php");
			?>
		</td>
	</tr>
</table>

