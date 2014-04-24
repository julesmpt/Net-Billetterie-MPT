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
include_once("include/fonction.php");?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<?php
include_once("include/head.php");
include_once("include/finhead.php");

?> 


<table  class="page" align="center">

	<tr>
		<td class="page" align="center">
			 <h3>Liste des réservations 
				 <?php if ($user_admin == 'y'||$user_dev=='y'){?>
				<SCRIPT LANGUAGE="JavaScript">
				if(window.print)
					{
					document.write('<A HREF="javascript:window.print()"><img border=0 src= image/printer.gif ></A>');
					}
				</SCRIPT>
				<?php } ?>
			</h3>
        </td>
    </tr>
    
    <tr>
        <td  class="page" align="center">
            <?php

            if ($message!='') {
             echo"<table><tr><td>$message</td></tr></table>";
            }
            if ($user_com == n) {
            echo"<h1>$lang_commande_droit";
            exit;
            }


          //=============================================
//pour que les articles soit classés par saison
$mois=date("n");
if ($mois=="11"||$mois=="12") {
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
            $sql = "SELECT mail, login, num_client, num_bon, fact, ctrl, attente, coment, tot_tva, nom, soir, id_tarif,
             DATE_FORMAT(date,'%d-%m-%Y') AS date, tot_tva as ttc, paiement
                             FROM ".$tblpref."bon_comm
                             RIGHT JOIN " . $tblpref ."client on " . $tblpref ."bon_comm.client_num = num_client
                      WHERE date BETWEEN '$annee_2-$debut_saison' AND '$annee_1-$fin_saison'
                            AND attente='0'
                             ";
                             //ORDER BY " . $tblpref ."bon_comm.`num_bon` DESC

            if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
            {
            $sql .= " ORDER BY " . $_GET[ordre] . " ASC";
            }
            else
            {
            $sql .= "ORDER BY " . $tblpref ."bon_comm.`num_bon` DESC ";
            }}
            $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());

/* pagination */
// Paramétrage de la requête (ne pas modifier le nom des variable)

//=====================================================
// Nombre d'enregistrements par page à afficher
if ( isset ( $_GET['parpage'] ) && $_GET['parpage'] != '')
	{
	$parpage=$_GET[parpage];
	}
