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
include_once("include/fonction.php");?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<?php
include_once("include/finhead.php");
include_once("include/head.php");
?>

<table  class="page" align="center">

    <tr>
        <td class="page" align="center">
            <h3>Liste des billets en attente </h3>
        </td>
    </tr>
    <tr>

        <td  class="page" align="center">
                <?php
                if ($message!='') {
                 echo"<table><tr><td>$message</td></tr></table>";
                 $jour=date("d");
                 $mois= date("m");
                 $annee=date("y");

                 //formulaire pour refaire une autre commande avec les même info du client deja selectioné
                 ?>
            <form name="formu" method="post" action="bon_attente.php" >
                <center>
                    <table >

                        <tr>
                            <input type="hidden" name="listeville" value="<?php echo $num_client; ?>" >
                            <input type="hidden" name="date" value="<?php echo"$jour/$mois/$annee" ?>">
                            <input type="hidden" name="id_tarif" value="<?php echo $id_tarif ?>">

                            <td class="submit" colspan="6"> <input type="submit" name="Submit" value="Inscrire un autre billet en attente pour <?php echo "$nom"; ?>"
                            </td>
                        </tr>
                    </table>
                </center>
            </form>
                <?php
                                }
                if ($user_com == n) {
                echo"<h1>$lang_commande_droit";
                exit;
                }

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

                if ($user_com == y) {
                                $sql = "SELECT mail, login, num_client, attente, coment, num_bon, tot_tva, nom, id_tarif,
                                 DATE_FORMAT(date,'%d-%m-%Y') AS date, tot_tva as ttc, paiement
                                 FROM ".$tblpref."bon_comm
                                 RIGHT JOIN " . $tblpref ."client on " . $tblpref ."bon_comm.client_num = num_client
                                 WHERE attente=1
                                 AND date  BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'";
                                    }
                if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
                                {
                $sql .= " ORDER BY " . $_GET[ordre] . " ASC";
                                }else{
                $sql .= "ORDER BY num_bon ASC ";
                }
                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

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

			 //=====================================================
			  /*  pour changer le paiement */
			 //=====================================================
			 $bon_num=isset($_POST['bon_num'])?$_POST['bon_num']:"";
			 $paiement=isset($_POST['paiement'])?$_POST['paiement']:"";
			 $sql4 = "UPDATE " . $tblpref ."bon_comm SET `paiement`='" . $paiement . "' WHERE `num_bon` = '" . $bon_num . "'";
			mysql_query($sql4) OR die("<p>Erreur Mysql<br/>$sql4<br/>".mysql_error()."</p>");
			?>
		</td>
	</tr>
	<tr>
		<td  align="center">
			<table class="boiteaction">
				<caption>Les commandes de la saison culturelle <?php echo "$annee_2 $annee_1"; ?></caption>
				<tr>
					<th><a href="lister_commandes_attente.php?ordre=num_bon"><?php echo $lang_numero; ?></a></th>
					<th><a href="lister_commandes_attente.php?ordre=nom"><?php echo $lang_client; ?></a></th>
					<th><a href="lister_commandes_attente.php?ordre=date"><?php echo $lang_date; ?></a></th>
					<th><a href="lister_commandes_attente.php?ordre=ttc"><?php echo $lang_total_ttc; ?></a></th>
					<th><a href="lister_commandes_attente.php?ordre=paiement">Réglé?</a></th>
					<th>Commentaires</th>
					<th colspan="2"><?php echo $lang_action; ?></th>
				</tr>
					<?php
						$nombre = 1;
						while($data = mysql_fetch_array($result))
						{
						  $num_bon = $data['num_bon'];
						  $coment = $data['coment'];
						  $total = $data['tot_htva'];
						  $paiement = $data['paiement'];
						  $tva = $data["tot_tva"];
						  $date = $data["date"];
						  $id_tarif = $data["id_tarif"];
						  $nom = $data['nom'];
							$nom = htmlentities($nom, ENT_QUOTES);
							$nom_html = htmlentities (urlencode ($nom));
						  $num_client = $data['num_client'];
						  $mail = $data['mail'];
						  $login = $data['login'];
						  $ttc = $data['ttc'];
						  $nombre = $nombre +1;
							if($nombre & 1){
							$line="0";
							}else{
							$line="1";
							}
					?>
				<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
					<td class="highlight"><?php echo "$num_bon"; ?></td>
					<td class="highlight"><?php echo "$nom"; ?></td>
					<td class="highlight"><?php echo "$date"; ?></td>
					<td class="highlight"><?php echo montant_financier($ttc); ?></td>
					<td class="highlight"><?php echo "$paiement"; ?></td>
					<td class="highlight"><?php echo "$coment"; ?></td>
					<td class="highlight">
						<a href='form_editer_bon_attente.php?num_bon=<?php echo "$num_bon"; ?>&amp;id_tarif=<?php echo "$id_tarif"; ?>' > 
						<img border="0" alt="editer" src="image/edit.gif" Title="Modiffier"></a> &nbsp;
					</td>
				   <td class="highlight">
						<a href='delete_bon_attente.php?num_bon=<?php echo $num_bon; ?>&amp;nom=<?php echo "$nom_html"; ?>'
						onClick="return confirmDelete('<?php echo"$lang_con_effa $num_bon"; ?>')">
						<img border="0" src="image/delete.png" alt="delete" Title="Supprimer" ></a>
					</td>
				 </tr>
					<?php 
						} 
					?>
				<tr>
					<td colspan="10" class="submit"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
		<?php
		//=====================================================
		// Menu de pagination que l'on place après la requête
		//======================================================
		 echo "<div class='pagination'>";
		 echo pagination($url,$parpage,$nblignes,$nbpages);
		function position($parpage){
		if (isset($_GET['limit'])) {
			$pointer = split('[,]', $_GET['limit']); // On scinde $_GET['limit'] en 2
			$debut = $pointer[0];
			$page = ($debut/$parpage)+1;
		return $page;
		}
		}
		 echo "</div>";
		 mysql_free_result($result); // Libère le résultat de la mémoire
		include("help.php");
		include_once("include/bas.php");
		$url = $_SERVER['PHP_SELF'];
		$file = basename ($url);
		?>
		</td>
	</tr>
</table>

<?php
include_once("include/footers.php");
 ?>

