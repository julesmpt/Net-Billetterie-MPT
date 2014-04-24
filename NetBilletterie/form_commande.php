<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
?>
<script type="text/javascript">
function verif_formulaire()
		{
	if(document.formu.id_tarif.value == "")  {
	alert("Veuillez Choisir le tarif!");
	document.formu.id_tarif.focus();
	return false;
					}
	if(document.formu.listeville.value == "")  {
	alert("Veuillez Choisir un spectateur!");
	document.formu.listeville.focus();
	return false;
					}
		}
</script>
<table border="0" class="page" align="center">
    <tr>
        <td class="page" align="center">
                <h3>Formulaire de réservation ou d'abonnement</h3>
        </td>
    </tr>
    <tr>
        <td  class="page" align="center">
            <?php
             if ($message!='') {
             echo"<table><tr><td>$message</td></tr></table>";
            }
            if ($user_com == n) {
            echo"<h1>$lang_commande_droit";
            exit;
            }            
            $jour = date("d");
            $mois = date("m");
            $annee = date("Y");

            $rqSql = "SELECT num_client, nom, nom2 FROM " . $tblpref ."client WHERE actif != 'n' AND `num_client`!='1'";
            if ($user_com == r) {
            $rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'n' AND `num_client`!='1'
                     and (" . $tblpref ."client.permi LIKE '$user_num,'
                     or  " . $tblpref ."client.permi LIKE '%,$user_num,'
                     or  " . $tblpref ."client.permi LIKE '%,$user_num,%'
                     or  " . $tblpref ."client.permi LIKE '$user_num,%')
                    ";
            }
             ?> 
        </td>
	</tr>
	<tr> 
		<td>
			<center>
			<table>
				<tr>
					<td>
						<form name="formu" method="post" action="bon.php" onSubmit="return verif_formulaire()">
							<table>
								<caption><?php echo "$lang_cre_bon"; ?></caption>
								<tr>
									<td  class="texte0" >
											 <?php
											 require_once("include/configav.php");
											 $rqSql="$rqSql order by nom";
											 $result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");
											 ?>
										<SELECT NAME='listeville'>
											<OPTION VALUE="">Cliquez ici et commencez à ecrire le nom</OPTION>
											<?php
											while ( $row = mysql_fetch_array( $result)) {
											$numclient = $row["num_client"];
											$nom = $row["nom"];
											$nom2 = $row["nom2"];
											?>
											<OPTION VALUE='<?php echo $numclient; ?>'><?php echo $nom; ?></OPTION>
											<?php
											}
											?>
										</SELECT>
									</td>
								</tr>
								<tr>
										<?php
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
											$rqSql3= "SELECT id_tarif, nom_tarif, prix_tarif, saison FROM " . $tblpref ."tarif
													 WHERE saison
													 BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
													 AND nom_tarif<>'gratuit'
													 AND selection='1'
													 ORDER BY nom_tarif ASC";
											$result3 = mysql_query( $rqSql3 )or die( mysql_error()."Exécution requête impossible.");?>
									<td class="texte0" colspan='2'>
									   <SELECT NAME='id_tarif'>
											<OPTION VALUE="">Choisir le<?php echo "$lang_tarif";?></OPTION>
											<?php
											while ( $row = mysql_fetch_array( $result3)) {
													$id_tarif = $row["id_tarif"];
													$nom_tarif = $row["nom_tarif"];
													$prix_tarif = $row["prix_tarif"];
													?>
											<OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
											<?php }
												if ($user_admin != 'n'){
													//tarif gratuit pour admin 
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
										<OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
											<?php
													}
												}?>
										</SELECT>
									</td>
								</tr>
								<tr><td>&nbsp;</td></tr>
								<tr>
									<td class="submit" colspan="6"> 
									<input type="hidden" name="date" value="<?php echo"$jour/$mois/$annee";?>" >
									<input type="image" name="Submit" src="image/valider.png" value="Démarrer"  border="0"></td>
								</tr>
							</table>
						</form>	
					</td>
				</tr>
			</center>
			</table>
		</td>
	</tr>
	<tr>
		<td class="texte0"><h1><a href="form_commande_soir.php"><img src="image/billetterie.png">Formulaire pour les enregistrements le jour du spectacle </a></h1>
		</td>
	</tr>
</table>
<?php
include_once("include/bas.php");
?>





