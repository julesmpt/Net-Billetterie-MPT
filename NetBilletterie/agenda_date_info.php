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
include_once("include/head.php");
include_once("include/finhead.php");
$d=$_GET['dt'];
?>
<table class="page">
	<tr><td>
<h1>Détail du spectacle : <?php echo $dt;?></h1>
<?php
	$sql="select * from factux_article where date_spectacle='$d'";
	$req=mysql_query($sql);
	if(mysql_num_rows($req)==0)
		echo "Aucune information pour cette date";
	else
		while($data=mysql_fetch_array($req))
		{
?>
        <table >
			<img src="<?php echo $data['image_article'];?>" height="100" >
        <tr height="50px"><td width="150px"><strong>Evenement</strong></td><td><?php echo $data['article'];?></td></tr>
        <tr height="50px"><td><strong>Lieu</strong></td><td><?php echo $data['lieu'];?></td></tr>
        <tr height="50px"><td><strong>Horaire</strong></td><td><?php echo $data['horaire'];?></td></tr>
        <tr height="50px"><td><strong>Commentaire</strong></td><td><?php echo $data['commentaire'];?></td></tr>
        <tr height="50px"><td><strong>Lieu</strong></td><td><?php echo $data['lieu'];?></td></tr>
        </table>
        </td></tr>
</table>
<?php
		}
?>
<?php

include_once("include/bas.php");
?>
