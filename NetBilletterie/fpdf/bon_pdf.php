<?php
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
session_cache_limiter('private');
if ($_POST['user']== 'adm') { 
require_once("../include/verif2.php");  
}else{
require_once("../include/verif_client.php");  
}
//error_reporting(0);
require('mysql_table.php');	
include("../include/config/common.php");
include("../include/config/var.php");
include("../include/language/$lang.php");
include_once("../include/configav.php"); 
$num_bon=isset($_POST['num_bon'])?$_POST['num_bon']:"";
$nom=isset($_POST['nom'])?$_POST['nom']:"";
define('FPDF_FONTPATH','font/');
$devise = ereg_replace('&euro;', $euro, $devise);
$slogan = stripslashes($slogan);
$entrep_nom= stripslashes($entrep_nom);
$social= stripslashes($social);
$tel= stripslashes($tel);
$tva_vend= stripslashes($tva_vend);
$compte= stripslashes($compte);
$reg= stripslashes($reg);
$mail= stripslashes($mail);

$mois = date("n");
$annee = date("Y");
if ($annee_1=='')
    {
         $annee_1= $annee ;
        if ($mois <= 6)
         {
            $annee_1=$annee_1;
         }
        if ($mois >= 7)
          {
            $annee_1=$annee_1+1;
          }
    }
$annee_2= $annee_1 -1;

//on compte le nombre de ligne
$sql = "
SELECT *
FROM ".$tblpref."client C, ".$tblpref."cont_bon CB, ".$tblpref."bon_comm BC , ".$tblpref."tarif T, ".$tblpref."article A
WHERE 
CB.bon_num=BC.num_bon
AND BC.client_num=C.num_client
AND CB.article_num = A.num
AND CB.id_tarif = T.id_tarif
AND BC.num_bon = $num_bon";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$nb_li = mysql_num_rows($req);
$nb_pa1 = $nb_li /20 ;
$nb_pa = ceil($nb_pa1);
$nb_li =$nb_pa * 20 ;

//pour la date
$sql = "select coment, tot_tva, DATE_FORMAT(date,'%d/%m/%Y') AS date_2 from ".$tblpref."bon_comm where num_bon = $num_bon";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_array($req);
    $date_bon = $data[date_2];
    $total_tva = $data[tot_tva];
    $tot_tva_inc =/*  $total_htva +  */$total_tva ;
    $coment = $data[coment];
    $nom_tarif = $data['nom_tarif'];
    $prix_tarif = $data['prix_tarif'];
    $to_tva_art = $data['to_tva_art'];
    $total_tva = $data['SUM(to_tva_art)'];

//pour le nom de client
$sql1 = "SELECT civ, mail, nom, nom2, rue, ville, cp, num_tva FROM ".$tblpref."client RIGHT JOIN ".$tblpref."bon_comm on client_num = num_client WHERE  num_bon = $num_bon";
$req1 = mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
$data = mysql_fetch_array($req1);
		$nom = $data['nom'];
		$civ = $data['civ'];
		$nom2 = $data['nom2'];
		$rue = $data['rue'];
		$ville = $data['ville'];
		$cp = $data['cp'];
		$num_tva = $data['num_tva'];
		$mail_client = $data['mail'];

//pour le nom du spectacle
$sql3 = "SELECT article_num FROM ".$tblpref."cont_bon WHERE bon_num=$num_bon";
$req3 = mysql_query($sql3) or die('Erreur SQL3 !<br>'.$sql3.'<br>'.mysql_error());
$data = mysql_fetch_array($req3);
		$num_article= $data['article_num'];

$sql4 = "SELECT article, DATE_FORMAT(date_spectacle,'%d/%m/%Y') AS date_spectacle, horaire, lieu FROM ".$tblpref."article WHERE  num = $num_article";
$req4 = mysql_query($sql4) or die('Erreur SQL4 !<br>'.$sql4.'<br>'.mysql_error());
$data = mysql_fetch_array($req4);
		$date_spectacle= $data['date_spectacle'];
        $lieu = $data['lieu'];
        $horaire = $data['horaire']; 
//page 1

class PDF extends PDF_MySQL_Table
{

function Header()
{		}
//debut Js
var $javascript;
    var $n_js;

    function IncludeJS($script) {
        $this->javascript=$script;
    }

    function _putjavascript() {
        $this->_newobj();
        $this->n_js=$this->n;
        $this->_out('<<');
        $this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R ]');
        $this->_out('>>');
        $this->_out('endobj');
        $this->_newobj();
        $this->_out('<<');
        $this->_out('/S /JavaScript');
        $this->_out('/JS '.$this->_textstring($this->javascript));
        $this->_out('>>');
        $this->_out('endobj');
    }

    function _putresources() {
        parent::_putresources();
        if (!empty($this->javascript)) {
            $this->_putjavascript();
        }
    }

    function _putcatalog() {
        parent::_putcatalog();
        if (isset($this->javascript)) {
            $this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
        }
    }
		function AutoPrint($dialog=false, $nb_impr)
{
    //Ajoute du JavaScript pour lancer la boîte d'impression ou imprimer immediatement
    $param=($dialog ? 'true' : 'false');
    $script=str_repeat("print($param);",$nb_impr);
		
    $this->IncludeJS($script);
}
//fin js

}
$pdf=new PDF('p','mm','a4');
$pdf->Open();

