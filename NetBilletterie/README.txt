

Installation de Net Billetterie sur votre serveur

Version 1.1.1

Avant l'installation assurer vous de recuperer 
1.l'adresse de votre base de donnée
2.le mot de passe de l'utilisateur de votre base mysql
3.le login de votre utilisateur mysql
4.Si la base de donnée à été crée le nom de cette base de donnée vide
5.Toutes les info de votre entreprise (n° de tva, adresse, tel, registre de commerce...)


Decompressez le fichier dans un repertoire accecible par apache
Verifier les droit des fichier (chmod 777)
- Touts les fichier doivent etres lisibles par apache
- Les repertoires 
									/include 
									/dump 
									/image 	
									/fpdf
									et le repertoire racine de Net Billetterie doivent permettre un droit d'ecriture par apache

Pointez votre navigateur sur http://votre_hebergeur.org/Net Billetterie/installeur/
Suivez les instructions à l'ecran.
Apres l'installation il faut effacer le repertoire installeur de l'arboressence de Net Billetterie (si vous ne le faites pas un message de rapel vous en feras le rappel)
Réduire les droits en ecriture du fichier :
									/include/config/common.php
Celui-ci ne doit être accesible qu'en lecture par apache.



######################################################

Upgrade de Net Billetterie

Faites tout d'abord une sauvgarde de votre base de donnée (en ligne de commande ou via phpmyadmin ou tout autre soft de gestion de mysql)
Ensuite faite un backup des fichiers suivant:
												 		 									/include/config/common.php
														
Ceci fait decompresser l'archive et uploader les fichier dans le repertoire de Net Billetterie en ecrassant les anciens fichiers.
Verifier les droits comme pour l'installation (voir plus haut) 
reuploader les fichiers:
			 		 									/include/config/common.php
Pointez votre navigateur sur http://votre_hebergeur.org/Net Billetterie/installeur/upgrade et suivez les instructions a l'ecran

!!!!!!!!!!!!!Je ne suis en aucun cas responsable des pertes de données du à l'upgrade de Net Billetterie !!!!!!!!!!!!!


###########################################

License


# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.

