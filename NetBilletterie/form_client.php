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
<script language="JavaScript">
<!--
function couleur(obj) {
     obj.style.backgroundColor = "#FFFFFF";
}
 
function check() {
	var msg = "";
 
		if (document.client.mail.value != "")	{
		indexAroba = document.client.mail.value.indexOf('@');
		indexPoint = document.client.mail.value.indexOf('.');
		if ((indexAroba < 0) || (indexPoint < 0))
				{
		document.client.mail.style.backgroundColor = "#F3C200";
			msg += "Le mail est incorrect\n";
		}
	}
//	else	{
//		document.client.mail.style.backgroundColor = "#F3C200";
//		msg += "Veuillez saisir votre mail.\n";
//	}
 
if (document.client.nom.value == "")	{
		msg += "Veuillez saisir votre nom\n";
		document.client.nom.style.backgroundColor = "#F3C200";
	}
 
if (document.client.mail.value != document.client.mail2.value)	{
		msg += "Veuillez resaisir le mail à l'identique'\n";
		document.client.mail2.style.backgroundColor = "#F3C200";
	}
 
	if (msg == "") return(true);
	else	{
		alert(msg);
		return(false);
	}
}
//-->
</script>

<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
				<h3>Formulaire de création de spectateur</h3>
		</td>
			<?php
			if($message!=''){
				echo"<tr><TD>$message</tr><tr>";
				if($user_com=='y'){
			?> 
				<tr>
					<td>
						<form name="formu" method="get" action="bon.php" onSubmit="return verif_formulaire()">
						<center> <table>
							<tr>
									<?php 
									$jour = date("d");
									$mois = date("m");
									$annee = date("Y");?>
								<td class="texte0"><?php echo "date" ?></td>
								<td class="texte0"><input type="text" name="date" value="<?php echo"$jour/$mois/$annee" ?>" readonly="readonly"/></td>
							</tr>
							<tr>
								<td class="texte0">Choisir le<?php echo "$lang_tarif";?>
										<?php
										$rqSql3= "SELECT id_tarif, nom_tarif, prix_tarif, DATE_FORMAT(saison, '%d/%m/%Y' ) AS date FROM " . $tblpref ."tarif
												WHERE saison
												BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
												AND selection=1
												ORDER BY nom_tarif ASC";
												$result3 = mysql_query( $rqSql3 ) or die( "Exécution requête $rqSql3 impossible.");?>
								</td>
									<script type="text/javascript">
									function verif_formulaire(){
										if(document.formu.id_tarif.value == "")  {
											alert("Veuillez Choisir le tarif!");
											document.formu.id_tarif.focus();
											return false;
										}
									}
									</script>
								<td class="texte0">
									<SELECT NAME='id_tarif'>
										<OPTION VALUE="">Choisissez </OPTION>
											<?php
											while ( $row = mysql_fetch_array( $result3)) 
											{
												$id_tarif = $row["id_tarif"];
												$nom_tarif = $row["nom_tarif"];
												$prix_tarif = $row["prix_tarif"];
											?>
										<OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
											 <?php
											}
											?>
									</SELECT>
								</td>
							<tr>
								<input type="hidden" name="listeville" value='<?php if ( $num==""){echo $client;} else {echo $num;} ?>'>
								<td class="submit" colspan="6"> <input type="submit" name="Submit" value="Créer une réservation pour <?php $nom=stripslashes($nom); echo "$civ $nom"; ?>"> </td>
							</tr>
						</table></center>
						</form>
					</td>
				</tr>
			<?php
			} }
			?>
	<tr>
		<td  class="page" align="center">
		<?php 
		if ($user_cli == n) { 
		echo"<h1>$lang_client_droit";
		exit;  
		}
		 ?> 
		<form action="client_new.php" method="post" enctype="application/x-www-form-urlencoded" name="client" onSubmit="return check();">
			<table >
				<caption><?php echo $lang_client_ajouter; ?></caption>
				<tr> 
					<td class="texte0"><?php echo $lang_civ; ?></td>
					<td class="texte0">
						<SELECT name="civ">
							<OPTION VALUE="Mme">Madame</OPTION>
							<OPTION VALUE="Mr">Monsieur</OPTION>
							<OPTION VALUE="Mlle">Mademoiselle</OPTION>
							<OPTION VALUE="Mlle">Famille</OPTION>
						</select>
					</td>
				</tr>
				<tr> 
					<td class="texte1"><?php echo $lang_nom; ?></td>
					<td class="texte1"><input name="nom" type="text" id="nom" onKeyUp="javascript:couleur(this);"></td>
				</tr>
				<tr> 
					<td class="texte0"><?php echo $lang_rue; ?></td>
					<td class="texte1"><input name="rue" type="text" id="rue" value="Rue"></td>
				</tr>
				<tr> 
					<td class="texte1"><?php echo $lang_code_postal; ?> </td>
					<td class="texte0"><input name="code_post" type="text" id="code_post" value="<?php echo $c_postal;?>"></td>
				</tr>
				<tr> 
					<td  class="texte0"><?php echo $lang_ville; ?></td>
					<td class="texte1"><input name="ville" type="text" id="ville" value="<?php echo $ville;?>"></td>
				</tr>				
				<tr> 
					<td class="texte1"><?php echo $lang_tele; ?></td>
					<td class="texte1"><input name="tel" type="text" id="tel" value="<?php echo $indicatif_tel; ?>"></td>
				</tr>
				<tr> 
					<td  class="texte0"><?php echo $lang_email; ?></td>
					<td class="texte1"><input name="mail" type="text" onKeyUp="javascript:couleur(this);"></td>
				</tr>
				<tr>
					<td  class="texte0">Confirmer l'<?php echo $lang_email; ?></td>
					<td class="texte1"><input name="mail2" type="text" onKeyUp="javascript:couleur(this);" ></td>
				</tr>
				<tr> 
					<td class="submit" colspan="2">
						<input type="image" name="Submit" src="image/valider.png" value="Démarrer"  border="0">
					</td>
				</tr>
			</table>
		</form>
		</td>
	<tr/>
<?php 
include("lister_clients.php");
?>
