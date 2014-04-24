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
include_once("javascripts/verif_form.js");
include_once("include/head.php");
include_once("include/finhead.php");
?>
<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
		<h3>Formulaire de création de tarif</h3>
		</td>
	</tr>
	<tr>
		<td  class="page" align="center">
			<?php 
			if ($user_art == n) { 
			echo "<h1>$lang_tarif_droit";
			exit;  
			}
			 if ($message !='') { 
			 echo"<table><tr><td>$message</td></tr></table>"; 
			}?>
			<form action="tarif_new.php" method="post" name="nom_tarif" id="nom_tarif" onSubmit="return verif_formulaire()" >
			<center>
				<table>
					<caption><?php echo $lang_tarif_creer; ?></caption>
						<tr>
							<td class='<?php echo couleur_alternee (); ?>'><?php echo "$lang_nom_tarif"; ?></td>
							<td class='<?php echo couleur_alternee (FALSE); ?>'><input name="nom_tarif" type="text" id="nom_tarif" size="40" maxlength="40"> </td>
						</tr>
						<tr>
							<td class='<?php echo couleur_alternee (); ?>'><?php echo"$lang_prix_tarif"; ?></td>
							<td class='<?php echo couleur_alternee (FALSE); ?>'><input name='prix_tarif'  type='text'>&euro;</td>
						 </tr>
						<tr>
							<td class="texte0">Entre en vigueur à partir du </td>
							<td class="texte0">Jour(JJ)
								<input name="jour" type="text" id="jour" size="8" maxlength="2" value="01">
								Mois(MM)
								<input name="mois" type="text" id="mois" size="8" maxlength="2"value="09">
								Année (AAAA)
								<input name="annee" type="text" id="annee" size="16" maxlength="4">
							</td>
						</tr>
						<tr>
							<td class='<?php echo couleur_alternee (); ?>'>Premier N° du carnet</td>
							<td class='<?php echo couleur_alternee (FALSE); ?>'><input name='carnet' type='text'></td>
						</tr>
							<td class="submit" colspan="2"> <input type="image" name="Submit" src="image/valider.png" value="Démarrer"  border="0"> 
								
							</td>
				</table>
			</center>
			</form>
		</td>
	</tr>
</table>
<?php
require_once("lister_tarif.php");
?>
