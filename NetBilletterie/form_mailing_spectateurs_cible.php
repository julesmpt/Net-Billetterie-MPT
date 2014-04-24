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
include_once("include/head_mailing.php");
include_once("include/head.php");
include_once("include/finhead.php");


$article_numero=isset($_GET['article'])?$_GET['article']:"";
$client_num=isset($_GET['nom'])?$_GET['nom']:"";


?>
<script type="text/javascript">
	function verif_formulaire()
	{
		if(document.edit.article.value == "")  
		{
			alert("Veuillez Choisir un spectacle!");
			document.edit.article.focus();
			return false;
		}
		if(document.edit.titre.value == "")  
		{
			alert("Veuillez donner un titre au message!");
			document.edit.titre.focus();
			return false;
		}
		if (agree=confirm("Veuillez confirmer l'envoi du message?"))
		{
		alert("Attention, si la liste des destinataires est longues, cela peut prendre plusieurs minutes!");
		return true ;
		}

		else
		return false ;				
	}
</script>

<table border="0" class="page" align="center">
	<?php
	if ($user_dep !='y') { ?>
	<tr>
		<td class="page" align="center">
			<?php echo "<h1>$lang_admin_droit";
			exit; ?>
		</td>
	</tr>
		<?php } 
//=============================================
//pour que les articles soit classés par saison
$mois=date("n");
if ($mois=="10"||$mois=="11"||$mois=="12") {
 $mois=date("n");
}
else{
  $mois =date("0n");
}
$jour =date("d");
$date_ref="$mois-$jour";
$annee = date("Y");
//pour le formulaire
$annee_1=isset($_POST['annee_1'])?$_POST['annee_1']:"";
if ($annee_1=='') 
{
  $annee_1= $annee ;
  if ($mois.'-'.$jour <= $fin_saison)
  {
  $annee_1=$annee_1;
  }
  if ($mois.'-'.$jour >= $fin_saison)
  {
  $annee_1=$annee_1+1;
  }  
}
$annee_2= $annee_1 -1;
//=============================================
		$rqSql_article = "SELECT num, article, date_spectacle FROM " . $tblpref ."article
			WHERE  date_spectacle
			AND date_spectacle BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
			ORDER BY date_spectacle";
			$result_article = mysql_query( $rqSql_article )or die( "Exécution requête impossible_article.");
		?>
	<tr>
		<td  class="page" align="center">
			<form action="mailing.php" method="post" id="edit" name="edit" onSubmit="return verif_formulaire()">
				<table class="boiteaction">
					<tr>
						<h1>Vous voulez envoyer un mail aux spectateurs?<br> Selectionner le spectacle  </h1>
					</tr>
					<tr>
							<SELECT NAME="article" align="center">
								<OPTION VALUE="">Choisissez le spectacle</OPTION>
								<?php
									while($data = mysql_fetch_array($result_article))
									{
									$article_numero = $data['num'];
									$article = $data['article'];
									$date = $data['date_spectacle'];
									list($annee, $mois, $jour) = explode("-", $date);
									?>
								<OPTION VALUE="<?php echo $article_numero; ?>"><?php echo " $article $jour-$mois-$annee"; ?></OPTION>
								<?php } ?>
							</SELECT>
					</tr>
					<tr>
						<td class="texte0"><?php echo $lang_mailing_list_titremessage; ?><input type="text" name="titre"></td>
					</tr>
					<tr>
						<td class="texte0"><h1><?php echo  "$lang_mailing_list_message"; ?></h1></td>
						<td>
							<noscript>
								<strong>CKEditor requires JavaScript to run</strong>. In a browser with no JavaScript
								support, like yours, you should still see the contents (HTML data) and you should
								be able to edit it normally, without a rich editor interface.
							</noscript>
						</td>
					</tr>
					<tr>
						<td>
						<textarea class="ckeditor" cols="80" id="editor1" name="message" rows="10"><?php echo $signature; ?>
                            <div style=" text-align:justify; padding:10px; border-style:solid; border-width:4px; border-color:#ff9900; margin-left: 20px; margin-right: 20px; margin-top: 20px; float: left; width: 520px; background-color:#FDE9D9">
    <p style="text-align:center">
        <a href="http://www.mairie-lentilly.fr/la-passerelle/saison-culturelle/"><img alt="" src="http://la-passerelle-lentilly.fr/saisonculturelle/kcfinder/upload/images/Passerelle-orange.png" style="width: 200px;" /> </a></p>
    <h2 style="text-align: center; color:#C00000; font-family:arial; font-size:18px; margin:20px;">
        <b>TITRE</b>
    </h2>
    
    <p style="text-align:justify; font-family:verdana; color:#404040; font-size:12px; margin:20px;">
        Corps du texte<br />
        <b>Texte gras</b>
    </p>

    <p style="text-align:justify; font-family:verdana; color:#c00000; font-size:12px; margin:20px 20px 20px 20px;">
        <b>L&#39;&eacute;quipe de la Saison Culturelle de Lentilly </b>
    </p>
    <p style="color:#262626; font-family:verdana; color:#262626; font-size:12px; margin-left: 10px; margin:20px;">
        <span style="color:#c00000;"><b>La Passerelle</b></span><br />
        <b>10 rue Chatelard Dru<br />
        69210 Lentilly<br />
        Infos et r&eacute;servations en mairie au 04 74 01 70 49<br />
        Mail : billetterie@la-passerelle-lentilly.fr<br />
        Plus d&#39;infos sur le site </b><a href="http://www.mairie-lentilly.fr/la-passerelle/saison-culturelle/">de la mairie</a><br />
        <br /><img alt="" src="http://la-passerelle-lentilly.fr/saisonculturelle/kcfinder/upload/images/mairie_lentilly.png" style="margin-top:0px; margin-bottom:0px; margin-left:170px;  margin-bottom:20px; float:left; width:100px; height:53px; " /></p>
</div>
                        </textarea>
							<script type="text/javascript">
							CKEDITOR.replace( 'editor1' );
							</script>
						</td>
					 </tr>
						<td class= "submit" colspan="2">
							<input type="image" name="Submit" src="image/envoyer.png" value="Démarrer"  border="0" ><h1>Attention, si la liste de destinataires est longue, cela peut prendre plusieurs minutes! <br />Soyez patient! </h1>
						</td>
					</tr>
				</table>
			</form>
			<?php 
			$aide = mailing;
			?><!-- InstanceEndEditable --> 
		</td>
	</tr>
</table>
<?php
include_once("include/bas.php");
?>

