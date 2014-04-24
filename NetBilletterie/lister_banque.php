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

 //=====================================================
  /*  pour changer le nom de la banque */
 //===================================================== 
 $id_banque=isset($_POST['id_banque'])?$_POST['id_banque']:"";
 $nom=isset($_POST['nom'])?$_POST['nom']:"";
 if($id_banque!=""){
 $sql4 = "UPDATE " . $tblpref ."banque SET `nom`='" . $nom . "' WHERE `id_banque` = '" . $id_banque . "'";
mysql_query($sql4) OR die("<p>Erreur Mysql<br/>$sql4<br/>".mysql_error()."</p>");
}

?> 


<table  class="page" align="center">

	<tr>
		<td>
			 <h3>Liste des banques </h3>
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


            $mois = date("n");
            $annee = date("Y");

            //pour le formulaire
            $annee_1=isset($_POST['annee_1'])?$_POST['annee_1']:"";


            if ($annee_1=='') {
             $annee_1= $annee ;

            if ($mois <= 6)
                    {
                $annee_1=$annee_1;
                    }

            if ($mois >= 7)
                    {
                $annee_1=$annee_1+1;
                    }}
            $annee_2= $annee_1 -1;

            if ($user_com == y) {
            $sql = "SELECT * FROM ".$tblpref."banque ";
                             //ORDER BY " . $tblpref ."bon_comm.`num_bon` DESC

            if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
            {
            $sql .= " ORDER BY " . $_GET[ordre] . " ASC";
            }
            else
            {
            $sql .= "ORDER BY nom DESC ";
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



?>
    <center>
        <table class="boiteaction">
            
                    
                    
						<caption> Les commandes de la saison culturelle <?php echo "$annee_2 - $annee_1"; ?> </caption>
						<FORM method="get" action="lister_banque.php">
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
                    <th><a href="lister_banque.php?ordre=nom&parpage=<?php echo$parpage;?>">Banque</a></th>
                    <th colspan="2">Action</th>
                </tr>
                    <?php
                    $nombre = 1;
                    while($data = mysql_fetch_array($result))
                    {
                      $id_banque = $data['id_banque'];
                      $nom = stripcslashes($data['nom']);
                      ?>
                <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
                
                 <td class="highlight">
						<form action="lister_banque.php" method="post" >
						<input type="text" name="nom" value="<?php echo $nom ?>" />	
						<input type="hidden" name="id_banque" value="<?php echo $id_banque ?>" />
						<input type="submit"  Title="modifier" value="Modifier"/>
						</form>
                    </td>
                    <td class="highlight"><a href='delete_banque.php?id_banque=<?php echo $id_banque; ?>'
                            onClick="return confirmDelete(' Vous êtes sur de vouloir effacer la banque - <?php echo $nom; ?> - de la liste?')">
                            <img border="0" src="image/delete.png" alt="delete" Title="Supprimer" ></a>
                    </td>

                </tr>
                	<?php
					} ?>
        </table>
</center>
        </td>
    </tr>
   <tr>
		<td>
			<form action="banque_new.php" method="post" >
			<center>
				<table>
					<tr><h1>Ajouter une banque à la liste</h1></tr>
					<tr>
						<td ><input name="nom_banque" type="text" > </td>
					</tr>
					</tr>
						<td class="submit" > <input type="image" name="Submit" src="image/valider.png" value="Démarrer"  border="0"> </td>
					</tr>
				</table>
			</center>
			</form>
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

