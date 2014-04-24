<!--
Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.

Gestionaire de liste d'attente-->
<div class="menublock" >
	<!--Menu 1er niveau-->
	<ul id="solidmenu" class="solidblockmenu">
		<li><a href="form_commande_attente.php" rel="menu4"><img border ="0" src="image/commandes_attente02.png" alt="Listes d'attente"><br>Listes <br>d'attente</a></li>
		<li><a href="agenda.php" rel="menu9 [left]"><img border ="0" src="image/outil.png" alt="outils"><br>Outils </a></li>
		<li><a href="logout.php" rel="menu10"><img border ="0" src="image/sortir.png" alt="Quiter"><br>Quiter </a></li>
	</ul>



<!--deroulant du menu4 niveau2-->
	<div id="menu4" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion des listes d'attente</b></p>
		<div class="column">
			<ul>
				<li><a href="form_commande_attente.php"><b>Inscrire sur liste d'attente</b></a></li><hr/>
				<li><a href="lister_commandes_attente.php"><b>Voir la liste d'attente</b></a></li><hr/>
				<li><a href="lister_spectacle_attente.php"><b>Voir la liste d'attente par spectacle</b></a></li><hr/>
			</ul>
		</div>
		</div>

<!--deroulant du menu9 niveau2-->
	<div id="menu9" class="mega">
		<p style="margin:5px 0 10px 0"><b>Quelques outils d'administration</b></p>
		<div class="column">
			<ul>
				<li><a href="projection.php">Vidéo projection</a></li><hr/>
				<li><a href="include/calculette.html" onclick="window.open('','popup','width=500,height=420,top=200,left=150,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0')" target="popup"><?php echo $lang_calculette; ?></a></li><hr/>
			</ul>
		</div>
	</div>
</div>
