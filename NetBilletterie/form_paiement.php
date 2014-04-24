<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/configav.php");
include_once("include/language/$lang.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");

if ($user_art == n) { 
echo "<h1>$lang_article_droit";
exit;  
}

$num_bon=isset($_GET['num_bon'])?$_GET['num_bon']:"";
$sql = "SELECT mail, login, num_client, num_bon, ctrl, fact, attente, coment, tot_tva, nom, id_tarif,
					DATE_FORMAT(date,'%d-%m-%Y') AS date, tot_tva as ttc, paiement, banque, titulaire_cheque, DATE_FORMAT(date_fact,'%d-%m-%Y') AS date_fact
					FROM ".$tblpref."bon_comm
					RIGHT JOIN ".$tblpref."client on ".$tblpref."bon_comm.client_num = num_client
					WHERE num_bon=$num_bon";
					$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
					while($data = mysql_fetch_array($req)){
						$ctrl = $data['ctrl'];
						$pointage = $data['fact'];
						$date_fact = $data['date_fact'];
                      $paiement = mysql_escape_string($data['paiement']);
                      $total = $data["tot_tva"];
                      $date = $data["date"];
                      $nom = $data['nom'];
                            $nom = htmlentities($nom, ENT_QUOTES);
                            $nom_html = htmlentities (urlencode ($nom));
                      $num_client = $data['num_client'];
                      $banque = stripslashes($data['banque']);
                      $bq = $data['banque'];
                      $titulaire_cheque = $data['titulaire_cheque'];
                      $coment = stripslashes($data['coment']);
					}

// Fonction qui supprime l'effet des magic quotes
/*function stripslashes_r($var) 
{
        if(is_array($var)) // Si la variable passée en argument est un array, on appelle la fonction stripslashes_r dessus
        {
                return array_map('stripslashes_r', $var);
        }
        else // Sinon, un simple stripslashes suffit
        {
                return stripslashes($var);
        }
}
 
if(get_magic_quotes_gpc()) // Si les magic quotes sont activés, on les désactive avec notre super fonction ! ;)
{
   $_GET = stripslashes_r($_GET);
   $_POST = stripslashes_r($_POST);
   $_COOKIE = stripslashes_r($_COOKIE);
}*/
?>		
<table class="page" >
	<tr>
		<td><?php echo"<h3>Modifier le paiement</h3>"; ?></td>
	</tr>
	<tr>
		<td>
			<center>
				<form action="paiement_update.php" method="post" name="" id="">
					<table class="boiteaction">
						<tr class="texte">
							<th>N°</th>
							<th>Nom</th>
							<th>Date</th>
							<th>Total</th>
							<th>Réglé?</th>
							<th>Controlé</th>
							<th>Encaissé</th>
							<th>Banque</th>
							<th>Titulaire du chèque</th>
							<th>Commentaire</th>
						</tr>
						<tr>
							<td><?php echo"$num_bon" ?> </td>
							<td><?php echo"$nom" ?></td>
							<td><?php echo"$date" ?></td>
							<td><?php echo"$total" ?></td>
							<td><select name="paiement" >
								<?php if ($paiement=="non"){ ?>
								<OPTION VALUE="non">En attente</OPTION>
								<?php } 
								else { ?>
								<OPTION VALUE="<?php echo $paiement;?>"><?php echo $paiement;?></OPTION>
								<?php
								}
									$sql3 = "SELECT * FROM ".$tblpref."type_paiement WHERE nom!='$paiement'";
											$req3 = mysql_query($sql3) or die('Erreur SQL3 !<br>'.$sql3.'<br>'.mysql_error());
											while($data = mysql_fetch_array($req3)){
												$paiement = mysql_escape_string($data['nom']);
												if ($paiement=="non"){ ?>
										<OPTION VALUE="non">En attente</OPTION>
											<?php } 
												else { ?>
										<OPTION VALUE="<?php echo $paiement;?>"><?php echo $paiement;?></OPTION>
												<?php
												}
											} ?>
								</SELECT>
							</td>
							<td><SELECT name="ctrl">
									<?php if ($ctrl=="ok"){ ?>
								<OPTION VALUE="ok">ok</OPTION>
								<OPTION VALUE="non">non</OPTION>
									<?php } 
									if ($ctrl=="non"){ ?>
								<OPTION VALUE="non">non</OPTION>
								<OPTION VALUE="ok">ok</OPTION>
									<?php } ?>
								</SELECT>
								
							</td>
							<td><SELECT name="pointage">
									<?php if ($pointage=="ok"){ ?>
								<OPTION VALUE="ok">ok</OPTION>
								<OPTION VALUE="non">non</OPTION>
									<?php } 
									if ($pointage=="non"){ ?>
								<OPTION VALUE="non">non</OPTION>
								<OPTION VALUE="ok">ok</OPTION>
									<?php } ?>
								</SELECT>
								<input type="text" name="date_fact" size="10" value="<?php if ($date_fact=='00-00-0000') {echo date("d-m-Y");} else { echo $date_fact;}?>"/>
							</td>
							<td><SELECT name="banque">
								<?php if ($bq!=""){ ?>
								<OPTION VALUE="<?php echo $banque;?>"><?php echo $banque;?></OPTION>
								<?php } 
								else { ?>
								<OPTION value="">Choisir</OPTION>
								<?php }
									$sql2 = "SELECT * FROM ".$tblpref."banque ";
											if ($banque!=""){
												$sql2.= " WHERE nom !=  '$bq'";
												}
											$req2 = mysql_query($sql2) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());
											while($data = mysql_fetch_array($req2)){
												$id_banque = $data['id_banque'];
												$nom = stripslashes($data['nom']);
												?>
												<OPTION VALUE="<?php echo $nom;?>"><?php echo $nom;?></OPTION>
												<?php } ?>
								</SELECT><a href="lister_banque.php">Ajouter une banque à la liste</a>
							</td>
							<td><input name="titulaire_cheque" type="text" size="10" value ="<?php echo $titulaire_cheque; ?>"></td>
							<td><input name="coment" type="TEXTAREA" size="30" value ="<?php echo $coment; ?>"></td>
						</tr>
						<tr>
							<td colspan="10" class="submit">
							<input name="num_bon" type="hidden" value="<?php echo $num_bon; ?>">
							<input type="image" name="Submit" src="image/valider.png" value="Démarrer"  border="0"></td>
						</tr>
					</table>
				</form>	
			</center>			
		</td>
	</tr>
</table>
		
<?php

include_once("include/bas.php");
?>

