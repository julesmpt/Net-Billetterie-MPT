<!--
Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr

Charger de communication-->
<div class="menublock" >
	<!--Menu 1er niveau-->
	<ul id="solidmenu" class="solidblockmenu">
		
		<li><a href="lister_clients.php" rel="menu1"><img border ="0" src="image/kontact_contacts.png" alt="client"><br><?php echo $lang_clients; ?></a></li>
		<li><a href="lister_spectacle_attente.php" rel="menu4"><img border ="0" src="image/commandes_attente02.png" alt="Listes d'attente"><br>Listes d'attente</a></li>
		<li><a href="lister_articles.php" rel="menu3"><img border ="0" src="image/spectacle.png" alt="Spectacles"><br>Spectacles</a></li>
		<li><a href="form_mailing.php" rel="menu8"><img border ="0" src="image/mailing.png" alt="Mailing"><br>Mailing</a></li>
		<li><a href="agenda.php" rel="menu9"><img border ="0" src="image/outil.png" alt="outils"><br>Outils </a></li>
		<li><a href="logout.php" rel="menu10"><img border ="0" src="image/sortir.png" alt="Quiter"><br>Quiter </a></li>
	</ul>

<!--deroulant du menu1 niveau2-->
	<div id="menu1" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion des spectateurs</b></p>
		<div class="column">
			<ul>
				<li><li><a href="form_client.php"><b>Créer une fiche "Spectateur"</b></a></li><hr/>
				<li><a href="lister_clients.php"><b>Liste des spectateurs</b></a></li><hr/>
				<li><a href="rechercher_clients.php"><b>Chercher par critère </b></a></li><hr/>
				<li><a href="lister_clients_inactifs.php"><b>Liste des spectateurs inactifs</b></a></li>
			</ul>
		</div>
		</div>

<!--deroulant du menu8 niveau2-->
	<div id="menu8" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion des courriels</b></p>
		<div class="column">
			<ul>
				<li><a href="form_mailing.php"><b>Mailing à tous les spectateurs </b></a></li><hr/>
				<li><a href="form_mailing_spectateurs_cible.php"><b>Mailing aux spectateurs d'un spectacle</b></a></li><hr/>
				<li><a href="form_mailing_spectateur.php"><b>Mailing à un spectateur</b></a></li><hr/><hr/>
				<li><a href="lister_mail.php"><b>Liste des mails envoyés</b></a></li><hr/>
			</ul>
		</div>
	</div>
		
		<!--deroulant du menu9 niveau2-->
	<div id="menu9" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Quelques outils d'administration</b></p>
		<div class="column">
			<ul>
				<li><a href="agenda.php">Agenda</a></li><hr/>
				<li><a href="include/calculette.html" onclick="window.open('','popup','width=500,height=420,top=200,left=150,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0')" target="popup"><?php echo $lang_calculette; ?></a></li><hr/>
			</ul>
		</div>
	</div>
</div>
