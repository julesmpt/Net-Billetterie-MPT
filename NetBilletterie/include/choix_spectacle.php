<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/

////pour que les articles affichés dans la selection soit de la saison du moment
$mois = date("n");
$annee = date("Y");
$annee_1= $annee ;
if ($mois <= 7)
	{
    $annee_1=$annee_1;
	}
if ($mois >= 8)
	{
    $annee_1=$annee_1+1;
	}
    $annee_2= $annee_1 -1;


				  if ($use_categorie !='y') {
$rqSql = "SELECT num, article, DATE_FORMAT(date_spectacle,'%d/%m/%Y') AS date, prix_htva FROM " . $tblpref ."article WHERE actif != 'non' AND date_spectacle BETWEEN '$annee_2-08-01' AND '$annee_1-07-01' ORDER BY date_spectacle";
$result = mysql_query( $rqSql )
             or die( "Exécution requête impossible.");
	?>
<SELECT NAME=article>"
<OPTION VALUE='0'>Choisissez</OPTION>"
<?php
						while ( $row = mysql_fetch_array( $result)) {
    							$num = $row["num"];
    							$article = $row["article"];
							$date = $row["date"];
    							?>
            <OPTION VALUE='<?php echo $num; ?>'><?php echo "$article || $date"; ?></OPTION>
            <?php
						}
						?>
</SELECT>
