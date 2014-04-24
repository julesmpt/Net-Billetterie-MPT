<!--
Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.

Administrateur plein pouvoir-->
<div class="menublock" >
	<!--Menu 1er niveau-->
	<ul id="solidmenu" class="solidblockmenu">
		
		<li><a href="form_client.php" rel="menu1"><img border ="0" src="image/kontact_contacts.png" alt="client"><br><?php echo $lang_clients; ?></a></li>
		<li><a href="form_commande.php" rel="menu2"><img border ="0" src="image/commandes.png" alt="Abonnement"><br>Réservations</a></li>
		<li><a href="form_commande_soir.php" rel="menu7"><img border ="0" src="image/billetterie.png" alt="billetterie"><br>Billetterie</a></li>
		<li><a href="lister_articles.php" rel="menu3"><img border ="0" src="image/spectacle.png" alt="Spectacles"><br>Spectacles</a></li>
		<li><a href="lister_caisse_billetterie.php" rel="menu5"><img border ="0" src="image/caisse.png" alt="caisse"><br>Caisse</a></li>
		<li><a href="ca_spectacle.php" rel="menu6"><img border ="0" src="image/stat.png" alt="Statistiques"><br>Stat.</a></li>
		<li><a href="form_mailing.php" rel="menu8 [left]"><img border ="0" src="image/mailing.png" alt="Mailing"><br>Mailing</a></li>
		<li><a href="accueil_print.php" rel="menu4"><img border ="0" src="image/print.png" alt="Impression"><br>Impression</a></li>
		<li><a href="agenda.php" rel="menu9 [left]"><img border ="0" src="image/outil.png" alt="outils"><br>Outils </a></li>
		<li><a href="logout.php" rel="menu10"><img border ="0" src="image/sortir.png" alt="Quiter"><br>Quiter </a></li>
	</ul>

<!--deroulant du menu1 -->
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

<!--deroulant du menu2 -->
	<div id="menu2" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion des abonnements et réservations</b></p>
		<div class="column">
			<ul>
				<li><a href="form_commande.php"><b>Créer une réservation</b></a></li><hr/>
				<li><a href="lister_commandes.php"><b>Lister les réservations</b></a></li><hr/>
				<li><a href="lister_detail_commandes.php"><b>Détail des réservations</b></a></li><hr/>
				<li><a href="lister_commandes_non_facturees.php"><b>Contrôler - Encaisser</b></a></li><hr/>
				<li><a href="impression.php"><b><img src="image/imprimante.png">&nbsp;&nbsp;Imprimer </b></a></li><hr/>
			</ul>
		</div>
		</div>
		

<!--deroulant du menu3 -->
	<div id="menu3" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion des spectacles</b></p>
		<div class="column">
			<ul>
				<li><a href="form_article.php"><b>Créer un spectacle</b></a></li><hr/>
				<li><a href="lister_articles.php"><b>Lister les spectacles</b></a></li><hr/>
			</ul>
		</div>
		</div>

	<!--deroulant du menu4 -->
	<div id="menu4" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion d'impression</b></p>
		<div class="column">
			<ul>
				<li><a href="impression_stat.php"><b>Statistiques</b></a></li><hr/>
				<li><a href="impression.php"><b>Reservations - Encaissements</b></a></li><hr/>
				<li><a href="impression_caisse.php"><b>Caisse journalière</b></a></li><hr/>
			</ul>
		</div>
		</div>

	<!--deroulant du menu5 -->
	<div id="menu5" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Opérations de caisse</b></p>
		<div class="column">
			<ul>
				<li><a href="form_caisse.php"><b>Enregistrer le contenu de caisse</b></a></li><hr/>
				<li><a href="form_caisse.php?retrait=y"><b>Retrait de caisse</b></a></li><hr/>
				<li><a href="lister_caisse_billetterie.php"><b>Caisse "Billetterie"</b></a></li><hr/>
				<li><a href="lister_caisse_bar.php"><b>Caisse "Buvette"</b></a></li><hr/>
				<li><a href="impression_caisse.php"><b><img src="image/imprimante.png">&nbsp;&nbsp;Imprimer les opérations de caisse</b></a></li><hr/>
			</ul>
		</div>
		</div>

<!--deroulant du menu6 -->
	<div id="menu6" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Chiffre d'affaire de la saison</b></p>
		<div class="column">
			<ul>
				<li><a href="ca_spectacle.php"><b>Statistiques par spectacle</b></a></li><hr/>
				<li><a href="ca_articles.php"><b>Statistiques par représentation</b></a></li><hr/>
				<li><a href="ca_tarif.php"><b>Statistiques par tarif</b></a></li><hr/>
				<li><a href="ca_parclient.php"><b>Statistiques par spectateur</b></a></li><hr/>
				<li><a href="impression_stat.php"><b><img src="image/imprimante.png">&nbsp;&nbsp;Imprimer les statistiques</b></a></li><hr/>
			</ul>
		</div>
		</div>


<!--deroulant du menu7 -->
	<div id="menu7" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion de la billetterie</b></p>
		<div class="column">
			<ul>
				<li><a href="form_commande_soir.php"><b>Créer un enregistrement de billet</b></a></li><hr/>
				<li><a href="form_commande_caisse_postdate.php"><b>Créer un enregistrement postdaté</b></a></li><hr/>
				<li><a href="lister_billetterie.php"><b>Voir la liste de la billetterie</b></a></li><hr/>
			</ul>
		</div>
		</div>

<!--deroulant du menu8 -->
	<div id="menu8" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion des courriels</b></p>
		<div class="column">
			<ul>
				<li><a href="form_mailing.php"><b>Mailing à tous les spectateurs </b></a></li><hr/>
				<li><a href="form_mailing_spectateurs_cible.php"><b>Mailing aux spectateurs d'un spectacle</b></a></li><hr/>
				<li><a href="form_mailing_spectateur.php"><b>Mailing à un spectateur</b></a></li><hr/>
				<li><a href="lister_mail.php"><b>Liste des mails envoyés</b></a></li><hr/>
			</ul>
		</div>
	</div>
		
		<!--deroulant du menu9 -->
	<div id="menu9" class="mega">
		<p style="margin:5px 0 10px 0"><b>Quelques outils d'administration</b></p>
		<div class="column">
			<ul>
				<li><a href="accueil_liste_attente.php"><img border ="0" src="image/commandes_attente02.png" alt="Listes d'attente"><br>Listes <br>d'attente</a></li><hr/>
				<li><a href="lister_tarif.php"><img border ="0" src="image/tarif.png" alt="Tarifs">Tarifs</a></li><hr/>
				<li><a href="lister_banque.php"><img border ="0" src="image/banque.png" alt="Banques">Banques</a></li><hr/>
				<li><a href="lister_paiement.php"><img border ="0" src="image/paiement.png" alt="Paiement">Paiements</a></li><hr/>
				<li><a href="projection.php">Vidéo projection</a></li><hr/>
				<li><a href="include/calculette.html" onclick="window.open('','popup','width=500,height=420,top=200,left=150,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0')" target="popup"><?php echo $lang_calculette; ?></a></li><hr/>
			</ul>
		</div>
		<div class="column">
			<ul>
				<li><a href="form_utilisateurs.php"><?php echo $lang_aj_utl ?></a></li><hr/>
				<li><a href="lister_utilisateurs.php"><?php echo $lang_list_utl ?></a></li><hr/>
				<li><a href="form_backup.php"><?php echo $lang_back_men ?></a></li><hr/>
				<li><a href="admin.php"><?php echo $lang_administra ?></a></li><hr/>
			</ul>
		</div>
	</div>
</div>
