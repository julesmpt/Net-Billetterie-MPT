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
<table  border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
			<h3><?php echo $lang_commandes_chercher; ?></h3>
		</td>
	</tr>
	<tr>
		<td  class="page" align="center">
			<?php 
			if ($user_com == n) { 
			echo"<h1>$lang_commande_droit";
			exit;  
			}
			?> 
			<?php
			$rqSql = "SELECT num_client, nom, nom2 FROM " . $tblpref ."client WHERE 1";
			if ($user_com == r) { 
			$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client 
				WHERE " . $tblpref ."client.permi LIKE '$user_num,' 
				 or  " . $tblpref ."client.permi LIKE '%,$user_num,' 
				or  " . $tblpref ."client.permi LIKE '%,$user_num,%' 
				 or  " . $tblpref ."client.permi LIKE '$user_num,%' 
				";  
			}

			?>
			<form name="formu" method="post" action="recherche.php">
				<center>
					<table class="action">
						<tr> 
							<td style="text-align:right;"> <?php echo "$lang_client "; ?></td>
							<td style="text-align:left;">
								<?php 
								require_once("include/configav.php");
								if ($liste_cli!='y') { 
								 $rqSql="$rqSql order by nom";
								 
								  $result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");
									?> 
								<SELECT NAME='listeville'>
									<OPTION VALUE='null'><?php echo $lang_choisissez; ?></OPTION>
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
									<?php 
								}
								else
								{?>
								<script type="text/javascript" src="javascripts/montrer_cacher.js"></script>
								<INPUT type="checkbox" checked name="list_client" onClick="montrer_cacher(this,'cluster','cluster2')">Activer
								<?php
									include_once("include/choix_cli.php");
								} ?> 
							</td>
						</tr>
						<tr>
						  <td style="text-align:right;"> <?php echo $lang_mois ?> <input name="mois" type="text" id="mois" size="2"  maxlength="2"></td>
						  <td style="text-align:right;"> <?php echo $lang_annee?> <input name="annee" type="text" id="annee" size="4"></td>
						</tr>
						<!--tr>
							<td><hr>
								<h1>Attention
								<br>
								Pour rechercher par N°, il ne faut pas oublier de désactiver les spectateurs ci dessus </h1>
							</td>
						</tr>
						<tr>
							<td style="text-align:right;">Numéro de commande de billets ou d'abonnement</td>
							<td style="text-align:left;"><input name="numero" type="text" id="numero" value="" size="2" > </td>
						</tr>
						<tr>
							<td style="text-align:right;"><?php  echo $lang_tri ?></td>
							<td style="text-align:left;">
								<select name="tri" id="tri">
								  <option value="nom"><?php echo $lang_client?></option>
								  <option value="num_bon"><?php echo $lang_num_bon?></option>
								  <option value="date"><?php echo $lang_date ?></option>
								  <option value="<?php echo "$tblpref" ?>bon_comm.tot_htva"> <?php  echo $lang_montant_htva ?></option>
								</select>
							</td>
						</tr-->
						<tr>
							<td class="submit" colspan="6"><input type="submit" name="Submit" value='<?php echo $lang_rech ?>'>  
							</td>
						</tr>
					</table>
				</center>
			</form>
		</td>
	</tr>
</table>
<?php
include_once("include/bas.php");
?>
