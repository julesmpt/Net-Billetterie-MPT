<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/var.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
sleep(1);
$limit_sup=isset($_GET['limit_sup'])?$_GET['limit_sup']:"";
$limit_count=isset($_GET['limit_count'])?$_GET['limit_count']:"";
$nbr_lot=isset($_GET['nbr_lot'])?$_GET['nbr_lot']:"";
//on recupère le N° du mail en cours d'envoi'
$id_mail=isset($_GET['id_mail'])?$_GET['id_mail']:"";
/* on resupère le id du spectacle en GET*/
$article_numero=isset($_GET['article'])?$_GET['article']:"";
$limit_inf=$limit_sup-$nbr_lot;
$pourcentage4 =$limit_inf / $limit_count * 100;
$pourcentage4 = sprintf('%.1f',$pourcentage4); 
?>

<table class="page">
	<tr>
		<td>
			<h2>Attention, comme la liste comprend <?php echo $limit_count;?> destinataires, cela peut prendre plusieurs minutes! <br/>
			Restez patient! <br/><br/><br/>
			<img src="image/sablier.png"></h2>
			<br/>
			<p>Le message est en cours d'envoi</p>
			<br/>
			<span class="bar">
				<span class="progression" style="width: <?php echo $pourcentage4 ?>%">
					<span title="<?php echo $pourcentage4 ?>%" class="precent"><?php echo $pourcentage4 ;?>%
					</span>
				</span>
			</span>
			<br/>
			<br/>
			<br/>
			<br/>
		</td>
	</tr>
</table>

<SCRIPT LANGUAGE="JavaScript">
	document.location.href="mailing.php?limit_sup=<?php echo $limit_sup;?>&id_mail=<?php echo $id_mail;?>&article=<?php echo $article_numero;?>" 
</SCRIPT>
