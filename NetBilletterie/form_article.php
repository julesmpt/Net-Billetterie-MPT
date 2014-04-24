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
include_once("javascripts/verif_form.js");
include_once("include/head.php");
include_once("include/finhead.php");
?>
<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">
<h3>Formulaire de création de spectacle</h3>
</td>
</tr>
<tr>
<td  class="page" align="center">
<?php 
if ($user_art == n) { 
echo "<h1>$lang_article_droit";
exit;  
}
 if ($message1 !='') {
 echo"<table><tr><td>$message1</td></tr></table>";
}


$jour = date("d");
$mois = date("m");
$annee = date("Y");?>
  
      <form action="article_new.php" method="post" name="article" id="article" onSubmit="return verif_formulaire()" enctype="multipart/form-data" >
        <center><table>
          <caption>
          <?php echo $lang_article_creer; ?>
          </caption>
          <tr> 
            <td class="texte0"> <?php echo "$lang_art_no"; ?> </td>
            <td align=left> <input name="article" type="text" id="article" size="80" maxlength="40">
            </td>
          </tr>
		  
		            <tr> 
            <td class="texte0">Lieu </td>
            <td align=left> <input name="lieu" type="text" id="lieu" size="40" maxlength="40">
            </td>
          </tr>
		  
		  <tr> 
            <td class="texte0">horaire</td>
            <td align=left> <input name="horaire" type="text" id="horaire" size="20" maxlength="40">
            </td>
          </tr>
		  

		  <tr> 
            <td class="texte0">DATE </td>
            <td class="texte0">
                        Jour(JJ)
			<input name="jour" type="text" id="jour" size="8" maxlength="2">
			Mois(MM)
            <input name="mois" type="text" id="mois" size="8" maxlength="2">
			Année (AAAA)
            <input name="annee" type="text" id="annee" size="16" maxlength="4"></td>
         
            <!-- td class='< ?php echo couleur_alternee (); ?>'> < ?php echo $lang_prix_uni; ?></td>
            <td class='< ?php echo couleur_alternee (FALSE); ?>'> <input name="prix" type="text" id="prix"> &euro;</td>
          </tr -->
          
          <tr> 
            <td class='<?php echo couleur_alternee (); ?>'> <?php echo "$langCommentaire" ?> : </td>
            <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="commentaire" type="text" size="80" id="commentaire">
            </td>
          </tr>
	  <tr>
	  <td class='<?php echo couleur_alternee (); ?>'><?php echo "$lang_stock"; ?></TD>
	  <td align=left><input name='stock' type='text'> </td>
	  </tr>
	  <tr>
	  <td class='<?php echo couleur_alternee (); ?>'><?php echo"$lang_stomin"; ?></td>
	  <td align=left><input name='stomin' type='text'></td>
	  </tr>
	  <tr>
	  <td class='<?php echo couleur_alternee (); ?>'><?php echo"$lang_stomax"; ?></td>
	  <td align=left><input name='stomax' type='text'></td>
	</tr>

	<tr>
		<td class='<?php echo couleur_alternee (); ?>'>
				<input type="hidden" name="MAX_FILE_SIZE" value="100000">
				Fichier au format 100 px HT. x 190 px larg.: 
		</td>
     
     
		<script type="text/javascript">
								function openKCFinder(field) {
								window.KCFinder = {
								callBack: function(url) {
								field.value = url;
								window.KCFinder = null;
								}
								};
								window.open('<?php echo $url_root;?>/kcfinder/browse.php?type=images&lang=fr&dir=images/public', 'kcfinder_textbox',
								'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
								'resizable=1, scrollbars=0, width=800, height=600'
								);
								}
								</script>
		<td align=left> <input name="cheminimage"  type="text" SIZE="60" readonly="readonly" onclick="openKCFinder(this)"
			value="<?php if ($logo!=""){echo $logo;} else {echo"Choisir une image jpg";}?>" /><br/> Cliquez dans la case ci dessus pour choisir un fichier image <br/> 
			puis cliquer sur parcourir pour choisir l'image à télécharger depuis votre ordinateur<br/>et enfin double cliquer sur cette dernière.
		</td>
	</tr>
            <td class="submit" colspan="2"> <input type="image" name="Submit" src="image/valider.png" value="Démarrer"  border="0"> 
              </td>
          </tr>
        </table></center>
      </form>
<?php
$aide = article;
require_once("lister_articles.php");
?>





