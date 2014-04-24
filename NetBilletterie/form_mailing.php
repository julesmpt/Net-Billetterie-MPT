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
include_once("include/head_mailing.php");
include_once("include/head.php");
include_once("include/finhead.php");

$article_numero=isset($_GET['article'])?$_GET['article']:"";
$client_num=isset($_GET['nom'])?$_GET['nom']:"";
$attente=isset($_GET['attente'])?$_GET['attente']:"";

if ($client_num!=""){
	$sql = " SELECT * FROM ".$tblpref ."client WHERE num_client='$client_num'";
	$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	while($data = mysql_fetch_array($req))
	{
		$nom = $data['nom'];
			$nom=stripslashes($nom);
		$to =$data['mail'];
		$civ = $data['civ'];
	}
	$a="à $civ $nom <br> <font size='1em'>$to</font>";
}
else {$a="";}
?>
<script type="text/javascript">
	function verif_formulaire()
	{
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
	if ($user_dep != y) { ?>
	<tr>
		<td class="page" align="center">
			<?php echo "<h1>$lang_admin_droit";
			exit; ?>
		</td>
	</tr>
		<?php } ?>
	<tr>
		<td  class="page" align="center">
			<form action="mailing.php" method="post" id="edit" name="edit" onSubmit="return verif_formulaire()">
			  <table class="boiteaction">
				<tr>
				  <caption>Envoyer un courriel <?php echo $a;?></caption>
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
    
    <p style="text-align:justify; font-family:verdana; color:#404040; font-size:12px; margin:20px 20px 20px 20px;">
        Corps du texte<br />
        <b>Texte gras</b>
    </p>

    <p style="text-align:justify; font-family:verdana; color:#c00000; font-size:12px; margin:20px;">
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
				<tr>
				 <td class= "submit" colspan="2">
					<?php if ($article_numero !="") { echo "<input type='hidden' name='article' value='$article_numero'>"; } ?>
					<?php if ($client_num !="") { echo "<input type='hidden' name='client_num' value='$client_num'>"; } ?>
					 <input type="hidden" name="article" value="<?php echo "$article_numero"; ?>">
					 <input type="hidden" name="attente" value="<?php echo "$attente"; ?>">
					 <input type="image" name="Submit" src="image/envoyer.png" value="Démarrer"  border="0" >
				</td>
				</tr>
			  </table>
			</form>
		</td>
	</tr>
</table>
<?php
include_once("include/bas.php");
?>
