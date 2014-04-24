<?php 
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Jos� Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");?>
<script type="text/javascript" src="javascripts/confdel.js"></script>

<table class="page" >
<tr>
<td  class="page" align="center">
 <?php
if ($user_cli == n) { 
echo"<h1>$lang_client_droit";
exit;  
}


$article_numero=isset($_GET['article'])?$_GET['article']:"";

$sql = " SELECT *
FROM " . $tblpref ."client C, " . $tblpref ."cont_bon CB, " . $tblpref ."bon_comm BC , " . $tblpref ."tarif T
WHERE CB.bon_num=BC.num_bon
AND BC.client_num=C.num_client
AND CB.article_num = $article_numero
AND BC.attente=0
AND CB.id_tarif = T.id_tarif";

if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
{
$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
}else{
$sql .= " ORDER BY CB.num ASC ";
}


$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

$sql2="SELECT DATE_FORMAT(date_spectacle,'%d/%m/%Y') AS date_spectacle, article, stock, num FROM " . $tblpref ."article WHERE num=$article_numero";
$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req2))
    {
    $article = $data['article'];
    $article_numero= $data['num'];
    $date = $data['date_spectacle'];
    $stock = $data['stock'];


?>
<center><table class="boiteaction">
  <caption>Liste des spectateurs pour: <br><?php
  if ($stock>0){
  echo "$article le $date - Il reste $stock places";
  
  }
 else {
   echo "$article le $date - La liste d'attente est � $stock places";
    }
  ?><br><br>
  <?php if ($user_admin != n) { ?>
  <a href="form_mailing.php?article=<?php echo $article_numero;?>">Envoyer un mail � tous ces spectateurs</a><br> <?php } ?>
  <a href="fpdf/liste_spectateurs.php?article=<?php echo $article_numero;?>" target="_blank">Imprimer la liste de tous ces spectateurs</a></caption>
  <tr>
      <?php } ?>

 <th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=civ"><?php echo $lang_civ; ?> </a></th>
 <th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=nom"><?php echo $lang_nom; ?></a></th>
<th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=rue"><?php echo $lang_rue; ?></a></th>
<th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=cp"><?php echo $lang_code_postal; ?></a></th>
<th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=ville"><?php echo $lang_ville; ?></a></th>
<th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=tel"><?php  echo $lang_tele;?></a></th>
<th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=mail"><?php echo $lang_email; ?></a></th>
<th><a href="lister_spectateurs.php?article=<?php echo $article_numero;?>&ordre=nom_tarif">Type de tarif</a></th>
<th>NBR</th>

</tr>
<?php
$nombre =1;
while($data = mysql_fetch_array($req))
    {
		$article_num = $data['article_num'];
		$bon_num = $data['bon_num'];
		$num_client = $data['num_client'];
		$nom = $data['nom'];
		$nom_html= stripslashes($nom);
		$nom2 = $data['nom2'];
		$rue = $data['rue'];
		$ville = $data['ville'];
		$cp = $data['cp'];
		$tva = $data['num_tva'];
		$mail =$data['mail'];
		$num = $data['num_client'];
		$civ = $data['civ'];
		$tel = $data['tel'];
		$fax = $data['fax'];
		$nom_tarif = $data['nom_tarif'];
		$quanti = $data['quanti'];
		$to_tva_art = $data['to_tva_art'];
$total_tva = $data['SUM(to_tva_art)'];			
		
if($nombre & 1){
		$line="0";
		}else{
		$line="1"; 
		}
		?>
		<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte <?php echo "$line" ?>'">
		<td class="highlight"><?php echo $civ; ?></td>
		<td class="highlight"><?php echo $nom_html; ?></td>
		<td class="highlight"><?php echo $rue; ?></td>
		<td class="highlight"><?php echo $cp; ?></td>
		<td class="highlight"><?php echo $ville; ?></td>
		<td class="highlight"><?php echo $tel; ?></td>
		<td class="highlight"><a href="mailto:<?php echo $mail; ?>" ><?php echo "$mail"; ?></a></td>
		<td class="highlight"><?php echo $nom_tarif; ?></td>
		<td class="highlight"><?php echo $quanti; ?></td>
		
		
		<?php
		}
$aide = client;
?>
<!--tr><td class='totalmontant' colspan="3">TOTAL DU SPECTACLE</td>

<td class='totaltexte'><?php echo "$total_tva $devise "; ?></td><td colspan='2' class='totalmontant'>
</td></tr-->

</table></center><tr><td>
<?php
include("help.php");	
echo"</td></tr><tr><td>";
include_once("include/bas.php");
?> 
</td></tr>
<?php
$url = $_SERVER['PHP_SELF'];
$file = basename ($url);
if ($file=="form_client.php") { 
echo"</table>"; 
} ?>
</table>
</body>
</html>
