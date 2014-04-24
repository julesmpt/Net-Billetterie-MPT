
<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
include_once("include/config/var.php");
include_once("include/language/$lang.php");
?>
<table class="page">
	<tr>
		<td>
			<div id="pied">
				<div id="pied_gauche"><a href="http://net-billetterie.tuxfamily.org/"><img src="image/logoNetBilletterie.png" alt="<?php echo $login;?>" height="150" ></a></div>
				<div id="pied_centre"><img src="<?php echo $logo;?>" alt="<?php echo $slogan;?>" height="100" WIDTH="270"></div>
				<div id="pied_droite"><a href="<?php echo $site;?>" target="_blank" ><?php echo $slogan; ?></a></div>			
			 <div id="btn_up">
				 <a href="#retour">
					<img alt="Retour en haut de la page" title="Retour en haut" src="image/fleche.png" width="40" />
				</a>
			</div>
</div>
		</td>
	</tr>
</table>
</body> 

