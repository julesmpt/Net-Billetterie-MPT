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

<?php 
if ($user_admin != y) { 
echo "<h1>$lang_admin_droit<h1/>";
exit;
}
 ?> 
</tr>
<tr>
<td  class="page" align="center">
	<form action="register.php" method="post" name="utilisateur" id="utilisateur">
		  <table class="boiteaction">
			<caption>
				<?php echo $lang_utilisateur_ajouter; ?>
			</caption>
				<tr> 
					<td class='<?php echo couleur_alternee (); ?>'><?php echo $lang_utilisateur_nom; ?> *</td>
					<td class='<?php echo couleur_alternee (FALSE); ?>'><input name="login2" type="text" id="login2"></td>
				</tr>
				<tr> 
				  <td class='<?php echo couleur_alternee (); ?>'> Nom*</td>
				  <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="nom" type="text" id="nom"></td>
				</tr>
				<tr> 
				  <td class='<?php echo couleur_alternee (); ?>'><?php echo $lang_prenom; ?></td>
				  <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="prenom" type="text" id="prenom"></td>
				</tr>
				<tr> 
				  <td class='<?php echo couleur_alternee (); ?>'><?php echo $lang_motdepasse; ?>*</td>
				  <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="pass" type="password" id="pass"></td>
				</tr>
				<tr> 
				  <td class='<?php echo couleur_alternee (); ?>'><?php echo $lang_mot_de_passe; ?>*</td>
				  <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="pass2" type="password" id="pass2"></td>
				</tr>
				<tr> 
				  <td class='<?php echo couleur_alternee (); ?>'><?php echo $lang_mail; ?></td>
				  <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="mail" type="text" id="mail"></td>
				</tr>
				<tr>
					<td colspan="2" >* Champ obligatoire</td>
				</tr>
				<tr>
					<td class="submit" colspan="2" ><?php echo $lang_util_droit ?></td>
				</tr>
				<tr>
					<td class='<?php echo couleur_alternee (); ?>'>Statut de l''utilisateur</td>
					<td class='<?php echo couleur_alternee (FALSE); ?>' style="text-align:left;">
							<input type="radio" name ="menu" value="2">Gestionnaire des abonnements<br>
							<input type="radio" name ="menu" value="3">Gestionnaire de la billetterie<br>
							<input type="radio" name ="menu" value="4">Charger de communication<br>
							<input type="radio" name ="menu" value="5">Comptable<br>
							<input type="radio" name ="menu" value="1">Administrateur plein pouvoir<br>
							<input type="radio" name ="menu" value="6">Gestionnaire de la liste d'attente uniquement (Activer uniquement "peut gerer les reservations" )
					</td>
				</tr>
				<tr>
					<td class="submit" colspan="2" ><?php echo $lang_util_droit ?></td>
				</tr>
				<tr>
					<td class='<?php echo couleur_alternee (); ?>'>Peut gérer l'encaissement des commandes</td>
					<td class='<?php echo couleur_alternee (FALSE); ?>'>
						<input type="radio" name ="dev" value="n"><?php echo $lang_non ?>
						<input type="radio" name ="dev" value="y"><?php echo $lang_oui ?>
					</td>
				</tr>
				<tr>
					<td class='<?php echo couleur_alternee (); ?>'><?php echo $lang_ger_com ?></td>
					<td class='<?php echo couleur_alternee (FALSE); ?>'>
							<input type="radio" name ="com" value="n"><?php echo $lang_non ?>
							<input type="radio" name ="com" value="y"><?php echo $lang_oui ?>
					</td>
				</tr>
					
				<tr>
				<td class='<?php echo couleur_alternee (); ?>'>Peut gérer la billetterie</td>
			  <td class='<?php echo couleur_alternee (FALSE); ?>'>
						<input type="radio" name ="fact" value="n"><?php echo $lang_non ?>
						<input type="radio" name ="fact" value="y"><?php echo $lang_oui ?>
					</td>
					</tr>
					
				<tr>
				<td class='<?php echo couleur_alternee (); ?>'>Gére les courriels</td>
			  <td class='<?php echo couleur_alternee (FALSE); ?>'>
						<input type="radio" name ="dep" value="n"><?php echo $lang_non ?>
						<input type="radio" name ="dep" value="y"><?php echo $lang_oui ?>
					</td>
					</tr>
					
				<tr>
				<td class='<?php echo couleur_alternee (); ?>'>Peut voir les statistiques</td>
			  <td class='<?php echo couleur_alternee (FALSE); ?>'>
						<input type="radio" name ="stat" value="n"><?php echo $lang_non ?>
						<input type="radio" name ="stat" value="y"><?php echo $lang_oui ?>
					</td>
					</tr>
					
				<tr>
				<td class='<?php echo couleur_alternee (); ?>'><?php echo $lang_ger_art ?></td>
			  <td class='<?php echo couleur_alternee (FALSE); ?>'>
						<input type="radio" name ="art" value="n"><?php echo $lang_non ?>
						<input type="radio" name ="art" value="y"><?php echo $lang_oui ?>
					</td>
					</tr>
					
				<tr>
					<td class='<?php echo couleur_alternee (); ?>'><?php echo $lang_ger_cli ?></td>
					<td class='<?php echo couleur_alternee (FALSE); ?>'>
						<input type="radio" name ="cli" value="n"><?php echo $lang_non ?>
						<input type="radio" name ="cli" value="y"><?php echo $lang_oui ?>
					</td>
				</tr>
				<tr>
					<td class='<?php echo couleur_alternee (); ?>'>Peut imprimer les billets</td>
					<td class='<?php echo couleur_alternee (FALSE); ?>'>
						<input type="radio" name ="print_user" value="n"><?php echo $lang_non ?>
						<input type="radio" name ="print_user" value="y"><?php echo $lang_oui ?>
					</td>
				</tr>
				<tr>
				<td class='<?php echo couleur_alternee (); ?>'><?php echo $lang_dr_admi ?><br><?php echo $lang_admi_modu ?></td>
			  <td class='<?php echo couleur_alternee (FALSE); ?>'>
						<input type="radio" name ="admin" value="n"><?php echo $lang_non ?>
						<input type="radio" name ="admin" value="y"><?php echo $lang_oui ?>
					</td>
					</tr>
			<tr> 
			  <td class="submit" colspan="2"> <input type="image" name="Submit" src="image/valider.png" value="Démarrer"  border="0"> 
				<input name="reset" type="reset" id="reset" value="<?php echo $lang_effacer; ?>"> 
			  </td>
			</tr>
		  </table>
		</form>

<?php
include("help.php");
include_once("include/bas.php");
?>
</table></body>
</html>
