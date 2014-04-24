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

//pour savoir le nombre de spectateurs au total sur la liste
$sql0 = "SELECT DISTINCT (nom) num_client FROM ".$tblpref."client WHERE actif='y'";
$req0 = mysql_query($sql0) or die('Erreur SQL0 !<br>'.$sql0.'<br>'.mysql_error());
 

//pour le total
$sql = "SELECT sum(tot_tva) total, nom, date
        FROM ".$tblpref."client CLI, ".$tblpref."bon_comm BC
        WHERE BC.client_num = CLI.num_client
        AND BC.attente='0'
        AND CLI.actif='y'
        AND date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
        AND BC.fact='ok'";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_array($req);
$total_saison = $data['total'];

//connaitre tous les spectateurs d'une saison
$sql1 = "SELECT sum(tot_tva) total, nom, date
              FROM ".$tblpref."client CLI, ".$tblpref."bon_comm BC
              WHERE BC.client_num = CLI.num_client
              AND BC.attente='0'
              AND actif='y'
              AND date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
              AND BC.fact='ok'
              GROUP BY CLI.num_client
              ORDER BY CLI.nom";
$req1 = mysql_query($sql1)or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());;

?>
<table width="760" border="0" class="page" align="center">
  <tr>
    <td>
      <h1><?php $nb0 = mysql_num_rows($req0); 
        echo "Nombre total de spectateurs inscrit dans la liste: $nb0 "; ?> </h1><br/>
      <h1><?php $nb1 = mysql_num_rows($req1); 
        echo "nombre de spectateur pour la saison $annee_2-$annee_1:  $nb1";?></h1>
    </td>
  </tr>
 	<tr>
  	<td>
  		<form action="ca_parclient.php" method="post">
        <table >
          <tr>
           <td width="27%" class="texte0">
              <select name="annee_1">
                  <option value="<?php echo"$annee_1"; ?>"><?php $date_1=$annee_1-1;echo"$date_1 -$annee_1"; ?></option>
                  <option value="<?php $date=date("Y");echo"$date"; ?>"><?php $date=date("Y");$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                  <option value="<?php $date=(date("Y")-1);echo"$date"; ?>"><?php $date=(date("Y")-1);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                  <option value="<?php $date=(date("Y")-2);echo"$date"; ?>"><?php $date=(date("Y")-2);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                  <option value="<?php $date=(date("Y")-3);echo"$date"; ?>"><?php $date=(date("Y")-3);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                  <option value="<?php $date=(date("Y")-4);echo"$date"; ?>"><?php $date=(date("Y")-4);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                  <option value="<?php $date=(date("Y")-5);echo"$date"; ?>"><?php $date=(date("Y")-5);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
                  <option value="<?php $date=(date("Y")-6);echo"$date"; ?>"><?php $date=(date("Y")-6);$date_1=$date-1;echo"$date_1 - $date"; ?></option>
              </select>
           </td>
           <td class="submit" colspan="4"><input type="submit" value='Choisir la saison culturelle'></td>
          </tr>
         </table>
      </form>
    </td>
  </tr>
  <tr>
    <td  class="page" align="center">
      <table class="boiteaction">
        <caption>
          Total des réservations par spectateur pour la saison <?php echo "$annee_2-$annee_1" ?>
        </caption>
        <tr> 
          <th><?php echo $lang_client; ?></th>
          <th><?php echo $lang_montant; ?></th>
          <th><?php echo $lang_pourcentage;?></th>
        </tr>
      <?php
        while ($data = mysql_fetch_array($req1))
        {         
          $nom = $data['nom'];
          $tot = montant_financier ($data['total']);
          $pourcentage = number_format( round( ($tot*100)/$total_saison), 0, ",", " ");
      ?>
        <tr>
          <td class='<?php echo couleur_alternee (); ?>'><?php echo $nom; ?></td>
          <td  class='<?php echo couleur_alternee (FALSE, "nombre"); ?>'><?php echo $tot; ?></td>
          <td class='<?php echo couleur_alternee (FALSE); ?>'><?php echo "$pourcentage %"; ?></td>
        </tr>
        <?php  } ?>
        <tr> 
          <td class='totaltexte'><?php echo $lang_total; ?></td>
          <td  class='totalmontant'><?php echo montant_financier ($total_saison); ?></td>
          <td class='td2'>&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>


<?php
include_once("include/bas.php");
?>

