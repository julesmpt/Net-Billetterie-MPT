<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/var.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
require_once ('include/lib/class.phpmailer.php');
$from=$mail;

//nombre de mail par tranche d'envoi
$nbr_lot=50;
//nombre de seconde entre chaque envoi
$temp=20;
/* on recupère les limits pour la nouvelle tranche d'envois */
$limit_sup=isset($_GET['limit_sup'])?$_GET['limit_sup']:"";
if ($limit_sup==""){
	$limit_sup=$nbr_lot;
}
else{
	$limit_inf=$limit_sup+1;
	$limit_sup=$limit_sup+$nbr_lot;
}
if ($limit_inf==""){
	$limit_inf=0;
}


/* on resupère le id du spectacle en post*/
$article_numero=isset($_POST['article'])?$_POST['article']:"";
/* on resupère le id du spectacle en GET*/
if($article_numero==""){
$article_numero=isset($_GET['article'])?$_GET['article']:"";
}
/* message pour spectateurs en liste d'attente'' */
$attente=isset($_POST['attente'])?$_POST['attente']:"";
if ($attente=='') {$attente=0;}
/* on resupère le num_client */
$client_num=isset($_POST['client_num'])?$_POST['client_num']:"";
//on recupère le titre du message
$titre=isset($_POST['titre'])?$_POST['titre']:"";
$titre= stripslashes($titre);
//on récupère le message 
$message=isset($_POST['message'])?$_POST['message']:"";
$message = stripslashes($message);
//on recupère le N° du mail en cours d'envoi'
$id_mail=isset($_GET['id_mail'])?$_GET['id_mail']:"";


