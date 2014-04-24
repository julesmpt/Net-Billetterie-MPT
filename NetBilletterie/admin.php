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
?>
<table width="760" border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
		<?php
		if ($user_admin != y) { 
		echo "<h1>$lang_admin_droit";
		exit;
		}
		?>
		</td>
	</tr>
		<?php
		if($message !=''){
		echo"<tr><TD>$message</TD></tr>";
		}
		?>
	<tr>
		<td  class="page" align="center">
			<form action="admin_modif.php" method="post" >
				<table class="boiteaction">
					<caption>Paramètre de Net-Billetterie</caption>
					<tr>
						<th>Nom de la salle de spectacle</th>
						<td align=left> <input name="entrep_nom" type="text" id="lieu" size="60" maxlength="40" value="<?php echo $entrep_nom;?>">
						</td>
					</tr>
					<tr>
						<th>adresse du siège social</th>
						<td align=left> <input name="social" type="text" id="lieu" size="60" maxlength="40" value="<?php echo $social;?>">
						</td>
					</tr>
					<tr>
						<th>Téléphonne de la salle de spectacle</th>
						<td align=left> <input name="tel" type="text" id="lieu" size="60" maxlength="40" value="<?php echo $tel;?>">
						</td>
					</tr>
					<tr>
						<th>Slogan de la salle de spectacle</th>
						<td align=left> <input name="slogan" type="text" id="lieu" size="60" maxlength="40" value="<?php echo $slogan;?>">
						</td>
					</tr>
					<tr>
						<th>Mail de la salle de spectacle</th>
						<td align=left> <input name="mail" type="text" id="lieu" size="60" maxlength="40" value="<?php echo $mail;?>">
						</td>
					</tr>
					<tr>
						<th>Devise utilisée pour la facturation</th>
						<td align=left> <input name="devise" type="text" id="lieu" size="10" maxlength="40" value="<?php echo $devise;?>">
						</td>
					</tr>
					<tr>
						<th>Logo de la salle de spectacle<br/> <img src="<?php echo $logo;?>" alt="<?php echo $slogan;?>" height="100" WIDTH="270"></th>
								<script type="text/javascript">
								function openKCFinder(field) {
								window.KCFinder = {
								callBack: function(url) {
								field.value = url;
								window.KCFinder = null;
								}
								};
								window.open('<?php echo $url_root;?>/kcfinder/browse.php?type=images&dir=images/public', 'kcfinder_textbox',
								'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
								'resizable=1, scrollbars=0, width=800, height=600'
								);
								}
								</script>
						<td align=left> <input name="logo"  type="text" SIZE="60" readonly="readonly" onclick="openKCFinder(this)"
							value="<?php if ($logo!=""){echo $logo;} else {echo"Choisir une image jpg";}?>" /><br/> Cliquez dans la case ci dessus pour choisir un fichier image jpg<br/> 
							puis cliquer sur upload pour choisir l'image à télécharger depuis votre ordinateur<br/>et enfin double cliquer sur cette dernière.<br/> 
							Attention! le format de l'image "jpg" uniquement
						</td>
					</tr>
					<tr>
						<th>Langue utilisée (seulement en fr pour l'instant)</th>
						<td align=left> <input name="lang" type="text" id="lieu" size="40" maxlength="40" value="<?php echo $lang;?>">
						</td>
					</tr>
					<tr>
						<th>Site de la salle de spectacle</th>
						<td align=left> <input name="site" type="text" id="lieu" size="60" maxlength="40" value="<?php echo $site;?>">
						</td>
					</tr>
					<tr>
						<th>Code postal pour préremplir les formulaires des fiches spectateurs</th>
						<td align=left> <input name="c_postal" type="text" id="lieu" size="40" maxlength="40" value="<?php echo $c_postal;?>">
						</td>
					</tr>
					<tr>
						<th>Ville pour préremplir les formulaires des fiches spectateurs</th>
						<td align=left> <input name="ville" type="text" id="lieu" size="40" maxlength="40" value="<?php echo $ville;?>">
						</td>
					<tr>
						<tr>
						<th>Indicatif téléphonique pour préremplir les formulaires des fiches spectateurs</th>
						<td align=left> <input name="indicatif_tel" type="text" id="lieu" size="40" maxlength="40" value="<?php echo $indicatif_tel;?>">
						</td>
					</tr>
					<tr>
						<th>Serveur smtp utilisé pour l'envoi des mails</th>
						<td align=left> <input name="smtp" type="text" id="lieu" size="40" maxlength="40" value="<?php echo $smtp;?>">
						</td>
					</tr>
					<tr>
						<th>Port utilisé pour l'envoi des mails smtp</th>
						<td align=left> <input name="port" type="text" id="lieu" size="40" maxlength="40" value="<?php echo $port;?>">
						</td>
					</tr>
					<tr>
						<th>Utilisateur du compte smtp</th>
						<td align=left> <input name="username_smtp" type="text" id="lieu" size="40" maxlength="40" value="<?php echo $username_smtp;?>">
						</td>
					</tr>
					<tr>
						<th>Mot de passe du compte smtp</th>
						<td align=left> <input name="password_smtp" type="text" id="lieu" size="40" maxlength="40" value="<?php echo $password_smtp;?>">
						</td>
					</tr>
					<tr>
						<th>Utilisation d'impression des billets (mettre y ou n)</th>
						<td align=left> <input name="impression" type="text" id="lieu" size="40" maxlength="40" value="<?php echo $impression;?>">
						</td>
					</tr>
					<tr>
						<th>Mois et jour du début de la saison<br/> (pour le début au 1er sept. ecrire 09-01)</th>
						<td align=left> <input name="debut_saison" type="text" id="lieu" size="40" maxlength="40" value="<?php echo $debut_saison;?>">
						</td>
					</tr>
					<tr>
						<th>Mois et jour de la fin de la saison <br/>(pour la fin au 31 aout écrire 08-31)</th>
						<td align=left> <input name="fin_saison" type="text" id="lieu" size="40" maxlength="40" value="<?php echo $fin_saison;?>">
						</td>
					</tr>
					</tr>
						<td class="submit" colspan="2"> <input type="image" name="Submit" src="image/valider.png" value="Démarrer"  border="0">
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td>
			<?php
			$dir='installeur/index.php';
			if (file_exists($dir)) {
				echo"<h1>Le dossier d'installation n'est pas supprimer</h1><br>";
				?>
				<h2><a href= "del_installeur.php">Supprimer le dossier d'installation  <img src="image/delete.png"></a></h2>
				<?php
			}
			else{echo"<h1>Le dossier d'installation est bien supprimer</h1><br>";}
			?>
		</td>
		
	</tr>
</table>
<?php
include_once("include/bas.php");
?>

