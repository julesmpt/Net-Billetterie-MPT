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
			<h3>Liste des spectateurs</h3>
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

		$sql = " SELECT * FROM ".$tblpref."client WHERE nom LIKE '$initial%' AND actif='y' AND `num_client`!='1'";

		 if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
		{
		$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
		} 
		else {
		$sql = " SELECT * FROM ".$tblpref ."client WHERE nom LIKE '$initial%' AND actif='y' AND `num_client`!='1' ORDER BY nom ASC";
		  }
		$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		?>
			<center>
				<table id="datatables" class="display">
					<caption><?php echo $lang_clients_existants; ?></caption>
					<thead>
						<tr>
							 <th><?php echo $lang_civ; ?> </th>
							 <th><?php echo $lang_nom; ?></th>
							<th><?php echo $lang_rue; ?></th>
							<th><?php echo $lang_code_postal; ?></th>
							<th><?php echo $lang_ville; ?></th>
							<th><?php  echo $lang_tele;?></th>
							<th><?php echo $lang_email; ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$nombre =1;
						while($data = mysql_fetch_array($req))
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
							<td><?php echo $civ; ?></td>
							<td><?php echo $nom; ?></td>
							<td><?php echo $rue; ?></td>
							<td><?php echo $cp; ?></td>
							<td><?php echo $ville; ?></td>
							<td><?php echo $tel; ?></td>
							<td><a href="form_mailing.php?nom=<?php echo $num; ?>" ><?php echo "$mail"; ?></a></td>
							<td><a href='edit_client.php?num=<?php echo "$num" ?>'><img border='0'src='image/edit.gif' alt='<?php echo $lang_editer; ?>'></a></td>
							<?php
							} ?>
					</tr>
					</tbody>
				</table>
			</center>
		</td>
	</tr>
</table>
<?php
include_once("include/bas.php");
?>

