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
			<li align="left"><a href="impression_stat.php"><b>Statistiques</b></a>
				<ul><a href="print_ca_tarif.php">Imprimer le chiffre d'affaires de la saison par tarif et par paiement</a></ul>
				<ul><a href="table_ca_spectacle.php">Imprimer le chiffre d'affaires par représentation</a></ul>
				<ul><form action="print_ca_tarif.php" method="get">
					<center>
						<table>
							<tr>
								<td><b>Chiffre d'affaires de la saison par tarif et par paiement: Entre le</b></td>
								<td><input name="date_debut" type="text" size="10" maxlength="40"  value="<?php echo $date_today;?>" ></td>
								<td>et le </td>
								<td> <input name="date_fin" type="text" size="10" maxlength="40" style="background-color :#E5E5E5;" value="<?php echo $date_today;?>" readonly><?php echo $date_today;?></td>
								<td> <input type="submit" name="Submit" value="Imprimer"></td>
							</tr>
	                    </table>
	                </center>
	              </form>
      			</ul>
			</li>
			<hr/>
			<li><a href="impression.php"><b>Reservations - Encaissements</b></a>
			</li><br/>
				<form action="print_detail_bon.php" method="get">
					<center>
						<table>
							<tr>
								<td><b>Liste détaillée de toutes les réservations en cours: Entre le</b></td>
								<td><input name="date_debut" type="text" size="10" maxlength="40"  value="<?php echo $date_today;?>" ></td>
								<td>et le </td>
								<td> <input name="date_fin" type="text" size="10" maxlength="40" style="background-color :#E5E5E5;" value="<?php echo $date_today;?>" readonly><?php echo $date_today;?></td>
								<td> <input type="submit" name="Submit" value="Imprimer"></td>
							</tr>
	                    </table>
	                </center>
	            </form>
				<form action="print_pointes_ok.php" method="get">
					<center>
						<table>
							<tr>
								<td><b>Liste détaillée des réservations pour la perception: Entre le</b></td>
								<td><input name="date_debut" type="text" size="10" maxlength="40"  value="<?php echo $date_today;?>" ></td>
								<td>et le </td>
								<td> <input name="date_fin" type="text" size="10" maxlength="40" style="background-color :#E5E5E5;" value="<?php echo $date_today;?>" readonly><?php echo $date_today;?></td>
								<td> <input type="submit" name="Submit" value="Imprimer"></td>
							</tr>
	                    </table>
	                </center>
	            </form>
				<form action="print_pointes_ok_light.php" method="get">
					<center>
						<table>
							
							<tr>
								<td><b>Détail des encaissements pour la perception: Entre le</b></td>
								<td><input name="date_debut" type="text" size="10" maxlength="40"  value="<?php echo $date_today;?>" ></td>
								<td>et le </td>
								<td> <input name="date_fin" type="text" size="10" maxlength="40" style="background-color :#E5E5E5;" value="<?php echo $date_today;?>" readonly><?php echo $date_today;?></td>
								<td> <input type="submit" name="Submit" value="Imprimer"></td>
							</tr>
	                    </table>
	                </center>
	            </form>
			</li>
			<hr/>
			<li><a href="impression_caisse.php"><b>Caisse journalière</b></a>
			</li>
			<br/>
				<form action="print_caisse_billetterie.php" method="get">
					<center>
						<table>
							<tr>
								<td><b>Imprimer les enregistrements des espéces de la billetterie: Entre le</b></td>
								<td> <input name="date_debut" type="text" size="10" maxlength="40"  value="<?php echo $date_today;?>" ></td>
								<td>et le </td>
								<td> <input name="date_fin" type="text" size="10" maxlength="40" style="background-color :#E5E5E5;" value="<?php echo $date_today;?>" readonly><?php echo $date_today;?></td>
								<td> <input type="submit" name="Submit" value="Imprimer"></td>
							</tr>
	                    </table>
	                </center>
	            </form>
				<form action="print_caisse_bar.php" method="get">
					<center>
						<table>
							<tr>
								<td><b>Imprimer les enregistrements des espéces de la buvette: Entre le</b></td>
								<td> <input name="date_debut" type="text" size="10" maxlength="40"  value="<?php echo $date_today;?>" ></td>
								<td>et le </td>
								<td> <input name="date_fin" type="text" size="10" maxlength="40" style="background-color :#E5E5E5;" value="<?php echo $date_today;?>" readonly><?php echo $date_today;?></td>
								<td> <input type="submit" name="Submit" value="Imprimer"></td>
							</tr>
	                    </table>
	                </center>
	            </form>
			</li>
			<hr/>
        </td>
    </tr>
 </table>
<?php
include_once("include/bas.php");
?>
