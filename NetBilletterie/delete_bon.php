<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/head.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
echo '<link rel="stylesheet" type="text/css" href="include/style.css">';
echo'<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" >';
$sql = "SELECT fact FROM " . $tblpref ."bon_comm WHERE num_bon = $num_bon";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$fact = $data['fact'];
		}
if($fact=='ok')
{
echo "<center><h1>$lang_err_efa_bon";
include('form_bon.php');
exit;
}
echo "<Center><h2><br>$lang_effacer_bon";
?>
<form action="delete_bon_suite.php" method="post" name="delete">
<input type="hidden" name="num_bon" value=<?php echo $num_bon ?>>
<input type="hidden" name="id_tarif" value=<?php echo $id_tarif ?>>
<input type="hidden" name="nom" value=<?php echo $nom ?>>
<input type="submit" name="Submit" value=<?php echo $lang_effacer ?>>
</form><?php 
include("include/bas.php");
 ?>
