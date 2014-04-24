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
include_once("include/head.php");
?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<?php
include_once("include/finhead.php");
include_once("include/fonction.php");
?>

<table border="0" class="page" align="center">
	<tr>
		<td class="page" align="center">
			<h3>Liste des spectateurs inactifs</h3>
		</td>
	</tr>
	<tr>
		<td  class="page" align="center">
		<?php 
		if ($user_cli == n) { 
		echo"<h1>$lang_client_droit";
		exit;  
		}

		$initial=isset($_GET['initial'])?$_GET['initial']:"";

		$sql = " SELECT * FROM ".$tblpref."client WHERE nom LIKE '$initial%' AND actif='n' ";

		 if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
		{
		$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
		} 
		else {
		$sql = " SELECT * FROM ".$tblpref ."client WHERE nom LIKE '$initial%' AND actif='n' ORDER BY nom ASC";
		  }
		$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());


		//===============================================================================
		/* pagination */

		// Paramétrage de la requête (ne pas modifier le nom des variable)


		//=====================================================
		// Nombre d'enregistrements par page à afficher
		$parpage = 500;
		//=====================================================


		//==============================================================================
		// Déclaration et initialisation des variables (ici ne rien modifier)
		//==============================================================================

		// On définit le suffixe du lien url qui affichera les pages
		// $_SERVEUR['PHP_SELF'] donne l'arborescence de la page courante
		$url = $_SERVER['PHP_SELF']."?limit=";

		$total = mysql_query($sql); // Résultat total de la requête $sql
		$nblignes = mysql_num_rows($total); // Nbre total d'enregistrements
		// On calcule le nombre de pages à afficher en arrondissant
		// le résultat au nombre supérieur grâce à la fonction ceil()
		$nbpages = ceil($nblignes/$parpage); 

		 // Si une valeur 'limit' est passée par url, on vérifie la validité de
		// cette valeur par mesure de sécurité avec la fonction validlimit()
		 // cette fonction retourne automatiquement le résultat de la requête
		 $result = validlimit($nblignes,$parpage,$sql); 
		// ==========================================================================
		?>
			<center>
				<table class="boiteaction">
					<caption><?php echo $lang_clients_existants; ?></caption>
						<form method="GET" action="lister_clients.php" >
							<h5>Cherche par initiale
						<input name="initial" type="text"  SIZE="3" value="<?php echo $initial; ?>">
						<input type="submit" name="Submit" value="Afficher les spectateurs"> </h5>
						</form>
					 <tr>
						 <th><a href="lister_clients.php?ordre=civ&initial=<?php echo $initial; ?>"><?php echo $lang_civ; ?> </a></th>
						 <th><a href="lister_clients.php?ordre=nom&initial=<?php echo $initial; ?>"><?php echo $lang_nom; ?></a></th>
						<th><a href="lister_clients.php?ordre=rue&initial=<?php echo $initial; ?>"><?php echo $lang_rue; ?></a></th>
						<th><a href="lister_clients.php?ordre=cp&initial=<?php echo $initial; ?>"><?php echo $lang_code_postal; ?></a></th>
						<th><a href="lister_clients.php?ordre=ville&initial=<?php echo $initial; ?>"><?php echo $lang_ville; ?></a></th>
						<th><a href="lister_clients.php?ordre=tel&initial=<?php echo $initial; ?>"><?php  echo $lang_tele;?></a></th>
						<th><a href="lister_clients.php?ordre=mail&initial=<?php echo $initial; ?>"><?php echo $lang_email; ?></a></th>
						<th colspan="2"><?php echo $lang_action; ?></th>
					</tr>
						<?php
						$nombre =1;
						while($data = mysql_fetch_array($result))
							{
								$nom = $data['nom'];
									$nom=stripslashes($nom);
								$nom2 = $data['nom2'];
								$rue = $data['rue'];
									$rue=stripslashes($rue);
								$ville = $data['ville'];
									$ville=stripslashes($ville);
								$cp = $data['cp'];
								$tva = $data['num_tva'];
								$mail =$data['mail'];
								$num = $data['num_client'];
								$civ = $data['civ'];
								$tel = $data['tel'];
								$fax = $data['fax'];
								$nombre = $nombre +1;
								if($nombre & 1){
								$line="0";
								}else{
								$line="1"; 
								}
								?>
					<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
							<td class="highlight"><?php echo $civ; ?></td>
							<td class="highlight"><?php echo $nom; ?></td>
							<td class="highlight"><?php echo $rue; ?></td>
							<td class="highlight"><?php echo $cp; ?></td>
							<td class="highlight"><?php echo $ville; ?></td>
							<td class="highlight"><?php echo $tel; ?></td>
							<td class="highlight"><a href="mailto:<?php echo $mail; ?>" ><?php echo "$mail"; ?></a></td>
							<td class="highlight"><a href='edit_client.php?num=<?php echo "$num" ?>'><img border='0'src='image/edit.gif' alt='<?php echo $lang_editer; ?>'></a></td>
							<?php
							} ?>
					</tr>
					<tr>
						<TD colspan="12" class="submit"></TD>
					</tr>
				</table>
			</center>
		</td>
	</tr>
	<tr>
		<td>
		<?php
		//============================================================================
				// Menu de pagination que l'on place après la requête 
		 echo "<div class='pagination'>";
		 echo pagination($url,$parpage,$nblignes,$nbpages,$initial);
		function position($parpage){
		if (isset($_GET['limit'])) {
			$pointer = split('[,]', $_GET['limit']); // On scinde $_GET['limit'] en 2
			$debut = $pointer[0];
			$page = ($debut/$parpage)+1;
		return $page;
		}
		}
		 echo "</div>";
		 //et tu rajoute dans ton script la fonction


		 mysql_free_result($result); // Libère le résultat de la mémoire
		 //=============================================================================
		 ?>
		</td>
	</tr>
</table>
<?php
include_once("include/bas.php");
?>

