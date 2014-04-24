<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/headers.php");
include_once("include/head.php");
include_once("include/finhead.php");

$id_tarif=isset($_GET['id_tarif'])?$_GET['id_tarif']:"";
$sql = "SELECT * FROM " . $tblpref ."tarif   
 WHERE id_tarif=$id_tarif";

$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$id_tarif = $data['id_tarif'];
		$nom_tarif =$data['nom_tarif'];
		$prix_tarif = $data['prix_tarif'];
		$carnet = $data['carnet'];
		$selection =$data['selection'];

		}
	?>			
<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">
<tr><td><?php echo"<h2>$lang_modi_no $nom_tarif </h2>"; ?></tr><tr><td>

<center><form action="tarif_update.php" method="post" name="id_tarif" id="id_tarif"><table>

	<tr>
		<th><?php  echo "$lang_nom_tarif " ?></th>
		<th><?php echo "$lang_prix_tarif"; ?></th>
		<th><?PHP echo "Num&eacute;ro du ticket de d&eacute;part";?></th>
		<th>Selectionnable</th>
	</tr>
	<tr>
		<td><input name="nom_tarif" type="text"  value ="<?php echo"$nom_tarif" ?> "></td>
		<td><input name="prix_tarif" type="text" value ="<?php echo"$prix_tarif $devise" ?>"</td>
		<td><input name="carnet" type="text" value ="<?php echo"$carnet" ?>"></td>
		<td><select name="selection" >
			  <option value="0">Non selectionnable</option>
			  <option value="1">Selectionnable</option>
			</select>
		</td>
		
	</tr>
	<tr>
		<td colspan="3" class="submit"><input name="id_tarif" type="hidden" value= <?php echo "$id_tarif" ?>  />
			<input type="submit" name="Submit" value="<?php echo $lang_envoyer; ?>">
			<input name="reset" type="reset" id="reset" value="effacer"></td>
			</tr>
    </table></form>	</center>
		
<?php
echo "<tr><td>";
include_once("include/bas.php");
?>
</td></tr></table>
