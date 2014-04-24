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
			<li>
			<form action="print_caisse_billetterie.php" method="get">
				<center>
					<table>
						<a href="print_caisse_billetterie.php"><b>Imprimer les enregistrements des espéces de la billetterie</b></a></li>
						<tr>
							<td><li>Imprimer en choisissant les dates entre le</td>
							<td> <input name="date_debut" type="text" size="10" maxlength="40"  value="<?php echo $date_today;?>" ></td>
							<td>et le </td>
							<td> <input name="date_fin" type="text" size="10" maxlength="40" value="<?php echo $date_today;?>"></td>
							<td> <input type="submit" name="Submit" value="Imprimer la liste"></td>
						</tr>
                    </table>
                </center>
              </form>
			</li><hr>			<li>
			<form action="print_caisse_bar.php" method="get">
				<center>
					<table>
						<a href="print_caisse_bar.php"><b>Imprimer les enregistrements des espéces de la buvette</b></a></li>
						<tr>
							<td><li>Imprimer en choisissant les dates entre le</td>
							<td> <input name="date_debut" type="text" size="10" maxlength="40"  value="<?php echo $date_today;?>" ></td>
							<td>et le </td>
							<td> <input name="date_fin" type="text" size="10" maxlength="40" value="<?php echo $date_today;?>"></td>
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

