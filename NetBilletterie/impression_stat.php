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
include_once("include/fonction.php");
include_once("include/finhead.php");
include_once("include/head.php");
$date_today= date("Y-m-d");
list($annee, $mois, $jour) = explode("-", $date_today);
$date_today = "$jour-$mois-$annee";
?>

<table class="page" align="center">
	<tr>
		<td>
			<li><a href="table_ca_article.php"><b>Imprimer le chiffre d'affaires par spectacle</b></a></li><hr>
			<li><a href="table_ca_spectacle.php"><b>Imprimer le chiffre d'affaires par représentation</b></a></li><hr>
			<li>
			<form action="print_ca_tarif.php" method="get">
				<center>
					<table>
						<a href="print_ca_tarif.php"><b>Imprimer le chiffre d'affaires de la saison par tarif et par paiement</b></a></li>
						<tr>
							<td><li>Imprimer en choisissant les dates entre le</td>
							<td> <input name="date_debut" type="text" size="10" maxlength="40"  value="<?php echo $date_today;?>" ></td>
							<td>et le </td>
							<td> <input name="date_fin" type="hidden" size="10" maxlength="40" value="<?php echo $date_today;?>"><?php echo $date_today;?></td>
							<td> <input type="submit" name="Submit" value="Imprimer la liste"></td>
						</tr>
                    </table>
                </center>
              </form>
			</li><hr>
        </td>
    </tr>


</table>
<?php
include_once("include/bas.php");
?>
