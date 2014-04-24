<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
include_once("include/head.php");
?>
<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">
</td>
</tr>
<tr>
<td  class="page" align="center">
<tr><TD>
<?php
$num=isset($_GET['num'])?$_GET['num']:"";
$sql = " SELECT * FROM " . $tblpref ."client WHERE num_client='$num'";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
	$nom = stripslashes($data['nom']);
	$nom2 = stripslashes($data['nom2']);
	$rue = stripslashes($data['rue']);
	$ville = stripslashes($data['ville']);
	$cp = stripslashes($data['cp']);
	$tva = stripslashes($data['num_tva']);
	$mail =stripslashes($data['mail']);
	$login = stripslashes($data['login']);
	$civ = stripslashes($data['civ']);
	$tel = stripslashes($data['tel']);
	$fax = stripslashes($data['fax']);
	$actif = stripslashes($data['actif']);
}
?>
<form name="edit_client" method="post" action="client_update.php" onsubmit="return confirmUpdate()" >
  <table align=center >
    <caption>
    <?php echo "$lang_client_modifier $nom"; ?> 
    </caption>
		    <tr> 
      <td class="texte1"><?php echo Civilité; ?></td>
      <td class="texte1"> <input name="civ" type="text" id="civ" value="<?php echo "$civ"; ?>"></td>
    </tr>
    <tr> 
      <td class="texte0"><?php echo $lang_nom; ?></td>
      <td class="texte0"> <input name="nom" type="text" id="nom" value="<?php echo "$nom"; ?>"></td>
    </tr>

    <tr> 
      <td class="texte1"> <?php echo $lang_rue; ?> </td>
      <td class="texte1"><input name="rue" type="text" id="rue" value="<?php echo "$rue"; ?>"></td>
    </tr>
    <tr> 
      <td class="texte0"> <?php echo $lang_code_postal; ?></td>
      <td class="texte0"><input name="code_post" type="text" id="code_post" value="<?php echo "$cp"; ?>"></td>
    <tr> 
      <td class="texte1"> <?php echo $lang_ville; ?> </td>
      <td class="texte1"><input name="ville" type="text" id="ville" value="<?php echo "$ville"; ?>"></td>
	</tr>
    
	<tr> 
      <td class="texte0">Télephone</td>
      <td class="texte0"> <input name="tel" type="text" id="tel" value="<?php echo "$tel"; ?>"></td>
    </tr>

	<tr> 
      <td class="texte1"><?php echo $lang_email; ?> </td>
      <td class="texte1"> <input name="mail" type="text" id="mail"  value="<?php echo "$mail"; ?>"> </td>
    </tr>
    
    <tr>
		<td class="texte0">Ce spectateur est</td>
		<td class="texte0">
			<select name="actif">
				<option VALUE="<?php echo $actif; ?>"><?php if ($actif=="y") {$act="actif";} if ($actif=="n") {$act="non actif";} echo $act; ?></option>
				<option VALUE="<?php if ($actif!="y") {$acti="y";} if ($actif!="n") {$acti="n";} echo $acti; ?>"><?php if ($actif!="y") {$act="actif";} if ($actif!="n") {$act="non actif";} echo $act; ?></option>
			</select>
    </tr>

    <tr> 
      <td class="submit" colspan="2"><input type="submit" name="Submit" value="<?php echo $lang_envoyer; ?>">
            
	      <input name="num" type="hidden" value="<?php echo $num; ?>">
	   </td>
	 </tr>
 </table>
 </form>

</td></tr>
<tr><td>
<?php
include("help.php");
include_once("include/bas.php");
?>
</td></tr></table></body>
</html>
