<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include("include/config/common.php");
include_once("include/configav.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php"); 
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
$client=isset($_POST['listeville'])?$_POST['listeville']:"";
$numero=isset($_POST['numero'])?$_POST['numero']:"";
$mois=isset($_POST['mois'])?$_POST['mois']:"";
$jour=isset($_POST['jour'])?$_POST['jour']:"";
$annee=isset($_POST['annee'])?$_POST['annee']:"";
$tri=isset($_POST['tri'])?$_POST['tri']:"";
$requete = "SELECT DATE_FORMAT(date,'%d/%m/%Y')as date, num_bon, id_tarif, tot_tva, num_bon, nom, attente, coment, paiement FROM " . $tblpref ."bon_comm
RIGHT JOIN " . $tblpref ."client on " . $tblpref ."bon_comm.client_num = num_client ";
//on verifie le client
    if($_POST['list_client']=='on')
    {
    $requete .= " WHERE num_client='" . $_POST['listeville'] . "'";
      }
//on verifie le numero
if ( isset ( $_POST['numero'] ) && $_POST['numero'] != '')
{
$requete .= " AND num_bon='" . $_POST['numero'] . "'";
}
//on verifie l'année
if ( isset ( $_POST['annee'] ) && $_POST['annee'] != '')
{
$requete .= " AND Year(date)='" . $_POST['annee'] . "'";
}
//on verifie le mois
if ( isset ( $_POST['mois'] ) && $_POST['mois'] != '')
{
$requete .= " AND MONTH(date)='" . $_POST['mois'] . "'";
}
//on verifie le jour
if ( isset ( $_POST['jour'] ) && $_POST['jour'] != '')
{
$requete .= " AND DAYOFMONTH(date)='" . $_POST['jour'] . "'";
}
if ($tri!="") {
$requete .= " ORDER BY $tri";
}  
//on execute
$req = mysql_query($requete) or die('Erreur SQL !<br>'.$requete.'<br>'.mysql_error());
?>
<SCRIPT language="JavaScript" type="text/javascript">
		function confirmDelete()
		{
		var agree=confirm('<?php echo "$lang_con_effa"; ?>');
		if (agree)
		 return true ;
		else
		 return false ;
		}
		</script>
		
<table  border="0" class="page" align="center">
	<tr>
		<td  class="page" align="center">
			<center>
				<table>
					<caption><?php echo $lang_res_rech;?></caption>
					<tr>  
						<th>Bon N&deg;</th>
						<th>Client</th>
						<th>Date du bon</th>
						<th>Total T.V.A</th>
						<th>commentaire</th>
						<th>Réglé</th>
						<th>Attente</th>
						<th colspan='3'>action</th>
					 </tr>
						<?php
						while($data = mysql_fetch_array($req)){
							$num_bon = $data['num_bon'];
							$tva = $data['tot_tva'];
							$date = $data['date'];
									$attente=$data['attente'];
									if ($attente =='0') {
										$attente= 'non';
									}
									if ($attente =='1') {
										$attente= 'oui';
									}
							$nom = $data['nom'];
									$paiement=$data['paiement'];
									$coment=$data['coment'];
							$id_tarif = $data['id_tarif'];
						?>
					<tr>
						<td class='<?php echo couleur_alternee (); ?>'><?php echo $num_bon; ?></td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'><?php echo $nom; ?> </td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'><?php echo $date; ?> </td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'><?php echo montant_financier($tva); ?> </td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'><?php echo $coment; ?> </td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'><?php echo $paiement; ?> </td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'><?php echo $attente; ?></td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'>
							<div align='center'><a href='form_editer_bon.php?num_bon=<?php echo "$num_bon"; ?>&amp;id_tarif=<?php echo "$id_tarif"; ?>'> 
							<img border="0" alt="editer" src="image/edit.gif" Title="Modiffier"></a></td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'>
							<a href='delete_bon_suite.php?num_bon=<?php echo $num_bon; ?>&amp;nom=<?php echo "$nom_html"; ?>'
								onClick="return confirmDelete('<?php echo"$lang_con_effa $num_bon"; ?>')"></a></td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'>
						<form action="fpdf/bon_pdf.php" method="post" target="_blank" >
						<input type="hidden" name="num_bon" value="<?php echo$num_bon; ?>" />
						<input type="hidden" name="nom" value="<?php echo $nom; ?>" />
						<input type="hidden" name="user" value="adm" />
						<input type="image" src="image/printer.gif" style=" border: none; margin: 0;" alt="imprimer" />
						</form>
						</td>
					</tr>
						<?php
						}
						?>
				</table>
			</center>
		</td>
	</tr>
</table>
<?php
include("chercher_commande.php");
 ?>