//creation du message html
if ($id_mail==""){
	$body1 = "<html><head> </ head><body>";
	$body2 = "</body></html>";
	$message = $body1.$message.$body2;

	//inserer les données du mail dans la table des mails
	$sql10 =sprintf ( "INSERT INTO ".$tblpref."mail(objet,message,user_name)
	VALUES ('%s', '%s', '%s')", mysql_real_escape_string($titre), mysql_real_escape_string($message), $user_nom);
	mysql_query($sql10) or die('Erreur SQL10 !<br>'.$sql10.'<br>'.mysql_error());
}
if($id_mail!=""){
	$rqSql11= "SELECT * FROM ".$tblpref."mail WHERE id_mail=$id_mail ";
	$result11 = mysql_query( $rqSql11 )or die( "Exécution requête rqsql11mailing impossible.");
		while ( $row = mysql_fetch_array( $result11)) {
			$titre = stripslashes($row["objet"]);
			$message =stripslashes($row["message"]);
		}
}

//On recupère l'id_mail du mail créer
if ($id_mail==""){
	$rqSql12= "SELECT id_mail FROM ".$tblpref."mail ORDER BY id_mail DESC LIMIT 0,1 ";
	$result12 = mysql_query( $rqSql12 )or die( "Exécution requête rqsql12mailing impossible.");
		while ( $row = mysql_fetch_array( $result12)) {
			$id_mail = $row["id_mail"];
		}
	
	}
$message_affiche=$message;

//////////////////////////////////////////////////////////////////////////////////////////////
//phpmailer
//////////////////////////////////////////////////////////////////////////////////////////////

$mail = new PHPMailer();
$mail->SetLanguage('fr');

if ($smtp!=""){
$mail->IsSMTP();
$mail->IsHTML=false;
$mail->SMTPDebug=2;
$mail->Host=$smtp;
$mail->Port=$port;
$mail->SMTPSecure="tls";
$mail->SMTPAuth=true;
$mail->Priority=1;
$mail->Username=$username_smtp;
$mail->Password=$password_smtp;
}

$mail->CharSet = "iso-8859-15";
$mail->ContentType="test/plain";
$mail->Encoding="8bit";
$body  = $message;
$body  = eregi_replace("[\]",'',$body);
$mail  = new PHPMailer(); // defaults to using php "mail()"
$mail->SetFrom($from, $entrep_nom);
$mail->AddReplyTo($from, $entrep_nom);
$mail->Subject= $titre;
///////////////////////////////////////////////////////////////////////////////////////////////



/* pour envoyer uniquement qu'à un spectateur donné*/
if ($client_num!=''){
	$sql3 = "SELECT * FROM ".$tblpref."client WHERE num_client=$client_num";
	$req3 = mysql_query($sql3) or die('Erreur SQL3 !<br>'.$sql3.'<br>'.mysql_error());
	while ($row = mysql_fetch_array ($req3)) {
		  $mail->AltBody    = "Pour voir le message, acceptez le format HTML pour cet email!"; // optional, comment out and test
		  $mail->MsgHTML($body);
		  $mail->AddAddress($row["mail"], $row["nom"]);
		  $mail1=$row["mail"];

		  if(!$mail->Send()) {
			  
			$mail1= "<br>Erreur dans le mail (" . str_replace("@", "&#64;", $row["mail"]) . ') ' . $mail->ErrorInfo . '<br>';
			  //inserer les id des spectateurs dans la table des mails
			$sql20 ="UPDATE ".$tblpref."mail  SET mail_client = CONCAT(mail_client, '$mail1', '; ') WHERE id_mail=$id_mail";
			mysql_query($sql20) or die('Erreur SQL20 !<br>'.$sql20.'<br>'.mysql_error());
		  } else {
			  //inserer les id des spectateurs dans la table des mails
			$sql20 ="UPDATE ".$tblpref."mail  SET mail_client = CONCAT(mail_client, '$mail1', '; ') WHERE id_mail=$id_mail";
			mysql_query($sql20) or die('Erreur SQL20 !<br>'.$sql20.'<br>'.mysql_error());
		  }
			// Clear all addresses and attachments for next loop
				$mail->ClearAddresses();
				$mail->ClearAttachments();
		}
} 

/* pour envoyer uniquement qu'aux spectateurs d'un spectacle donné */
 if ($article_numero!=''){
	 //on compte le nombre de destinataires
	 	$sqlb = "SELECT COUNT(DISTINCT mail) as limit_count FROM " . $tblpref ."client C, " . $tblpref ."cont_bon CB, " . $tblpref ."bon_comm BC , " . $tblpref ."tarif T
	WHERE CB.bon_num=BC.num_bon
	AND mail!= ''
	AND BC.client_num=C.num_client
	AND CB.article_num = $article_numero
	AND BC.attente=$attente
	AND CB.id_tarif = T.id_tarif
	GROUP BY mail";
	$reqb = mysql_query($sqlb) or die('Erreur SQLb !<br>'.$sqlb.'<br>'.mysql_error());
	while($data = mysql_fetch_array($reqb))
			{$limit_count=$data['limit_count'];
			}
	 $sql = "SELECT DISTINCT nom, mail FROM " . $tblpref ."client C, " . $tblpref ."cont_bon CB, " . $tblpref ."bon_comm BC , " . $tblpref ."tarif T
	WHERE CB.bon_num=BC.num_bon
	AND mail!= ''
	AND BC.client_num=C.num_client
	AND CB.article_num = $article_numero
	AND BC.attente=$attente
	AND CB.id_tarif = T.id_tarif
	GROUP BY mail LIMIT ".$limit_inf." , ".$nbr_lot."";
	$result = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
			while ($row = mysql_fetch_array ($result)) {
		  $mail->AltBody    = "Pour voir le message, acceptez le format HTML pour cet email!"; // optional, comment out and test
		  $mail->MsgHTML($body);
		  $mail->AddAddress($row["mail"], $row["nom"]);
		  $mail1=$row["mail"];

		  if(!$mail->Send()) {
			  
			$mail1= "<br>Erreur dans le mail (" . str_replace("@", "&#64;", $row["mail"]) . ') ' . $mail->ErrorInfo . '<br>';
			  //inserer les id des spectateurs dans la table des mails
			$sql20 ="UPDATE ".$tblpref."mail  SET mail_client = CONCAT(mail_client, '$mail1', '; ') WHERE id_mail=$id_mail";
			mysql_query($sql20) or die('Erreur SQL20 !<br>'.$sql20.'<br>'.mysql_error());
		  } else {
			  //inserer les id des spectateurs dans la table des mails
			$sql20 ="UPDATE ".$tblpref."mail  SET mail_client = CONCAT(mail_client, '$mail1', '; ') WHERE id_mail=$id_mail";
			mysql_query($sql20) or die('Erreur SQL20 !<br>'.$sql20.'<br>'.mysql_error());
		  }
			// Clear all addresses and attachments for next loop
				$mail->ClearAddresses();
				$mail->ClearAttachments();
		}
}

/* Pour l'envoi à tout le monde */
if ($client_num==""&& $article_numero==""){
	//on compte le nombre de destinataires
	$sql4 = "SELECT COUNT(DISTINCT mail) as limit_count FROM ".$tblpref."client WHERE mail!= ''  AND actif='y' ";
	$req4 = mysql_query($sql4) or die('Erreur SQL4 !<br>'.$sql4.'<br>'.mysql_error());
	while($data = mysql_fetch_array($req4))
			{$limit_count=$data['limit_count'];
			}
	//on selectionne les mails dans la tranche
	$sql2 = "SELECT DISTINCT mail, nom, num_client FROM ".$tblpref."client WHERE mail!= ''  AND actif='y' GROUP BY mail LIMIT ".$limit_inf." , ".$nbr_lot."";
	$result = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
		while ($row = mysql_fetch_array ($result)) {
		  $mail->AltBody    = "Pour voir le message, acceptez le format HTML pour cet email!"; // optional, comment out and test
		  $mail->MsgHTML($body);
		  $mail->AddAddress($row["mail"], $row["nom"]);
		  $mail1=$row["mail"];

		  if(!$mail->Send()) {
			  
			$mail1= "<br>Erreur dans le mail (" . str_replace("@", "&#64;", $row["mail"]) . ') ' . $mail->ErrorInfo . '<br>';
			  //inserer les id des spectateurs dans la table des mails
			$sql20 ="UPDATE ".$tblpref."mail  SET mail_client = CONCAT(mail_client, '$mail1', '; ') WHERE id_mail=$id_mail";
			mysql_query($sql20) or die('Erreur SQL20 !<br>'.$sql20.'<br>'.mysql_error());
		  } else {
			  //inserer les id des spectateurs dans la table des mails
			$sql20 ="UPDATE ".$tblpref."mail  SET mail_client = CONCAT(mail_client, '$mail1', '; ') WHERE id_mail=$id_mail";
			mysql_query($sql20) or die('Erreur SQL20 !<br>'.$sql20.'<br>'.mysql_error());
		  }
			// Clear all addresses and attachments for next loop
				$mail->ClearAddresses();
				$mail->ClearAttachments();
		}
} 
  
if ($limit_inf<$limit_count){
		?>
	<table class="page">
		<tr>
			<td>
					<?php
					
					$limit_inf=$limit_sup-$nbr_lot;
					$pourcentage4 =$limit_inf / $limit_count * 100;
					$pourcentage4 = sprintf('%.1f',$pourcentage4); 
					?>
				<h2>Attention, comme la liste comprend <?php echo $limit_count;?> destinataires, cela peut prendre plusieurs minutes! <br>
				Restez patient! <br/><br/><br/>
				<img src="image/sablier.png"></h2>
				<br/>
				<p>Le message est en cours d'envoi</p>
				<br/>
				<span class="bar">
					<span class="progression" style="width: <?php echo $pourcentage4 ?>%">
						<span title="<?php echo $pourcentage4 ?>%" class="precent"><?php echo $pourcentage4 ;?>%
						</span>
					</span>
				</span>
				<br/>
				<br/>
				<br/>
				<br/>
			</td>
		</tr>
	</table>
	<SCRIPT LANGUAGE="JavaScript">
		 document.location.href="mailing_attente.php?limit_sup=<?php echo $limit_sup;?>&limit_count=<?php echo $limit_count;?>&id_mail=<?php echo $id_mail;?>&nbr_lot=<?php echo $nbr_lot;?>&article=<?php echo $article_numero;?>" 
	</SCRIPT>
	<?php
}
else {
	include_once("include/head.php");
}

	if($id_mail!=""){
		$rqSql30= "SELECT * FROM ".$tblpref."mail WHERE id_mail=$id_mail ";
		$result30 = mysql_query( $rqSql30 )or die( "Exécution requête rqsql30_mailing impossible.");
		while ( $row = mysql_fetch_array( $result30)) {
		$titre = stripslashes($row["objet"]);
		$message =stripslashes($row["message"]);
		}
	}
	else{
	echo $mail_client;
	}
	?>
<table width="760" border="0" class="page" align="center">
	<tr>
		<td>Titre du message: <?php echo $titre ;?></td>
	</tr>
	<tr>
		<td> Adresse utilisée:<?php echo $from;?></td>
	</tr>
	<tr>
		<td>
		Corps du message:<br><?php echo $message;?></td>
	</tr>

</table>


<?php
include_once("include/bas.php");
?> 

