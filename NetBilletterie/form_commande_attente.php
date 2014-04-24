<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");
?>
<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">
    <h3>Formulaire de création pour la liste d'attente</h3>
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
 ?>
<?php
$jour = date("d");
$mois = date("m");
$annee = date("Y");

$rqSql = "SELECT num_client, nom, nom2 FROM " . $tblpref ."client WHERE actif != 'n'";
if ($user_com == r) {
$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'n'
	 and (" . $tblpref ."client.permi LIKE '$user_num,'
	 or  " . $tblpref ."client.permi LIKE '%,$user_num,'
	 or  " . $tblpref ."client.permi LIKE '%,$user_num,%'
	 or  " . $tblpref ."client.permi LIKE '$user_num,%')
	";
}
 ?>
<form name="formu" method="post" action="bon_attente.php" onSubmit="return verif_formulaire()">
  <center><table >
  <caption><?php echo "$lang_cre_bon"; ?></caption>
<tr>
<td class="texte0">&nbsp;</td>
  <td  class="texte0" ><?php echo "$lang_client";?> </td>
  <td  class="texte0" >
	<?php
	require_once("include/configav.php");
if ($liste_cli!='y') {
 $rqSql="$rqSql order by nom";
 $result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");
 ?>


    <SELECT NAME='listeville'>
    <OPTION VALUE='0'><?php echo $lang_choisissez; ?></OPTION>
    <?php
    while ( $row = mysql_fetch_array( $result)) {
    $numclient = $row["num_client"];
    $nom = $row["nom"];
    $nom2 = $row["nom2"];
    ?>
    <OPTION VALUE='<?php echo $numclient; ?>'><?php echo $nom2; ?></OPTION>
    <?php
    }
    ?>
    </SELECT>
    <?php }else{include_once("include/choix_cli.php");
    } ?> </td>

</tr>

<tr>
  <td class="texte0"> &nbsp;</td>

  <td class="texte0"><?php echo "date" ?> </td>
  <td class="texte0"><input type="text" name="date" value="<?php echo"$jour/$mois/$annee" ?>" readonly="readonly"/>
    </td>
  <td class="texte0">&nbsp;</td>

  </tr>
  <tr><td class="texte0"> &nbsp;</td>
  <td class="texte0">Choisir le<?php echo "$lang_tarif";?>

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

                   $rqSql3= "SELECT id_tarif, nom_tarif, prix_tarif, DATE_FORMAT(saison, '%d/%m/%Y' ) AS date FROM " . $tblpref ."tarif
                            WHERE saison
                            BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
                            AND selection='1'
                            ORDER BY nom_tarif ASC";
				 $result3 = mysql_query( $rqSql3 )
             or die( "Exécution requête impossible.");?>

</td>
				<script type="text/javascript">
				function verif_formulaire()
					{
				if(document.formu.id_tarif.value == "")  {
				alert("Veuillez Choisir le tarif!");
				document.formu.id_tarif.focus();
				return false;
						}
					}
				</script>



		   <td class="texte0"><SELECT NAME='id_tarif'>
            <OPTION VALUE="">Choisissez</OPTION>
            <?php
						while ( $row = mysql_fetch_array( $result3)) {
    							$id_tarif = $row["id_tarif"];
    							$nom_tarif = $row["nom_tarif"];
							$prix_tarif = $row["prix_tarif"];
    							?>
            <OPTION VALUE='<?php echo $id_tarif; ?>'><?php echo "$nom_tarif $prix_tarif $devise "; ?></OPTION>
            <?php
						}
						?>
           </SELECT>
		   <td class="texte0"> &nbsp;</td>
</td></tr>

  <tr>
    <td class="submit" colspan="6"> <input type="submit" name="Submit"
                                   value="Inscrire sur une liste d'attente"> </td>
</tr></table></center></form>
<br>
<br>
<br>
<br>
<?php
include_once("include/bas.php");

?>