else
	{
	$parpage = 10;
	}
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
    <center>
        <table class="boiteaction">
            
                    
                    
						<caption> Les commandes de la saison culturelle <?php echo "$annee_2 - $annee_1"; ?> </caption>
						<FORM method="get" action="lister_commandes.php">
						Nombre de lignes affichées :
						<SELECT name="parpage" onchange='submit()'>
							<OPTION VALUE="<?php echo$parpage;?>"><?php if ($parpage=="10000"){echo "Tout";}else{echo$parpage;}?></OPTION>
							<OPTION VALUE="20">20</OPTION>
							<OPTION VALUE="100">100</OPTION>
							<OPTION VALUE="200">200</OPTION>
							<OPTION VALUE="300">300</OPTION>
							<OPTION VALUE="10000">Tout</OPTION>
						</SELECT>
						</form>
                    
               
                <tr>
                    <th><a href="lister_commandes.php?ordre=num_bon&parpage=<?php echo$parpage;?>"><?php echo $lang_numero; ?></a></th>
                    <th><a href="lister_commandes.php?ordre=nom&parpage=<?php echo$parpage;?>"><?php echo $lang_client; ?></a></th>
                    <th><?php echo $lang_date; ?></th>
                    <th><a href="lister_commandes.php?ordre=ttc&parpage=<?php echo$parpage;?>"><?php echo $lang_total_ttc; ?></a></th>
                    <th><a href="lister_commandes.php?ordre=paiement&parpage=<?php echo$parpage;?>">Réglé?</a></th>
					<?php if ($user_admin == 'y'||$user_dev=='y') 
						{ ?>                  
					<th><a href="lister_commandes.php?ordre=fact&parpage=<?php echo$parpage;?>">Encaissé</a></th>
					<th><a href="lister_commandes.php?ordre=fact&parpage=<?php echo$parpage;?>">Contrôlé</a></th>
					<?php }?>
                    <th><a href="lister_commandes.php?ordre=coment&parpage=<?php echo$parpage;?>">Commentaires</a></th>
                    <th colspan="6"><?php echo $lang_action; ?></th>
                </tr>
                    <?php
                    $nombre = 1;
                    while($data = mysql_fetch_array($result))
                    {
                      $num_bon = $data['num_bon'];
					  $pointage = $data['fact'];
					  $ctrl = $data['ctrl'];
                      $paiement = $data['paiement'];
                      $tva = $data["tot_tva"];
                      $date = $data["date"];
                      $id_tarif = $data["id_tarif"];
                      $nom = $data['nom'];
                      $nom=stripslashes($nom);
                            $nom = htmlentities($nom, ENT_QUOTES);
                            $nom_html = htmlentities (urlencode ($nom));
                      $soir = $data['soir'];
                      $soir=stripslashes($soir);
                      if ($soir=="0"){$soir="";}
                      if ($soir==""){$soir="";}
					else {$soir= "pour \"$soir\"";}
                      $num_client = $data['num_client'];
                      $mail = $data['mail'];
                      $login = $data['login'];
                      $coment = $data['coment'];
                      $coment=stripslashes($coment);
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
                    <td class="highlight"><?php echo "$nom $soir"; ?></td>
                    <td class="highlight"><?php echo "$date"; ?></td>
                    <td class="highlight"><?php echo montant_financier($ttc); ?></td>
                    <td class="highlight"><?php echo "$paiement"; ?></td>
						<?php if ($user_admin == 'y'||$user_dev=='y') { ?> 
					<td class="highlight"><?php echo "$pointage"; ?></td>
					<td class="highlight"><?php echo "$ctrl"; ?></td>
						<?php }?>
                    <td class="highlight"><?php echo "$coment"; ?></td>
					<td class="highlight"><a href='form_editer_bon.php?num_bon=<?php echo "$num_bon"; ?>&amp;id_tarif=<?php echo "$id_tarif"; ?>&amp;voir=ok' >
                            <img border="0" alt="voir" src="image/voir.gif" Title="Voir la commande"></a></td>
                    <td class="highlight"><a href='form_editer_bon.php?num_bon=<?php echo "$num_bon"; ?>&amp;id_tarif=<?php echo "$id_tarif"; ?>' >
                            <img border="0" alt="editer" src="image/edit.gif" Title="Modifier la commande"></a></td>
                    <td class="highlight"><a href='delete_bon_suite.php?num_bon=<?php echo $num_bon; ?>&amp;nom=<?php echo "$nom_html"; ?>'
                            onClick="return confirmDelete('<?php echo"$lang_con_effa $num_bon"; ?>')">
                            <img border="0" src="image/delete.png" alt="delete" Title="Supprimer" ></a></td>
                    <td class="highlight">
						<form action="fpdf/bon_pdf.php" method="post" target="_blank" >
						<input type="hidden" name="num_bon" value="<?php echo $num_bon ?>" />
						<input type="hidden" name="nom" value="<?php echo $nom ?>" />	
						<input type="hidden" name="user" value="adm" />
						<input type="image" src="image/printer.gif" style=" border: none; margin: 0;" alt="<?php echo $lang_imprimer; ?>" Title="Imprimer"/>
						</form>
                    </td>

                        <?php if ($user_admin != n) 
						{
						if ($mail != '' and $login !='')
                        { ?>
                    <td class="highlight"><a href='notifi_cli.php?type=comm&amp;mail=<?php echo"$mail"; ?>'><img src='image/mail.gif' border='0' alt='mail' onClick="return confirmDelete('<?php echo"$lang_con_env_notif $num_bon"; ?>')" Title="Envoyer un mail"></a>
                    </td>
                        <?php
                        }
                        else
                        {?>
                    <td class="highlight"></td>
                        <?php }
                        if ($mail != '' )
                        {
                        ?>
                    <td class="highlight">
                        <form action="fpdf/bon_pdf.php" method="post" onClick="return confirmDelete('<?php echo"$lang_con_env_pdf $num_bon"; ?>')">
                                <input type="hidden" name="num_bon" value="<?php echo $num_bon; ?>"/>
                                <input type="hidden" name="nom" value="<?php echo $nom; ?>"/>
                                <input type="hidden" name="user" VALUE="adm"/>
                                <input type="hidden" name="ext" VALUE=".pdf"/>
                                <input type="hidden" name="mail" VALUE="y"/>
                                <input type="image" src="image/mail.gif" alt="mail" Title="Envoyer par mail"/>
                        </form>	</td>
                                <?php
                                }
                                else
                                {
                                ?>
                    <td class="highlight"></td>
                                <?php } } } ?>
                </tr>
        </table>
</center>
        </td>
    </tr>

    <tr>
        <td>
             <?php
//=====================================================
// Menu de pagination que l'on place après la requête 
//======================================================
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

 mysql_free_result($result); // Libère le résultat de la mémoire
 ?>
        </td>
    </tr>
    <tr>
        <td>
        <?php
include("help.php");
include_once("include/bas.php");
$url = $_SERVER['PHP_SELF'];
$file = basename ($url); 
?>
        </td>
    </tr>
</table>

<?php 

if ($file=="form_commande.php" or $file=="login.php") { 
echo"</table>"; 
}
 ?> 