for ($i=0;$i<$nb_pa;$i++)
{
$nb = $i *20;
$num_pa = $i;
$num_pa2 = $num_pa +1;

$pdf->AddPage();

//le logo
$pdf->Image("../upload/$logo",20,8,0,35,'jpg');
$pdf->SetFillColor(255,238,204);


//Troisieme cellule le slogan
$pdf->SetFont('Arial','B',15);
$pdf->SetY(45);
$pdf->SetX(10);
$pdf->MultiCell(71,6,"$slogan $annee_2-$annee_1",0,C,0);

//deuxieme cellule les coordoné clients
$pdf->SetFont('Arial','B',15);
$pdf->SetY(35);
$pdf->SetX(100);
$pdf->MultiCell(90,8,"$civ $nom \n $rue \n $cp  $ville \n ",1,C,1);
$pdf->Line(10,93,200,93);


//premiere celule le numero de bon
$pdf->SetFont('Arial','B',10);
$pdf->SetY(100);
$pdf->SetX(25);
$pdf->MultiCell(65,6,"Commande de billets n° $num_bon \n Enregistré le: $date_bon ",1,C,1);
$file="$lang_fi_b_c $num_bon.pdf";


//la grande cellule sous le tableau



//Le tableau : on définit les colonnes
$pdf->SetY(120);
$pdf->SetX(12);
if($lot=='y'){
/* $pdf->AddCol('uni',10,"$lang_unite",'C'); */
$pdf->AddCol('article',60,"$lang_article",'C');	
$pdf->AddCol('num_lot',20,"$lang_num_lot",'C');
$pdf->AddCol('nom_tarif',40,"tarif",'C');
$pdf->AddCol('prix_tarif',25,"$lang_prix_htva",'C');
}else {
$pdf->AddCol('article',52,"$lang_article",'C');
$pdf->AddCol('date',16,"Date",'C');
$pdf->AddCol('lieu',50,"Lieu",'C');
$pdf->AddCol('horaire',13,"Horaire",'C');
$pdf->AddCol('nom_tarif',25,"Tarif",'C');
$pdf->AddCol('prix_tarif',9,"$lang_prix_htva",'C');}
$pdf->AddCol('quanti',9,"Nbr.",'C');
$pdf->AddCol('to_tva_art',12,"Total",'C');
$prop=array('HeaderColor'=>array(255,150,100),
		  'color1'=>array(255,255,210),
			'color2'=>array(255,238,204),
			'padding'=>2);
$pdf->Table("SELECT *, DATE_FORMAT(date_spectacle,'%d/%m/%Y') AS date
FROM ".$tblpref."client C, ".$tblpref."cont_bon CB, ".$tblpref."bon_comm BC , ".$tblpref."tarif T, ".$tblpref."article A
WHERE CB.bon_num=BC.num_bon
AND BC.client_num=C.num_client
AND CB.article_num = A.num
AND CB.id_tarif = T.id_tarif
AND BC.num_bon = $num_bon 
ORDER BY date_spectacle
LIMIT $nb, 20",$prop
);



if($num_pa2 >= $nb_pa)
  {
//Quatrieme cellule les enoncés de totaux
$pdf->SetFont('Arial','B',12);
$pdf->SetY(230);
$pdf->SetX(158);
$pdf->MultiCell(40,8,"$tot_tva_inc $devise ",1,C,1);

//Cinquieme cellule les totaux
$pdf->SetFont('Arial','B',10);
$pdf->SetY(230);
$pdf->SetX(118);
$pdf->MultiCell(40,8,"Total payé",1,R,1);


//Troisieme cellule les coordoné vendeur
$pdf->SetFont('Arial','',10);
$pdf->SetY(240);
$pdf->SetX(20);
$pdf->MultiCell(60,6,"$entrep_nom\n$social\n$c_postal $ville\n $tel\n $mail",1,C,1);//

//$pdf->ln(10);

//Troisieme cellule info pratique
$pdf->SetFont('Arial','',10);
$pdf->SetY(240);
$pdf->SetX(87);
$pdf->MultiCell(110,6,"Bon de commande à presenter à l'entrée des spectacles. \n Retrait des billets sur place ¼ d’heure avant la séance. \n Attention  ! Passé  l’heure du spectacle  la réservation sera  levée et  la place pourra être réattribuée.",1,C,1);//


   }




//le nombre de page 
$pdf->SetFont('Arial','B',10);
$pdf->SetY(270);
$pdf->SetX(30);
$pdf->MultiCell(160,4,"$lang_page $num_pa2 $lang_de $nb_pa\n",0,C,0);


}	 



if($autoprint=='y' and $_POST['mail']!='y' and $_POST['user']=='adm'){
$pdf->AutoPrint(false, $nbr_impr);
}
//Sauvegarde du PDF dans le fichier
$pdf->Output("$file");
//Redirection JavaScript
//echo "<HTML><SCRIPT>document.location='$file';</SCRIPT></HTML>";
if ($_POST['mail']=='y') {
$to = "$mail_client";
$sujet = "Bon de commande de $entrep_nom";
$message = "Bonjour, \n Veuillez trouver ci-joint une copie de votre bon de commande pour les spectacles de la saison culturelle. \n Merci de conserver ce mail pour pouvoir l'imprimer en cas de besoin. \n \n
Meilleurs salutations de l'équipe de la saison culturelle.";
$fichier = "$file";
$typemime = "pdf";
$nom = "$file";
$reply = "$mail";
$from = "$entrep_nom<$mail>";
require "../include/CMailFile.php";
$newmail = new CMailFile("$sujet","$to","$from","$message","$fichier","application/pdf");
$newmail->sendfile();

echo "<HTML><SCRIPT>document.location='../lister_commandes.php';</SCRIPT></HTML>";
  
} else { 
echo "<HTML><SCRIPT>document.location='$file';</SCRIPT></HTML>";
}
?> 
