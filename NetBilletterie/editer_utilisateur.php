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
if ($num_user=='') { 
$num_user=isset($_GET['num_user'])?$_GET['num_user']:"";
}
?>


<table width="760" border="0" class="page" align="center">
	<tr>
	<td class="page" align="center">
	<?php
	include_once("include/head.php");
	?>
	</td>
	</tr>
	<tr>
	<td  class="page" align="center">
	<?php 
	if ($user_admin != y) { 
	echo "<h1>$lang_admin_droit";
	exit;
	}
	 ?> 
	<?php 
	$sql = " SELECT * FROM " . $tblpref ."user WHERE num = $num_user ";
	$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

	while($data = mysql_fetch_array($req))
	{
	$nom = $data['nom'];
	$prenom = $data['prenom'];
	$login = $data['login'];
	$dev = $data['dev'];
			if ($dev == y) { $dev1 = $lang_oui ;}
			if ($dev == n) { $dev1 = $lang_non ; }
			if ($dev == r) { $dev1 = $lang_restrint ; }
	$com = $data['com'];
			if ($com == y) { $com1 = $lang_oui ; }
			if ($com == n) { $com1 = $lang_non ; }
			if ($com == r) { $com1 = $lang_restrint ; }
	$fact = $data['fact'];
			if ($fact == y) { $fact1 = $lang_oui ; }
			if ($fact == n) { $fact1 = $lang_non ; }
			if ($fact == r) { $fact1 = $lang_restrint ; }
	$mail =$data['email'];
	$dep = $data['dep'];
			if ($dep == y) { $dep1 = $lang_oui ; }
			if ($dep == n) { $dep1 = $lang_non ; }
	$stat = $data['stat'];
			if ($stat == y) { $stat1 = $lang_oui ; }
			if ($stat == n) { $stat1 = $lang_non ; }
	$art = $data['art'];
			if ($art == y) { $art1 = $lang_oui ; }
			if ($art == n) { $art1 = $lang_non ; }
	$cli = $data['cli'];
			if ($cli == y) { $cli1 = $lang_oui ; }
			if ($cli == n) { $cli1 = $lang_non ; }
			if ($dev == r) { $dev1 = $lang_restrint ; }
	$admin = $data['admin'];
			if ($admin == y) { $admin1= $lang_oui ; }
			if ($admin == n) { $admin1 = $lang_non ; }
	$print_user = $data['print_user'];
			if ($print_user == y) { $print_user1 = $lang_oui ; }
			if ($print_user == n) { $print_user1 = $lang_non ; }
	$num_user = $data['num'];
	$menu = $data['menu'];
		if ($menu=='1') {
			$menu1=$menu;
		}
		if ($menu=='2') {
			$menu2=$menu;
		}
		if ($menu=='3') {
			$menu3=$menu;
		}
		if ($menu=='4') {
			$menu4=$menu;
		}
		if ($menu=='5') {
			$menu5=$menu;
		}
		if ($menu=='6') {
			$menu6=$menu;
		}

				$menu1 = 'Administrateur'; 
				$menu2 = 'saisie abonnement'; 
				$menu3 = 'saisie billetterie'; 
				$menu4 = 'Charger de comm'; 
				$menu5 = 'comptable'; 
				$menu6 = 'liste d\'attente'; 
	}
	
			?>


	</tr>
	<tr>
		<td  class="page" align="center">
			<form action="suite_edit_utilisateur.php" method="post" name="utilisateur" id="utilisateur">
			  <table class="boiteaction">
			  <caption>
			  <?php echo $lang_utilisateur_editer; ?>
			  </caption>
				<tr> 
				  <td  class='<?php echo couleur_alternee (); ?>'> <?php echo $lang_utilisateur_nom; ?></td>
				  <td colspan="2" class='<?php echo couleur_alternee (FALSE); ?>'><input name="login2" type="text" id="login2" value="<?php echo $login ?>"></td>
				</tr>
				<tr> 
				  <td  class='<?php echo couleur_alternee (); ?>'> <?php echo $lang_nom; ?></td>
				  <td colspan="2" class='<?php echo couleur_alternee (FALSE); ?>'><input name="nom" type="text" id="nom" value="<?php echo $nom ?>"></td>
				</tr>
				<tr> 
				  <td  class='<?php echo couleur_alternee (); ?>'><?php echo $lang_prenom; ?></td>
				  <td colspan="2" class='<?php echo couleur_alternee (FALSE); ?>'><input name="prenom" type="text" id="prenom" value="<?php echo $prenom ?>"></td>
				</tr>
				<tr> 
				  <td  class='<?php echo couleur_alternee (); ?>'><?php echo $lang_motdepasse; ?></td>
				  <td colspan="2" class='<?php echo couleur_alternee (FALSE); ?>'><input name="pass" type="password" id="pass"></td>
				</tr>
				<tr> 
				  <td c class='<?php echo couleur_alternee (); ?>'><?php echo $lang_mot_de_passe; ?></td>
				  <td colspan="2" class='<?php echo couleur_alternee (FALSE); ?>'><input name="pass2" type="password" id="pass2"></td>
				</tr>
				<tr> 
				  <td  class='<?php echo couleur_alternee (); ?>'><?php echo $lang_mail; ?></td>
				  <td colspan="2" class='<?php echo couleur_alternee (FALSE); ?>'><input name="mail" type="text" id="mail" value="<?php echo $mail ?>" ></td>
				</tr>
				<tr>
					<td class='<?php echo couleur_alternee (); ?>'>Statut de l''utilisateur</td>
					<td class='<?php echo couleur_alternee (FALSE); ?>' style="text-align:left;">
							<input type="radio" name ="menu" value="2" <?php if ($menu=='2') { echo "checked='checked'";} ?>>Gestionnaire des abonnements<br/>
							<input type="radio" name ="menu" value="3"<?php if ($menu=='3') { echo "checked='checked'";} ?>>Gestionnaire de la billetterie<br/>
							<input type="radio" name ="menu" value="4"<?php if ($menu=='4') { echo "checked='checked'";} ?>>Charger de communication<br/>
							<input type="radio" name ="menu" value="5"<?php if ($menu=='5') { echo "checked='checked'";} ?>>Comptable<br/>
							<input type="radio" name ="menu" value="6"<?php if ($menu=='6') { echo "checked='checked'";} ?>>Gestionnaire de la liste d'attente( ne donner les droits que pour la gestion des réservations)<br/>
							<input type="radio" name ="menu" value="1"<?php if ($menu=='1') { echo "checked='checked'";} ?>>Admninistrateur plein pouvoir<br/>
					</td>
				</tr>
				<tr>
					<td class="submit" ><?php echo $lang_util_droit?></td>
					<td class="submit"><?php echo $lang_val_actu ?></td>
				</tr>
				<tr>
					<td class='<?php echo couleur_alternee (); ?>'>Peut gérer l'encaissement des commandes?</td>
					<td class='<?php echo couleur_alternee (FALSE); ?>'>
						<input type="radio" name ="dev" value="n" <?php if ($dev=='n') { echo "checked='checked'";} ?>><?php echo $lang_non ?>
						<input type="radio" name ="dev" value="y" <?php if ($dev=='y') { echo "checked='checked'";} ?>><?php echo $lang_oui ?>
					</td>
				</tr>
						
				<tr>
					<td class='<?php echo couleur_alternee (); ?>'><?php echo $lang_ger_com;?> et la liste d'attente?</td>
					<td class='<?php echo couleur_alternee (FALSE); ?>'>
						<input type="radio" name ="com" value="n" <?php if ($com=='n') { echo "checked='checked'";} ?>><?php echo $lang_non ?>
						<input type="radio" name ="com" value="y" <?php if ($com=='y') { echo "checked='checked'";} ?>><?php echo $lang_oui ?>
					</td>
					</tr>

					<tr>
						<td class='<?php echo couleur_alternee (); ?>'>Peut gérer la billetterie</td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'>
							<input type="radio" name ="fact" value="n" <?php if ($fact=='n') { echo "checked='checked'";} ?>><?php echo $lang_non ?>
							<input type="radio" name ="fact" value="y" <?php if ($fact=='y') { echo "checked='checked'";} ?>><?php echo $lang_oui ?>
						</td>
					</tr>
					<tr>
						<td class='<?php echo couleur_alternee (); ?>'>Gère les courriels</td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'>
							<input type="radio" name ="dep" value="n" <?php if ($dep=='n') { echo "checked='checked'";} ?>><?php echo $lang_non ?>
							<input type="radio" name ="dep" value="y" <?php if ($dep=='y') { echo "checked='checked'";} ?>><?php echo $lang_oui ?>
						</td>
					</tr>
					<tr>
						<td class='<?php echo couleur_alternee (); ?>'>Peut voir les statistiques</td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'>
							<input type="radio" name ="stat" value="n" <?php if ($stat=='n') { echo "checked='checked'";} ?>><?php echo $lang_non ?>
							<input type="radio" name ="stat" value="y" <?php if ($stat=='y') { echo "checked='checked'";} ?>><?php echo $lang_oui ?>
						</td>
					</tr>
					<tr>
						<td class='<?php echo couleur_alternee (); ?>'><?php echo $lang_ger_art ?></td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'>
							<input type="radio" name ="art" value="n" <?php if ($art=='n') { echo "checked='checked'";} ?>><?php echo $lang_non ?>
							<input type="radio" name ="art" value="y" <?php if ($art=='y') { echo "checked='checked'";} ?>><?php echo $lang_oui ?>
						</td>
					</tr>
					<tr>
						<td class='<?php echo couleur_alternee (); ?>'><?php echo $lang_ger_cli ?></td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'>
							<input type="radio" name ="cli" value="n" <?php if ($cli=='n') { echo "checked='checked'";} ?>><?php echo $lang_non ?>
							<input type="radio" name ="cli" value="y" <?php if ($cli=='y') { echo "checked='checked'";} ?>><?php echo $lang_oui ?>
						</td>
					</tr>
					<tr>
						<td class='<?php echo couleur_alternee (); ?>'>Peut imprimer</td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'>
							<input type="radio" name ="print_user" value="n" <?php if ($print_user=='n') { echo "checked='checked'";} ?>><?php echo $lang_non ?>
							<input type="radio" name ="print_user" value="y" <?php if ($print_user=='y') { echo "checked='checked'";} ?>><?php echo $lang_oui ?>
						</td>
					</tr>
					<tr>
						<td class='<?php echo couleur_alternee (); ?>'><?php echo $lang_dr_admi ?><br/><?php echo $lang_admi_modu ?></td>
						<td class='<?php echo couleur_alternee (FALSE); ?>'>
							<input type="radio" name ="admin" value="n" <?php if ($admin=='n') { echo "checked='checked'";} ?>><?php echo $lang_non ?>
							<input type="radio" name ="admin" value="y" <?php if ($admin=='y') { echo "checked='checked'";} ?>><?php echo $lang_oui ?>
						</td>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="num_user" value="<?php echo $num_user ?>" /> </td>
						<td class="submit" colspan="3"> <input type="submit" name="Submit" value="<?php echo $lang_envoyer; ?>"> 
							 
						</td>
					</tr>
			  </table>
			</form>
		</td>
	</tr>
	<tr>
		<td><h2><a href="lister_utilisateurs.php"> Retour à la liste des utilisateurs </a></h2></td>
	</tr>
</table>
<?php 
include_once("include/bas.php");
 ?> 
